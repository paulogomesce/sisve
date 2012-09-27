<?php
session_start();
?>
<script language="javascript" type="text/javascript">
	function fuErro(){
		document.getElementById("conteiner_modal").style.visibility = 'visible';
		document.getElementById("btn_fecha_mod").focus();
	}
	function fuSucessoCadastra(cdProduto){
		alert('Produto gravado com sucesso!\n\nCódigo do Produto: '+cdProduto);
    location.href="frmCadastroProduto.php?operacao=alterar&cd_produto="+cdProduto;
	}
	function fuSucessoAltera(cdProduto){
		alert('Informações do produto alteradas com sucesso!');
		location.href="frmCadastroProduto.php?operacao=alterar&cd_produto="+cdProduto;
	}	
	function fuSucessoExluir(){
		alert('Vendedor excluído com sucesso!');
		location.href="frmPesquisaVendedor.php";
	}	
</script>
<?php
require "../db/dadosConexaoDB.php";
require "../class/classProduto.php";
require "../class/classEstoque.php";
require "../funcoesUtilitarias.php";
require "../seguranca/checaSessao.php";

$msgValidacao    = "";
$resultValidacao = true;

/*CONEXAO com o banco de dados*/
$objConn = new mysqli($host, $user, $senha, $banco);
if (mysqli_connect_errno()){
	$msgValidacao .= "- ERRO: Conexão o banco de dados.<br />";
	$resultValidacao = false;		
}
$objConn->autocommit(FALSE);

//Objeto Produto
$objProduto = new produto($objConn);
//Objeto Estoque
$objEstoque = new estoque($objConn);

/*(01)VALIDAÇÃO DOS DADOS*/
if($_REQUEST["ds_produto"] == ""){
	$msgValidacao    .= "- Digite o nome do produto.<br />";
	$resultValidacao = false;
}
/*VALIDAÇÃO DA CATEGORIA*/
if($_REQUEST["cd_categoria"] == ""){
	$msgValidacao    .= "- Informe a categoria do produto.<br />";
	$resultValidacao = false;
}
if($_REQUEST["und_medida"] == ""){
	$msgValidacao    .= "- Informe o tipo de medida do produto.<br />";
	$resultValidacao = false;
}

if($_REQUEST["tp_operacao"] == "cadastrar"){
	$resultado = $objProduto->existeProduto($_REQUEST["cod_barras"]);
	if($resultado != ""){
		$msgValidacao    .= "- Já existe um produto cadastrado no sistema com esse<br />&nbsp;&nbsp;código de barras.<br />";
		$resultValidacao = false;		
	}
}

/*FIM (01)*/

/*(02) INFORMAÇÕES DO ESTOQUES, VALIDA SOMENTE SE FOR UMA NOVA INCLUSÃO DE PRODUTO*/
if($_REQUEST["tp_operacao"] == "cadastrar"){
	if($_REQUEST["qtd_estoque"] == ""){
		$msgValidacao    .= "- Informe a quantidade de produtos que está sendo colocado<br />&nbsp;&nbsp;no estoque.<br />";
		$resultValidacao = false;
	}
	if(!is_int(trataFloat($_REQUEST["qtd_estoque"])*1) && $_REQUEST["qtd_estoque"] != ""){
		$msgValidacao    .= "- A quantidade de produtos informado é inválido.<br />";
		$resultValidacao = false;
	}
	//Preço de custo
	if($_REQUEST["preco_custo"] == ""){
		$msgValidacao    .= "- Informe o preço de custo do Produto.<br />";
		$resultValidacao = false;
	}
	//Preço de venda
	if($_REQUEST["preco_venda"] == ""){
		$msgValidacao    .= "- Informe o preço de venda do Produto.<br />";
		$resultValidacao = false;
	}
	//O preço de venda não pode ser que o preço de custo
	if($_REQUEST["preco_venda"] < $_REQUEST["preco_custo"]){
		$msgValidacao    .= "- O preço de venda não pode ser menor que o preço de custo.<br />";
		$resultValidacao = false;
	}
	
	
	if((!is_float($_REQUEST["preco"]*1)) && (!is_int($_REQUEST["preco"]*1))){
		$msgValidacao    .= "- O preço informado é inválido.<br />";
		$resultValidacao = false;
	}
	if($_REQUEST["fl_desconto"] == "S" && $_REQUEST["vl_desconto"] == ""){
		$msgValidacao    .= "- Informe o valor do desconto.<br />";
		$resultValidacao = false;
	}

	if(trataFloat($_REQUEST["vl_desconto"]) > trataFloat($_REQUEST["preco"])){
		$msgValidacao    .= "- O valor do desconto não pode ser maior que o valor do produto.<br />";
		$resultValidacao = false;
	}

	/*
	if($_REQUEST["dt_validade"] == ""){
		$msgValidacao .= "- Informe a data de validade do produto.<br />";
		$resultValidacao = false;		
	}
	*/
	//Situação do estoque
	if($_REQUEST["status_estoque"] == ""){
		$msgValidacao    .= "- Informe em que situação o estoque deve ficar.<br />";
		$resultValidacao = false;
	}
	//Verifica se a data de fabricação é válida
	if($_REQUEST["dt_fabricacao"] != ""){
		if(!validaData($_REQUEST["dt_fabricacao"])){
			$msgValidacao    .= "- A data de fabricação do produto é inválida.<br />";
			$resultValidacao = false;			
		}
	}
	//Verifica se a data de validade é válida
	if($_REQUEST["dt_validade"] != ""){
		if(!validaData($_REQUEST["dt_validade"])){
			$msgValidacao    .= "- A data de validade do produto é inválida.<br />";
			$resultValidacao = false;			
		}
	}	
}//fim do if se é novo cadastro
/*FIM (02)*/

