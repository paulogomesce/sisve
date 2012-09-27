<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
	<head>
		<META http-equiv=Content-Type content="text/html; charset=UTF-8">
		<title>Contato</title>
		<style type="text/css">
			.conteiner{border: 0 solid gray; padding: 0; width: 423px; margin: 5px;}
			body{font-family: arial; margin: 0; padding: 0; font-size: 0.8em;}
			.cl_label{width: 70px; border: 0 solid gray; float: left; margin: 0; padding: 0;}
			.cl_campo{width: 328px; border: 0 solid gray; float: left; margin: 0;}
			.limpa{clear: both; height: 5px;}
			#botoes{border: 0 solid gray; text-align: center;}
			.div_msg{text-align: center; border: 0 solid gray;}
		</style>
		
		<script type="text/javascript">
			function validacao(){
				var msg    = document.getElementById('mensagem').value;
				var nome   = document.getElementById('nome').value;
				var result = false;
				
				if(nome == ''){
				  alert('Digite o seu nome.');
				  return false;
				}else if(msg == ''){
				  alert('Digite uma mensagem.');
				  return false;				
				}else{
					return true;
				}				
			}
		</script>
		
	</head>
<body>
	<?php
	if(!isset($_REQUEST["p"])){
	?>
		<div class="conteiner">
			<form method="post" action="" onsubmit="return validacao()" >
				<input type="hidden" name="p" value="1" />
				<div class="cl_label">*Nome:</div>
				<div class="cl_campo"><input type="text" name="nome" id="nome" maxlength="40" size="50" /></div>
				<div class="limpa"></div>
				<div class="cl_label">E-mail:</div>
				<div class="cl_campo"><input type="text" name="email" maxlength="40" size="50" /></div>
				<div class="limpa"></div>
				<div class="cl_label">*Mensagem:</div>
				<div class="cl_campo">
					<textarea rows="5" cols="38" name="mensagem" id="mensagem"></textarea>	
				</div>
				<div class="limpa"></div>
				<div id="botoes">
					<input type="submit" value="Enviar" />
					<input type="reset" value="Limpar" />
				</div>
			</form>
		</div>
	<?php
	}else{
		echo "<div class=\"conteiner\">";
		if($_REQUEST["mensagem"] != ""){
			$email   = $_REQUEST["email"];
			$nome    = $_REQUEST["nome"];
			$message = $nome."\n\n".$_REQUEST["mensagem"];
			mail("paulogomes.tec@gmail.com", "Novo Comentário no Site", $message, $email);
			echo "<div class=\"div_msg\"><h3>Sua Mensagem foi enviada com sucesso!</h3></div>";
			echo "<div class=\"div_msg\">Obrigado pelo seu contato, caso tenha informado o seu e-mail, brevemente estarei retornando a sua mensagem!<br /><br />
			<a href=\"enviaEmail.php\">Voltar</a>
			</div>";
		}else{
		  echo "<div class=\"div_msg\">";
			echo "Escreva a mensagem!"."<br />";
			echo "<a href=\"enviaEmail.php\">Voltar</a>";
			echo "</div class=\"div_msg\">";
		}
		echo "</div>";
	}	
	?>
</body>
</html>