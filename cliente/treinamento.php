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
			<title>Arquivos</title>
		   	<link href="../css/style.css" rel="stylesheet" type="text/css" /> <!-- CSS Pad -->
			<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" /> <!-- CSS do BootStrap -->

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> <!-- Biblioteca Jquery Geral -->
			<script type="text/javascript" src="../js/bootstrap.bundle.js"></script><!-- Bootstrap JS  -->

			<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Faz o site ser Responsivo -->

			<style type="text/css">
				a:link {
				text-decoration:none;
				color: black;
				}
				a:visited {
				text-decoration:none;
				color: black;
				}
				a:hover {
				text-decoration:none;
				color: black;
				}
			</style>


			</head>
	<body>';

		$_GET['nav'] = 'cliente';
		include("../nav.php");

if((isset($_GET['acao']))&&($_GET['acao']=="visual")){
	$sql= mysqli_query($mysqli,"SELECT * FROM treinamento WHERE id_treinamento = '".$_GET['id']."' AND bl_ativo = '1' ");
	$sql_treinamento = mysqli_fetch_array($sql);

	$id= $_GET['id'];
	echo'
<br>
<div class="container-fluid"> <!-- Fluido -->
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
			<div class="card">
				<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
					<h5 class="card-title" style="color:white;" > <center><b> '.$sql_treinamento["nm_nome"].' </b></h5>
				</div>
				<div class="card-body">
					<p>
					'.$sql_treinamento["ds_longa"].'
					</p>
					<br>
					<h5>Arquivos referentes ao treinamento: </h5>
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">Nome</th>
								<th scope="col" style="width:50px;"></th>
							</tr>
						</thead>
						<tbody>';
							if($sql_arquivo = mysqli_query($mysqli,"SELECT * FROM treinamento_has_arquivos WHERE treinamento_id_treinamento ='".$id."' AND bl_ativo = '1' ")){

							while($sql_result_arqui = mysqli_fetch_array($sql_arquivo)){
								$sql_result_arq = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM arquivos WHERE id_arquivos ='".$sql_result_arqui['arquivos_id_arquivos']."' AND bl_ativo = '1' "));
							echo'
							<tr>
								<td>'.$sql_result_arq['nm_nome'].'</td>
								<td>
									<div>
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
</div>
				';
}else{
	echo'
	<br>
	<div class="container-fluid"> <!-- Fluido -->
	 	<div class="row">';
		$sql= mysqli_query($mysqli,"SELECT * FROM treinamento WHERE bl_ativo = '1' ");
		while($sql_result=mysqli_fetch_array($sql)){
		echo'
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="padding: 1%;">  <!-- Faz os campos de texto ocuparem 8 -->
				<a href="treinamento.php?id='.$sql_result["id_treinamento"].'&acao=visual">
					<div class="card">
						<div class="card-header" style="background-color: #1D1D1B; padding-top: 8px; padding-bottom: 2px; ">
							<h5 class="card-title" style="color:white;" > <center><b> '.$sql_result["nm_nome"].' </b></h5>
						</div>
						<div class="card-body">
							<p>'.$sql_result["ds_curta"].'</p>
						</div>
					</div>
				</a>
			</div>

		';
		}



	echo'
	 	</div>
	</div>
	';
}

echo '</body>';


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
