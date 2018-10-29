<?php
session_start();

if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 0)){

}else{
	header('Location: ../login.php');
	session_unset();
  	session_destroy();
}

include_once("../Conexao.php");

if ((isset($_GET["id"])) && (isset($_GET["acao"]))){
	$id=$_GET["id"];

	if ((isset($_GET['acao'])) && ($_GET['acao'] =='upload_ft')){
	$id = $_GET['id'];
	include_once('../classes/m2brimagem.class.php');
	$arquivo = $_FILES["aq_foto"];
		$pasta_dir = "../uploads/img/";
		if(!file_exists($pasta_dir)){
			mkdir($pasta_dir);
		}
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
		$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
		move_uploaded_file($arquivo["tmp_name"], $imagem);

		$sql= mysqli_query($mysqli,"UPDATE prestador SET ft_foto = '".$imagem."' WHERE id_prestador= '".$id."' ");

		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='upload_arq')){
	$id = $_GET['id'];
	$nome = $_POST['nome_arquivo'];

	$arquivo = $_FILES["aq_arquivo"];
		$pasta_dir = "../uploads/arqvs/";
		if(!file_exists($pasta_dir)){
			mkdir($pasta_dir);
		}
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|ppt|pptx|xls){1}$/i", $arquivo["name"], $ext);
		$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
		move_uploaded_file($arquivo["tmp_name"], $imagem);

		$sql = mysqli_query($mysqli,"INSERT INTO arquivos(nm_nome, ds_caminho, bl_ativo) VALUES ('".$nome."','".$imagem."','1')");
		$result = mysqli_fetch_array( mysqli_query($mysqli,"SELECT * FROM arquivos WHERE nm_nome = '".$nome."' AND ds_caminho = '".$imagem."' ") );
		$sql = mysqli_query($mysqli,"INSERT INTO empreendimentos_has_arquivos(empreendimentos_id_empreendimentos, arquivos_id_arquivos, bl_ativo) VALUES ('".$id."','".$result['id_arquivos']."','1') ");

		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_arq')){
	$id = $_GET['id'];
	$id_arquivo = $_GET['id_arquivo'];

	$sql = mysqli_query($mysqli,"SELECT * FROM arquivos WHERE id_arquivos='".$id_arquivo."' ");
	$sql = mysqli_fetch_array($sql);
	unlink($sql['ds_caminho']);

	$sql = mysqli_query($mysqli,"UPDATE arquivos SET bl_ativo='0' WHERE id_arquivos='".$id_arquivo."' ");
	$sql = mysqli_query($mysqli,"UPDATE empreendimentos_has_arquivos SET bl_ativo='0' WHERE arquivos_id_arquivos='".$id_arquivo."' ");
	header('Location: empreendimento.php?id='.$id.'&acao=visualizar');

}


if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysqli_query($mysqli,"SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysqli_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysqli_query($mysqli,"UPDATE prestador_has_servico SET bl_ativo='0' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');
	}else{
		$sql = mysqli_query($mysqli,"INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','0') ");
		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');
	}

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='ativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysqli_query($mysqli,"SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysqli_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysqli_query($mysqli,"UPDATE prestador_has_servico SET bl_ativo='1' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');
	}else{
		$sql = mysqli_query($mysqli,"INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','1') ");
		header('Location: empreendimento.php?id='.$id.'&acao=visualizar');
	}

}




	if($_GET["acao"] == 'aprovar'){
		if($sql= mysqli_query($mysqli,"UPDATE empreendimentos SET bl_ativo= 1 WHERE id_Empreendimentos= '".$id."' ")){
			header('Location: empreendimento');
		}else{
			echo'<h1> Erro Encontrado </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'.mysql_error().'</h3>
			';
		}
	}else if($_GET["acao"] == 'negar'){
		if($sql= mysqli_query($mysqli,"UPDATE empreendimentos SET bl_ativo= 2 WHERE id_Empreendimentos= '".$id."' ")){
			header('Location: empreendimento');
		}else{
			echo'<h1> Erro Encontrado </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'.mysql_error().'</h3>
			';
		}
	}else if($_GET["acao"] == 'visualizar'){
		$sql = mysqli_query($mysqli,"SELECT * FROM empreendimentos WHERE id_Empreendimentos='".$id."' ");
		$result= mysqli_fetch_array($sql);

		$nome 			= $result['nm_nome'];	/* Seta as vartiaveis */
		$ds_curta		= $result['ds_curta'];
		$ds_longa		= $result['ds_longa'];
		$celular 		= $result['nu_telefone'];
		$im_logo		= $result['im_logo'];
		echo'


		<!DOCTYPE html>
		<html>
		<head>
			<title>Empreendimentos</title>
		    <link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
			<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

			<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
			<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);
			</script>


			<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->
			<script language="JavaScript" type="text/javascript" src="../js/cidades-estados-1.4-utf8.js"></script> <!-- Biblioteca Das cidades e Estados -->
			<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
		</head>
		<body>';
		$_GET['nav'] = 'adm';
		include("../nav.php");

		echo'

