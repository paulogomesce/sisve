<?php
session_start();
include "seguranca/checaSessao.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
	<head>
		<link rel="Shortcut Icon" href="favicon.ico">
		<title>.::Controle de Vendas::.</title>
		<style type="text/css">
			body{background-color: #F8F8FF;}
		</style>
	</head>
	<FRAMESET ROWS="80px, *"  FRAMEBORDER="1" FRAMESPACING="2" border="1">		
    <FRAME SRC="cabecalho.php" frameborder="0px" scrolling="no" NORESIZE name="cabecalho" id="cabecalho" marginheight="0px" marginwidth="0px"/>
		<frameset COLS="210px, *" >
			<FRAME SRC="menu.php" scrolling="no" name="menu" id="munu"/>
			<FRAME SRC="conteudo.php" name="conteudo" id="conteudo"/>
		</frameset>	
		<body>
		</body>	
	</FRAMESET>
</html>