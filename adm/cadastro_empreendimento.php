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
	<title>Cadastro de Empreendimento </title>
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
	$ds_curta		= $_POST['ds_curta'];
	$ds_longa		= $_POST['ds_longa'];
	$celular 		= $_POST['celular'];

	include("../Conexao.php");  /* Chama o DB */


	$arquivo = $_FILES["im_logo"];
	$pasta_dir = "../uploads/img/";
	if(!file_exists($pasta_dir)){
		mkdir($pasta_dir);
	}
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
	$imagem = $pasta_dir.md5(uniqid(time())).".".$ext[1];
	move_uploaded_file($arquivo["tmp_name"], $imagem);

	echo  $imagem;

	$sql =mysqli_query($mysqli,"INSERT INTO empreendimentos(nm_nome, ds_curta, ds_longa, im_logo, nu_telefone, bl_ativo) VALUES ('".$nome."','".$ds_curta."','".$ds_longa."','".$imagem."','".$celular."','1')"); 														 /* Insere os dados do prestador */

	 if($sql==TRUE){ /* Se Obtiver Sucesso */
	 	echo'
	 	<script>
	 		alert("Cadastro Realizado Com Sucesso!");
	    	document.location = "empreendimento.php";
	   </script>';				/* Exibe mensagem de sucesso e manda pro login */
	 }else{ 						/* Se não */
	 	echo'<h2> Erro Fatal <h2>
	 		 <br>
	 		 <h3>'.mysql_error().'</h3>
	 		 <br>
	 		 <h4>'.$nome.' | '.$cpf.' | '.$cnh.'| '.$categoria.' | '.$sexo.' | '.$email.' | '.$nascimento.' | '.$celular.' | '.$endereco.' | '.$numero.' | '.$complemento.' | '.$cep.' | '.$estado.' | '.$cidade.' | '.$senha.' | '.$conf_senha.' </h4>
	 	';
	 }


}else{  /* Caso seja primeiro acesso */

	echo'<br>
	<div class="container-fluid" id="Pagina"> <!-- Faz o Responsivo ser "Fluido" -->
	  <div class="row">
	    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> <!-- Faz os campos de texto ocuparem 8 -->
	      <div class="card">
	        <div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
	          <h5 class="card-title" style="color:white;" > <center> Novo Empreendimento </center></h5>

	        </div>
	        <div class="card-body">
	          <div class="row">
	            <form name="Usuario" id="Usuario" action="cadastro_empreendimento.php" method="post" enctype="multipart/form-data"> <!-- Formulário -->
	              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                <div class="row"> <!-- Gera uma campo de flutuação -->
	                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Nome<a class="text-danger">*</a><br>
	                    <input type="text" name="nm_nome"  class="form-control" maxlength="70" placeholder="Arthur Dent" required/>
	                  </label>

	                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Descrição Curta <br>
	                    <textarea class="form-control" name="ds_curta" id="ds_curta" rows="3" maxlength="299" ></textarea>
	                  </label>

	                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Caracteristicas <br>
	                    <textarea class="form-control" name="ds_longa" id="ds_longa" rows="25" maxlength="5000" ></textarea>
	                  </label>

	                  <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> Telefone <a class="text-danger">*</a><br>
	                    <input type="text" name="celular" id="celular" id="celular" class="form-control" maxlength="15" placeholder="(47) 98489-8984" required/>
	                  </label>

										<label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Logo do empreendimento<a class="text-danger">*</a><br>
											<input type="file" name="im_logo"  class="form-control" required/>
										</label>

	                  <br>
	                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Botao" >
	                    <center><input type="submit" name="cadastrar" id="cadastrar" class="btn btn-success"  value="Salvar" ></center>
	                  </div>
	                </div>
	              </div>
	            </form>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
<br>
<br>
	';

}
?>

</body>
</html>
