<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=320" />
		<title>Pesquisa de Produto</title>
		<!--Arquivos CSS-->
		<link type="text/css" rel="stylesheet" href="css/css_formulario_novo.css" />
		<!--Arquivos JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery.js"></script>
		<!--Declarações CSS-->
		<style type="text/css" >
			body{background-color: #F8F8FF;}
			#result{border: 1px solid gray; width: 822px; padding: 5px 0 5px 0px; height: 300px; overflow: auto;};
		</style>
		<!--Declarações JAVASCRIPT-->
		<script type="text/javascript">
			function pesquisarProduto(){
				var dados = $("form").serialize();
				$.ajax({
					type: "POST",
					url: "controler/processaPesquisaProduto.php",
					data: dados,
					cache: true,
					success: function(txt){$('#result').html(txt);},
					error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
					});				
			}
			window.onload = function(){
				pesquisarProduto();
				var cdProduto = document.getElementById('cd_produto').value;
				var codBarras = document.getElementById('cd_barras').value;
				var nmProduto = document.getElementById('nm_produto').value;
			}
		</script>
	</head>
	<body>
		<div id="resultado" style="display: none;"></div>
		<fieldset id="field_geral">
			<legend class="legend_super">Pesquisa de Produto - <?=strtoupper($_REQUEST["operacao"])?></legend>
			<div class="espacamento"></div>
			<form name="frmPesquisa" method="post">
				<fieldset>
					<legend>Dados do Produto</legend>
					<div class="espacamento"></div>
					<div class="campos">
						<label for="cd_produto" class="label">Código</label><br />
						<input type="text" name="cd_produto" id="cd_produto" class="campos_txt" size="5" onkeyup="pesquisarProduto()" />
					</div>

					<div class="campos">
						<label for="cd_barras" class="label">Código de Barras</label><br />
						<input type="text" name="cd_barras" id="cd_barras" class="campos_txt" size="20" maxlength="20" onkeyup="pesquisarProduto()" />
					</div>

					<div class="campos">
						<label for="nm_produto" class="label">Descrição do Produto</label><br />
						<input type="text" name="nm_produto" id="nm_produto" onkeyup="pesquisarProduto()" class="campos_txt" size="50" maxlength="35"/>
					</div>
					<div class="campos">
						<label for="tp_operacao" class="label">Operação</label><br />
						<input type="text" name="tp_operacao" value="<?=strtoupper($_REQUEST["operacao"])?>" size="10" readonly="readonly" />
					</div>
					<div class="clear"></div>					
				</fieldset>
				<!--Dados do acesso ao sistema-->
			</form>
		</fieldset>
		<div align="center" id="div_btns" style="width: 780px;">
			<button onclick="pesquisarProduto()">Pesquisar</button>
		</div>
		<br />
		<div id="result"></div>
	</body>
</html>