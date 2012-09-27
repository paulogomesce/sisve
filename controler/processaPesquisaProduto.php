<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Processa Pesquisa de Vendedor</title>
		<style type="text/css" media="print, screen and (min-width: 481px)"> 
		</style>
		<!--<link href="" rel="stylesheet" type="text/css" media="handheld, only screen and (max-device-width: 480px)" />-->
		<meta name="viewport" content="width=320" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript">
			function abreNovaJanela(url){
				window.open(url,'EditaProduto','height=500,width=855,top=100,left=210,resizable=1,scrollbars=1,location=no,toolbar=0,titlebar=0,status=0')
			}
		</script>
		<style type="text/css">
		  .conteiner_linha{border: 1px solid white; width: 99.7%;}
			.conteiner_linha:hover{background-color: #E0FFFF; border: 1px solid #AFEEEE;}
			.linhas{float: left; border: 0px solid gray; font-family: tahoma; font-size: 0.8em;}
			.cd_produto{width: 60px; border: 0px solid gray;  padding-top: 5px; padding-left: 5px; cursor: pointer; font-weight: bold;}
			.nm_produto{width: 350px; border: 0px solid gray; padding-top: 5px; cursor: pointer; font-weight: bold;}
			.operacoes{width: 110px; border: 0px solid gray;  height: 25px;}
			.btn{border: 0px; width: 30px;}
			.botao{ margin-top: 2px;}
			.nm_produto a{display: block; padding-bottom: 7px; padding-top: 3px; margin-top: -3px;;text-decoration: none; border: 0;}
			.nm_produto a:visited{color: black;}
			.clear{clear: both;}
		</style>
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
			$tpOperacao = strtolower($_REQUEST["tp_operacao"]);
			
			$url = "./frmCadastroProduto.php?operacao=".$tpOperacao."&cd_produto=";

			$sql = "select pr.cd_produto,
			               pr.codigo_barras,
                     pr.ds_produto
										 from tb_produto pr
							 where pr.cd_produto like '".$_REQUEST["cd_produto"]."%'
								 and pr.ds_produto like '%".$nmProduto."%'
								 and (pr.codigo_barras like '".$_REQUEST["cd_barras"]."%' or pr.codigo_barras is null)
							 order by 2 limit 50";
								
      $objRS = $objConn->query($sql);
			while ($dados = $objRS->fetch_object()){
					$cdVen = $dados->cd_produto;
				?>
					<div class="conteiner_linha">
						<div class="linhas cd_produto"><?=$dados->cd_produto?></div>
						<div class="linhas nm_produto"><a href="<?=$url.$dados->cd_produto?>"><?=$dados->ds_produto?></a></div>
						<div class="linhas operacoes"><button class="botao" onclick="abreNovaJanela('<?=$url.$dados->cd_produto?>')" title="Abrir em uma nova janela."><img src="icones/nova_janela.gif"/></button></div>
						<div class="clear"></div>
					</div>
				<?php		
			}
			$objConn->close();
		?>
	</body>
</html>