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


<?php
// 	// Conexão com o banco de dados
// 	$mysqli = new mysqli("localhost", "hrqxcmshba", "pYFrKHy9U7", "hrqxcmshba");

// 	/* check connection */
// if ($mysqli->connect_errno) {
//     printf("Banco de Dados Falhou :(  %s\n", $mysqli->connect_error);
//     exit();
// }

// ini_set('display_errors',1);
// ini_set('display_startup_erros',1);
// error_reporting(E_ALL);


// 	function to_date($data)
// {
//     return date("d/m/Y H:i:s", strtotime($data));
// }
?>
