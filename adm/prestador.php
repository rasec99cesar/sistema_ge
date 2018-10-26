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

		header('Location: prestador.php?id='.$id.'&acao=visualizar');

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
		$sql = mysqli_query($mysqli," INSERT INTO usuario_has_arquivos(usuario_id_usuario, arquivos_id_arquivos, bl_ativo) VALUES ('".$id."','".$result['id_arquivos']."','1') ");
		header('Location: prestador.php?id='.$id.'&acao=visualizar');

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_arq')){
	$id = $_GET['id'];
	$id_arquivo = $_GET['id_arquivo'];

	$sql = mysqli_query($mysqli,"UPDATE arquivos SET bl_ativo='0' WHERE id_arquivos='".$id_arquivo."' ");
	$sql = mysqli_query($mysqli,"UPDATE usuario_has_arquivos SET bl_ativo='0' WHERE arquivos_id_arquivos='".$id_arquivo."' ");
	header('Location: prestador.php?id='.$id.'&acao=visualizar');

}


if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysqli_query($mysqli,"SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysqli_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysqli_query($mysqli,"UPDATE prestador_has_servico SET bl_ativo='0' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: prestador.php?id='.$id.'&acao=visualizar');
	}else{
		$sql = mysqli_query($mysqli,"INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','0') ");
		header('Location: prestador.php?id='.$id.'&acao=visualizar');
	}

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='ativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysqli_query($mysqli,"SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysqli_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysqli_query($mysqli,"UPDATE prestador_has_servico SET bl_ativo='1' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: prestador.php?id='.$id.'&acao=visualizar');
	}else{
		$sql = mysqli_query($mysqli,"INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','1') ");
		header('Location: prestador.php?id='.$id.'&acao=visualizar');
	}

}




	if($_GET["acao"] == 'aprovar'){
		if($sql= mysqli_query($mysqli,"UPDATE usuario SET bl_ativo= 1 WHERE id_usuario= '".$id."' ")){
			header('Location: prestador');
		}else{
			echo'<h1> Erro Encontrado </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'.mysql_error().'</h3>
			';
		}
	}else if($_GET["acao"] == 'negar'){
		if($sql= mysqli_query($mysqli,"UPDATE usuario SET bl_ativo= 2 WHERE id_usuario= '".$id."' ")){
			header('Location: prestador');
		}else{
			echo'<h1> Erro Encontrado </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'.mysql_error().'</h3>
			';
		}
	}else if($_GET["acao"] == 'visualizar'){
		$sql = mysqli_query($mysqli,"SELECT * FROM usuario WHERE id_usuario='".$id."' ");
		$result= mysqli_fetch_array($sql);

		$nm_nome  		=$result['nm_nome'];
		$nm_email 		=$result['ds_email'];
		$celular			=$result['nu_telefone'];
		echo'


		<!DOCTYPE html>
		<html>
		<head>
			<title>Corretores</title>
		    <link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
			<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

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
						<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
							<h5 class="card-title" style="color:white;" > <center> Visualização de Corretor </h5>
						</div>
						<div class="card-body">
							<form name="Usuario" id="Usuario" action="prestador.php?acao=visual" method="post" enctype="multipart/form-data"> <!-- Formulário -->
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <!-- Faz os campos de texto ocuparem 8 -->
											<input type="text" name="visualizar"  class="form-control" maxlength="70" value="1" required hidden/>
											<input type="text" name="id_user" value="'.$id.'" hidden/>
											<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome Completo <a class="text-danger">*</a><br>
												<input type="text" name="nm_nome"  class="form-control" maxlength="70" value="'.$nm_nome.'" required/>
											</label>
											<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> E-mail <a class="text-danger">*</a><br>
												<input type="mail" name="ds_email" id="ds_email" class="form-control" maxlength="80"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="'.$nm_email.'" required/>
											</label>

											<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> Telefone <a class="text-danger">*</a><br>
												<input type="text" name="celular" id="celular" id="celular" class="form-control" maxlength="15" value="'.$celular.'" required/>
											</label>


	<div class="row" style="margin-left:1px; margin-right:1px;">

																				<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Nova Senha <a class="text-danger">*</a><br>
																				<input type="password" name="ds_senha" id="password" maxlength="25" class="form-control" /> </label>

																				<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Confirme a Nova Senha <a class="text-danger">*</a><br>
																				<input type="password" name="ds_confsenha" id="ds_confsenha" maxlength="25" class="form-control" /> </label>

																				<script>
																					var password = document.getElementById("password")
																					  , confirm_password = document.getElementById("confirm_password");

																					function validatePassword(){
																					  if(password.value != confirm_password.value) {
																					    confirm_password.setCustomValidity("Senhas diferentes!");
																					  } else {
																					    confirm_password.setCustomValidity("");
																					  }
																					}

																					password.onchange = validatePassword;
																					confirm_password.onkeyup = validatePassword;
																				</script>


</div>

















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
					<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
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
							<a style="width: 49%" href="prestador.php?id='.$result["id_usuario"].'&acao=aprovar" class="btn btn-success " role="button" aria-pressed="true">
								<img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png">
							</a>

							<a style="width: 49%; padding-left:2%;" href="prestador.php?id='.$result["id_usuario"].'&acao=negar" class="btn btn-danger " role="button" aria-pressed="true">
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
						<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
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
										if($sql_arquivo = mysqli_query($mysqli,"SELECT * FROM usuario_has_arquivos WHERE usuario_id_usuario ='".$id."' AND bl_ativo = '1' ")){

										while($sql_result_arqui = mysqli_fetch_array($sql_arquivo)){
											$sql_result_arq = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM arquivos WHERE id_arquivos ='".$sql_result_arqui['arquivos_id_arquivos']."' AND bl_ativo = '1' "));
										echo'
										<tr>
											<td>'.$sql_result_arq['nm_nome'].'</td>
											<td>
												<div>
													<a  href="prestador.php?id='.$id.'&id_arquivo='.$sql_result_arq["id_arquivos"].'&acao=desativa_arq " class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>
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
					<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
						<h5 class="card-title" style="color:white;" > <center> Novo Arquivo </h5>
					</div>
					<div class="card-body">
						<form name="Usuario" id="Usuario" action="prestador.php?acao=upload_arq&id='.$id.'" method="post" enctype="multipart/form-data"> <!-- Formulário -->
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
		//header('Location: prestador');
	}
}else if((isset($_POST['nm_nome'])) && (isset($_POST['visualizar']))){
	$id = $_POST['id_user'];
	$nm_nome = $_POST['nm_nome'];
	$ds_email = $_POST['ds_email'];
	$senha = $_POST['ds_senha'];
	$celular = $_POST['celular'];

	if($senha != NULL){
		$senha = password_hash($senha, PASSWORD_DEFAULT);
		$sql = mysqli_query($mysqli,"UPDATE usuario SET ky_senha = '".$senha."'  WHERE id_usuario = '".$id."' ");
		echo'
			<script>
				alert("Senha Atualizada.");
				document.location = "prestador";
			</script>';
	}

	if($sql = mysqli_query($mysqli,"UPDATE usuario SET nm_nome = '".$nm_nome."', ds_email= '".$ds_email."', nu_telefone = '".$celular."'  WHERE id_usuario = '".$id."' ")){

	echo'
		<script>
			alert("Dados Atualizados.");
			document.location = "prestador";
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
			<title>Corretores</title>
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
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Corretores </b></h5>
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
								      		<th scope="col">Nome</th>
								      		<th scope="col">Email</th>
													<th scope="col">Telefone</th>
								      		<th scope="col">Situação</th>
								      		<th scope="col">  </th>
								    	</tr>
								  	</thead>
									<tbody>
								  		';
								  		include_once("../Conexao.php");
								  		$sql= mysqli_query($mysqli,"SELECT * FROM usuario WHERE lv_nivel = 1");
								  		if($sql != NULL){
								  			while($sql_result=mysqli_fetch_array($sql)){
								  				echo'

										<tr>
										    <td>'.$sql_result["nm_nome"].'</td>
										    <td>'.$sql_result["ds_email"].'</td>
												<td>'.$sql_result["nu_telefone"].'</td>

										    <td>
											    <div>';
											    if($sql_result["bl_ativo"]==0){
											    	echo'<a style="width: 45%;" href="prestador.php?id='.$sql_result["id_usuario"].'&acao=aprovar" class="btn btn-success " role="button" aria-pressed="true"><img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png"></a>
											    	<a style="width: 45%;" href="prestador.php?id='.$sql_result["id_usuario"].'&acao=negar" class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>';
											    }else  if($sql_result["bl_ativo"]==1){
											    	echo'<div class="btn btn-success" style="color: white; width: 94%; ">Ativo</div>';

											    }if($sql_result["bl_ativo"]==2){
											    	echo'<div class="btn btn-danger" style="color: white; width: 94%; ">Cancelado</div>';

											    }

											    echo'</div>
										    </td>
										    <td>
											    <div>
											    	<a href="prestador.php?id='.$sql_result["id_usuario"].'&acao=visualizar" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
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
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Informações </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  			</div>
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  				<center><a href="cadastro_prestador.php" class="btn btn-success " role="button" aria-pressed="true"> Novo Cliente </a> </center>
			  			</div>
			  			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">
			  			</div>
			  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 1%;">';
			  				 $total= mysqli_num_rows($sql);
			  					$sql= mysqli_query($mysqli,"SELECT * FROM usuario WHERE bl_ativo = 1 AND lv_nivel= 1");
			  					$aprovado = mysqli_num_rows($sql);
			  					$sql= mysqli_query($mysqli,"SELECT * FROM usuario WHERE bl_ativo = 0 AND lv_nivel= 1");
			  					$espera = mysqli_num_rows($sql);
			  					echo'<br><p> Estão Cadastrados '.$total.' corretores.</p>
			  							<p> • '.$espera.' Aguardando aprovação. </p>
			  							<p> • '.$aprovado.' Estão Ativos. </p>';
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
