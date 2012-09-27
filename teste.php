<?php
  $email = "paulogomes.tec@gmail.com";

  $message = "Teste de envio de e-mail";
  mail("paulogomes.tec@gmail.com", "Email Subject", $message, $email );

  print "Congratulations your email has been sent";

  echo "Nome do Script: ".$_SERVER["PHP_SELF"]."<br />";
  echo "IP do Servidor: ".$_SERVER["SERVER_ADDR"]."<br />";
  echo "Nome do Host do Servidor: ".$_SERVER["SERVER_NAME"]."<br />";
  echo "Diretório Root do Servidor: ".$_SERVER["DOCUMENT_ROOT"]."<br />";
  echo "Host da Requisição Atual: ".$_SERVER["HTTP_HOST"]."<br />";
  echo "IP do usuário que está visualizando a página: ".$_SERVER["REMOTE_ADDR"]."<br />";
  echo "Nome do Host do usuário que está visualizando a página: ".$_SERVER["REMOTE_HOST"]."<br />";
  echo "Caminho absoluto do script: ".$_SERVER["SCRIPT_FILENAME"]."<br />";
  echo "Caminho completo do script: ".$_SERVER["SCRIPT_NAME"]."<br />";
  echo "Caminho completo do script: ".__FILE__."<br />";
?>