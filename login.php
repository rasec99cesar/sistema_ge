<?php
session_start(); /* Inicia Sessão */
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 0)){ /* Se ja estiver logado como cliente */
	if (isset($_SESSION["id_user"])){
		header('Location: adm/prestador.php'); /* Redireciona para cliente */
	}
}
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 1)){ /* Se já estiver logado como prestador */
	if (isset($_SESSION["id_user"])){
		header('Location: cliente/arquivos.php'); /* Redireciona para Prestador */
	}
}

if (isset($_POST['entrar'])) { 	/* Se o Botão Entrar for Pressionado */
	include("Conexao.php");    	/* Chama o DB */

	$email = $_POST['email'];	/* Seta as vartiaveis */
	$senha = $_POST['senha'];


	if($sql = mysqli_query($mysqli,"SELECT * FROM usuario WHERE ds_email='".$email."' AND bl_ativo = '1' ")){

		$result_senha = mysqli_fetch_array($sql);
		$hash = $result_senha['ky_senha'];
		$id= $result_senha['id_usuario'];



		if (password_verify($senha, $hash)) {


			// Correct Password
			$sql = mysqli_query($mysqli,"SELECT * FROM usuario WHERE ds_email='".$email."' AND bl_ativo = '1' ");
			$login_result = mysqli_fetch_assoc($sql); 	/* associação do resultado */
			if($login_result == NULL){	/* Se o usuario não existir */
				echo '
				<div id="notificacao" class="alert alert-danger" role="alert">
				Dados Incorretos, tente novamente.
				</div>';
			}else{						/* Se o Usuario Existir */
				$_SESSION['error'] = 0;
				if($login_result['lv_nivel']==0){
					if($login_result['bl_ativo']==0){
						echo '
						<div id="notificacao" class="alert alert-danger" role="alert" style="">
						Conta Desabilitada.
						</div>';
					}else{
						$_SESSION["id_user"] = $login_result['id_usuario'];				/* Define globalmente o id */
						$_SESSION["loged"] = $login_result['lv_nivel'];				/* Define Globalmente o nivel */
						header('Location: adm/prestador.php');							/* Manda Pra pagina Cliente */
					}
				}else if($login_result['lv_nivel']==1){
					if($login_result['bl_ativo']==0){
						echo '
						<div id="notificacao" class="alert alert-danger" role="alert" style="">
						Conta Desabilitada.
						</div>';
					}else{
						$_SESSION["id_user"] = $login_result['id_usuario'];				/* Define globalmente o id */
						$_SESSION["loged"] = $login_result['lv_nivel'];				/* Define Globalmente o nivel */
						header('Location: cliente/arquivos.php');							/* Manda Pra pagina Cliente */
					}
				}
			}
		}else{
			echo '
			<div id="notificacao" class="alert alert-danger" role="alert">
			<center>Dados Inconsistentes.
			</div>';
		}
	}else{
		echo '
		<div id="notificacao" class="alert alert-danger" role="alert">
		<center>Dados Inconsistentes.
		</div>';
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema para Corretores </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Define escala do Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet"> 					<!--Bootstrap -->
	<link href="css/style.css" rel="stylesheet"> 						<!--Css próprio -->
	<script type="text/javascript" src="js/bootstrap.js"/></script>		<!--Bootstrap -->
	<script type="text/javascript" src="js/jquery-3.2.1.js"/></script> <!-- JQuery -->
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<br>
				<br>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
				<div class="card" style="margin-top: 42%;">
					<div  style="margin-top: 15px; margin-left: 25%; margin-right: 25%; padding: 20px;">
						<center>  <img src="img/logo.png"  height="50" alt="logo">
						</center></div>
						<form name="login" value="Login" id="Login" action="login.php" method="post" style="padding: 10px;margin-bottom: 20px">
							<div class="form-group">
								<label class="email">Email:</label>
								<input type="email" name="email" class="form-control" id="Email" placeholder="exemplo@exemplo.com" required>
							</div>
							<div class="form-group">
								<label>Senha</label>
								<input type="password" name="senha" class="form-control" id="Senha" placeholder="Sua Senha" required>
							</div>
							<center> <input type="submit" name="entrar" class="btn btn-success"  value="Entrar">
								<a href="cadastro.php">  <input type="button" name="Cadastrar-se" class="btn btn-info"  value="Cadastrar-se"> </a>
							</form>
						</div>													<!--Fecha Card -->
					</div>
				</div>															<!--fecha Row -->
			</div> 																<!--fecha container -->
		</body>
		</html>
