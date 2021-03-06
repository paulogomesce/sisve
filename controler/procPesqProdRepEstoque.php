﻿<?php
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<title>Pesquisa Produto Repor Estoque</title>
<script src="../js/jquery.js"></script>
<style type="text/css">
</style>
<script type="text/javascript">
	function preencheDadosProduto(barcode, cdPorduto, dsProduto, fabricante, qtdVolume, status, dsStatus){
		document.getElementById('cod_barras').value = barcode;
		document.getElementById('cd_produto').value = cdPorduto;
		document.getElementById('ds_produto').value = dsProduto;
		document.getElementById('nm_fabricante').value = fabricante;
		document.getElementById('qtd_volume').value = qtdVolume;
		document.getElementById('status_produto').value = status;
		document.getElementById('status_prod').value = dsStatus;
		document.getElementById('cod_barras').readOnly = true;
		document.getElementById('cd_produto').readOnly = true;
		document.getElementById('btn_salvar').disabled = false;
		bkgColor('status_prod', '#3CB371');
		//se o produto tiver ativo
		if(status != 'N'){
			document.getElementById('fieldset_estoque').style.display = '';
			document.getElementById('qtd_estoque').focus();
		}else{
			bkgColor('status_prod', '#FF6347');
			alert('Este produto está cancelado, e não é possivel repor estoque para esse produto até seja ativado novamente.');
		}
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
	
	if($_REQUEST["tp_filtro"] != ""){
		if($_REQUEST["tp_filtro"] == "CD_PRODUTO"){
			$sql = "select pr.CD_PRODUTO as cdProduto,
						   pr.CODIGO_BARRAS as barcode,
			               pr.DS_PRODUTO as dsProduto,
			               pr.FABRICANTE fabricante,
			               pr.QTD_VOLUME qtd_volume,
			               pr.FL_ATIVO status,
			          case pr.FL_ATIVO when 'S' then 'ATIVO'
			          	when 'N' then 'CANCELADO' end as ds_status
			          from tb_produto pr
			         where pr.CD_PRODUTO = {$_REQUEST["vl_filtro"]}";
		}else{
			$sql = "select pr.CD_PRODUTO as cdProduto,
			               pr.CODIGO_BARRAS as barcode,
			               pr.DS_PRODUTO as dsProduto,
						   pr.FABRICANTE fabricante,
			               pr.QTD_VOLUME qtd_volume,
			               pr.FL_ATIVO status,
			          case pr.FL_ATIVO when 'S' then 'ATIVO'
			          	when 'N' then 'CANCELADO' end as  ds_status
			          from tb_produto pr
			          where pr.CODIGO_BARRAS <> ''
			            and pr.CODIGO_BARRAS is not null
			            and pr.CODIGO_BARRAS = {$_REQUEST["vl_filtro"]}";

		}
		
		$objRS = $objConn->query($sql);
		if($objRS){
			while($row = $objRS->fetch_object()){
				$cdProduto = $row->cdProduto;
				$barcode   = $row->barcode;
				$dsProduto  = $row->dsProduto;
				$fabricante = $row->fabricante;
				$qtdVolume  = $row->qtd_volume;
				$status     = $row->status;
				$dsStatus   = $row->ds_status;
			}
		}

		if(isset($cdProduto)){
			?>
			<script type="text/javascript">
				preencheDadosProduto('<?=$barcode?>', '<?=$cdProduto?>', '<?=$dsProduto?>', '<?=$fabricante?>', '<?=$qtdVolume?>', '<?=$status?>', '<?=$dsStatus?>');
			</script>
			<?php
		}else{
			echo "Produto não encontrado!";
		}
	}else{
		echo "Digite o código de barras ou o código do produto!";
	}
?>
</body>
</html>



