if($resultValidacao){
	/*CRIAÇÃO DOS OBJETOS*/
	/*PRODUTO*/	
	$objProduto->setCodBarras(strtoupper($_REQUEST["cod_barras"]));
	$objProduto->setDsProduto(strtoupper($_REQUEST["ds_produto"]));	
	$objProduto->setFabricante(strtoupper($_REQUEST["nm_fabricante"]));
	$objProduto->setCategoria($_REQUEST["cd_categoria"]);
	$objProduto->setNmUsuCadastro($_SESSION["nm_usuario"]);
	$objProduto->setFlAtivo(strtoupper($_REQUEST["situacao_produto"]));
	$objProduto->setReferencia(strtoupper($_REQUEST["referencia"]));
	$objProduto->setFlDesconto(strtoupper($_REQUEST["fl_desconto"]));
	$objProduto->setCdMedida(strtoupper($_REQUEST["und_medida"]));
	$objProduto->setQtdVolume($_REQUEST["qtd_volume"]);
	$objProduto->setFlPerecivel(strtoupper($_REQUEST["fl_perecivel"]));
	
	/*ESTOQUE*/
	if($_REQUEST["tp_operacao"] == "cadastrar"){
		$objEstoque->setQtdEntrada($_REQUEST["qtd_estoque"]);//quantidade de produtos que tá entrando no estoque
		$objEstoque->setQtdRestante($_REQUEST["qtd_estoque"]);//quantidade de produtos que resta no estoque
		$objEstoque->setDtFabricacao($_REQUEST["dt_fabricacao"]);
		$objEstoque->setDtValidade($_REQUEST["dt_validade"]);
		$objEstoque->setPrecoCustoProduto(trataFloat($_REQUEST["preco_custo"]));//PREÇO DE CUSTO DO PRODUTO
		$objEstoque->setPrecoVendaProduto(trataFloat($_REQUEST["preco_venda"]));//PREÇO DE VENDA DO PRODUTO
		$objEstoque->setLote(strtoupper($_REQUEST["lote"]));
		$objEstoque->setCdStatus(strtoupper($_REQUEST["status_estoque"]));
		$objEstoque->setNmUsuarioCadastrou($_SESSION["nm_usuario"]);
	}
	
	/*OPERAÇÃO CADASTRAR*/
	if($_REQUEST["tp_operacao"] == "cadastrar"){
		/*GRAVAS DOS DADOS NAS TABELAS*/
		/*PRODUTO*/
		$cdProduto = $objProduto->gravaProduto();//GRAVA E RETORNA O CODIGO DO PRODUTO
		/*ESTOQUE*/
		$resultIncEstoq = $objEstoque->incluirProduto($cdProduto);//INCLUSAO DOS PRODUTOS NO ESTOQUE
		$objEstoque->setCdProduto($cdProduto);
		
		$msgGravacao = "";
		if(!$cdProduto){
			$msgGravacao .= "<span>- Erro Inesperado ao gravar as informações do produto, verifique os valores digitados e tente novamente. DS_ERRO: ".$objProduto->msgErro."</span><br />";
		}
		if(!$resultIncEstoq){
			$msgGravacao .= "- Erro Inesperado ao gravar as informações do estoque,<br />&nbsp;&nbsp;verifique os valores digitados e tente novamente. DS_ERRO: ".$objEstoque->msgErro."<br />";
		}
		
		if($msgGravacao == ""){
			$objConn->commit();
			echo "<script>fuSucessoCadastra('$cdProduto');</script>";		
		}else{
			$objConn->rollback();
			echo "<script>fuErro()</script>";
			echo $msgGravacao;
		}
	/*ALTERAÇÃO DOS DADOS DO PRODUTO*/
	}elseif($_REQUEST["tp_operacao"] == "alterar"){
		$cdProduto = $_REQUEST["cd_produto"];
		$resultado = $objProduto->updateProduto($cdProduto);
		if($resultado){
			$objConn->commit();
			echo "<script>fuSucessoAltera('$cdProduto')</script>";
		}else{
			$objConn->rollback();
			echo "<script>fuErro()</script>";
			echo "<span>- Ocorreu um erro ao alterar as informações, verifique as informações digitados e tente novamente.<br />DS_ERRO: ".$objProduto->msgErro."</span>";
		}
	}elseif($_REQUEST["tp_operacao"] == "excluir"){
		echo "<script>alert('Excluir')</script>";
	}/*FIM DO IF QUE VERIFICA O TIPO DE OPERAÇÃO*/
	
}else{/*FIM DO IF DA VALIDAÇÃO DOS DADOS*/
	echo "<script>fuErro()</script>";
	echo $msgValidacao;
}/*FIM DO ELSE DA VALIDAÇÃO DOS DADOS*/
?>



