<?php
session_start(); /* Inicia Sessão */
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 4)){ /* Se ja estiver logado como cliente */
	if (isset($_SESSION["id_user"])){
		header('Location: ../login.php'); /* Redireciona para cliente */
	}
}
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 5)){ /* Se já estiver logado como prestador */
	if (isset($_SESSION["id_user"])){
		header('Location: ../login.php'); /* Redireciona para Prestador */
	}
}
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 4)){ /* Se já estiver logado como Adm */
	if (isset($_SESSION["id_user"])){
		header('Location: ../login.php'); /* Redireciona para Adm */
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Prestador de Serviço | Family Car</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Define escala do Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet"> 					<!--Bootstrap -->
	<link href="../css/style.css" rel="stylesheet"> 						<!--Css próprio -->
	<script type="text/javascript" src="../js/bootstrap.bundle.js"/></script>		<!--Bootstrap -->
	<script language="JavaScript" type="text/javascript" src="../js/cidades-estados-1.4-utf8.js"></script> <!-- Biblioteca Das cidades e Estados -->
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
	<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
</head>
<body>
<?php $_GET['nav'] = 'adm';
	include("../nav.php");
	include("../Conexao.php");  /* Chama o DB */
	$id = $_GET['id'];
	$sql = mysql_query("SELECT * FROM prestador WHERE id_prestador = '".$id."' ");
	$sql_result = mysql_fetch_array($sql);

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

		$sql= mysql_query("UPDATE prestador SET ft_foto = '".$imagem."' WHERE id_prestador= '".$id."' ");

		header('Location: cadastro_prestador_2.php?id='.$id.'');
}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='upload_arq')){
	$id = $_GET['id'];
	$nome = $_POST['nome_arquivo'];
	include_once('../classes/m2brimagem.class.php');
	$arquivo = $_FILES["aq_arquivo"];
		$pasta_dir = "../uploads/arqvs/";
		if(!file_exists($pasta_dir)){
			mkdir($pasta_dir);
		}
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $arquivo["name"], $ext);
		$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
		move_uploaded_file($arquivo["tmp_name"], $imagem);

		$sql = mysql_query("INSERT INTO arquivos(nm_nome, ds_endereco, tp_portador, id_portador, bl_ativo) VALUES ('".$nome."','".$imagem."','5','".$id."','1') ");

		header('Location: cadastro_prestador_2.php?id='.$id.'');
}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_arq')){
	$id = $_GET['id'];
	$id_arquivo = $_GET['id_arquivo'];

	$sql = mysql_query("UPDATE arquivos SET bl_ativo='0' WHERE id_arquivo='".$id_arquivo."' ");

	header('Location: cadastro_prestador_2.php?id='.$id.'');
}



if ((isset($_GET['acao'])) && ($_GET['acao'] =='desativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysql_query("SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysql_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysql_query("UPDATE prestador_has_servico SET bl_ativo='0' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: cadastro_prestador_2.php?id='.$id.'');
	}else{
		$sql = mysql_query("INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','0') ");
		header('Location: cadastro_prestador_2.php?id='.$id.'');
	}

}

