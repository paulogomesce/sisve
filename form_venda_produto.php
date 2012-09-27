<?php
@session_start();
include "seguranca/checaSessao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <style type="text/css">
		.camPric{height: 26px; font-size: 1.4em; margin: 0;}
		#divItens{width: 673px; border: 1px solid gray; height: 300px; min-height: 200px; overflow:auto;}
		#conteiner_header_itens{width: 673px; height: 20px; background-color: #DCDCDC; border-left: 1px solid gray; border-top: 1px solid gray; border-right: 1px solid gray;}
		.header_itens{float: left; font-family: tahoma; font-weight: bold; font-size: 0.8em; padding: 2px 2px 0 3px;}
		#header_nu_item{width: 50px; border-right: 1px solid gray;}
		#header_cd_produto{width: 80px; border-right: 1px solid gray;}
		#header_ds_produto{width: 300px; border-right: 1px solid gray;}
		#header_quantidade{width: 50px; border-right: 1px solid gray;}
		#header_preco{width: 80px; border-right: 1px solid gray;}
		.operadores{font-family: tahoma; font-weight: bold; font-size: 1em; padding: 0 4px 0 4px;}
		.div_itens_men_princ{float: left; margin: 0; padding: 0; border: 0px solid gray;}
		.div_clear{clear: both;}
		.label_principal{font-family: tahoma; font-size: 0.8em; margin: 0; padding: 0;}
		
		.campo_nu_item{width: 51px;}
		.campo_cd_produto{width: 82px;}
		.campo_ds_produto{width: 303px;}
		.campo_quantidade{width: 51px;}
		.campo_preco{width: 82px;}
		.campo_preco_total{width: 80px;}
		.dados_item{margin:0; margin: 0; padding: 0;}
		#dados_retorno{height: 25px; border: 0px solid gray; color: red; font-family: tahoma; font-size: 0.9em;}
		
		.img_icones{width: 30px; border:0;}
		.separa_obj_men_princ{float: left; width: 1px; border: 0px solid transparent;}

		#principal_dsProdut{width: 500px;/*background-color: #191970; color: white; border: 0;*/ color: #ff0000;}
		#principal_barcode{width: 190px;}
		#principal_cdProdut{width: 65px;}
		#principal_quantidade{width: 50px;}
		#principal_preco{width: 100px;}
		#principal_total_item{width: 100px;}
		#principal_total_venda{width: 100px;}
		#principal_vl_desconto{width: 100px;}
		.btn_operacoes{font-size: 11px; width: 52px; height: 32px; margin:0; padding: 0;}
		
  </style>
  <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/funcoesJS.js"></script>
	<script type="text/javascript" src="js/shortcut.js"></script>
	
	<script type="text/javascript">
		function limpaFormulario(){
			document.getElementById('principal_barcode').value = '';
			document.getElementById('principal_cdProdut').value = '';
			document.getElementById('principal_dsProdut').value = '';
			document.getElementById('principal_quantidade').value = '';
			document.getElementById('principal_preco').value = '';
			document.getElementById('principal_total_item').value = '';
			document.getElementById('principal_barcode').focus();
		}
				
		function removeDisabledQtd(){
			$('#principal_quantidade').attr('disabled', false);
		}

		function addDisabledQtd(){
			$('#principal_quantidade').attr('disabled', true);
		}
	
		function addItemBarCode(evento, vlParametro, tpFiltro){
		  var parametros = 'vl_parametro='+vlParametro+'&tp_filtro='+tpFiltro;
			limpaMensagem();
			var tecla      = (evento.which) ? evento.which : evento.keyCode;
			if(tecla == 13){
				$.ajax({ 
					type: "POST", 
					 url: "controler/processaAddItemVenda.php?"+parametros, 
			 success: function(txt){$(txt).prependTo("#dados_retorno")},
				 error: function(){alert("ERRO")}
					});
			}else if(tecla == 9){
				return false;
			}
		}
		
		function fecharVenda(){
			var dados = $('form').serialize();
				$.ajax({ 
					type: "POST", 
					 url: "controler/processaVenda.php?"+dados, 
			 success: function(txt){$(txt).prependTo("#dados_retorno")},
				 error: function(){alert("ERRO")}
					});
		}
		
		idItem = 1;//Contador de cada item que vai sendo colocado na venda
		
		function addItem(cdProduto, dsProduto, quantidade, preco, precoTotal){
				var item = "<div>"+
										"<input type='text' class='dados_item campo_nu_item'     name='campo_nu_item"+idItem+"'      value='"+idItem+"'     readonly='readonly' />"+
										"<input type='text' class='dados_item campo_cd_produto'  name='campo_cd_produto_"+idItem+"'  value='"+cdProduto+"'  readonly='readonly' />"+
										"<input type='text' class='dados_item campo_ds_produto'  name='campo_ds_produto_"+idItem+"'  value='"+dsProduto+"'  readonly='readonly' />"+
										"<input type='text' class='dados_item campo_quantidade'  name='campo_quantidade_"+idItem+"'  value='"+quantidade+"' readonly='readonly' />"+
										"<input type='text' class='dados_item campo_preco'       name='campo_preco_"+idItem+"'       value='"+preco+"'      readonly='readonly' />"+
										"<input type='text' class='dados_item campo_preco_total' name='campo_preco_total_"+idItem+"' value='"+precoTotal+"' readonly='readonly' />"+
									 "</div>";
				$(item).prependTo("#frmItens");
				idItem++;
				addDisabledQtd();
				limpaMensagem();
		}
		
		function incluiProduto(evento){
			var tecla = (evento.which) ? evento.which : evento.keyCode;
			var cdProduto  = document.getElementById('principal_cdProdut').value;
			var dsProduto  = document.getElementById('principal_dsProdut').value;
			var quantidade = document.getElementById('principal_quantidade').value;
			var preco      = document.getElementById('principal_preco').value;
			var precoTotal = document.getElementById('principal_total_item').value;
			var totalVenda = document.getElementById('principal_total_venda').value;
			var novoValor = 0;
			document.getElementById('principal_total_item').value  = (preco * quantidade).toFixed(2);			
			novoValor = Number(totalVenda)+(preco * quantidade);
			if(tecla == 13){
				//Pega os valores do formulário pirncipal
				if(quantidade != '' && quantidade > 0){
					//Calcula incrementa o total da venda
					document.getElementById('principal_total_venda').value = novoValor.toFixed(2);
					//Função que cria e adiciona o item
					addItem(cdProduto, dsProduto, quantidade, preco, precoTotal);
					//Limpa o formulário pricipal e prepara para adicionar um novo produto
					limpaFormulario();
					//addReadOnlyQtd();
				}else{
					limpaMensagem();
					var msg = '<span>A quantidade deve ser maior ou igual a 1.</span>';
					$(msg).prependTo("#dados_retorno");
				}
			}
		}
		
		function limpaMensagem(){
			$('#dados_retorno').empty();
		}
		
		function limpaVenda(){
			var opcao = confirm('Deseja realmente cancelar venda?');
			if(opcao){
				location.reload(true);
			}
		}
		
		function abrePesquisaProduto(){
			var winLargura = document.body.offsetWidth;
			var margens = (winLargura - 300)/2;
			window.open('frmPesquisaProdutoVenda.php','_blank','width=420,height=395,left='+margens+',top=150');
		}
		
		/*Configuração das Teclas de Atalho e faz ajustes da inicialização*/
		$('document').ready(function(){
			document.getElementById('principal_barcode').focus();
			
			$('body').bind('keydown',function(e){
				if(e.which == 18){
					$('#dados_retorno').html('<span>Pesquisar(Alt+1) | Desfazer(Alt+2) | Cancelar(Alt+3) | Salvar(Alt+4)</span>');
				}
			});
			
			/*Abrir a janela de pesquisa de produto para venda*/
			shortcut.add("Alt+1",function(){/*Configure as teclas*/
				/*Defina a ação*/
				abrePesquisaProduto();
			});			
			/*Cancelar item da venda*/
			shortcut.add("Alt+2",function(){/*Configure as teclas*/
				limpaFormulario();
			});
			/*Cancelar venda*/
			shortcut.add("Alt+3",function(){/*Configure as teclas*/
				limpaVenda();
			});
			/*Cancelar venda*/
			shortcut.add("Alt+4",function(){/*Configure as teclas*/
				fecharVenda();
			});
		});
		

	</script>
