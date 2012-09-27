<?php
  $conexao = mysql_connect('localhost', "97517", "91545117");
  mysql_select_db("97517db2");
	
	mysql_set_charset('8tf8_general_ci',$conexao); 
	mysql_set_charset('utf8',$conexao);

  if($conexao){
    //echo"Conexao bem sucedida!";
  }
?>