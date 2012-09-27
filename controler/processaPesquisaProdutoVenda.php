<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Processa Pesquisa de Produto</title>
		<style type="text/css" media="print, screen and (min-width: 481px)"> 
		</style>
		<!--<link href="" rel="stylesheet" type="text/css" media="handheld, only screen and (max-device-width: 480px)" />-->
		<meta name="viewport" content="width=320" />
		<script type="text/javascript" src="js/jquery.js"></script>

		<style type="text/css">
		  .conteiner_linha{border: 0px solid #F8F8FF; width:385px; margin: 0; padding: 0 0 4px 0;}
			.conteiner_linha:hover{background-color: #B0E2FF;}
			.linhas{float: left; border: 0px solid gray; font-family: tahoma; font-size: 0.7em;}
			.cd_produto{width: 60px; border-right: 0px solid gray;  padding-top: 5px; cursor: pointer; font-weight: bold;}
			.nm_produto{width: 265px; border: 0px solid gray; padding-top: 5px; cursor: pointer; font-weight: bold;}
			.operacoes{width: 110px; border: 0px solid gray;  height: 25px;}
			.btn{border: 0px; width: 30px;}
			.botao{ margin-top: 2px;}
			.nm_produto a{display: block; padding-bottom: 7px; padding-top: 3px; margin-top: -3px; text-decoration: none; border: 0;}
			.nm_produto a:visited{color: black;}
			.clear{clear: both;}
		</style>
		<script type="text/javascript">
			function preencheProduto(cdBarras, cdProduto, dsProduto, preco){
				window.opener.document.getElementById('principal_barcode').value = cdBarras;
				window.opener.document.getElementById('principal_cdProdut').value = cdProduto;
				window.opener.document.getElementById('principal_dsProdut').value = dsProduto;
				window.opener.document.getElementById('principal_preco').value = preco;
				window.opener.removeDisabledQtd();
				window.opener.document.getElementById('principal_quantidade').focus();
				window.close();
			}
		</script>
	</head>
	<body>
		<?php
			require("../db/dadosConexaoDB.php");

			$objConn = new mysqli($host, $user, $senha, $banco);
			$objConn->set_charset("utf8");
			if (mysqli_connect_errno()){
				echo "ERRO: Conexão o banco de dados.";
			}
		
			$nmProduto  = str_replace(" ","%",$_REQUEST["nm_produto"]);

			$sql = "SELECT PR.CD_PRODUTO,
			               PR.CODIGO_BARRAS,
                     PR.DS_PRODUTO
										 FROM tb_produto PR
							 WHERE PR.DS_PRODUTO LIKE '%".$nmProduto."%'
							 ORDER BY 2 LIMIT 50";
								
      $objRS = $objConn->query($sql);
			while ($dados  = $objRS->fetch_object()){
					$cdVen = $dados->CD_PRODUTO;
				?>
					<div class="conteiner_linha" onclick="preencheProduto('<?=$dados->CODIGO_BARRAS ?>' ,'<?=$dados->CD_PRODUTO ?>', '<?=$dados->DS_PRODUTO ?>', 1000.00)">
						<div class="linhas cd_produto"><?=$dados->CD_PRODUTO?></div>
						<div class="linhas nm_produto"><?=$dados->DS_PRODUTO ?> </div>
						<div class="linhas cd_produto">1000.00</div>
						<div class="clear"></div>
					</div>
				<?php		
			}
			$objConn->close();
		?>
	</body>
</html>