<?php
//$encrypted = encryptIt( $input );
//$decrypted = decryptIt( $encrypted );

function encryptIt( $q ) {
    
    $qEncoded      = base64_encode($q);
    return( $qEncoded );
}

function decryptIt( $q ) {

    $qDecoded      = base64_decode($q);
    return( $qDecoded );
}




if(isset($_GET["act"])){
	include_once("Conexao.php");
	
	if($_GET["act"]=="ativar"){
		
		$cpf = $_GET['id'];
		
		
		$nivel = $_GET['lvl'];
				

		if($nivel==4){
			$sql= mysql_query("UPDATE cliente SET bl_ativo = '1' WHERE nu_cpf = '".$cpf."' ");
			mysql_error();
			echo "d";
			header("LOCATION: login.php");
		}else if($nivel==5){
			$sql= mysql_query("UPDATE prestador SET bl_ativo = '1' WHERE nu_cpf = '".$cpf."' ");
			header("LOCATION: login.php");
		}else{
			echo '
			<div id="notificacao" class="alert alert-danger" role="alert">
				Dados Incosistentes, entre em contato com o Suporte.
			</div>';
		}
	}

	if($_GET["act"]=="ava"){
		$id = $_GET['id'];
		$nota = $_GET['nota'];

	
		$sql = mysql_query("SELECT tp_estado FROM solicitacao WHERE id_solicitacao = '".$id."' ");
		$sql_result = mysql_fetch_array($sql);

		if($sql_result['tp_estado'] != 6){
			if($sql = mysql_query("UPDATE solicitacao SET nota = '".$nota."', tp_estado = '6' WHERE id_solicitacao = '".$id."' ")){
				echo'
					<script>
					alert("Obrigado por avaliar nosso Serviço!");
					document.location = "login.php";
				   	</script>';
			}else{
				echo'
					<script>
					alert("Ocorreu um erro inesperado, tente novamente mais tarde.");
					document.location = "login.php";
				   	</script>';
			}
		}

		



	}



}else{
	header("LOCATION: login.php");
}


?>