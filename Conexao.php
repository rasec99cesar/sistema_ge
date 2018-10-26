<?php
	// Conexão com o banco de dados
	$mysqli = new mysqli("localhost", "root", "", "sistema_ge");

	/* check connection */
if ($mysqli->connect_errno) {
    printf("Banco de Dados Falhou :(  %s\n", $mysqli->connect_error);
    exit();
}




	function to_date($data)
{
    return date("d/m/Y H:i:s", strtotime($data));
}
?>
