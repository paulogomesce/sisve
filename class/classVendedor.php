<?php
require_once "classPessoa.php";

class vendedor extends pessoa{	
  public $conexao;		

  function __construct($link){
    $this->conexao  = $link;
    $this->linkConn = $link; //Link de conexao da classe pessoa	
  }		

  function gravaVendedor($cdPessoa){
    $resultado = $this->conexao->query("INSERT INTO tb_vendedor VALUES(null, 'S',now(),'{$cdPessoa}')");
    return $resultado;
  }

}
?>