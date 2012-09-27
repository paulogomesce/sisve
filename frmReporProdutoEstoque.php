<?php
require "db/dadosConexaoDB.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="pt-br">
	<head>
		<title>Reposição de Produto no Estoque</title>
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
			//Envia a pesquisa do produto
			function procPesquisaBcCd(evento, vlFiltro, tpFiltro){
			  $("#dados_retorno").empty();
				if(vlFiltro != ""){
					var parametros = 'vl_filtro='+vlFiltro+'&tp_filtro='+tpFiltro;
					var tecla      = (evento.which) ? evento.which : evento.keyCode;
					if(tecla == 13){
						//alert(vlFiltro);
						$.ajax({ 
							type: "POST", 
							 url: "controler/procPesqProdRepEstoque.php?"+parametros, 
					 success: function(txt){$(txt).prependTo("#dados_retorno")},
						 error: function(){alert("ERRO")}
							});
					}
				}
			}		
			//Grava as informações do estoque
			function gravaEstoque(){
				var confirmacao = confirm('Confirma a inclusão do produto no estoque?');
				if(confirmacao){
					$("#dados_res").empty();
					var campos = decodeURIComponent($("form").serialize());
					$.ajax({ 
						type: "POST", 
						 url: "controler/manterReposicaoEstoque.php", 
						data: campos, 
				 success: function(txt){$(txt).prependTo("#dados_res"); /*alert(txt)*/},
					 error: function(){alert("ERRO")}
						});
				}else{
					alert('Operação cancelada!');
				}
			}
			//Coloca o foco no campo código de barras
			window.onload = function(){
				document.getElementById("cod_barras").focus();
			}
			//Popup para pesquisa de produto
			function abrePesquisaProduto(){
				var winLargura = document.body.offsetWidth;
				var margens = (winLargura - 300)/2;
				window.open('frmPesquisaProdutoVenda.php','_blank','width=420,height=395,left='+margens+',top=150');
			}
			
		</script>
		<!--Declarações CSS-->
		<style type="text/css">
			#div_btns{width: 780px; text-align: center; padding-top: 5px;}
			#div_reposicoes{border: 0px solid gray; width: 793px; min-height: 210px; overflow: auto; max-height: 210px;}
			#tb_reposicoes{font-family: tahoma; font-size: 0.8em;}
			.tb_dados{text-align: center;}
			#msg_sem_estoque{font-family: tahoma; font-size: 0.8em; color: red;}
			table.bordasimples {border-collapse: collapse;}
			table.bordasimples tr td {border:1px solid gray;}
			.dados:hover{background-color: #E0FFFF;}
			
			#img_btn_pesquisa{height: 12px;}
			#dados_retorno{font-family: tahoma; font-size: 0.8em; color: red; padding: 2px 0 0 4px;}
			
		</style>
	</head>
	<body>
		<?php
			$objConn = new mysqli($host, $user, $senha, $banco);
			$objConn->set_charset("utf8");

			if (mysqli_connect_errno()){
				$msgValidacao .= "- ERRO: Conexão o banco de dados.<br />";
				$resultValidacao = false;		
			}
			
			if(isset($_REQUEST["fl_incluido"])){
					$sql = "select pr.CD_PRODUTO as cdProduto,
												 pr.CODIGO_BARRAS as barcode,
												 pr.DS_PRODUTO as dsProduto,
												 pr.FABRICANTE fabricante,
												 pr.QTD_VOLUME qtd_volume,
												 pr.FL_ATIVO status,
												 case pr.FL_ATIVO when 'S' then 'ATIVO' when 'N' then 'CANCELADO' end as ds_status
										from tb_produto pr
									 where pr.CD_PRODUTO = {$_REQUEST["cd_produto"]}
									   and pr.fl_ativo   = 'S'";

				$objRS = $objConn->query($sql);
					while($row = $objRS->fetch_object()){
						$cdProduto  = $row->cdProduto;
						$barcode    = $row->barcode;
						$dsProduto  = $row->dsProduto;
						$fabricante = $row->fabricante;
						$qtdVolume  = $row->qtd_volume;
						$status     = $row->status;
						$dsStatus   = $row->ds_status;
					}
			}else{
				$cdProduto  = null;
				$barcode    = null;
				$dsProduto  = null;
				$fabricante = null;
				$qtdVolume  = null;
				$status     = null;
				$dsStatus   = null;
			}
			
		?>
		<!--Inicio do formulário-->
		<fieldset id="field_geral">
			<legend class="legend_super">Reposição de Produtos no Estoque</legend>
			<div class="espacamento"></div>
			<form method="post" action="javascript:void(0)" >
				<fieldset>
					<legend>Filtros</legend>
					<div class="espacamento"></div>
					<div class="campos">
						<label for="cd_produto" class="label">Código</label><br />
						<input type="text" name="cd_produto" id="cd_produto" value="<?=$cdProduto?>" class="campos_txt" size="5" onkeyup="procPesquisaBcCd(event, this.value, 'CD_PRODUTO')" />
					</div>
					<div class="campos">
						<label for="cod_barras" class="label">Código de Barras</label><br />
						<input type="text" name="cod_barras" value="<?=$barcode?>" id="cod_barras" class="campos_txt" size="20" maxlength="20" onkeyup="procPesquisaBcCd(event, this.value, 'CD_BARRAS')" />
					</div>
					<div class="campos">
						<label for="ds_produto" class="label">Nome do Produto</label><br />
						<input type="text" name="ds_produto" value="<?=$dsProduto?>" id="ds_produto" class="campos_txt" size="50" maxlength="35" readonly="readonly"/>
					</div>
					<div class="campos">
						<label for="nm_fabricante" class="label">Nome do Fabricante</label><br />
						<input type="text" name="nm_fabricante" value="<?=$fabricante?>" id="nm_fabricante" class="campos_txt" size="32" maxlength="30" readonly="readonly" />
					</div>
					<div class="clear"></div>
					<!--Quantidade do volume do produto-->
					<div class="campos">
						<label for="qtd_volume" class="label">Qtd. Volume</label><br />
						<input type="text" name="qtd_volume" id="qtd_volume" value="<?=$qtdVolume?>" class="campos_txt" size="8" maxlength="10" readonly="readonly" />
					</div>
					<!--SITUAÇÃO DO PRODUTO-->					
					<div class="campos">
						<label for="status_prod" class="label">Status</label><br />
						<input type="text" name="status_prod" id="status_prod" value="<?=$dsStatus?>" class="campos_txt" size="10" maxlength="10" readonly="readonly"/>
						<input type="text" name="status_produto" id="status_produto" size="5" hidden="hidden"/>
					</div>
					<!--Botão pesquisa produto-->
					<div class="campos">
						<div>&nbsp;</div>
						<!---<button id="btn_pesquisa_produto" class="input_form tag_option" onclick="abrePesquisaProduto()" ><img src="icones/pesquisar_2.png" id="img_btn_pesquisa" /> Pesquisar</button>-->
						<input type="button" value="Pesquisar" onclick="abrePesquisaProduto()" class="input_form tag_option"/>
					</div>
					<div class="campos">
						<div>&nbsp;</div>
						<div id="dados_retorno"></div>
					</div>
					<!--CAMPOS EM BAIXO-->
					<div class="clear"></div>	
				</fieldset>
				
				<!--Informações do Estoque-->
				<br />
				<fieldset style="display: none;" id="fieldset_estoque"><!--FIM DO FIALDSET DAS UNFORMAÇÕES DO ESTOQUE-->
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

				<?php
							if(isset($_REQUEST["fl_incluido"])){
				?>
								<fieldset>
									<legend>Histórico de Reposições do Produto</legend>
									<div class="espacamento"></div>
									<div id="div_reposicoes">
										<table id="tb_reposicoes" class="bordasimples">
											<tr>
												<th width="70px">Reposição</th>
												<th width="63px">Incluído</th>												
												<th width="70px">Restante</th>
												<th width="70px">Pr. Custo</th>
												<th width="70px">Pr. Venda</th>
												<th width="80px">Fabricação</th>
												<th width="80px">Validade</th>
												<th width="90px">Dt. Reposição</th>
												<th width="160px">Estado</th>
											</tr>
											<?php
												$contador = 0;
												$sql = "SELECT RE.CD_REPOSICAO,
												               RE.QTD_PRODUTO,
																			 RE.QTD_RESTANTE,
																			 RE.PRECO_CUSTO_PRODUTO AS PR_CUSTO,
																			 RE.PRECO_VENDA_PRODUTO AS PR_VENDA,
																			 DATE_FORMAT(RE.DT_FABRICACAO, '%d/%m/%Y') AS DT_FABRICACAO,
																			 DATE_FORMAT(RE.DT_REPOSICAO, '%d/%m/%Y') AS DT_REPOSICAO,
																			 DATE_FORMAT(RE.DT_VALIDADE, '%d/%d/%Y') AS DT_VALIDADE,
																			 EE.DS_STATUS_ESTOQUE AS STATUS
																	FROM TB_REPOSICAO_ESTOQUE RE,
																	     TB_STATUS_ESTOQUE EE
																 WHERE RE.CD_PRODUTO = '".$_REQUEST["cd_produto"]."'
																   AND RE.CD_STATUS    = EE.CD_STATUS_ESTOQUE
																 ORDER BY 1 DESC";
												$objRS = $objConn->query($sql);
												while ($dados = $objRS->fetch_assoc()) {
												$contador++;
											?>
											<tr class="dados">
												<td class="tb_dados"><?=$dados["CD_REPOSICAO"]?></td>
												<td class="tb_dados"><?=$dados["QTD_PRODUTO"]?></td>
												<td class="tb_dados"><?=$dados["QTD_RESTANTE"]?></td>
												<td class="tb_dados"><?=$dados["PR_CUSTO"]?></td>
												<td class="tb_dados"><?=$dados["PR_VENDA"]?></td>
												<td class="tb_dados"><?=$dados["DT_FABRICACAO"]?></td>
												<td class="tb_dados"><?=$dados["DT_VALIDADE"]?></td>
												<td class="tb_dados"><?=$dados["DT_REPOSICAO"]?></td>
												<td class="tb_dados"><?=$dados["STATUS"]?></td>
											</tr>
											<script type="text/javascript">
												setDisabled('cd_produto');
												setDisabled('cod_barras');
											</script>
											<?php } ?>
										</table>
										<?php
										if($contador == 0){
											echo "<br /><span id='msg_sem_estoque'>Nenhum produto foi calocado no estoque para esse produto.</span>";
										}
										?>
									</div>
								</fieldset>
				<?php } ?>				
				
			</form>
		</fieldset><!--Fim do fieldset geral-->
		<div id="div_btns">
			<button onclick="gravaEstoque()" id="btn_salvar" disabled="disabled">Salvar</button>
			<button onclick="javascript: location.href='frmReporProdutoEstoque.php'" id="btn_novo">Novo</button>
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