<?php
class contato{
	private $telFixo;
	private $telCelular;
	private $email;
	private $linkConn;
	
	function __construct($link){
		$this->linkConn = $link;
	}
	
	function setTelFixo($prTelFixo){
		$this->telFixo = $prTelFixo;
	}

	function setTelCel($prTelCel){
		$this->telCelular = $prTelCel;
	}
	
	function setEmail($prEmail){
		$this->email = $prEmail;
	}
	
	function gravaContato($cdPessoa){
		$sql = "INSERT INTO tb_contato_pessoa(cd_pessoa_contato,nu_tel_fixo,nu_tel_celular,email)
            VALUES({$cdPessoa},'{$this->telFixo}','{$this->telCelular}','{$this->email}')";
		$resultado = $this->linkConn->query($sql);
		return $resultado;
	}
	
	function updateContato($cdPessoa){
    $sql="UPDATE tb_contato_pessoa cp
             SET cp.nu_tel_fixo    = '{$this->telFixo}',
                 cp.nu_tel_celular = '{$this->telCelular}',
                 cp.email          = '{$this->email}'
           WHERE cp.cd_pessoa_contato =  '".$cdPessoa."'";
		$resultado = $this->linkConn->query($sql);
		return $resultado;
	}
	
}
?>