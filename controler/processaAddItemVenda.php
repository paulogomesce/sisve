<?php
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <title>Meu Menu</title>
		<script src="../js/jquery.js"></script>
		<style type="text/css">
		</style>
		<script type="text/javascript">
			function preencheDadosProduto(barcode, cdPorduto, dsProduto, preco){
				document.getElementById('principal_barcode').value = barcode;
				document.getElementById('principal_cdProdut').value = cdPorduto;
				document.getElementById('principal_dsProdut').value = dsProduto;
				document.getElementById('principal_quantidade').value = '1';
				document.getElementById('principal_preco').value = preco;
				document.getElementById('principal_total_item').value = preco;
				removeDisabledQtd();
				document.getElementById('principal_quantidade').select();
			}
		</script>
  </head>
  <body>
	<?php
		require_once "../seguranca/checaSessao.php";
		require_once "../db/dadosConexaoDB.php";
		
		$objConn = new mysqli($host, $user, $senha, $banco);
		//$objConn->set_charset("utf8");
		if (mysqli_connect_errno()){
			echo "ERRO: Conexão o banco de dados.";
		}
		if($_REQUEST["vl_parametro"] != ""){
			if($_REQUEST["tp_filtro"] == "cdProduto"){
				$sql = "select pr.CD_PRODUTO as cdProduto,
											 pr.CODIGO_BARRAS as barcode,
											 pr.DS_PRODUTO as dsProduto,
											 pr.PRECO as preco,
											 pr.QTD_ATUAL_DISPONIVEL as qtdDisponivel
									from tb_produto pr
								 where pr.CD_PRODUTO = {$_REQUEST["vl_parametro"]}";
			}else{
				$sql = "select pr.CD_PRODUTO as cdProduto,
											 pr.CODIGO_BARRAS as barcode,
											 pr.DS_PRODUTO as dsProduto,
											 pr.PRECO as preco,
											 pr.QTD_ATUAL_DISPONIVEL as qtdDisponivel
									from tb_produto pr
								 where pr.CODIGO_BARRAS <> ''
								   and pr.CODIGO_BARRAS is not null
								   and pr.CODIGO_BARRAS = {$_REQUEST["vl_parametro"]}";		
			}
							 
			$objRS = $objConn->query($sql);
			if($objRS){
				while($row = $objRS->fetch_object()){
					$cdProduto = $row->cdProduto;
					$barcode   = $row->barcode;
					$dsProduto = $row->dsProduto;
					$preco     = $row->preco;
				}
			}
			if(isset($cdProduto)){
			?>
				<script type="text/javascript">
					preencheDadosProduto('<?=$barcode?>', '<?=$cdProduto?>', '<?=$dsProduto?>', '<?=$preco?>');
				</script>
			<?php
			}else{
				echo "Produto não encontrado!";
				echo "<script>limpaFormulario();</script>";
			}
		}else{
			echo "Digite o código de barras ou o código do produto!";
			echo "<script>limpaFormulario();</script>";
		}
		?>
  </body>
</html>
