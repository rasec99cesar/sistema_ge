<?php
session_start(); /* Inicia Sessão */
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 0)){

}else{
	header('Location: ../login.php');
	session_unset();
  	session_destroy();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Cliente </title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
	<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

	<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
	<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
	<script language="JavaScript" type="text/javascript" src="../js/cidades-estados-1.4-utf8.js"></script> <!-- Biblioteca Das cidades e Estados -->
</head>
<body>
<?php $_GET['nav'] = 'adm';
	include("../nav.php");
if (isset($_POST['cadastrar'])) { 	/* Se o Botão Entrar for Pressionado */
	$nome 			= $_POST['nm_nome'];	/* Seta as vartiaveis */
	$email 			= $_POST['ds_email'];
	$senha 			= $_POST['ds_senha'];
	$celular 		= $_POST['celular'];
	$conf_senha = $_POST['ds_confsenha'];

	include("../Conexao.php");  /* Chama o DB */


		$sql =mysqli_query($mysqli,"SELECT ds_email FROM usuario WHERE ds_email = '".$email."' ");	/* Verifica se existe o email no banco */
		$linhas = mysqli_num_rows($sql);														/* Conta as linhas */
		if( $linhas == 0){																	/* Se não existir o email, deixa cadastar */
			if($senha != $conf_senha){ /* Se as Senhas não coincidem... */
				echo'
					<script>
					alert("As Senhas não Coincidem");
					document.location = "cadastro_prestador.php";
				   	</script>';
			}else{ /* Se coincidem */
				$senha = password_hash($senha, PASSWORD_DEFAULT);



				$sql =mysqli_query($mysqli,"INSERT INTO usuario(nm_nome, ds_email, ky_senha, bl_ativo, lv_nivel, nu_telefone) VALUES ('".$nome."','".$email."','".$senha."','0','1','".$celular."')"); 														 /* Insere os dados do prestador */

				if($sql==TRUE){ /* Se Obtiver Sucesso */
					echo'
					<script>
					alert("Cadastro Realizado Com Sucesso!");
				   	document.location = "prestador.php";
				   	</script>';				/* Exibe mensagem de sucesso e manda pro login */
				}else{ 						/* Se não */
					echo'<h2> Erro Fatal <h2>
						 <br>
						 <h3>'.mysql_error().'</h3>
						 <br>
						 <h4>'.$nome.' | '.$cpf.' | '.$cnh.'| '.$categoria.' | '.$sexo.' | '.$email.' | '.$nascimento.' | '.$celular.' | '.$endereco.' | '.$numero.' | '.$complemento.' | '.$cep.' | '.$estado.' | '.$cidade.' | '.$senha.' | '.$conf_senha.' </h4>
					';
				}
			}
		}else{
			echo'
					<script>
					alert("O Email '.$email.' já está em uso.");
					document.location = "cadastro_prestador.php";
				   	</script>';
		}

}else{  /* Caso seja primeiro acesso */

	echo'<br>
		<div class="container-fluid" id="Pagina"> <!-- Faz o Responsivo ser "Fluido" -->
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 -->
		<div class="card">
		<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
		   	<h5 class="card-title" style="color:white;" > <center> Novo Cliente </h5>

		</div>
		<div class="card-body">
			<div class="row">
				<form name="Usuario" id="Usuario" action="cadastro_prestador.php" method="post" enctype="multipart/form-data"> <!-- Formulário -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row"> <!-- Gera uma campo de flutuação -->
							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome Completo <a class="text-danger">*</a><br>
							<input type="text" name="nm_nome"  class="form-control" maxlength="70" placeholder="Arthur Dent" required/></label>

							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> E-mail <a class="text-danger">*</a><br>
							<input type="mail" name="ds_email" id="ds_email" class="form-control" maxlength="80"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="seuemail@dominio.com" required/> </label>

							<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> Telefone <a class="text-danger">*</a><br>
							<input type="text" name="celular" id="celular" id="celular" class="form-control" maxlength="15" placeholder="(47) 98489-8984" required/> </label>

							<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Senha <a class="text-danger">*</a><br>
							<input type="password" name="ds_senha" id="password" maxlength="25" class="form-control" required/> </label>

							<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Confirme a Senha <a class="text-danger">*</a><br>
							<input type="password" name="ds_confsenha" id="confirm_password" maxlength="25" class="form-control" required/> </label>

						<script>
							var password = document.getElementById("password")
							  , confirm_password = document.getElementById("confirm_password");

							function validatePassword(){
							  if(password.value != confirm_password.value) {
							  	document.getElementById("ds_confsenha").removeAttribute("class");
								document.getElementById("cd_cpf").setAttribute("class", "form-control is-invalid");
							    confirm_password.setCustomValidity("Senhas diferentes!");
							  } else {
							    confirm_password.setCustomValidity("");
							  }
							}

							password.onchange = validatePassword;
							confirm_password.onkeyup = validatePassword;
						</script>




					<br>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao" >
							<center><input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Salvar" >

						</div>
					</div>
				</form>
			</div>
		</div>
		</div>
		</div>
	</div>
	';

}
?>

</body>
</html>
