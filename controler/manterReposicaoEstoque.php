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
    location.href="frmReporProdutoEstoque.php?fl_incluido=y&cd_produto="+cdProduto;
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

//Objeto Estoque
$objEstoque = new estoque($objConn);

/*(02) INFORMAÇÕES DO ESTOQUES, VALIDA SOMENTE SE FOR UMA NOVA INCLUSÃO DE PRODUTO*/
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

if($resultValidacao){
	/*ESTOQUE*/
	$objEstoque->setQtdEntrada($_REQUEST["qtd_estoque"]);//quantidade de produtos que tá entrando no estoque
	$objEstoque->setQtdRestante($_REQUEST["qtd_estoque"]);//quantidade de produtos que resta no estoque
	$objEstoque->setDtFabricacao($_REQUEST["dt_fabricacao"]);
	$objEstoque->setDtValidade($_REQUEST["dt_validade"]);
	$objEstoque->setPrecoCustoProduto(trataFloat($_REQUEST["preco_custo"]));//PREÇO DE CUSTO DO PRODUTO
	$objEstoque->setPrecoVendaProduto(trataFloat($_REQUEST["preco_venda"]));//PREÇO DE VENDA DO PRODUTO
	$objEstoque->setLote(strtoupper($_REQUEST["lote"]));
	$objEstoque->setCdStatus(strtoupper($_REQUEST["status_estoque"]));
	$objEstoque->setNmUsuarioCadastrou($_SESSION["nm_usuario"]);
	$objEstoque->setCdProduto($_REQUEST["cd_produto"]);
	
		$resultIncEstoq = $objEstoque->incluirProduto($_REQUEST["cd_produto"]);//INCLUSAO DOS PRODUTOS NO ESTOQUE
		
		$msgGravacao = "";

		if(!$resultIncEstoq){
			$msgGravacao .= "- Erro Inesperado ao gravar as informações do estoque,<br />&nbsp;&nbsp;verifique os valores digitados e tente novamente. DS_ERRO: ".$objEstoque->msgErro."<br />";
		}
		
		if($msgGravacao == ""){
			$objConn->commit();
			echo "<script>fuSucessoCadastra('{$_REQUEST['cd_produto']}');</script>";		
		}else{
			$objConn->rollback();
			echo "<script>fuErro()</script>";
			echo $msgGravacao;
		}
}else{/*FIM DO IF DA VALIDAÇÃO DOS DADOS*/
	echo "<script>fuErro()</script>";
	echo $msgValidacao;
}/*FIM DO ELSE DA VALIDAÇÃO DOS DADOS*/
?>



