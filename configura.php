<?php
session_start();
include("Conexao.php");  /* Chama o DB */


if (isset($_GET['nivel'])){

	}else{
		header('Location: login.php');
		session_unset();
  		session_destroy();
	}




$id_user = $_SESSION["id_user"];

		$sql = mysql_query("  SELECT * FROM cliente WHERE id_cliente = '".$id_user."'  ");
		$result=mysql_fetch_array($sql);

		$nm_nome = $result['nm_nome'];
		$nm_email = $result['nm_email'];
		$ds_rua = $result['ds_rua'];
		$nu_numero = $result['nu_numero'];
		$nu_cep = $result['nu_cep'];
		$nu_celular = $result['nu_celular'];
		$nu_cpf = $result['nu_cpf'];
		$ds_sexo = $result['ds_sexo'];
		$ds_complemento = $result['ds_complemento'];
		$nm_cidade = $result['nm_cidade'];
		$nm_estado = $result['nm_estado'];
		$dt_nascimento = $result['dt_nascimento'];
		$id_login = $result['Login_id_login'];

		$sql = mysql_query("  SELECT * FROM login WHERE id_login = '".$id_login."'  ");
		$resultado=mysql_fetch_array($sql);
		$ds_senha = $resultado['ds_senha'];
		$nu_nivel = $resultado['nu_nivel'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edição de Cliente | Family Car</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Define escala do Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet"> 					<!--Bootstrap -->
	<link href="css/style.css" rel="stylesheet"> 						<!--Css próprio -->
	<script type="text/javascript" src="js/bootstrap.js"/></script>		<!--Bootstrap -->
	<script language="JavaScript" type="text/javascript" src="js/cidades-estados-1.4-utf8.js"></script> <!-- Biblioteca Das cidades e Estados -->
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
	<script type="text/javascript" src="js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid"> <!-- Fluido -->
 	  	<div class="row">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
			    <ul class="navbar-nav">
			    	<li class="nav-item">
			        	<a class="nav-link" href="combos.php">Combos</a>
			    	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="personalcar.php">Personal Car</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="motoristaamigo.php">Motorista Amigo</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="cuidadores.php">Cuidadores</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="petsister.php">Pet Sister</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="#"><b>Configurações</b></a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="sair.php">Sair</a>
			      	</li>

			    </ul>
			</div>

		</div>
	</div>
</nav>

<?php
if (isset($_POST['cadastrar'])) { 	/* Se o Botão Entrar for Pressionado */
	$nome = $_POST['nm_nome'];	/* Seta as vartiaveis */
	$cpf = $_POST['cd_cpf'];
	$sexo = $_POST['ds_sexo'];
	$email = $_POST['ds_email'];
	$nascimento = $_POST['dt_nascimento'];
	$celular = $_POST['nr_celular'];
	$endereco = $_POST['ds_endereco'];
	$numero = $_POST['nr_numero'];
	$complemento = $_POST['ds_complemento'];
	$cep = $_POST['nr_cep'];
	$estado = $_POST['nm_uf'];
	$cidade = $_POST['nm_cidade'];
	$senha = $_POST['ds_senha'];
	$conf_senha = $_POST['ds_confsenha'];

	include("Conexao.php");  /* Chama o DB */

	if (isset($_POST['excluir'])){
		$excluir = $_POST['excluir'];

		$sql = mysql_query("UPDATE login SET nu_nivel = '0' WHERE id_login='".$id_login."' ");
		mysql_error();
		echo'
					<script>
					alert("Conta Desativada");
					document.location = "login.php";
				   	</script>';
	}else{

		if($senha != $conf_senha){ /* Se as Senhas não coincidem... */
					echo'
						<script>
						alert("As Senhas não Coincidem");
						document.location = "configura.php";
					   	</script>';
				}else{ /* Se coincidem */
					$sql = mysql_query("UPDATE login SET nm_usuario ='".$email."', ds_senha='".$senha."' WHERE id_login='".$id_login."' "); 	/* Atualiza o login */
					$sql = mysql_query("UPDATE cliente SET nm_email ='".$email."', ds_rua = '".$endereco."', nu_numero = '".$numero."', nu_cep ='".$cep."' , nu_celular ='".$celular."' , ds_complemento ='".$complemento."' , nm_cidade ='".$cidade."' , nm_estado ='".$estado."' WHERE id_cliente='".$id_user."'  "); 														 /* Insere os dados do cliente */

					if($sql==TRUE){ /* Se Obtiver Sucesso */
						echo'
						<script>
						alert("Dados Atualizados com Sucesso");
					   	document.location = "cliente.php";
					   	</script>';				/* Exibe mensagem de sucesso e manda pro login */
					}else{ 						/* Se não */
						echo'<h2> Erro Fatal <h2>
							 <br>
							 <h3>'.mysql_error().'</h3>
							 <br>
							 <h4>'.$nome.' | '.$cpf.' | '.$sexo.' | '.$email.' | '.$nascimento.' | '.$celular.' | '.$endereco.' | '.$numero.' | '.$complemento.' | '.$cep.' | '.$estado.' | '.$cidade.' | '.$senha.' | '.$conf_senha.' </h4>
						';						/* Exibe as variavéis e o erro */
					}
		}
	}
}
?>



<div class="container-fluid" id="Pagina"> <!-- Faz o Responsivo ser "Fluido" -->
 	<div class="row">
		<form name="Usuario" id="Usuario" action="configura.php" method="post" enctype="multipart/form-data"> <!-- Formulário -->
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 -->
				<div class="row" id="CadUm"> <!-- Gera uma campo de flutuação -->
					<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome Completo <a class="text-danger">*</a><br>
					<input type="text" name="nm_nome"  class="form-control" maxlength="70" <?php echo' value="'.$nm_nome.'" '; ?> required readonly/></label>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">CPF <a class="text-danger">*</a><br>
					<input type="text" name="cd_cpf" id="cd_cpf" maxlength="20" class="form-control" placeholder="113.577.999-75" <?php echo' value="'.$nu_cpf.'" '; ?> required readonly/></label> <!--Use readonly="true"-->


					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Sexo <a class="text-danger">*</a><br>
					<input type="text" name="ds_sexo" id="ds_sexo" class="form-control" <?php echo' value="'.$ds_sexo.'" '; ?> required readonly/> </label>


					<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> E-mail <a class="text-danger">*</a><br>
					<input type="mail" name="ds_email" id="ds_email" class="form-control" maxlength="80"  <?php echo' value="'.$nm_email.'" '; ?> required/> </label>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> Data de Nascimento <a class="text-danger">*</a><br>
					<input type="text" name="dt_nascimento" id="theDate" class="form-control" <?php echo' value="'.$dt_nascimento.'" '; ?> required readonly/> </label>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Telefone Celular <a class="text-danger">*</a><br>
					<input type="tel" name="nr_celular" id="nr_celular" maxlength="15" class="form-control" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" <?php echo' value="'.$nu_celular.'" '; ?> required/> </label>
					<script type="text/javascript">$("#nr_celular").mask("(00) 00000-0000");</script>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Endereço <a class="text-danger">*</a><br>
					<input type="text" name="ds_endereco" class="form-control" maxlength="110" <?php echo' value="'.$ds_rua.'" '; ?> required/> </label>

					<label class="col-xs-4 col-sm-2 col-md-2 col-lg-2">Número <br>
					<input type="text" name="nr_numero" maxlength="8" class="form-control" pattern="[0-9]+$" <?php echo' value="'.$nu_numero.'" '; ?>/> </label>

					<label class="col-xs-8 col-sm-4 col-md-4 col-lg-4">Complemento <br>
					<input type="text" name="ds_complemento"  maxlength="80" class="form-control" <?php echo' value="'.$ds_complemento.'" '; ?>/> </label>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">CEP <a class="text-danger">*</a><br>
					<input type="text" name="nr_cep" id="nr_cep" maxlength="8" class="form-control" pattern= "\d{5}-?\d{3}" <?php echo' value="'.$nu_cep.'" '; ?> required/> </label>
					<script type="text/javascript">$("#nr_cep").mask("00000-000");</script>

					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3">Estado <a class="text-danger">*</a><br>
					<select id="estado"  name="nm_uf" class="form-control" <?php echo' value="'.$nm_estado.'" '; ?>  required/> </select></label>

					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3">Cidade <a class="text-danger">*</a><br>
					<select id="cidade" name="nm_cidade" class="form-control" <?php echo' value="'.$nm_cidade.'" '; ?> required/></select></label>
				</div>

				<!-- Script que gera a mudanã de estados e cidades -->
				<script language="JavaScript" type="text/javascript" charset="utf-8">
					new dgCidadesEstados({
						cidade: document.getElementById("cidade"),
						estado: document.getElementById("estado")
					})
				</script>

				<div class="row" id="CadDois"> <!-- Gera uma campo de flutuação -->
					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Senha <a class="text-danger">*</a><br>
					<input type="password" name="ds_senha" id="password" maxlength="25" class="form-control" <?php echo' value="'.$ds_senha.'" '; ?> required/> </label>

					<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Confirme a Senha <a class="text-danger">*</a><br>
					<input type="password" name="ds_confsenha" id="confirm_password" maxlength="25" class="form-control" <?php echo' value="'.$ds_senha.'" '; ?> required/> </label>


				</div>
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


				<div class="row" id="CadTres">
				<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<br>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="exampleCheck1" name="excluir">
				    <label class="form-check-label" for="exampleCheck1">Desejo Desativar minha Conta. <a class="text-info"> Atenção, este processo é irreversível!
				    </a></label>
				</div>
				<br>
				</label>


			</div>

			</div>


			<div class="row"> <!-- Gera uma campo de flutuação -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao">
					<input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Salvar" >
					<input type="reset" name="Limpar" class="btn btn-danger" value="Limpar">
				</div>
			</div>
		</form>
	</div>
</div>

</body>
</html>
