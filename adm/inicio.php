<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 6)){
	if (isset($_SESSION["id_user"])){
		//AQUI VAI SQL

	}else{
		header('Location: ../login.php');
		session_unset();
  		session_destroy();
	}
}else{
	header('Location: ../login.php');
	session_unset();
  	session_destroy();
}

include_once("../Conexao.php");

$sql = mysql_query("SELECT * FROM solicitacao");





if ((isset($_GET["id"])) && (isset($_GET["acao"]))){
	$id=$_GET["id"];

	date_default_timezone_set('America/Sao_Paulo');
	$date = date('d-m-Y H:i:s');

	if($_GET["acao"] == 'aprovar_combo'){
		$sql = mysql_query("UPDATE cliente_has_combos SET bl_ativo='1', dt_liberacao='".$date."' WHERE id_controle='".$id."'  ");
	}

	if($_GET["acao"] == 'negar_combo'){
		$sql = mysql_query("UPDATE cliente_has_combos SET bl_ativo='2', dt_liberacao='".$date."' WHERE id_controle='".$id."'  ");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administração | Family Car</title>
   	<link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
	<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

	<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->

	

</head>
<body>
<?php $_GET['nav'] = 'adm';
	include("../nav.php");
?>
<br>
<div class="container-fluid"> <!-- Fluido -->
 	<div class="row">
 		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Cadastros Pendentes </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
			  			<div class="table-responsive">
				  			<table class="table table-striped">
								<thead>
							    	<tr>
							      		<th scope="col">Nome</th>
							      		<th scope="col">Telefone</th>
							      		<th scope="col">CPF</th>
							      		<th scope="col">  </th>
							    	</tr>
							  	</thead>
								<tbody>
							  		<?php 
							  		include_once("../Conexao.php");
							  		$sql= mysql_query("SELECT * FROM prestador WHERE bl_ativo = 0");
							  		if($sql != NULL){
							  			while($sql_result=mysql_fetch_array($sql)){
							  				echo'

									<tr>
									    <td>'.$sql_result["nm_prestador"].'</td>
									    <td>'.$sql_result["nu_celular"].'</td>
									    <td>'.$sql_result["nu_cpf"].'</td>
									    <td>
										    <div>
										    	<a href="prestador.php?id='.$sql_result["id_prestador"].'&acao=aprovar" class="btn btn-success " role="button" aria-pressed="true"><img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png"></a>
										    	<a href="prestador.php?id='.$sql_result["id_prestador"].'&acao=negar" class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>
										    	<a href="prestador.php?id='.$sql_result["id_prestador"].'&acao=visualizar" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
										    </div>
									    </td>
									</tr>

							  				';

							  			}
							  		}
							  		?>
							  	</tbody>
							</table>	
						</div>					  
				    </div>
				</div>

			</div>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Aprovações de Combo </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">
				  		<div class="table-responsive">
				  			<table class="table table-striped">
								<thead>
							    	<tr>
							      		<th scope="col">Cliente</th>
							      		<th scope="col">Combo</th>
							      		<th scope="col">Data</th>
							      		<th scope="col">  </th>
							    	</tr>
							  	</thead>
								<tbody>
							  		<?php 
							  		include_once("../Conexao.php");
							  		$sql= mysql_query("SELECT * FROM cliente_has_combos WHERE bl_ativo = 0");
							  		if($sql != NULL){
							  			while($sql_result=mysql_fetch_array($sql)){
							  				
							  				$combos_id_combo = $sql_result['Combos_id_combo'];

							  				$sql_combo = mysql_query("SELECT * FROM combos WHERE id_combo = '".$combos_id_combo."' ");
							  				$sql_combo=mysql_fetch_array($sql_combo);

							  				$cliente_id_cliente = $sql_result['Cliente_id_cliente'];
							  				$sql_cliente = mysql_query("SELECT * FROM cliente WHERE id_cliente = '".$cliente_id_cliente."' ");
							  				$sql_cliente=mysql_fetch_array($sql_cliente);
							  				echo'

									<tr>
									    <td>'.$sql_cliente["nm_cliente"].'</td>
									    <td>'.$sql_combo["nm_nome"].'</td>
									    <td>'.$sql_result["dt_solicitacao"].'</td>
									    <td>
										    <div>
										    	<a href="inicio.php?id='.$sql_result["id_controle"].'&acao=aprovar_combo" class="btn btn-success " role="button" aria-pressed="true"><img width="18" height="18" alt="Aprovar" src="../img/thumbs-up.png"></a>
										    	<a href="inicio.php?id='.$sql_result["id_controle"].'&acao=negar_combo" class="btn btn-danger " role="button" aria-pressed="true"><img width="18" height="18" alt="Negar" src="../img/thumb-down.png"></a>
										    </div>
									    </td>
									</tr>

							  				';

							  			}
							  		}






							  		 ?>
							  	</tbody>
							</table>	
						</div>			
				    </div>
				 </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm02 col-md-2 col-lg-2" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-body">
			  		<div class="row">
				  		
				    </div>
				 </div>
			</div>
		</div>




 	</div>
</div>
</body>