<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
      <title>Pesquisa de Produto</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<link rel="stylesheet" type="text/css" href="css/popup_pesquisa.css"/>
      <script language="javascript" type="text/javascript" src="js/gravacao_foms.js"></script>
			<script language="javascript" type="text/javascript" src="js/processa_eventos.js"></script>
      <script src="js/jquery.js"></script>
			<script language="javascript">
				//coloca o cursor no campo codigo do produto do primeiro item da venda
				window.onload = function(){
					document.getElementById("nm_produto").focus();
				}
				function precessaPesquisa(){
					var NmProduto = document.getElementById('nm_produto').value;
					$.ajax({ 
						type: "POST", 
						 url: "controler/processaPesquisaProdutoVenda.php?nm_produto="+NmProduto, 
				 success: function(txt){$('#div_resultado').html(txt);},
					 error: function(){alert("ERRO")}
						});
				}
			</script>
			<style type="text/css">
				.cabecalho_popup{background-image:url("imagens/bg_title_popup.png"); height: 22px; border: 0px solid gray; padding: 3px 0 0 5px; marging: 0; font-weight: bold; color: black;}
				.txt_titulo{font-family: tahoma; font-size: 0.8em;}
				.div_label{margin: 0; padding: 0; border: 0px solid gray; font-family: tahoma; font-size: 0.9em;}
				.div_input{margin: 0; padding: 0; border: 0px solid gray;}
				#div_conteiner{border: 0px solid black; padding: 5px;}
				#div_resultado{border: 0px solid black; padding: 5px; min-height: 280px; max-height: 280px; overflow: auto; width: 400px;}
				#nm_produto{width: 280px; padding: 0;}
				
				.conteiner_linha_h{background-color: #DCDCDC; width:406px; margin-left: 4px; padding: 0 0 4px 0;}
				.linhas_h{float: left; border: 0px solid gray; font-family: tahoma; font-size: 0.7em;}
				.clear{clear: both;}
				.cd_produto_h{width: 60px; border-right: 0px solid gray;  padding-top: 5px; cursor: pointer; font-weight: bold;}
				.nm_produto_h a{display: block; padding-bottom: 7px; padding-top: 3px; margin-top: -3px; text-decoration: none; border: 0;}
				.nm_produto_h a:visited{color: black;}
				.nm_produto_h{width: 265px; border: 0px solid gray; padding-top: 5px; cursor: pointer; font-weight: bold;}
			</style>
		</head>
    <body>
			<div class="cabecalho_popup">
				<span class="txt_titulo">Pesquisa de Produto<span>
			</div>
			<form method="post" action="">
				<div id="div_conteiner">
					<div class="div_label">
						<span>Nome do Produto</span>
					</div>
					<div class="div_input">
						<input type="text" name="nm_produto" id="nm_produto" onkeyup="precessaPesquisa()" />
					</div>
				</div>
				<!--DIV cabecalho-->
				<div class="conteiner_linha_h">
					<div class="linhas_h cd_produto_h">Código</div>
					<div class="linhas_h nm_produto_h">Descrição</div>
					<div class="linhas_h cd_produto_h">Preço</div>
					<div class="clear"></div>
				</div>
				<!--Resultado da Pesquisa-->
				<div id="div_resultado">
				</div>
			</form>
		</body>
</html>
