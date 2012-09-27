<?php
session_start();
include "../seguranca/checaSessao.php";
require "../db/dadosConexaoDB.php";
require "../class/classProduto.php";

$msgValidacao = "";
$resultado = "";
$decodeReult;

$objConn = new mysqli($host, $user, $senha, $banco);
$objConn->set_charset("utf8");
if (mysqli_connect_errno()){
	$msgValidacao = "- ERRO: Conexão com banco de dados falhou, saia e entre no sistema novamente.<br />";
	die;
}

$objProduto = new produto($objConn);
$resultado = $objProduto->existeProduto(strtoupper($_REQUEST["cod_barras"]));

if($resultado != ""){
	$decodeReult = explode(";", $resultado );
	$msgValidacao	= "Já existe um produto cadastrado com esse código de barras.\\n\\nNome: ".$decodeReult[1]."\\nCódigo: ".$decodeReult[0]."\\nEstado: ".$decodeReult[2];
?>
<script>
	alert('<?=$msgValidacao?>');
	document.getElementById('cod_barras').value = '';
	document.getElementById('cod_barras').focus();
</script>
<?php	
}
?>