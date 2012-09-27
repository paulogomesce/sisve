<?php
session_start();

if(isset($_REQUEST["sair"]) && $_REQUEST["sair"] == "y"){
	unset($_SESSION['nm_usuario']);
	//header('Location: index.php?origem=app');
}else{
	if (isset($_SESSION['nm_usuario'])){
		header('Location: inicio.php');
	}
}

//Verifica de onde foi chamado o script
if(isset($_REQUEST["origem"])){
	$origem = $_REQUEST["origem"];
}else{
	$origem = "inicio";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="Shortcut Icon" href="favicon.ico" />
		<script type="text/javascript" src="js/jquery.js"></script>		
		<script type="text/javascript" src="js/processa_eventos.js" ></script>
		<script type="text/javascript">
			$('document').ready(function(){
				document.getElementById('login').value = 'casa';
			});
		</script>

		<style type="text/css">
			#conteudo{width: 290px;
			          height: 240px;
								margin: -120px 0 0 -145px;
								left: 50%;
								top: 50%;
								position: absolute;
								border: solid black 0px;
								text-align: center;
								padding: 10px 0 0 0;
								background-image: url(imagens/bg_frm_login.png);
								background-repeat: no-repeat;
			}
			#form_login{margin:0 auto; border: solid black 0px; text-align: left; width: 200px;}
			#login,#senha{width: 200px; text-transform:uppercase}
			#div_titulo{font-family: tahoma; color: #000080; font-size: 1.5em;}
			#div_botoes{text-align: center; margin: 4px 0 0 0;}
			#img_cadeado{height: 65px;}
			#resultado{margin-top: -2px;}
		</style>
		<title>.::Login - Controle de Vendas::.</title>
	</head>
	<body>
		<div id="conteudo">
			<div id="div_titulo">Login do Usuário</div>
			<img src="icones/Cadeado_2.png" id="img_cadeado" />
			<div id="form_login">
				<form name="form_login" method="post" action="">
					<label style="font-family: tahoma; color: #000080; font-size: 14;">Usuário<br />
						<input type="text" name="login" id="login" maxlength="20" size="30"/>
					</label>
					<label style="font-family: tahoma; color: #000080; font-size: 14;">Senha<br />
						<input type="password" name="senha" id="senha" maxlength="20" size="30" onkeyup="loginUsuarioEnter('#resultado', event)"/>
						<input type="hidden" name="origem" value="<?=$origem?>" />
					</label>
					<div id="div_botoes">
						<input type="button" name="btn_entar" id="btn_entar" value=" Entar " onclick="loginUsuario('#resultado')" />
						<input type="reset" name="btn_reset" id="btn_reset" value=" Cancelar " onclick="javascript:window.close()"/>
					</div>
				</form>
				<div id="resultado" style="display: "";"></div>
			</div>
		</div>
	</body>
</html>