if ((isset($_GET['acao'])) && ($_GET['acao'] =='ativa_serv')){
	$id = $_GET['id'];
	$id_servico = $_GET['id_servico'];
	$sql = mysql_query("SELECT * FROM prestador_has_servico WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
	$sql = mysql_fetch_array($sql);

	if($sql['id_controle']!=NULL){
		$sql = mysql_query("UPDATE prestador_has_servico SET bl_ativo='1' WHERE servicos_id_servicos='".$id_servico."' AND prestador_id_prestador = '".$id."' ");
		header('Location: cadastro_prestador_2.php?id='.$id.'');
	}else{
		$sql = mysql_query("INSERT INTO prestador_has_servico (Prestador_id_prestador, Servicos_id_servicos, bl_ativo) VALUES ('".$id."','".$id_servico."','1') ");
		header('Location: cadastro_prestador_2.php?id='.$id.'');
	}
}



if (isset($_POST['cadastrar'])) { 	/* Se o Botão Entrar for Pressionado */
	

}else{  /* Caso seja primeiro acesso */
$sql = mysql_query("SELECT * FROM prestador WHERE id_prestador= '".$id."' ");
$sql_result = mysql_fetch_array($sql);

echo'
<br>
<div class="container-fluid" id="Pagina"> <!-- Faz o Responsivo ser "Fluido" -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 -->
			<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
					<h5 class="card-title" style="color:white;" > <center> Novo Prestador </h5>
					<div class="progress" style="height: 10px;">
						<div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">2 de 2</div>
					</div>
				</div>
				<div class="card-body">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<form name="Usuario" id="Usuario" action="cadastro_prestador_2.php?acao=upload_arq&id='.$id.'" method="post" enctype="multipart/form-data"> <!-- Formulário -->
									<label class="col-xs-12 col-sm-11 col-md-11 col-lg-11">Nome do Arquivo<a class="text-danger">*</a><br>
										<input type="text" name="nome_arquivo"  class="form-control" required/>
									</label>
									<label class="col-xs-12 col-sm-10 col-md-10 col-lg-10">Arquivo<a class="text-danger">*</a><br>
										<input type="file" name="aq_arquivo"  class="form-control" required/>
									</label>
									<input type="submit"  name="cadastrar" id="cadastrar" class="btn btn-info"  value="Carregar" style="margin-left: -15px; margin-top:-5px;" >
								</form>	
							</div>
							
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11">
								<table class="table table-hover">
								  <thead>
								    <tr>
								      <th scope="col">Nome</th>
								      <th scope="col" style="width:120px;"></th>
								    </tr>
								  </thead>
								  <tbody>';
								$sql_arquivos = mysql_query("SELECT * FROM arquivos WHERE id_portador ='".$id."' AND tp_portador = '5' AND bl_ativo='1' ");
								while($sql_result_arq = mysql_fetch_array($sql_arquivos)){
									echo'
									<tr>
								      <td>'.$sql_result_arq['nm_nome'].'</td>
								      <td >
								      	<div>
								      	 <a  href="cadastro_prestador_2.php?&id='.$id.'?&id_arquivo='.$sql_result_arq["id_arquivo"].'&acao=desativa_arq " class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>
										 <a href="'.$sql_result_arq["ds_endereco"].'" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
										 </div>

								      </td>
								    </tr>
									';
								}    						   
								echo'
								  </tbody>
								</table>
							</div>	



							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<br><br>	<center><a href="prestador.php" ><input type="button" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Finalizar" > </a>
							</div>	
						</div>
					</div>
				</div>		
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <!-- Faz os campos de texto ocuparem 8 -->
			<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
					<h5 class="card-title" style="color:white;" > <center> Foto </h5>
				</div>
				<div class="card-body">';
					if($sql_result['ft_foto'] != NULL){
					echo'
					<center><img src="'.$sql_result['ft_foto'].'"  height="180" width="180"> </center>
					';
					}
					echo'
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form name="Usuario" id="Usuario" action="cadastro_prestador_2.php?acao=upload_ft&id='.$id.'" method="post" enctype="multipart/form-data"> 
							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Foto<a class="text-danger">*</a><br>
								<input type="file" name="aq_foto"  class="form-control" required/>
							</label>
							<center><input type="submit" name="cadastrar" id="cadastrar" class="btn btn-info" value="Carregar" style="margin-left:-15px;margin-top:-5px;"></center>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 --> <BR>
					<div class="card">
						<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
							<h5 class="card-title" style="color:white;" > <center> Serviços Prestados </h5>
						</div>
						<div class="card-body">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">Nome</th>
											
											<th scope="col" style="width:200px;"></th>
										</tr>
									</thead>
									<tbody>';
										$sql_servico = mysql_query("SELECT * FROM servicos WHERE bl_ativo='1' ");
										while($sql_result_serv = mysql_fetch_array($sql_servico)){
										$sql_join = mysql_query("SELECT * FROM prestador_has_servico WHERE Servicos_id_servicos = '".$sql_result_serv['id_servicos']."' AND 	Prestador_id_prestador = '".$id."'  ");
										$sql_result_join = mysql_fetch_array($sql_join);
										echo'
										<tr>
											<td>'.$sql_result_serv['nm_servico'].'</td>
											
											<td>
												<div>

													';
													if($sql_result_join['bl_ativo']==1){
												    	echo'<a class="badge badge-success" style="color:white; margin-right: 50px; width: 50px; "> Ativo   </a>
												    	<a  href="cadastro_prestador_2.php?id='.$id.'&id_servico='.$sql_result_serv['id_servicos'].'&acao=desativa_serv " class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Desativar" src="../img/thumb-down.png"></a>
												    	';
												    }if($sql_result_join['bl_ativo']==0){
												    	echo'<a class="badge badge-danger" style="color:white; margin-right: 50px; width: 50px; ">Inativo</a>
												    	<a  href="cadastro_prestador_2.php?id='.$id.'&id_servico='.$sql_result_serv['id_servicos'].'&acao=ativa_serv " class="btn btn-success " role="button" aria-pressed="true"><img width="18" height="18" alt="Ativar" src="../img/thumbs-up.png"></a>
												    	';
												    }
													echo'
																									
												</div>
											</td>
										</tr>
										';
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
	';

}
?>

<script>
function uparq() {
    document.location = "cadastro_prestador_2.php?acao=upload_arq&id=<?php echo $id; ?>";
}
function upft() {
    document.location = "cadastro_prestador_2.php?acao=upload_ft&id=<?php echo $id; ?>";
}
</script>	
</body>
</html>