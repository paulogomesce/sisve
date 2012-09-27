<?php

class endereco{
	private $logradouro;
	private $numero;
	private $cep;
	private $cidade;
	private $bairro;
	private $uf;
	private $complemento;
	private $conexao;
	
	function __construct($link){
		$this->conexao = $link;
	}

	function setLogradouro($logradouro){
		$this->logradouro = $logradouro;
	}
	function setNumero($numero){
		$this->numero = $numero;
	}
	function setCep($cep){
		$this->cep = $cep;
	}
	function setCidade($cidade){
		$this->cidade = $cidade;
	}
	function setBairro($bairro){
		$this->bairro = $bairro;
	}
	function setUf($uf){
		$this->uf = $uf;
	}
	Function setComplemento($complemento){
		$this->complemento = $complemento;
	}

	function gravaEndereco($cdPessoa){
		$sql = "INSERT INTO tb_endereco_pessoa
		        VALUES (null,'{$this->logradouro}','{$this->numero}','{$this->cep}','{$this->cidade}','{$this->bairro}','{$this->uf}','{$this->complemento}','{$cdPessoa}')";
		$resultado = $this->conexao->query($sql);
		return $resultado;
	}
	
	function updateEndereco($cdPessoa){
		$sql="UPDATE tb_endereco_pessoa ep
						 SET ep.ds_logradouro  = '{$this->logradouro}',
								 ep.numero         = '{$this->numero}',
								 ep.nu_cep         = '{$this->cep}',
								 ep.ds_cidade      = '{$this->cidade}',
								 ep.bairro         = '{$this->bairro}',
								 ep.uf             = '{$this->uf}',
								 ep.ds_complemento = '{$this->complemento}'
					 WHERE ep.cd_pessoa_endereco =  '".$cdPessoa."'";
		$resultado = $this->conexao->query($sql);
		return $resultado;			 
	}
	
}//Fim da Classe
?>