<?php
//$encrypted = encryptIt( $input );
//$decrypted = decryptIt( $encrypted );

function encryptIt( $q ) {

    return($q);
}

function decryptIt( $q ) {
   return($q);
}


function nova_conta($nome,$telefone,$id){


	$message = '
  Um novo cadastro foi registrado no site.<br>
  <b>Nome:</b> '.$nome.'<br>
  <b>Telefone:</b> '.$telefone.'<br>
  Para liberar o acesso, clique no link abaixo:<br>
  <a href="http://localhost/sistema_ge/adm/prestador.php?id='.$id.'&acao=aprovar">Liberar Acesso</a>

  ';


  $to = "cesar@twccomunicacao.com.br";
	$subject = "[Grupo Estrutura] Cadastro externo de Corretor.";
	$headers = "FROM: noreply@grupoestrutura.com.br" . "\r\n";
  $headers .= "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	mail($to, $subject, $message, $headers);
}


function libera_conta($email,$nome){


	$message = '
  Olá '.$nome.',<br>
  Seu cadastro no sistema de Corretores do grupo estrutura foi aprovado!<br>
  <a href=""> Acesse já </a> e conheça nossos empreendimentos.<br>
  ';


  $to = $email;
	$subject = "[Grupo Estrutura] Cadastro externo de Corretor.";
	$headers = "FROM: noreply@grupoestrutura.com.br" . "\r\n";
  $headers .= "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	mail($to, $subject, $message, $headers);
}




?>
