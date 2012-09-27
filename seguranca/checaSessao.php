<?php
	if(!isset($_SESSION["nm_usuario"])){
?>
	<script type="text/javascript" src="js/processa_eventos.js" ></script>
	<script type="text/javascript">
		alert('Você deve se logar para ter acesso as telas do sistema!');
		trocarUsuario();//chama a tela de login
   </script>
<?php
		die;
	}
?>