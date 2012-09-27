<?php
require "db/dadosConexaoDB.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="pt-br">
	<head>
		<title>Cadastro de Produto</title>
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
			//Processa a gravação do produto
			function executarAcao(operacao){
				var confirmacao = confirm('Confirma '+operacao+"?");
				if(confirmacao){
					$("#dados_res").empty();
					var campos = decodeURIComponent($("form").serialize());
					$.ajax({ 
						type: "POST", 
						 url: "controler/manterProduto.php", 
						data: campos, 
				 success: function(txt){$(txt).prependTo("#dados_res"); alert(txt)},
					 error: function(){alert("ERRO")}
						});
				}else{
					alert('Operação cancelada!');
				}
			}
			
			//Pesquisa se o produto já está cadastrado no sistema
			function execPesqExistProd(codBarras){
				//alert(codBarras);
				var tpOperacao = document.getElementById("tp_operacao").value;
				if(tpOperacao == "cadastrar"){
					 if(codBarras != ''){
						$.ajax({ 
							type: "POST", 
							 url: "controler/checaExisteProduto.php?cod_barras="+codBarras, 
							data: "", 
					 success: function(txt){$(txt).prependTo("#dados_res");},
						 error: function(){alert("ERRO: Digite novamente o código de barras do produto.")}
							});
					}
				}
			}		
			
			window.onload = function(){
				document.getElementById("cod_barras").focus();
			}
			function habilitaDesconto(){
				document.getElementById("vl_desconto").readOnly = false;
				document.getElementById("vl_desconto").value = '';
			}
			function desabilitaDesconto(){
				document.getElementById("vl_desconto").readOnly = true;
				document.getElementById("vl_desconto").value = 0.00;
			}
			
			function setBgColor(valor){
				if(valor == 'N'){
					$("#situacao_produto").css("background-color","#FF6347");
					$("#situacao_produto").css("color","white");
				}else if(valor == 'S'){
					$("#situacao_produto").css("background-color","#3CB371");
					$("#situacao_produto").css("color","white");
				}
			}
			
		</script>
		<!--Declarações CSS-->
		<style type="text/css">
			#div_btns{width: 780px; text-align: center; padding-top: 5px;}
			#div_reposicoes{border: 0px solid gray; width: 793px; min-height: 200px; overflow: auto; max-height: 200px;}
			#tb_reposicoes{font-family: tahoma; font-size: 0.8em;}
			.tb_dados{text-align: center;}
			#msg_sem_estoque{font-family: tahoma; font-size: 0.8em; color: red;}
			table.bordasimples {border-collapse: collapse;}
			table.bordasimples tr td {border:1px solid gray;}
			.dados:hover{background-color: #E0FFFF;}
			
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
			
			$operacao  = $_REQUEST["operacao"];
			$tituloForm = "";			
			switch($operacao){
				case "cadastrar":
					$tituloForm = "Cadastro de Produto";
					break;
				case "alterar":	
					$tituloForm = "Alteração de dados do Produto";
					break;
				case "excluir":
					$tituloForm = "Excluir Produto";
					break;
			}
			
			if($operacao != "cadastrar"){
				$sql = "SELECT p.codigo_barras as cd_barras,
                       p.ds_produto,
											 p.referencia,
                       p.fabricante,
                       p.cd_categoria,
                       date_format(p.dt_cadastro,'%d/%m/%Y') as dt_cadastro,
                       p.fl_ativo,
                       p.fl_desconto,
											 p.fl_perecivel,
											 p.cd_unidade_medida medida,
											 p.qtd_volume
                  FROM tb_produto p
                 WHERE p.cd_produto = '".$_REQUEST["cd_produto"]."'";
								 
        $objRS = $objConn->query($sql);
        while($dados = $objRS->fetch_assoc()){
					$cdProduto     = $_REQUEST["cd_produto"];
					$cdBarras      = $dados["cd_barras"];
					$dsProduto     = $dados["ds_produto"];
					$referencia    = $dados["referencia"];
					$fabricante    = $dados["fabricante"];
					$categoria     = $dados["cd_categoria"];
					$desconto      = $dados["fl_desconto"];
					$dtCadastro    = $dados["dt_cadastro"];
					$statusProduto = $dados["fl_ativo"];
					$flPerecivel   = $dados["fl_perecivel"];
					$medida        = $dados["medida"];
					$qtdVolume     = $dados["qtd_volume"];
				}				
			}else{
				$cdProduto     = null;
				$cdBarras      = null;
				$dsProduto     = null;
				$referencia	   = null;
				$fabricante    = null;
				$categoria     = null;
				$desconto      = null;
				$dtCadastro    = null;
				$statusProduto = null;
				$flPerecivel   = null;
				$medida        = null;
				$qtdVolume     = null;
			}
		?>
		<fieldset id="field_geral">
			<legend class="legend_super"><?=$tituloForm?></legend>
			<div class="espacamento"></div>
			<form method="post" action="void" >
				<input type="hidden" name="tp_operacao" value="<?=$operacao?>" id="tp_operacao" />
				<fieldset>
					<legend>Informações do Produto</legend>
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
					<div class="campos">
						<label for="referencia" class="label">Referência</label><br />
						<input type="text" name="referencia" value="<?=$referencia?>" id="referencia" class="campos_txt" size="20" maxlength="20" />
					</div>
					<!--CATEGORIA-->
					<div class="campos">
						<label for="categoria" class="label">*Categoria</label><br />
            <select name="cd_categoria" id="cd_categoria" class="input_form tag_option">
              <option value="">Selecione...</option>
              <?php
              $sql = "SELECT cp.cd_categoria, cp.ds_categoria
                        FROM tb_categoria_produto cp order by 2";
              $objRS = $objConn->query($sql);
              while ($dados = $objRS->fetch_assoc()) { ?>
                <option value="<?php echo $dados["cd_categoria"]?>" <?php echo($categoria == $dados["cd_categoria"])?"selected='selected'" : '' ?>><?php echo $dados["ds_categoria"];?></option>
              <?php
              }
              ?>
            </select>
					</div>
					
					<!--DATA DE CADASTRO-->
					<div class="campos">
						<label for="dt_cadastro" class="label">Dt. Cadastro</label><br />
						<input type="text" name="dt_cadastro" value="<?=$dtCadastro?>" id="dt_cadastro" class="campos_txt" size="10" maxlength="10" readonly="readonly"/>
					</div>
					<!--DESCONTO-->
					<div class="campos">
						<label for="fl_desconto" class="label">&nbsp;Desconto</label><br />
						<span class="label">Não&nbsp;</span><input type="radio" name="fl_desconto" value="N" id="fl_desconto_n" class="campos_txt" onclick="desabilitaDesconto()" <?php echo($desconto == "N")? "checked='checked'": "" ?> <?php echo ($operacao == "cadastrar")? "checked='checked'": "" ?> />
						<span class="label">Sim&nbsp;</span><input type="radio" name="fl_desconto" value="S" id="fl_desconto_s" class="campos_txt" onclick="habilitaDesconto()"   <?php echo($desconto == "S")? "checked='checked'": "" ?> />
					</div>
					<!--O PRODUTO É PERECÍVEL?-->
					<div class="campos">
						<label for="fl_perecivel" class="label">&nbsp;Perecível</label><br />
						<span class="label">Não&nbsp;</span><input type="radio" name="fl_perecivel" value="N" id="fl_perecivel_n" class="campos_txt" <?php echo($flPerecivel == "N")? "checked='checked'": "" ?> <?php echo ($operacao == "cadastrar")? "checked='checked'": "" ?> />
						<span class="label">Sim&nbsp;</span><input type="radio" name="fl_perecivel" value="S" id="fl_perecivel_s" class="campos_txt" <?php echo($flPerecivel == "S")? "checked='checked'": "" ?> />
					</div>
					<!--Quantidade do volume do produto-->
						<div class="campos">
							<label for="qtd_volume" class="label">Qtd. Volume</label><br />
							<input type="text" name="qtd_volume" id="qtd_volume" value="<?=$qtdVolume?>" class="campos_txt" size="8" maxlength="10" />
						</div>
						
					<!--UNIDADE DE MEDIDA-->
					<div class="campos">
						<div><label for="und_medida" class="label">*Medida</label></div>
            <select name="und_medida" id="und_medida" class="input_form tag_option">
              <option value="">Selecione...</option>
              <?php
              $sql = "select um.cd_unidade_medida cd_medida, um.ds_unidade_medida ds_medida from tb_unidade_medida um";
              $objRS = $objConn->query($sql);
              while ($dados = $objRS->fetch_assoc()) { ?>
                <option value="<?php echo $dados["cd_medida"]?>" <?php echo($medida == $dados["cd_medida"])?"selected='selected'" : '' ?>><?php echo $dados["ds_medida"];?></option>
              <?php
              }
              ?>
            </select>
					</div>
					
					<!--CAMPOS EM BAIXO-->
					<div class="clear"></div>	
					
					<!--SITUAÇÃO DO PRODUTO-->					
					<div class="campos">
						<div><label for="situacao_produto" class="label">Situação</label></div>
						<select name="situacao_produto" id="situacao_produto" class="input_form tag_option">
							<option value="S">ATIVO</option>
							<option value="N" <?php echo($statusProduto == "N") ? "selected='selected'" : "" ?> >CANCELADO</option>
						</select>
						<!--Coloca a cor do plano de fundo do estado do produto-->				
						<script type="text/javascript">setBgColor('<?=$statusProduto?>')</script>
					</div>
					
					<!--CAMPOS EM BAIXO-->
					<div class="clear"></div>	
				</fieldset>
				<?php if($operacao == "cadastrar"){?>
					<div class="espacamento"></div>
					<div class="espacamento"></div>
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
				<?php }elseif($operacao == "alterar"){ ?>
								<div class="espacamento"></div>
								<div class="espacamento"></div>
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
												$sql = "select re.cd_reposicao,
												               re.qtd_produto,
																			 re.qtd_restante,
																			 re.preco_custo_produto as pr_custo,
																			 re.preco_venda_produto as pr_venda,
																			 date_format(re.dt_fabricacao, '%d/%m/%y') as dt_fabricacao,
																			 date_format(re.dt_reposicao, '%d/%m/%y') as dt_reposicao,
																			 date_format(re.dt_validade, '%d/%d/%y') as dt_validade,
																			 ee.ds_status_estoque as status
																	from tb_reposicao_estoque re,
																	     tb_status_estoque ee
																 where re.cd_produto = '".$cdProduto."'
																   and re.cd_status    = ee.cd_status_estoque
																 order by 1 desc";
												
												$objRS = $objConn->query($sql);
												
												while ($dados = $objRS->fetch_object()) {
												$contador++;
											?>
											<tr class="dados">
												<td class="tb_dados"><?=$dados->cd_reposicao?></td>
												<td class="tb_dados"><?=$dados->qtd_produto?></td>
												<td class="tb_dados"><?=$dados->qtd_restante?></td>
												<td class="tb_dados"><?=$dados->pr_custo?></td>
												<td class="tb_dados"><?=$dados->pr_venda?></td>
												<td class="tb_dados"><?=$dados->dt_fabricacao?></td>
												<td class="tb_dados"><?=$dados->dt_validade?></td>
												<td class="tb_dados"><?=$dados->dt_reposicao?></td>
												<td class="tb_dados"><?=$dados->status?></td>
											</tr>
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
		</fieldset>
		<div id="div_btns">
			<button onclick="executarAcao('o cadastro')"  <?echo ($operacao != "cadastrar")? "disabled='disabled'" : ""; ?> id="btn_salvar">Salvar</button>
			<button onclick="executarAcao('a alteração')" <?echo ($operacao != "alterar")  ? "disabled='disabled'": ""; ?> id="btn_alterar">Alterar</button>
			<button onclick="executarAcao('a exclusão')"  <?echo ($operacao != "excluir")  ? "disabled='disabled'": ""; ?> id="btn_excluir">Excluir</button>
			<button onclick="javascript: location.href='frmCadastroProduto.php?operacao=cadastrar'" id="btn_novo">Novo</button>
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