<br>
<div class="container-fluid" id="Pagina"> <!-- Faz o Responsivo ser "Fluido" -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div class="card">
						<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
							<h5 class="card-title" style="color:white;" > <center> Visualização de Empreendimento </h5>
						</div>
						<div class="card-body">
							<form name="Usuario" id="Usuario" action="empreendimento.php?acao=visual" method="post" enctype="multipart/form-data"> <!-- Formulário -->
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- Faz os campos de texto ocuparem 8 -->
											<input type="text" name="visualizar"  class="form-control" maxlength="70" value="1" required hidden/>
											<input type="text" name="id_user" value="'.$id.'" hidden/>

											<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome<a class="text-danger">*</a><br>
		                    <input type="text" name="nm_nome"  class="form-control" maxlength="70" value="'.$nome.'" required/>
		                  </label>

		                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Descrição Curta <br>
		                    <textarea style="resize: none" class="form-control" name="ds_curta" id="ds_curta" rows="3" maxlength="299" >'.$ds_curta.'</textarea>
		                  </label>

		                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Caracteristicas <br>
		                    <textarea style="resize: none" class="form-control" name="ds_longa" id="ds_longa" rows="25" maxlength="5000" >'.$ds_longa.'</textarea>
		                  </label>

		                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> Telefone <a class="text-danger">*</a><br>
		                    <input type="text" name="celular" id="celular" id="celular" class="form-control" maxlength="15"  value="'.$celular.'" required/>
		                  </label>



											<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Logo do empreendimento<a class="text-danger">*</a><br>
												<img src="'.$im_logo.'" alt="" class="img-thumbnail">
												<input type="file" name="im_logo"  class="form-control">
											</label>


									</div>
									<div class="row" style="margin-left: 3px;"> <!-- Gera uma campo de flutuação -->
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao">
										<center>
											<input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Salvar" >
											<input type="button" name="Voltar" class="btn btn-danger" value="Voltar" onclick="window.history.back();">
										</center>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
 				</div>

				<div  class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

				<div class="card">
					<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
						<h5 class="card-title" style="color:white;" > <center> Situação </h5>
					</div>
					<div class="card-body">
						<br><br>
						';

						if($result["bl_ativo"]==1){
							echo'
							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="btn btn-success" style="color: white; width: 100%; ">Ativo</div>
							</label>';
						}if($result["bl_ativo"]==2){
							echo'
							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="btn btn-danger" style="color: white; width: 100%; ">Cancelado</div>
							</label>';
						}
						echo'
						<br>
						<label  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<a style="width: 49%" href="empreendimento.php?id='.$result["id_Empreendimentos"].'&acao=aprovar" class="btn btn-success " role="button" aria-pressed="true">
								<img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png">
							</a>

							<a style="width: 49%; padding-left:2%;" href="empreendimento.php?id='.$result["id_Empreendimentos"].'&acao=negar" class="btn btn-danger " role="button" aria-pressed="true">
								<img width="18" height="18" alt="Negar" src="../img/thumb-down.png">
							</a>
						</label>';


						echo'
						<br>
						<br>

					</div>
				</div>

				</div>

			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 --> <BR>
					<div class="card">
						<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
							<h5 class="card-title" style="color:white;" > <center> Arquivos </h5>
						</div>
						<div class="card-body">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">Nome</th>
											<th scope="col" style="width:120px;"></th>
										</tr>
									</thead>
									<tbody>';
										if($sql_arquivo = mysqli_query($mysqli,"SELECT * FROM empreendimentos_has_arquivos WHERE empreendimentos_id_empreendimentos ='".$id."' AND bl_ativo = '1' ")){

										while($sql_result_arqui = mysqli_fetch_array($sql_arquivo)){
											$sql_result_arq = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM arquivos WHERE id_arquivos ='".$sql_result_arqui['arquivos_id_arquivos']."' AND bl_ativo = '1' "));
										echo'
										<tr>
											<td>'.$sql_result_arq['nm_nome'].'</td>
											<td>
												<div>
													<a  href="empreendimento.php?id='.$id.'&id_arquivo='.$sql_result_arq["id_arquivos"].'&acao=desativa_arq " class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>
													<a href="'.$sql_result_arq["ds_caminho"].'" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
												</div>
											</td>
										</tr>
										';
										}
										}
										echo'
									</tbody>
								</table>
							</div>
						</div>
					</div>

			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <!-- Faz os campos de texto ocuparem 8 --><br>
				<div class="card">
					<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
						<h5 class="card-title" style="color:white;" > <center> Novo Arquivo </h5>
					</div>
					<div class="card-body">
						<form name="Usuario" id="Usuario" action="empreendimento.php?acao=upload_arq&id='.$id.'" method="post" enctype="multipart/form-data"> <!-- Formulário -->
							<div class="row">
								<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome do Arquivo<a class="text-danger">*</a><br>
									<input type="text" name="nome_arquivo"  class="form-control" required/>
								</label>
								<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Arquivo<a class="text-danger">*</a><br>
									<input type="file" name="aq_arquivo"  class="form-control" required/>
								</label>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<center> <input type="submit"  name="cadastrar" id="cadastrar" class="btn btn-info"  value="Carregar"  >
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
</div>
</body>
</html>
	';


	}else{
		//header('Location: empreendimento');
	}
}else if((isset($_POST['nm_nome'])) && (isset($_POST['visualizar']))){
	$id					= $_POST['id_user'];
	$nome 			= $_POST['nm_nome'];	/* Seta as vartiaveis */
	$ds_curta		= $_POST['ds_curta'];
	$ds_longa		= $_POST['ds_longa'];
	$celular 		= $_POST['celular'];

	if($_FILES['im_logo']['size'] != 0){
		$arquivo = $_FILES["im_logo"];
		$pasta_dir = "../uploads/img/";
		if(!file_exists($pasta_dir)){
			mkdir($pasta_dir);
		}
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
		$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
		move_uploaded_file($arquivo["tmp_name"], $imagem);

		$sql = mysqli_query($mysqli," UPDATE empreendimentos SET im_logo= '".$imagem."' WHERE id_Empreendimentos = '".$id."' ");
	}

	$result = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM Empreendimentos WHERE id_Empreendimentos = '".$id."' "));

	$imagem = $result['im_logo'];

	if($sql = mysqli_query($mysqli," UPDATE empreendimentos SET nm_nome= '".$nome."' ,ds_curta= '".$ds_curta."' ,ds_longa= '".$ds_longa."' ,nu_telefone= '".$celular."', im_logo= '".$imagem."' WHERE id_Empreendimentos = '".$id."' ")){

	echo'
		<script>
			alert("Dados Atualizados.");
			document.location = "empreendimento";
		</script>';

	}else{
		echo'<h1> Falha no Sistema </h1>
		<h3>'.$nm_nome.' | '.$ds_email.' </h3>
		<h2> '.mysqli_error().' </h2>';
	}


}else{
echo'

<!DOCTYPE html>
<html>
	<head>
			<title>Empreendimentos</title>
		   	<link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
			<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

			<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->
			</head>
	<body>';

		$_GET['nav'] = 'adm';
		include("../nav.php");
echo'
<br>
<div class="container-fluid"> <!-- Fluido -->
 	<div class="row">
 		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Empreendimentos </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="table-responsive">
				  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
				  				<input class="form-control" id="filtro-nome" placeholder="Filtro por nome"/>
					  		</div>
					  		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					  			<table class="table table-striped">
									<thead>
								    	<tr>
													<th scope="col" width="50"> </th>
								      		<th scope="col">Nome</th>
								      		<th scope="col" width="150">Situação</th>
								      		<th scope="col" width="50">  </th>
								    	</tr>
								  	</thead>
									<tbody>
								  		';
								  		include_once("../Conexao.php");
								  		$sql= mysqli_query($mysqli,"SELECT * FROM empreendimentos");
								  		if($sql != NULL){

								  			while($sql_result=mysqli_fetch_array($sql)){
								  				echo'

										<tr>
												<td><img src="'.$sql_result["im_logo"].'" height="45" > </td>
										    <td>'.$sql_result["nm_nome"].'</td>


										    <td>
											    <div>';
											    if($sql_result["bl_ativo"]==0){
											    	echo'<a style="width: 45%;" href="empreendimento.php?id='.$sql_result["id_Empreendimentos"].'&acao=aprovar" class="btn btn-success " role="button" aria-pressed="true"><img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png"></a>
											    	<a style="width: 45%;" href="empreendimento.php?id='.$sql_result["id_Empreendimentos"].'&acao=negar" class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>';
											    }else  if($sql_result["bl_ativo"]==1){
											    	echo'<div class="btn btn-success" style="color: white; width: 94%; ">Ativo</div>';

											    }if($sql_result["bl_ativo"]==2){
											    	echo'<div class="btn btn-danger" style="color: white; width: 94%; ">Cancelado</div>';

											    }

											    echo'</div>
										    </td>
										    <td>
											    <div>
											    	<a href="empreendimento.php?id='.$sql_result["id_Empreendimentos"].'&acao=visualizar" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
											    </div>
										    </td>
										</tr>

								  				';

								  			}
								  		}
								  		echo'
								  	</tbody>
								</table>
							</div>
						</div>
				    </div>
				</div>

			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Informações </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  			</div>
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  				<center><a href="cadastro_empreendimento.php" class="btn btn-success " role="button" aria-pressed="true"> Novo Empreendimento </a> </center>
			  			</div>
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  			</div>
			  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 1%;">';
			  				 $total= mysqli_num_rows($sql);
			  					$sql= mysqli_query($mysqli,"SELECT * FROM empreendimentos WHERE bl_ativo = 1 ");
			  					$aprovado = mysqli_num_rows($sql);
			  					$sql= mysqli_query($mysqli,"SELECT * FROM empreendimentos WHERE bl_ativo = 0 ");
			  					$espera = mysqli_num_rows($sql);
			  					echo'<br><p> Estão Cadastrados '.$total.' empreendimentos.</p>
			  							<p> • '.$espera.' estão Desativados. </p>
			  							<p> • '.$aprovado.' estão Ativos. </p>';
			  				echo'
			  			</div>
				    </div>
				 </div>
			</div>
		</div>

 	</div>
</div>


</body>
';
}
?>

		<script>
			$('#filtro-nome').keyup(function() {
			    var nomeFiltro = $(this).val().toLowerCase();
			    console.log(nomeFiltro);
			    $('table tbody').find('tr').each(function() {
			        var conteudoCelula = $(this).find('td:first').text();
			        console.log(conteudoCelula);
			        var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
			        $(this).css('display', corresponde ? '' : 'none');
			    });
			});
		</script>
