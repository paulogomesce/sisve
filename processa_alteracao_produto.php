 <script language="javascript" type="text/javascript">
	function resultadoOK(){
		alert('Produto alterado com sucesso!');
    location.href="form_alteracao_produto.php";		
	}
</script>


<?php
include_once 'db/conexao.php';

$resultadoValidacao = true;
$mensagem = "";

if($_REQUEST["ds_produto"] == ""){
	$mensagem .= "Escreva uma descrição para o produto.<br />";
	$resultadoValidacao = false;	
}

if($_REQUEST["cd_categoria_produto"] == ""){
	$mensagem .= "Escolha uma categoria para o produto.<br />";
	$resultadoValidacao = false;	
}

if($_REQUEST["vlr_unitario"] == ""){
	$mensagem .= "Informe o valor unitário do produto.<br />";
	$resultadoValidacao = false;	
}

if($resultadoValidacao){

$sql = "UPDATE tb_produto
				   SET ds_produto   = '".strtoupper($_REQUEST["ds_produto"])."'
					  	,fabricante   = '".strtoupper($_REQUEST["fabricante"])."'
						  ,cd_categoria = '".strtoupper($_REQUEST["cd_categoria_produto"])."'
						  ,vl_unitario  = '".$_REQUEST["vlr_unitario"]."'
			   WHERE cd_produto   = '".$_REQUEST["cd_produto"]."'";
																					 
	$resultado = mysql_query($sql) or die("Erro ao Gravar os dados: ".mysql_error());
	
	if($resultado == true){
		echo "sucesso";
		echo"<script>resultadoOK()</script>";
	}
	
}else{
	echo "$mensagem";
}
$closed = mysql_close($conexao);
?>
