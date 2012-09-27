<script type="text/javascript">
	function fuErro(){
		document.getElementById("conteiner_modal").style.visibility = 'visible';
		document.getElementById("btn_fecha_mod").focus();
	}
	function fuSucesso(cdPessoa){
		alert('Vendedor cadastrado com sucesso!');
		location.href="frm_cad_vendedor.php?operacao=alterar&cdvend="+cdPessoa;
	}
	function fuSucessoAltera(cdPessoa){
		alert('Informações alteradas com sucesso!');
		location.href="frm_cad_vendedor.php?operacao=alterar&cdvend="+cdPessoa;
	}	
	function fuSucessoExluir(){
		alert('Vendedor excluído com sucesso!');
		location.href="frmPesquisaVendedor.php";
	}	
</script>
<?php
require "../class/classVendedor.php";
require "../class/classEndereco.php";
require "../class/classUsuarioSistema.php";
require "../class/classContato.php";
require "../db/dadosConexaoDB.php";
require "../FuncoesUtilitarias.php";

$msgValidacao    = "";
$resultValidacao = true;

/*CONEXAO com o banco de dados*/
$objConexao = new mysqli($host, $user, $senha, $banco);
if (mysqli_connect_errno()){
	$msgValidacao .= "- ERRO: Conexão o banco de dados.<br />";
	$resultValidacao = false;		
}
$objConexao->autocommit(FALSE);

if($_REQUEST["nm_pessoa"] == ""){
	$msgValidacao .= "- É obrigatório preencher o nome do vendedor.<br />";
	$resultValidacao = false;		
}

/*Inicio das validações*/
if($_REQUEST["dt_nascimento"] == ""){
	$msgValidacao .= "- É obrigatório preencher a data de nascimento.<br />";
	$resultValidacao = false;		
}

/*Validação do CPF*/
if($_REQUEST["cpf_pessoa"] != ""){
	if(validaCPF($_REQUEST["cpf_pessoa"]) == false){
		$msgValidacao .= "- O número do CPF é inválido.<br />";
		$resultValidacao = false;		
	}
}

/*Valida a data de nascimento*/
if($_REQUEST["dt_nascimento"] != ""){
	if(validaData($_REQUEST["dt_nascimento"]) == false){
		$msgValidacao .= "- Data de nascimento inválida.<br />";
		$resultValidacao = false;		
	}
}

if($_REQUEST["sexo"] == ""){
	$msgValidacao .= "- Informe o sexo.<br />";
	$resultValidacao = false;		
}

if($_REQUEST["tp_operacao"] == "cadastrar"){
	/*Verifica se já existe um usuario no sistema com o login informado*/
	$sql = "select login_usuario login from tb_usuario_sistema where login_usuario = '".$_REQUEST["login"]."'";
	if($result = $objConexao->query($sql)){
		while ($arrRS = $result->fetch_assoc()){
			if($_REQUEST["login"] == $arrRS["login"]){
				$msgValidacao .= "- Já existe um usuário com o login ".$arrRS["login"]." cadastrado no sistema.<br />";
				$resultValidacao = false;		
			}
	}
		$result->close();
	}else{
		$msgValidacao .= "- ERRO: Consulta do usuário.<br />";
		$resultValidacao = false;
	}

	/*Checagem da senha*/
	if($_REQUEST["senha"] != "" && $_REQUEST["repete_senha"] != ""){
		if($_REQUEST["senha"] != $_REQUEST["repete_senha"]){
			$msgValidacao .= "- As senhas digitas não conferem.<br />";
			$resultValidacao = false;
		}
	}

	/*Fim das validações*/
	if($_REQUEST["login"] == ""){
		$msgValidacao .= "- Informe um login para o vendedor.<br />";
		$resultValidacao = false;
	}

	/*Validação da Senha*/
	if($_REQUEST["senha"] == ""){
		$msgValidacao .= "- Digite a senha do usuário.<br />";
		$resultValidacao = false;
	}

	if($_REQUEST["repete_senha"] == ""){
		$msgValidacao .= "- Digite a senha de confirmação.<br />";
		$resultValidacao = false;
	}

	if($_REQUEST["cd_prupo_acesso"] == ""){
		$msgValidacao .= "- Informe o grupo de acesso para o usuário.<br />";
		$resultValidacao = false;
	}
}//fim do if tp_operacao dados login

