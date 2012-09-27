<?php
include_once 'db/conexao.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/formulario.css"/>
        
        <script language="javascript" type="text/javascript" src="js/gravacao_foms.js"></script>
        <script src="js/jquery.js"></script>
        
    </head>
    <body>
      <form name="form_alteracao_produto" method="post" action="" id="form_alteracao_produto">
        <div id="title_form">
          <img id="img_title" src="icones/editar.png" width="25px" height="25px" title="Cadastrar um novo produto" />
          <h3 id="titulo">Alterar Cadastro de Produto</h3>
        </div>
        <br />
          <label class="label_form">Cód.Produto<br />
            <input type="text" name="cd_produto" id="cd_produto" class="input_form" size="10" style="text-align: right;" readonly />
						<span id="pesquisa"><a href="#" onclick="javascript: window.open('form_pesquisa_produto_alteracao.php', 'Pesquisa', 'width=700, height=800, scrollbars=yes');" >
							<img src="icones/pesquisa.png" width="18px" height="18px" border="0"/></a>
						</span>
          </label>
          <div id="espaco_campos"></div>
					<label class="label_form">Descrição do Produto<br />
            <input type="text" name="ds_produto" id="ds_produto" class="input_form" size="60"/>
          </label>

          <div id="espaco_campos"></div>
          <label class="label_form">Fabricante<br />
            <input type="text" name="fabricante" id="fabricante" class="input_form" size="60"/>
          </label>

          <div id="espaco_campos"></div>
          <label class="label_form">Categoria<br />
            <select name="cd_categoria_produto" id="ccd_categoria_produto" class="input_form">
              <option value="">Selecione...</option>
              <?php
              $sql = "SELECT cp.cd_categoria, cp.ds_categoria
                        FROM tb_categoria_produto cp";

              $sql = mysql_query($sql, $conexao);

              while ($dados = mysql_fetch_assoc($sql)) { ?>
                <option value="<?php echo $dados["cd_categoria"];?>"><?php echo $dados["ds_categoria"];?></option>
              <?php
              }
              ?>
            </select>
          </label>

          <div id="espaco_campos"></div>
          <label class="label_form">Valor Unitário<br />
            <input type="text" name="vlr_unitario" id="vlr_unitario" class="input_form" size="10" style="text-align: right;"/>
          </label>

          <div id="espaco_campos"></div>
          <label class="label_form">Quantidade<br />
            <input type="text" name="qtd_produto" id="qtd_produto" class="input_form" size="10" style="text-align: right;" readonly />
          </label>
					
          <div id="espaco_campos"></div>
          <input type="button" onclick="processaAlteracaoProduto('#resultado')" name="grava_produto" value="&nbsp;Gravar&nbsp;" id="grava_produto" class="botao_gravar" style="text-align: center;"/>
					<input type="reset" name="cancelar" value="&nbsp;Cancelar&nbsp;" id="cancelar" class="botao_gravar" style="text-align: center;"/>
        </form>

        <div id="resultado"></div>
    </body>
</html>
<?php
$closed = mysql_close($conexao);
?>
