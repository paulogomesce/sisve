<?php

class conexaoDB{
	private $user    = "root";
	private $senha   = "";
	private $host    = "127.0.0.1";
	private $banco   = "controle_venda";
	public $conexao;

	public function conecta(){
		$this->conexao = mysql_connect($this->host, $this->user, $this->senha);
		mysql_select_db($this->banco);	
		mysql_set_charset('utf8',$this->conexao);
		return $this->conexao;
	}
	
	function closeConn(){
		mysql_close($this->conexao);
	}
	
}//Fim da Classe
?>