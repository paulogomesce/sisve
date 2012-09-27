<?php
class conecta_bd {

  function loginUsuario($usuario, $senha){
    $conexao = mysql_connect('localhost', $usuario, $senha);
    mysql_select_db("controle_venda");

    if($conexao){
      return true;
    }else{
      return false;
    }
  }
 }

?>
