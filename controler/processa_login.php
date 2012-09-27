<?php
@session_start();
include_once '../db/conexao.php';
?>
<script language="javascript" type="text/javascript">
	function resultadoOK(origem){
		if(origem == 'inicio'){
			window.location.href="inicio.php"		
		}else{
			window.opener.parent.menu.location.reload();
			window.opener.parent.cabecalho.location.reload();
			window.close();
		}
	}

	function erro(){
		alert('O login ou a senha estão incorretos!');
		document.form_login.senha.value = '';
	}
</script>
<?php
$resultadoValidacao = true;
$mensagem = "";

if($_REQUEST["login"] == ""){
	$mensagem .= "Informe o login do usuário.<br />";
	$resultadoValidacao = false;	
}

if($_REQUEST["senha"] == ""){
	$mensagem .= "Informe a senha do usuário.<br />";
	$resultadoValidacao = false;	
}

if($resultadoValidacao == true){
	$sql = "select us.login_usuario,
								 us.senha_usuario,
								 p.nm_pessoa,
								 v.cd_vendedor,
								 p.cd_pessoa,
								 uga.cd_grupo_acesso as usu_cd_grupo_acesso
						from tb_usuario_sistema us,
								 tb_pessoa p,
								 tb_vendedor v,
								 tb_usuario_grupo_acesso uga
					 where us.cd_pessoa_usuario_sistema = p.cd_pessoa
						 and us.login_usuario = upper('".$_REQUEST["login"]."')
						 and us.senha_usuario = md5(upper('".$_REQUEST["senha"]."'))
						 and v.cd_pessoa_vendedor = p.cd_pessoa
						 and uga.login_usuario    = us.login_usuario";
																					 
	$stm = mysql_query($sql) or die("Erro ao processar dados de acesso!<br />".mysql_error());

	$nmUsuario    = "";
	$loginUsu     = "";
	$cdPessoaVend = "";
	$dados;

	while($dados = mysql_fetch_assoc($stm)){
		$nmUsuario      = $dados["nm_pessoa"];
		$loginUsu       = $dados["login_usuario"];
		$cdPessoaVend   = $dados["cd_pessoa"];
		$usuGrupoAcesso = $dados["usu_cd_grupo_acesso"];
	}

	if($nmUsuario){
		$_SESSION["nm_usuario"]       = $nmUsuario;
		$_SESSION["login_usu"]        = $loginUsu;
		$_SESSION["cd_usuario"]       = $cdPessoaVend;
		$_SESSION["usu_grupo_acesso"] = $usuGrupoAcesso;
		
		if(isset($_REQUEST["origem"])){
			$origem = $_REQUEST["origem"];
		}
		
		echo"<script>resultadoOK('$origem')</script>";
	}else{
		echo "<script>erro();</script>";
	}
}else{
	echo "<script>alert('O preenchimento de todos dados é obrigatório.');</script>";
}
$closed = mysql_close($conexao);
?>