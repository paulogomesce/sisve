<script language="javascript" type="text/javascript">
	function resultadoOK(nuVenda, vlTotalVenda, qtdItens){
		alert('Venda realizada com sucesso!\nNúmero da venda: '+nuVenda+
		      '\nValor total da venda: R$ '+vlTotalVenda.toFixed(2)+
					'\nTotal de intens: '+qtdItens);
    location.href="form_venda_produto.php";
	}
</script>
<?php
include_once 'db/conexao.php';

$resultadoValidacao = true;
$mensagem = "";
$totalItens = 0;
$valorTotalVenda = 0;

//Inicio dasvalidações
for($cont=1; $cont < 51; $cont++){
	if($_REQUEST["cd_produto_".$cont] != "" || $_REQUEST["qtd_produto_".$cont] != ""){
		
		$totalItens++;
		
		if($_REQUEST["cd_produto_".$cont] == ""){
			$mensagem .= "Item $cont: Informe o código do produto.<br />";
			$resultadoValidacao = false;	
		}
	
		if($_REQUEST["qtd_produto_".$cont] == ""){
			$mensagem .= "Item $cont: Informe a quantidade de itens.<br />";
			$resultadoValidacao = false;	
		}
		
		if($_REQUEST["qtd_produto_".$cont] > $_REQUEST["qtd_produto_estoque_".$cont]){
			$mensagem .= "Item $cont: Quantidade do produto não disponível no estoque! Solicitado: ".$_REQUEST["qtd_produto_".$cont].", Disponível: ".$_REQUEST["qtd_produto_estoque_".$cont].".<br />";
			$resultadoValidacao = false;	
		}				
	}//fim do if das validações	
}//fim do for que conta os procedimentos
//Fim das validações

//Verifica se pelo menos um produto foi adicionado
if($totalItens < 1){
	$mensagem .= "Adicione no mínimo um produto para a venda.<br />";
	$resultadoValidacao = false;	
}
//Inicio da gravação dos produtos
if($resultadoValidacao){
	//Abre a venda e retorna o número da venda
	$sql = "select fu_abre_venda(1, 'SOMENTE DE TESTES NO DESENVOLVIMENTO.') as RESULTADO";
	$resultado = mysql_query($sql) or die("Erro ao abrir a venda: ".mysql_error());
	
	while($dados = mysql_fetch_assoc($resultado)){
		$nuVenda = $dados["RESULTADO"];//numero da venda
	}
	
	//Gravação de cada item
	for($cont=1; $cont <= $totalItens; $cont++){
		$valorTotalVenda += ($_REQUEST["preco_produt_".$cont] * $_REQUEST["qtd_produto_".$cont]);//calcula o valor da venda
																																														
		$sql = "call pr_grava_intem_venda('".$nuVenda."'
																		 ,'".$_REQUEST["cd_produto_".$cont]."'
																		 ,'".$_REQUEST["qtd_produto_".$cont]."'
																		 ,'".$_REQUEST["preco_produt_".$cont]."'
																		 ,'".$_REQUEST["vl_total_item_".$cont]."'
																		 ,'".$cont."');";
																		 
																
/*		$sql = "INSERT INTO tb_venda_produto_item (CD_VENDA
		                                          ,CD_PRODUTO
																							,QTD_PRODUTO
																							,PRECO_UNITARIO
																							,VL_TOTAL_ITEM
																							,SEQUENCIA)
		                                    VALUES('".$nuVenda."'
																				      ,'".$_REQUEST["cd_produto_".$cont]."'
																							,'".$_REQUEST["qtd_produto_".$cont]."'
																							,'".$_REQUEST["preco_produt_".$cont]."'
																							,'".$_REQUEST["vl_total_item_".$cont]."'
																							,'".$cont."');";
																							
*/																							
																							
		$resultado = mysql_query($sql) or die("Erro ao Gravar os dados: ".mysql_error());
	}
	
	if($resultado){
		echo"<script>resultadoOK($nuVenda, $valorTotalVenda, $totalItens)</script>";//chama a função javascript a mosta a tela
	}
	
}else{
	echo "$mensagem";
}
$closed = mysql_close($conexao);
?>



