<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="pt-br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=320" />
		<title>Cadastro de Vendedor</title>
		<!--ARQUIVOS CSS-->
		<link href="css/popup.css" rel="stylesheet" type="text/css"/>
		<link type="text/css" rel="stylesheet" href="css/css_formulario_novo.css" />
		
		<!--Arquivos JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/funcoesJS.js"></script>
		
		<script type="text/javascript">
			function executarAcao(operacao){
				var confirmacao = confirm('Confirma '+operacao+"?");
				if(confirmacao){
					$("#dados_res").empty();
					var campos = decodeURIComponent($("form").serialize());
					$.ajax({ 
						type: "POST", 
						 url: "controler/manterVendedor.php", 
						data: campos, 
				 success: function(txt){$(txt).prependTo("#dados_res"); alert(txt)},
					 error: function(){alert("ERRO")}
						});
				}else{
					alert('Operação cancelada!');
				}
			}
			
			$("document").ready(function(){
				var cdVendedor = document.getElementById("cd_vendedor").value;
				var opracao    = document.getElementById("tp_operacao").value;
				if(cdVendedor == 1 && opracao == "excluir"){
					document.getElementById("btn_excluir").disabled = true;
					alert("O usuário administrador não pode ser excluído!");
				}
			});
			
			function closeDivErro(){
				document.getElementById("conteiner_modal").style.visibility = 'hidden';
				$("#dados_res").empty();
			}
		</script>
		<style type="text/css">
			body{background-color: #F8F8FF;}
			fieldset{border: 1px solid gray; padding: 6px 6px 6px 6px;}
			#field_geral{width: 810px;}
			.campos{float: left; padding: 1px 0 1px 2px;}
			.clear{clear: both;}
			.label{font-family: tahoma; font-weight: 400; font-size: 0.8em; padding-left: 2px;}
			.espacamento{height: 6px;}
			legend{font-family: tahoma; font-weight: bold; font-size: 0.8em;}
			.legend_super{font-family: tahoma; font-weight: bold; font-size: 1.2em;}
		</style>
	</head>
	<body>
		<?php
			require_once "class/classConexaoDB.php";
			$objConn = new conexaoDB;
			$objConn->conecta();
			
			if(isset($_REQUEST["operacao"])){
				$operacao = $_REQUEST["operacao"];
				$tituloForm = "";
			
				switch($operacao){
					case "cadastrar":
						$tituloForm = "Cadastro de Vendedor";
						break;
					case "alterar":	
						$tituloForm = "Alterar Dados do Vendedor";
						break;
					case "excluir":
						$tituloForm = "Excluir Vendedor";
						break;
				}
				
				if($operacao != "cadastrar"){
					$sql="SELECT p.nm_pessoa
									,p.cpf
									,p.sexo
									,date_format(p.dt_nascimento,'%d/%m/%Y') dt_nascimento
									,ep.ds_logradouro
									,ep.numero
									,ep.nu_cep
									,ep.ds_cidade
									,ep.bairro
									,ep.uf
									,ep.ds_complemento
									,us.login_usuario
									,uga.cd_grupo_acesso as grupo_acesso
									,cp.nu_tel_fixo as fixo
									,cp.nu_tel_celular as celular
									,cp.email
						FROM tb_pessoa p
								,tb_endereco_pessoa ep
								,tb_usuario_sistema us
								,tb_usuario_grupo_acesso uga
								,tb_contato_pessoa cp
						WHERE p.cd_pessoa = '".$_REQUEST["cdvend"]."'
							AND ep.cd_pessoa_endereco = p.cd_pessoa
							AND us.cd_pessoa_usuario_sistema = p.cd_pessoa
							AND us.login_usuario = uga.login_usuario
							AND cp.cd_pessoa_contato = p.cd_pessoa";
				
					$sql = mysql_query($sql, $objConn->conexao);
					while($row = mysql_fetch_assoc($sql)){
						$cdVendedor  = $_REQUEST["cdvend"];
						$nome        = $row["nm_pessoa"];
						$cpf         = $row["cpf"];
						$nascimento  = $row["dt_nascimento"];
						$sexo        = $row["sexo"];
						$logradouro  = $row["ds_logradouro"];
						$numero      = $row["numero"];
						$cep         = $row["nu_cep"];
						$cidade      = $row["ds_cidade"];
						$bairro      = $row["bairro"];
						$uf          = $row["uf"];
						$complemento = $row["ds_complemento"];
						$login       = $row["login_usuario"];
						$grupoAcesso = $row["grupo_acesso"];
						$nuFixo      = $row["fixo"];
						$nuCelular   = $row["celular"];
						$email       = $row["email"];
					}
				}else{
						$cdVendedor  = null;
						$nome        = null;
						$cpf         = null;
						$nascimento  = null;
						$sexo        = null;
						$logradouro  = null;
						$numero      = null;
						$cep         = null;
						$cidade      = null;
						$bairro      = null;
						$uf          = null;
						$complemento = null;
						$login       = null;
						$grupoAcesso = null;
						$nuFixo      = null;
						$nuCelular   = null;
						$email       = null;
				}
			}
		?>
	
		<div id="resultado" style="display: none;"></div>
		<fieldset id="field_geral">
			<legend class="legend_super"><?=$tituloForm?></legend>
			<div class="espacamento"></div>
			<form >
				<fieldset>
					<legend>Dados do Vendedor</legend>
					<div class="espacamento"></div>
					<div class="campos">
						<label for="cd_vendedor" class="label">Código</label><br />
						<input type="text" name="cd_vendedor" id="cd_vendedor" value="<?=$cdVendedor?>" class="campos_txt" size="5" readonly="readonly"/>
					</div>					
					<div class="campos">
						<label for="nm_pessoa" class="label">*Nome</label><br />
						<input type="text" name="nm_pessoa" value="<?=$nome?>" class="campos_txt" id="nm_pessoa" size="60" maxlength="60" />
					</div>
					<div class="campos">
						<label for="cpf_pessoa" class="label">CPF</label><br />
						<input type="text" name="cpf_pessoa" value="<?=$cpf?>" id="cpf_pessoa" class="campos_txt" size="12" maxlength="14" onkeyup="Mascara('CPF', this, event)" onkeydown="return isNumberKey(event)" />
					</div>
					<div class="campos">
						<label for="dt_nascimento" class="label">*Nascimento</label><br />
						<input type="text" name="dt_nascimento" value="<?=$nascimento?>" class="campos_txt" id="dt_nascimento" size="10" maxlength="10" onkeyup="FormataData(this, event)" onkeydown="return isNumberKey(event)" />
					</div>
					<div class="campos">
						<label for="sexo" class="label">*Sexo</label><br />
						<select name="sexo" class="input_form tag_option">
							<option value="" selected="selected">Selecione...</option>
							<option value="M" <?php echo($sexo == "M")? "selected='selected'" : "";  ?>>Masculino</option>
							<option value="F" <?php echo($sexo == "F")? "selected='selected'" : ""; ?>>Feminino</option>
						</select>
					</div>
					
					<div class="clear"></div>
					
					<div class="campos">
						<label for="endereco_pessoa" class="label">Logradouro</label><br />
						<input type="text" name="endereco_pessoa" value="<?=$logradouro?>" id="endereco_pessoa" class="campos_txt" size="60" maxlength="60" />
					</div>
					<div class="campos">
						<label for="numero" class="label">Número</label><br />
						<input type="text" name="numero" value="<?=$numero?>" class="campos_txt" size="10" maxlength="5"/>
					</div>
					<div class="campos">
						<label for="cep" class="label">CEP</label><br />
						<input type="text" name="cep" value="<?=$cep?>" id="cep" class="campos_txt" size="8" maxlength="9" onkeyup="Mascara('CEP', this, event)" onkeydown="return isNumberKey(event)" />
					</div>
					<div class="campos">
						<label for="bairro" class="label">Bairro</label><br />
						<input type="text" name="bairro" value="<?=$bairro?>" id="bairro" class="campos_txt" size="25" maxlength="30" />
					</div>
					<div class="clear"></div>
					<div class="campos">
						<label for="cidade" class="label">Cidade</label><br />
						<input type="text" name="cidade" value="<?=$cidade?>" id="cidade" class="campos_txt" size="25" maxlength="30"/>
					</div>
					<div class="campos">
						<label for="uf" class="label">UF</label><br />
						<input type="text" name="uf" value="<?=$uf?>" id="uf" class="campos_txt" size="5" maxlength="2" />
					</div>
					<div class="campos">
						<label for="complemento" class="label">Complemento</label><br />
						<input type="text" name="complemento" value="<?=$complemento?>" id="complemento" class="campos_txt" size="60" maxlength="100"/>
					</div>
				</fieldset>
		
				<!--DADOS DE CONTATOS-->
				<fieldset>
						<legend>Contatos</legend>
						<div class="espacamento"></div>
						<div class="campos">
							<label for="tel_residencia" class="label">Tel. Resedencial</label><br />
							<input type="text" name="tel_residencia" value="<?=$nuFixo?>" id="tel_residencia" class="campos_txt" size="15" maxlength="13" />
						</div>
						<div class="campos">
							<label for="tel_celular" class="label">Celular</label><br />
							<input type="text" name="tel_celular" value="<?=$nuCelular?>" class="campos_txt" size="15" maxlength="13"/>
						</div>
						<div class="clear"></div>					
						<div class="campos">
							<label for="email" class="label">E-mail</label><br />
							<input type="text" name="email" value="<?=$email?>" class="campos_txt" size="45" maxlength="50"/>
						</div>
					</fieldset>				
				
					<!--Dados do acesso ao sistema-->
					<fieldset>
						<legend>Dados de Acesso</legend>
						<div class="espacamento"></div>
						<div class="campos">
							<label for="login" class="label">*Login</label><br />
							<input type="text" name="login" value="<?=$login?>" id="login" class="campos_txt" <?echo ($operacao != "cadastrar")? "readonly='readonly'" : ""?> size="30" maxlength="20"/>
						</div>
						<div class="clear"></div>
						<div class="campos">
							<label for="senha" class="label">*Senha</label><br />
							<input type="password" name="senha" class="campos_txt" size="31" maxlength="20"/>
						</div>
						<div class="clear"></div>					
						<div class="campos">
							<label for="senha" class="label">*Repita a Senha</label><br />
							<input type="password" name="repete_senha" class="campos_txt" size="31" maxlength="20"/>
						</div>
						<div class="clear"></div>
						<div class="campos">
							<label for="cd_prupo_acesso" class="label">*Grupo de Acesso</label><br />
							<select name="cd_prupo_acesso">
								<option value="">Selecione...</option>
								
								<?php
								$sql2 = mysql_query("select cd_grupo, nm_grupo from tb_grupo_acesso ga where ga.fl_ativo = 'S'");
								while($obj2 = mysql_fetch_object($sql2)){
								?>
									<option value="<?=$obj2->cd_grupo?>" <?=($obj2->cd_grupo == $grupoAcesso)? "selected='selected'": ""?> ><?=$obj2->nm_grupo?></option>
								<?php
								}
								$objConn->closeCon;
								?>
							</select>
						</div>
						<!--TIPO DE OPERAÇÃO-->
						<input type="hidden" name="tp_operacao" id="tp_operacao" value="<?=$_REQUEST["operacao"]?>" />
					</fieldset>
			</form>
		</fieldset>
		<div class="espacamento"></div>
		<div align="center" id="div_btns" style="width: 780px;">
			<button onclick="executarAcao('o cadastro')"  <?echo ($operacao != "cadastrar")? "disabled='disabled'" : ""; ?> id="btn_salvar">Salvar</button>
			<button onclick="executarAcao('a alteração')" <?echo ($operacao != "alterar")  ? "disabled='disabled'": ""; ?> id="btn_alterar">Alterar</button>
			<button onclick="executarAcao('a exclusão')"  <?echo ($operacao != "excluir")  ? "disabled='disabled'": ""; ?> id="btn_excluir">Excluir</button>
			<button onclick="javascript: location.href='frm_cad_vendedor.php?operacao=cadastrar'"             id="btn_novo">Novo Cadastro</button>
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