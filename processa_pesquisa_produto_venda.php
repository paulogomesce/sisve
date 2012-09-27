<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

				<style type="text/css">

			#cd_produto{
				width: 65px;
				text-align: right;
			}
			
			#ds_produto{
				width: 450px;
				padding-left: 10px;
			}
			
			#vl_produto{
				width: 80px;
				text-align: right;
			}
			
			#qtd_estoque{
				width: 65px;
				text-align: right;
				padding-right: 10px;

			}
			
			#tabela_resultado{
				font-size: 13;
				font-weight: bolder;
				font-family: arial;
			}

			#dados:hover{background-color: #ADD8E6;}
					
				</style>
        <link rel="stylesheet" type="text/css" href="css/formulario.css"/>
	</head>
<body>	
<?php
include_once 'db/conexao.php';

$nuItem    = $_REQUEST["nu_item"];
$nmProduto = $_REQUEST["nm_produto"];

$produtoEncontrado = false;

$sql = "select p.cd_produto
              ,p.ds_produto
              ,p.vl_unitario
              ,p.qtd_estoque
          from tb_produto p
         where p.ativo = 'S'
           and p.ds_produto like '".$nmProduto."%'
				 order by 2";
			   
$result = mysql_query($sql);
?>
<table cellspacing="0px" cellpadding="0px" id="tabela_resultado" border="0">
<?php
while($dados = mysql_fetch_assoc($result)){ ?>

		<tr id="dados">
			<td id="cd_produto"><?=$dados["cd_produto"]?></td>
			<td id="ds_produto"><a href="#" onclick="javascript: 
																							opener.document.form_venda.cd_produto_<?=$nuItem?>.value   = '<?=$dados["cd_produto"]?>';
																							opener.document.form_venda.ds_produto_<?=$nuItem?>.value   = '<?=$dados["ds_produto"]?>';
																							opener.document.form_venda.preco_produt_<?=$nuItem?>.value = '<?=number_Format((string)$dados["vl_unitario"], 2, ".", "")?>';
																							opener.document.form_venda.qtd_produto_estoque_<?=$nuItem?>.value = '<?=$dados["qtd_estoque"]?>';
																							opener.document.form_venda.qtd_produto_<?=$nuItem?>.focus();
																							window.close();
																							">
				<?=$dados["ds_produto"]?></a>
			</td>
			
		
		
		
			
			
			<td id="vl_produto"><?=(string)$dados["vl_unitario"]?></td>
			<td id="qtd_estoque"><?=$dados["qtd_estoque"]?></td>
		</tr>

<?php
	$produtoEncontrado = true;
}
?>
</table>
<?php
if($produtoEncontrado == true){

}else{
	echo "<script>alert('Produto não encontrado!')</script>";
}
$closed = mysql_close($conexao);
?>
</body>
</html>
