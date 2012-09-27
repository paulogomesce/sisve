<?php
include_once 'db/conexao.php';

$nuItem = $_REQUEST["nu_item"];
$produtoEncontrado = false;

$sql = "select p.cd_produto
              ,p.ds_produto
              ,p.vl_unitario
              ,p.qtd_estoque
          from tb_produto p
         where p.ativo = 'S'
           and p.cd_produto like '".$_REQUEST["cd_produto"]."'";
			   
$result = mysql_query($sql);

while($dados = mysql_fetch_assoc($result)){
	$dsProduto  = $dados["ds_produto"];
	$vrUnitario = (string)$dados["vl_unitario"];
	$qtdEstoque = $dados["qtd_estoque"];
	$produtoEncontrado = true;
}
if($produtoEncontrado == true){
?>
	<script language="javascript">
		document.form_venda.ds_produto_<?=$nuItem?>.value   = '<?=$dsProduto?>';
		document.form_venda.preco_produt_<?=$nuItem?>.value = '<?=number_Format($vrUnitario, 2, ".", "")?>';
		document.form_venda.qtd_produto_estoque_<?=$nuItem?>.value = <?=$qtdEstoque?>;
		
		document.form_venda.qtd_produto_<?=$nuItem?>.focus();
		
	</script>
<?php
}else{
	echo "<script>alert('Produto não encontrado!')</script>";
}
$closed = mysql_close($conexao);
?>
