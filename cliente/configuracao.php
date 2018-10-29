<?php
session_start();
require_once("../Conexao.php");  /* Chama o DB */


if (isset($_SESSION['loged'])){

	}else{
		header('Location: ../login.php');
		session_unset();
  		session_destroy();
	}




$id = $_SESSION["id_user"];

		$sql = mysqli_query($mysqli,"SELECT * FROM usuario WHERE id_usuario= '".$id."'  ");
		$result=mysqli_fetch_array($sql);

		$nm_nome = $result['nm_nome'];
		$nm_email = $result['ds_email'];
		$id_login = $result['id_usuario'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Configurações</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Define escala do Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet"> 					<!--Bootstrap -->
	<link href="../css/style.css" rel="stylesheet"> 						<!--Css próprio -->
	<script type="text/javascript" src="../js/bootstrap.js"/></script>		<!--Bootstrap -->
	<script language="JavaScript" type="text/javascript" src="../js/cidades-estados-1.4-utf8.js"></script> <!-- Biblioteca Das cidades e Estados -->
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
	<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
</head>
<body>
<?php
	$_GET['nav'] = 'cliente';
	include("../nav.php");
?>

<?php
if (isset($_GET["acao"])){
	if ((isset($_GET["id"])) && ($_GET["acao"] == 'atualizar')){

		$id = $_GET["id"];
		$nm_nome = $_POST['nm_nome'];
		$nm_email = $_POST['nm_email'];


		$senha = $_POST['ds_senha'];
		$confsenha = $_POST['ds_confsenha'];

		if($senha != NULL){

			$senha = password_hash($senha, PASSWORD_DEFAULT);

			if($sql = mysqli_query($mysqli,"UPDATE usuario SET ky_senha = '".$senha."'  WHERE id_usuario = '".$id."' ")){
				echo'
						<script>
						alert("Senha Atualizada.");
						document.location = "configuracao.php";
							</script>';
			}else{
				echo'<h1> Erro Encontrado na senha</h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h4> '.$nm_nome.' | '.$nm_email.' | '.$nu_celular.' | '.$id.'  </h4>
				 <h3>'.mysql_error().'</h3>
			';
			}
		}

	}
}


echo'
<br>
<div class="container-fluid"> <!-- Fluido -->
 	<div class="row">
 		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Edição de Conta </b></h5>
			  	</div>
			  	<div class="card-body">

			  			<form name="Combos" id="Combos" action="configuracao.php?acao=atualizar&id='.$id.'" method="post" enctype="multipart/form-data"> <!-- Formulário -->
			  				<div class="row">
			  					';



									echo'
			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome<a class="text-danger">*</a><br>
									<input type="text" name="nm_nome" class="form-control" maxlength="44" value="'.$nm_nome.'" required readonly/> </label>

			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Email<a class="text-danger">*</a><br>
									<input type="email" name="nm_email" class="form-control" maxlength="74" value="'.$nm_email.'" required readonly/> </label>

									<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Senha <a class="text-danger">*</a><br>
									<input type="password" name="ds_senha" id="password" maxlength="25" class="form-control" /> </label>

									<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Confirme a Senha <a class="text-danger">*</a><br>
									<input type="password" name="ds_confsenha" id="confirm_password" maxlength="25" class="form-control" /> </label>';

			  				echo'
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao" >';


										echo'
										<input type="submit" name="salvar" id="Salvar" class="btn btn-success"  value="Salvar" >
										';

									echo'
									<input type="button" name="Voltar" class="btn btn-danger" value="Voltar" onclick="window.history.back();">
								</div>



			  			</form>

				</div>

			</div>
		</div>
	</div>';
		include("../classes/versionamento.php");
		echo'

 	</div>
</div>


</body>
</html>';