</head>
<body>
	<form name="frm" method="post" action="javascript:void(0)">
		<input type="text" name="principal_dsProdut"   id="principal_dsProdut"   class="camPric" size="50" readonly="readonly" />
		<br />
		<div class="div_itens_men_princ">
			<div class="label_principal">Código de Barras</div>
			<input type="text" name="principal_barcode"    id="principal_barcode"    class="camPric" onkeyup="return addItemBarCode(event, this.value, 'barcode')" />
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Cd. Produto</div>
			<input type="text" name="principal_cdProdut"   id="principal_cdProdut"   class="camPric" onkeyup="return addItemBarCode(event, this.value, 'cdProduto')" onkeydown="return isNumberKey(event)"/>
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Quant.</div>
			<input type="text" name="principal_quantidade" id="principal_quantidade" class="camPric" onkeyup="incluiProduto(event)" onkeydown="return isNumberKey(event)" disabled="disabled" /><span class="operadores">X </span>
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Vl. Unitário</div>
			<input type="text" name="principal_preco"      id="principal_preco"      class="camPric" readonly="readonly"/><span class="operadores">= R$</span>
		</div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Vl. Total</div>
			<input type="text" name="principal_total_item" id="principal_total_item" class="camPric" readonly="readonly"/>
		</div>
		<div class="div_clear"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Total da Venda</div>
			<input type="text" name="principal_total_venda" id="principal_total_venda" class="camPric" readonly="readonly"/>
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">Desconto</div>
			<input type="text" name="principal_vl_desconto" id="principal_vl_desconto" class="camPric" readonly="readonly"/>
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">&nbsp;</div>
			<!--<a href="javascript:void(0)"><img class="img_icones" id="ico_pesquisa_prod" src="icones/pesquisa_produto.png" alt="Pesquisa Produto" title="Pesquisar Produto (Alt + P)" onclick="abrePesquisaProduto()"/></a>-->
			<input type="button" value="Pesquisa" onclick="abrePesquisaProduto()" class="btn_operacoes" title="Pesquisar Produto (Alt + P)" />
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">&nbsp;</div>
			<!--a href="javascript:void(0)"><img class="img_icones" id="ico_cancela_item" src="icones/cancelar_item.png" alt="Cancela Item" title="Cancelar Item (Alt + I)" onclick="limpaFormulario()" /></a>-->
			<input type="button" value="Desfazer" onclick="limpaFormulario()" class="btn_operacoes" title="Cancelar Item (Alt + I)" />
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">&nbsp;</div>
			<!--<a href="javascript:void(0)"><img class="img_icones" id="ico_cancela_venda" src="icones/cancela_venda.png" alt="Cancela Venda" title="Cancelar Venda (alt + V)" onclick="limpaVenda()" /></a>-->
			<input type="button" value="Cancelar" onclick="limpaVenda()" class="btn_operacoes" title="Cancelar Venda (alt + V)" />
		</div>
		<div class="separa_obj_men_princ"></div>
		<div class="div_itens_men_princ">
			<div class="label_principal">&nbsp;</div>
			<!--<a href="javascript:void(0)"><img class="img_icones" id="ico_fecha_venda" src="icones/fechar_venda.png" alt="Fechar Venda" title="Fechar Venda (alt + S)" onclick="fecharVenda()" /></a>-->
			<input type="button" value="Salvar" onclick="fecharVenda()" class="btn_operacoes" title="Fechar Venda (alt + S)" />
		</div>
		<div class="div_clear"></div>
	</form>
	<!--Mensagem de retorno-->
	<div id="dados_retorno"></div>

	<div id="conteiner_header_itens">
		<div id="header_nu_item"     class="header_itens">Item</div>
		<div id="header_cd_produto"  class="header_itens">Código</div>
		<div id="header_ds_produto"  class="header_itens">Descrição do Produto</div>
		<div id="header_quantidade"  class="header_itens">Qtd.</div>
		<div id="header_preco"       class="header_itens">Vl. Unitário</div>
		<div id="header_preco_total" class="header_itens">Vl. Total</div>
	</div>
	<div id="divItens">
		<form name="frm" id="frmItens" method="post" action="">
		</form>	
	</div>
</body>
</html>