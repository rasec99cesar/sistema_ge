<?php
session_start();

if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 0)){

}else{
	header('Location: ../login.php');
	session_unset();
  	session_destroy();
}

include_once("../Conexao.php");

if (isset($_GET["acao"])){
	if ((isset($_GET["id"])) && ($_GET["acao"] == 'visualizar')){
		$id = $_GET["id"];
		$sql = mysqli_query($mysqli,"SELECT * FROM usuario WHERE id_usuario='".$id."' ");

		$result = mysqli_fetch_array($sql);
		$nm_nome = $result['nm_nome'];
		$nm_email = $result['ds_email'];
		$id_login = $result['id_usuario'];

echo'

<html>
<head>
	<title> Configurações </title>

	<link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
	<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

	<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
	<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->

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
			    	<h5 class="card-title" style="color:white;" > <center><b> Edição Administrador </b></h5>
			  	</div>
			  	<div class="card-body">

			  			<form name="Combos" id="Combos" action="configura.php?acao=atualizar&id='.$id.'" method="post" enctype="multipart/form-data"> <!-- Formulário -->
			  				<div class="row">
			  					';



									echo'
			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome<a class="text-danger">*</a><br>
									<input type="text" name="nm_nome" class="form-control" maxlength="44" value="'.$nm_nome.'" required/> </label>

			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Email<a class="text-danger">*</a><br>
									<input type="email" name="nm_email" class="form-control" maxlength="74" value="'.$nm_email.'" required/> </label>

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
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%; margin-top: 25px;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Administradores </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="table-responsive">
				  			<table class="table table-striped">
								<thead>
							    	<tr>
							      		<th scope="col">Nome</th>
							      		<th scope="col">Email</th>
							      		<th scope="col">  </th>
							    	</tr>
							  	</thead>
								<tbody>
							  		';
							  		include_once("../Conexao.php");
							  		$sql= mysqli_query($mysqli,"SELECT * FROM usuario where lv_nivel = 0");
							  		if($sql != NULL){
							  			while($sql_result=mysqli_fetch_array($sql)){
							  				echo'

									<tr>
									    <td>'.$sql_result["nm_nome"].'</td>
									    <td>'.$sql_result["ds_email"].'</td>
			   						    <td>
										    <div>
										    	<a href="configura.php?id='.$sql_result["id_usuario"].'&acao=visualizar" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
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
</div>


</body>
';





	}else if ((isset($_GET["id"])) && ($_GET["acao"] == 'atualizar')){
		$id = $_GET["id"];
		$nm_nome = $_POST['nm_nome'];
		$nm_email = $_POST['nm_email'];


		$senha = $_POST['ds_senha'];
		$confsenha = $_POST['ds_confsenha'];

		if($senha != NULL){

			$senha = password_hash($senha, PASSWORD_DEFAULT);

			if($sql = mysqli_query($mysqli,"UPDATE usuario SET ky_senha = '".$senha."'  WHERE id_usuario = '".$id."' ")){

			}else{
				echo'<h1> Erro Encontrado na senha</h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h4> '.$nm_nome.' | '.$nm_email.' | '.$nu_celular.' | '.$id.'  </h4>
				 <h3>'.mysql_error().'</h3>
			';
			}
		}




		if($sql = mysqli_query($mysqli,"UPDATE usuario SET nm_nome = '".$nm_nome."', ds_email = '".$nm_email."' WHERE id_usuario = '".$id."' ")){
			echo'
					<script>
					alert("Dados Atualizados.");
					document.location = "configura.php";
				   	</script>';

		}else{
			echo'<h1> Erro Encontrado  </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'.mysql_error().'</h3>
			';
		}

	}

	if($_GET["acao"] == 'novo'){
		$nm_nome = $_POST['nm_nome'];
		$nm_email = $_POST['nm_email'];
		$nu_celular = $_POST['nr_celular'];

		$senha = $_POST['ds_senha'];
		$conf_senha = $_POST['ds_confsenha'];



		if($senha != $conf_senha){ /* Se as Senhas não coincidem... */
				echo'
					<script>
					alert("As Senhas não Coincidem");
					document.location = "configura.php";
				   	</script>';
		}else{ /* Se coincidem */
				$senha = password_hash($senha, PASSWORD_DEFAULT);


			if($sql = mysqli_query($mysqli,"INSERT INTO usuario(nm_nome, ds_email, ky_senha, bl_ativo, lv_nivel) VALUES ('".$nm_nome."','".$nm_email."','".$senha."','1','0')")){ 	/* Cria o login */
				
				echo'
					<script>
					alert("Cadastro efetuado com sucesso!");
					document.location = "configura.php";
				   	</script>';
			}else{
				echo'<h1> Erro Encontrado </h1>
				 <h3> Favor contatar o ADM do Sistema </h3>
				 <h3>'. $mysqli->connect_error.'</h3>
				 <h4> '.$nu_cred_geral.' | '.$nu_cred_exclu.' | '.$nm_nome.' | '.$ds_descricao.' | '.$vl_custo.' | '.$bl_ativo.'</h4>
			';
		}
	}
	}
}else{

echo'

<!DOCTYPE html>
<html>
	<head>
			<title> Configurações </title>
		    <meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Define escala do Bootstrap -->
			<link href="../css/bootstrap.css" rel="stylesheet"> 					<!--Bootstrap -->
			<link href="../css/style.css" rel="stylesheet"> 						<!--Css próprio -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"/></script>		<!--Bootstrap -->
			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"/></script> <!-- JQuery -->
			<script type="text/javascript" src="../js/jquery.mask.min.js"/></script> <!-- JS das mascaras -->
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
			    	<h5 class="card-title" style="color:white;" > <center><b> Novo Administrador </b></h5>
			  	</div>
			  	<div class="card-body">

			  			<form name="Combos" id="Combos" action="configura.php?acao=novo" method="post" enctype="multipart/form-data"> <!-- Formulário -->
			  				<div class="row">

			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome<a class="text-danger">*</a><br>
									<input type="text" name="nm_nome" class="form-control" maxlength="44" placeholder="Nome Sobrenome" required/> </label>

			  						<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Email<a class="text-danger">*</a><br>
									<input type="email" name="nm_email" class="form-control" maxlength="74" placeholder="nome@dominio.com" required/> </label>


								<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Senha <a class="text-danger">*</a><br>
								<input type="password" name="ds_senha" id="password" maxlength="25" class="form-control" required/> </label>

								<label class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Confirme a Senha <a class="text-danger">*</a><br>
								<input type="password" name="ds_confsenha" id="ds_confsenha" maxlength="25" class="form-control" required/> </label>

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


								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao" >
									<input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Cadastrar" >
									<input type="reset" name="Limpar" class="btn btn-danger" value="Limpar">
								</div>

			  			</form>

				</div>

			</div>
		</div>
		</div>
		';
		include("../classes/versionamento.php");
		echo'
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%; margin-top: 25px;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Administradores </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="table-responsive">
				  			<table class="table table-striped">
								<thead>
							    	<tr>
							      		<th scope="col">Nome</th>
							      		<th scope="col">Email</th>
							      		<th scope="col">  </th>
							    	</tr>
							  	</thead>
								<tbody>
							  		';
							  		include_once("../Conexao.php");
							  		$sql= mysqli_query($mysqli,"SELECT * FROM usuario WHERE lv_nivel = 0");
							  		if($sql != NULL){
							  			while($sql_result=mysqli_fetch_array($sql)){
							  				echo'

									<tr>
									    <td>'.$sql_result["nm_nome"].'</td>
									    <td>'.$sql_result["ds_email"].'</td>
			   						    <td>
										    <div>
										    	<a href="configura.php?id='.$sql_result["id_usuario"].'&acao=visualizar" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
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
</div>


</body>
';
}
?>
