<?php
session_start();

if (isset($_SESSION["loged"]) && ($_SESSION["loged"] == 1)){

}else{
	header('Location: ../login.php');
	session_unset();
  	session_destroy();
}

include_once("../Conexao.php");
echo'

<!DOCTYPE html>
<html>
	<head>
			<title>Clientes</title>
		   	<link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
			<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

			<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->
			</head>
	<body>';

		$_GET['nav'] = 'cliente';
		include("../nav.php");
echo'
<br>
<div class="container-fluid"> <!-- Fluido -->
 	<div class="row">
 		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Seus Arquivos </b></h5>
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
								      		<th scope="col">  </th>
								    	</tr>
								  	</thead>
									<tbody>
								  		';
								  		include_once("../Conexao.php");
								  		$sql= mysqli_query($mysqli,"SELECT * FROM arquivos WHERE id_user = '".$_SESSION['id_user']."' AND bl_ativo = '1' ");

								 			while($sql_result=mysqli_fetch_array($sql)){
								  				echo'

										<tr>
										    <td style="width:95%;">'.$sql_result["nm_nome"].'</td>
										    <td>
											    <div>
											    		<a href="'.$sql_result["ds_caminho"].'" class="btn btn-primary " role="button" aria-pressed="true"><img width="18" height="18" alt="Visualizar" src="../img/eye-open.png"></a>
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
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
		 	<div class="card">
				<div class="card-header" style="background-color: #004f7c; padding-top: 8px; padding-bottom: 2px; ">
			    	<h5 class="card-title" style="color:white;" > <center><b> Informações </b></h5>
			  	</div>
			  	<div class="card-body">
			  		<div class="row">

			  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 1%;">';
			  				 $total= mysqli_num_rows($sql);


			  					echo'<p> Estão disponiveis '.$total.' arquivos.</p>';

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