/*Valida alteração senha e grupo acesso*/
if($_REQUEST["tp_operacao"] == "alterar"){
	if($_REQUEST["cd_prupo_acesso"] == ""){
		$msgValidacao .= "- Informe o grupo de acesso para o usuário.<br />";
		$resultValidacao = false;
	}
	/*Se o usuario deseja alterar a senha faz a validação*/
	if($_REQUEST["senha"] != "" || $_REQUEST["repete_senha"]){
		if($_REQUEST["senha"] != $_REQUEST["repete_senha"]){
			$msgValidacao .= "- As senhas digitas não conferem.<br />";
			$resultValidacao = false;
		}
		if($_REQUEST["senha"] == ""){
			$msgValidacao .= "- Digite a senha do usuário.<br />";
			$resultValidacao = false;
		}

		if($_REQUEST["repete_senha"] == ""){
			$msgValidacao .= "- Digite a senha de confirmação.<br />";
			$resultValidacao = false;
		}
	}
}//Fim Valida alteração senha e grupo acesso

/*INICIO DA GRAVAÇÃO DOS DADOS*/
if($resultValidacao == true){//if passou pela validação
	$msgGravacoes = "";
	$resultadoGravacoes = true;
	
	/*SETA AS PROPRIEDADES DA CLASSE PESSOA E VENDEDOR*/
	$objVendedor = new vendedor($objConexao);
	$objVendedor->setNome(strtoupper($_REQUEST["nm_pessoa"]));
	$objVendedor->setCPF(ereg_replace("[^0-9]", "", $_REQUEST["cpf_pessoa"]));
	$objVendedor->setNascimento($_REQUEST["dt_nascimento"]);
	$objVendedor->setSexo(strtoupper($_REQUEST["sexo"]));

	/*SETA AS PROPRIEDADES DA CLASSE ENDEREÇO*/
	$objEndereco = new endereco($objConexao);
	$objEndereco->setLogradouro(strtoupper($_REQUEST["endereco_pessoa"]));
	$objEndereco->setNumero($_REQUEST["numero"]);
	$objEndereco->setCep($_REQUEST["cep"]);
	$objEndereco->setCidade(strtoupper($_REQUEST["cidade"]));	
	$objEndereco->setBairro(strtoupper($_REQUEST["bairro"]));	
	$objEndereco->setUf(strtoupper($_REQUEST["uf"]));
	$objEndereco->setComplemento(strtoupper($_REQUEST["complemento"]));

	/*SETA AS PROPRIEDAES DA CLASSE USUÁRIO DO SISTEMA*/
	$objUsuarioSistema = new usuarioSistema($objConexao);
	$objUsuarioSistema->setlogin(strtoupper($_REQUEST["login"]));
	$objUsuarioSistema->setSenha(strtoupper($_REQUEST["senha"]));
	$objUsuarioSistema->setGrupo($_REQUEST["cd_prupo_acesso"]);

	/*SETA AS PROPRIEDADES DA CLASSE CONTATO*/
	$objContato = new contato($objConexao);
	$objContato->setTelFixo($_REQUEST["tel_residencia"]);
	$objContato->setTelCel($_REQUEST["tel_celular"]);
	$objContato->setEmail($_REQUEST["email"]);
	
	if($_REQUEST["tp_operacao"] == "cadastrar"){	
		/*GRAVAÇÃO DOS DADOS*/
		/*GRAVAÇÃO VENDEDOR e PESSOA*/
		$cdPessoa = $objVendedor->gravarPessoa($objConexao);//é um metodo da classe pessoa chamado da classe vendedor
		$resultVendedor = true;
		if($cdPessoa){
			$resultVendedor = $objVendedor->gravaVendedor($cdPessoa);
		}
		
		/*GRAVA ENDEREÇO*/	
		$resultEndereco = true;
		if($cdPessoa){
			$resultEndereco = $objEndereco->gravaEndereco($cdPessoa);
		}
		/*GRAVA O USUARIO DO SISTEMA*/
		$resultUsuSistema = true;
		if($cdPessoa){
				$resultUsuSistema = $objUsuarioSistema->gravaUsuarioSistema($cdPessoa);
		}	
		
		/*GRAVA OS CONTATOS*/
		$resultContato = true;
		if($cdPessoa){
			$resultContato = $objContato->gravaContato($cdPessoa);
		}
	
		/*Verificação se todas as informações foram gravados com sucesso*/
		if(!$cdPessoa){
			$msgGravacoes .= "ERRO: Erro desconhecido#TB_PESSOA.<br />";
			$resultadoGravacoes = false;
		}

		if(!$resultVendedor){
			$msgGravacoes .= "ERRO: Erro desconhecido#TB_VENDEDOR.<br />";
			$resultadoGravacoes = false;
		}
		
		if(!$resultEndereco){
			$msgGravacoes .= "ERRO: Erro desconhecido#TB_ENDERECO.<br />";
			$resultadoGravacoes = false;
		}
		
		if(!$resultUsuSistema){
			$msgGravacoes .= "ERRO: Erro desconhecido#TB_USUARIO_SISTEMA.<br />";
			$resultadoGravacoes = false;
		}
		
		if(!$resultContato){
			$msgGravacoes .= "ERRO: Erro desconhecido#TB_CONTATO_PESSOA.<br />";
			$resultadoGravacoes = false;
		}

		if($resultadoGravacoes == true){
			$objConexao->commit();
			$objConexao->close();
			echo "<script>fuSucesso($cdPessoa)</script>";		
		}else{
			$objConexao->rollback();
			$objConexao->close();
			echo $msgGravacoes;		
		}		
		$objConexao->close();
		/*EXCLUSÃO*/
	}elseif($_REQUEST["tp_operacao"] == "excluir"){//Exclusao
		$resultDelVen = $objVendedor->deleteVendedor($_REQUEST["cd_vendedor"]);
		if($resultDelVen){
			$objConexao->commit();
			$objConexao->close();
			echo "<script>fuSucessoExluir()</script>";
		}else{
			$objConexao->close();
			echo "<script>fuErro()</script>";
			echo "Erro inesperado ao deletar o vendedor, tente novamente.";
		}
		
	}elseif($_REQUEST["tp_operacao"] == "alterar"){//UPDATE
		$resultUpdateVen  = $objVendedor->updatePessoa($_REQUEST["cd_vendedor"]);    //atualiza pessoa
		$resultUpdateEnd  = $objEndereco->updateEndereco($_REQUEST["cd_vendedor"]);  //atualiza endereço
		$resuttUpdateCon  = $objContato->updateContato($_REQUEST["cd_vendedor"]);    //atualiza contato
		$resultUpdateGru  = $objUsuarioSistema->mudarGrupoAcesso();                  //alterar grupo de acesso
		$resultMudaSenha  = true;
		if($_REQUEST["senha"] != ""){                                                //alterar senha
			$resultMudaSenha = $objUsuarioSistema->mudarSenha();
		}
		/*ALTERAÇÃO*/
		if($resultUpdateVen && $resultUpdateEnd && $resuttUpdateCon && $resultUpdateGru && $resultMudaSenha){
			$objConexao->commit();
			$objConexao->close();
			$cdVendedor = $_REQUEST["cd_vendedor"];
			echo "<script>fuSucessoAltera($cdVendedor)</script>";			
		}else{
			$objConexao->rollback();
			$objConexao->close();
			echo "<script>fuErro()</script>";
			echo "Erro inesperado ao atualizar os dados, verifique as informações e tente novamente.";
		}
	}//fim do if do tipo de operação
}else{//Fim do if da validação dos dados do formulário
	echo "<script>fuErro()</script>";
	echo $msgValidacao;
}
?>