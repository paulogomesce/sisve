<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php
		require "../class/classVenda.php";
		?>
		<span><?=(isset($_REQUEST["campo_ds_produto_1"])) ? ($_REQUEST["campo_ds_produto_1"]) : ("Item não existe!") ?></span>
	</body>
</html>