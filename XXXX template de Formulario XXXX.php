<?php
require "db/dadosConexaoDB.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="pt-br">
	<head>
		<title>Titulo da Página</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!--Arquivos CSS-->
		<link type="text/css" rel="stylesheet" href="css/css_formulario_novo.css" />
		<link href="css/popup.css" rel="stylesheet" type="text/css"/>
		
		<!--Arquivos JAVASCRIPT-->
    <script type="text/javascript" src="js/gravacao_foms.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/funcoesJS.js"></script>
		<script type="text/javascript" src="js/processa_eventos.js"></script>
		
		<!--Declarações JAVASCRIPT-->
		<script type="text/javascript">
			window.onload = function(){
				document.getElementById("cod_barras").focus();
			}
		</script>
		<!--Declarações CSS-->
		<style type="text/css">
			#div_btns{width: 780px; text-align: center; padding-top: 5px;}
			#div_reposicoes{border: 0px solid gray; width: 780px; min-height: 210px; overflow: auto; max-height: 210px;}
			#tb_reposicoes{font-family: tahoma; font-size: 0.8em;}
			.tb_dados{text-align: center;}
			#msg_sem_estoque{font-family: tahoma; font-size: 0.8em; color: red;}
			table.bordasimples {border-collapse: collapse;}
			table.bordasimples tr td {border:1px solid gray;}
			.dados:hover{background-color: #E0FFFF;}
			
		</style>
	</head>
	<body>
		<h1>Template de Formulário</h1>
		<?php
			$objConn = new mysqli($host, $user, $senha, $banco);
			$objConn->set_charset("utf8");

			if (mysqli_connect_errno()){
				$msgValidacao .= "- ERRO: Conexão o banco de dados.<br />";
				$resultValidacao = false;		
			}
		?>
		<!--Inicio do formulário-->
		<fieldset id="field_geral">
			<legend class="legend_super">Reposição de Produtos no Estoque</legend>
			<div class="espacamento"></div>
			<form method="post" action="void" >
				<fieldset>
					<legend>Filtros</legend>
					<div class="espacamento"></div>
					<div class="campos">
						<label for="cd_produto" class="label">Código</label><br />
						<input type="text" name="cd_produto" id="cd_produto" value="<?=$cdProduto?>" class="campos_txt" size="5" readonly="readonly"/>
					</div>
					<div class="campos">
						<label for="cod_barras" class="label">Código de Barras</label><br />
						<input type="text" name="cod_barras" value="<?=$cdBarras?>" id="cod_barras" class="campos_txt" size="20" maxlength="20" onkeyup="proxItem('ds_produto', event)" onblur="execPesqExistProd(this.value)"/>
					</div>
					<div class="campos">
						<label for="ds_produto" class="label">*Nome do Produto</label><br />
						<input type="text" name="ds_produto" value="<?=$dsProduto?>" id="ds_produto" class="campos_txt" size="50" maxlength="35"/>
					</div>
					<div class="campos">
						<label for="nm_fabricante" class="label">Nome do Fabricante</label><br />
						<input type="text" name="nm_fabricante" value="<?=$fabricante?>" id="nm_fabricante" class="campos_txt" size="32" maxlength="30" />
					</div>
					<div class="clear"></div>
					<!--Quantidade do volume do produto-->
					<div class="campos">
						<label for="qtd_volume" class="label">Qtd. Volume</label><br />
						<input type="text" name="qtd_volume" id="qtd_volume" value="<?=$qtdVolume?>" class="campos_txt" size="8" maxlength="10" />
					</div>

					<!--SITUAÇÃO DO PRODUTO-->					
					<div class="campos">
						<label for="status_prod" class="label">Status</label><br />
						<input type="text" name="status_prod" id="status_prod" value="" class="campos_txt" size="15" maxlength="15" readonly="readonly"/>
					</div>
					
					<!--CAMPOS EM BAIXO-->
					<div class="clear"></div>	
				</fieldset>
				
				<!--Informações do Estoque-->
				<br />
				<fieldset><!--FIM DO FIALDSET DAS UNFORMAÇÕES DO ESTOQUE-->
					<legend>Informações do Estoque</legend>
					<div class="espacamento"></div>
					<!--QUANTIDADE INCLUIDA-->
					<div class="campos">
						<label for="qtd_estoque" class="label">*Qt. Entrada</label><br />
						<input type="text" name="qtd_estoque" id="qtd_estoque" value="" class="campos_txt" size="6" onkeydown="return isNumberKey(event)" maxlength="7" />
					</div>
					<!--PREÇO DE CUSTO DO PRODUTO-->
					<div class="campos">
						<label for="preco_custo" class="label">*Preço Custo</label><br />
						<input type="text" name="preco_custo" id="preco_custo" value="" class="campos_txt" size="10" maxlength="10" onkeydown="return soNumeroEPonto(event)" />
					</div>
					<!--PREÇO DE VENDA DO PRODUTO-->
					<div class="campos">
						<label for="preco_venda" class="label">*Preço Venda</label><br />
						<input type="text" name="preco_venda" id="preco_venda" value="" class="campos_txt" size="10" maxlength="10" onkeydown="return soNumeroEPonto(event)" />
					</div>
					<!--DATA FABRICAÇÃO-->
					<div class="campos">
						<label for="dt_fabricacao" class="label">Dt. Fabricação</label><br />
						<input type="text" name="dt_fabricacao" id="dt_fabricacao" value="" class="campos_txt" size="10" maxlength="10" onkeyup="FormataData(this, event)" onkeydown="return isNumberKey(event)" />
					</div>						
					<!--DATA DE VALIDADE-->
					<div class="campos">
						<label for="dt_validade" class="label">Dt. Validade</label><br />
						<input type="text" name="dt_validade" id="dt_validade" value="" class="campos_txt" size="10" maxlength="10" onkeyup="FormataData(this, event)" onkeydown="return isNumberKey(event)" />
					</div>
					<!--LOTE-->
					<div class="campos">
						<label for="lote" class="label">Lote</label><br />
						<input type="text" name="lote" id="lote" value="" class="campos_txt" size="15" maxlength="15" />
					</div>
					<div class="clear"></div>
					<!--STATUS DO ESTOQUE-->
					<div class="campos">
						<label for="status_estoque" class="label">*Situação</label><br />
						<select name="status_estoque" id="status_estoque" class="input_form tag_option">
							<option value="">Selecione...</option>
							<?php
							$sql = "select es.cd_status_estoque as cd,
														 es.ds_status_estoque as descricao,
														 es.fl_cheked cheked
												from tb_status_estoque es
											 order by 1";
							$objRS = $objConn->query($sql);
							while ($dados = $objRS->fetch_assoc()) { ?>
								<option value="<?=$dados["cd"]?>" <?echo ($dados["cheked"] == "S")? "selected='selected'" : ""; ?> ><?=$dados["descricao"]?></option>
							<?php
							}
							?>
						</select>
					</div>					
				</fieldset><!--FIM DO FIALDSET DAS UNFORMAÇÕES DO ESTOQUE-->
				
				
			</form>
		</fieldset><!--Fim do fieldset geral-->
		<div id="div_btns">
			<button onclick="executarAcao('o cadastro')"  <?echo ($operacao != "cadastrar")? "disabled='disabled'" : ""; ?> id="btn_salvar">Salvar</button>
			<button onclick="executarAcao('a alteração')" <?echo ($operacao != "alterar")  ? "disabled='disabled'": ""; ?> id="btn_alterar">Alterar</button>
			<button onclick="executarAcao('a exclusão')"  <?echo ($operacao != "excluir")  ? "disabled='disabled'": ""; ?> id="btn_excluir">Excluir</button>
			<button onclick="javascript: location.href='frmReporProdutoEstoque.php'" id="btn_novo">Novo</button>
			<button onclick="javascript: window.close();" id="btn_fechar">Fechar</button>
			<button onclick="javascript:  history.go(-1);" id="btn_fechar">Voltar</button>
		</div>
		<div id="conteiner_modal">
			<div id="titulo_conteiner">Verifique as seguintes mensagens:</div>
			<div id="dados_res"></div>
			<div id="div_botao">
				<button onclick='closeDivErro()' id="btn_fecha_mod">Fechar</button>
			</div>	
		</div>
	</body>
</html>