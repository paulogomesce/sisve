<?php
class usuarioSistema{
	private $login;
	private $senha;
	private $grupoAcesso;
	private $conexao;
	
	function __construct($link){
		$this->conexao = $link;
	}
	
	function setLogin($login){
		$this->login = $login;
	}
	function setSenha($senha){
		$this->senha = $senha;
	}
	function setGrupo($grupo){
		$this->grupoAcesso = $grupo;
	}

	function gravaUsuarioSistema($cdPessoa){		
		$sql = "INSERT INTO tb_usuario_sistema VALUES(NULL, '{$cdPessoa}', '{$this->login}',md5('{$this->senha}'),'S')";
		$resultUsu      = $this->conexao->query($sql);
		$resultUsuGrupo = self::insertUsuarioGrupoAcesso();		
		if($resultUsu && $resultUsuGrupo){
			return true;
		}else{
			return false;
		}
	}
	
	function insertUsuarioGrupoAcesso(){
		$sql = "INSERT INTO tb_usuario_grupo_acesso VALUES('{$this->login}','{$this->grupoAcesso}')";
		$result = $this->conexao->query($sql);
		return $result;
	}
	
	function mudarSenha(){
		$sql="UPDATE tb_usuario_sistema us
						 SET us.senha_usuario = md5('".$this->senha."')
					 WHERE us.login_usuario = '".$this->login."'";
		$resultado = $this->conexao->query($sql);
		return $resultado;
	}
	
	function mudarGrupoAcesso(){
		$sql="UPDATE tb_usuario_grupo_acesso uga
						 SET uga.cd_grupo_acesso = '".$this->grupoAcesso."'
					 WHERE uga.login_usuario = '".$this->login."'";
		$resultado = $this->conexao->query($sql);
		return $resultado;
	}
	
}
?>