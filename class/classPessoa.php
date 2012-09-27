<?php
class pessoa{
	private $cdPessoa;
	private $nome;
	private $cpf;
	private $dtNascimento;
	private $sexo;
	public $linkConn;//Um objeto vendedor controi essa propriedade
	
	function setNome($prNome){
		$this->nome = $prNome;
	}
	
	function setCPF($prCpf){
		$this->cpf = $prCpf;
	}
	
	function setNascimento($data){
		$this->dtNascimento = $data;
	}
	
	function setSexo($prSexo){
		$this->sexo = $prSexo;
	}

	//Inclui os dados na tabela tb_pessoa
	function gravarPessoa(){
		$sql = "insert into tb_pessoa(cd_pessoa, nm_pessoa,cpf,sexo, dt_nascimento)
		        values ('".$cdPessoa."', '{$this->nome}','{$this->cpf}','{$this->sexo}',STR_TO_DATE('{$this->dtNascimento}','%d/%m/%Y'))";
		$this->linkConn->query($sql);
		$cdPessoa = $this->linkConn->insert_id;
		return $cdPessoa;
	}
	
	function updatePessoa($cdVendedor){
		$sql = "UPDATE tb_pessoa p
		        	 SET nm_pessoa = '{$this->nome}'
		        			,p.cpf     = '{$this->cpf}'
		        			,p.sexo    = '{$this->sexo}'
		        			,p.dt_nascimento = STR_TO_DATE('{$this->dtNascimento}','%d/%m/%Y')
		         WHERE p.cd_pessoa = '".$cdVendedor."'";
		$resultado = $this->linkConn->query($sql);
		return $resultado;
	}
	
	function deleteVendedor($cdPessoa){
		$sql = "DELETE FROM tb_pessoa WHERE cd_pessoa = '".$cdPessoa."'";
		$resultado = $this->linkConn->query($sql);
		return $resultado;
	}

}//Fim da Classe
?>