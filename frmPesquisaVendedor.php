<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=320" />
		<title>Pesquisa de Vendedor</title>
		<!--Arquivos CSS-->
		<link type="text/css" rel="stylesheet" href="css/css_formulario_novo.css" />
		<!--Arquivos JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery.js"></script>
		<!--Declarações CSS-->
		<style type="text/css" >
			body{background-color: #F8F8FF;}
			#result{border: 1px solid gray; width: 822px; padding: 5px 0 5px 5px; height: 300px; overflow: auto;};
		</style>
		<!--Declarações JAVASCRIPT-->
		<script type="text/javascript">
			function pesquisarVendedor(){
				var dados = $("form").serialize();
				$.ajax({
					type: "POST",
					url: "controler/processaPesquisaVendedor.php",
					data: dados,
					cache: true,
					success: function(txt){$('#result').html(txt);},
					error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
					});				
			}
			window.onload = function(){
				pesquisarVendedor();
			}
		</script>
	</head>
	<body>
		<div id="resultado" style="display: none;"></div>
		<fieldset id="field_geral">
			<legend class="legend_super">Pesquisa Vendedor</legend>
			<div class="espacamento"></div>
			<form name="frmPesquisa" method="post">
				<fieldset>
					<legend>Dados do Vendedor</legend>
					<div class="espacamento"></div>
					<div class="campos">
						<label for="cd_vendedor" class="label">Código</label><br />
						<input type="text" name="cd_vendedor" class="campos_txt" size="5" onkeyup="pesquisarVendedor()" />
					</div>					
					<div class="campos">
						<label for="nm_pessoa" class="label">Nome</label><br />
						<input type="text" name="nm_vendedor" onkeyup="pesquisarVendedor()" class="campos_txt" size="60" maxlength="60"/>
					</div>
					<div class="clear"></div>					
				</fieldset>
				<!--Dados do acesso ao sistema-->
			</form>
		</fieldset>
		<div align="center" id="div_btns" style="width: 780px;">
			<button onclick="pesquisarVendedor()">Pesquisar</button>
		</div>
		<br />
		<div id="result"></div>
	</body>
</html>