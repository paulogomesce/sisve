<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

				<style type="text/css">
					.formulario{
						margin-left: 0px;
					}
				</style>
        <link rel="stylesheet" type="text/css" href="css/formulario.css"/>
        
        <script language="javascript" type="text/javascript" src="js/gravacao_foms.js"></script>
				<script language="javascript" type="text/javascript" src="js/processa_eventos.js"></script>
		
        <script src="js/jquery.js"></script>
				<script language="javascript">
				
							
					//coloca o cursor no campo codigo do produto do primeiro item da venda
					function focaCampo(){
						//alert('Entrou na função');
						document.getElementById("nm_produto").focus();
					}
					
					 					
				</script>
        <title></title>
				
		</head>
    <body onload="focaCampo();">
      <div id="title_form">
        <img id="img_title" src="icones/pesquisa.png" width="25px" height="25px" title="Cadastrar um novo produto" />
        <h3 id="titulo">Venda de Produtos</h3>
      </div>
			<br />
			<form name="form_pesquisa_produto" id="form_venda" method="POST" action="#" class="formulario">
				<table>
					<tr>
						<td  style="align: center;">
							<label class="label_form">Cod. Produto</label><br />
							<input type="text" name="cd_produto" id="cd_produto" class="input_form" size="5" style="text-align: right;"
							       onkeyup="pesquisaProdutoAlteracao('#resultado', document.getElementById('nm_produto').value,this.value)"/>
						</td>
					</tr>	

					<tr>
							<td  style="align: center;">
								<label class="label_form">Nome do Produto</label><br />
								<input type="text" name="nm_produto" id="nm_produto" class="input_form" size="60"
								       onkeyup="pesquisaProdutoAlteracao('#resultado', this.value, document.getElementById('cd_produto').value)"/>
							</td>
						</tr>	
				</table>

        <div id="espaco_campos"></div>

        <input type="button" onclick="pesquisaProdutoAlteracao('#resultado', document.getElementById('nm_produto').value, document.getElementById('cd_produto').value)"
							 name="grava_produto" value=" Buscar " id="grava_produto" class="botao_gravar" title="Gravar a venda"/>
			</form>			
      <div id="resultado"></div>
		</body>
</html>
