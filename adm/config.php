<?php
###############################################
#	Desenvolvido por: Altamiro D. Rodrigues   #
#		E-mail: altamiro27@gmail.com		  #
#	(75) 3622 - 4145 // (75) 8816 - 9835	  #
#	MSN: altamiro@nitrofox.com.br			  #
#		http://www.trilhadesign.com.br		  #
###############################################	

###############################################
#    Modificado em 15/05/2016 por REGISRMP    #
###############################################

?>
<?php
$DB = 'agenda'; // mudar o nome caso deseje
$link = mysql_connect('localhost','root','') or die('Nao foi possivel se conectar com o banco de dados'); 
$sel = mysql_select_db($DB) or die("Nao foi possivel selecionar a tabela: $DB"); 

/**
* Formata data
*/
function to_date($data)
{
    return date("d/m/Y H:i:s", strtotime($data));
}

?>