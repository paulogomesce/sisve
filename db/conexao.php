<?php
  $conexao = mysql_connect("127.0.0.1", "root", "");
  mysql_select_db("controle_venda");
	
	mysql_set_charset('8tf8_general_ci',$conexao); 
	mysql_set_charset('utf8',$conexao);

  if($conexao){
    //echo"Conexao bem sucedida!";
  }
?>