<?php
@session_start();
include_once 'db/dadosConexaoDB.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Menu</title>
		<script src="js/jquery.js"></script>
		<script type="text/javascript" src="js/processa_eventos.js" ></script>
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
		<style type="text/css">
			ul{list-style-type: none;}
			ul, li{padding: 0; margin: 0;}
			.ul_itens{display:none;}
			.item_principal{cursor: pointer;}
			span{font-weight: bold; border: 0 solid gray; display: block; padding: 2px;}
			#div_menu{border: 0px solid gray; width: 180px; background-color: #F5F5F5; padding: 5px;}
			body{margin: 5px;}
			body{padding: 5px;}
			a{text-decoration: none; color: black; font-family: tahoma; font-size: 0.8em;}
			ul li span:hover{background-color: #FDF5E6;}
			ul li ul li a:hover{background-color: #E0FFFF;}
			ul li ul li a:hover{background-color: #E0FFFF; display: block; padding: 2px;}
			ul li ul li a{display: block; padding: 2px; color: #458B74;}
			.icon_padrao_menu{width: 32px;}
			#menu_rodape{font-size: 0.8em; text-align: center; margin-top:10%; font-style:italic; color: #1E90FF;}
		</style>
		<script type="text/javascript">
			$('document').ready(function(){
				var velocidadeExibicaoMenu = null;
				$("#principal_1").click(function(){
					$("#menu_1").toggle(velocidadeExibicaoMenu);
				});				
				$("#principal_2").click(function(){
					$("#menu_2").toggle(velocidadeExibicaoMenu);
				});				
				$("#principal_3").click(function(){
					$("#menu_3").toggle(velocidadeExibicaoMenu);
				});				
				$("#principal_4").click(function(){
					$("#menu_4").toggle(velocidadeExibicaoMenu);
				});				
				$("#principal_5").click(function(){
					$("#menu_5").toggle(velocidadeExibicaoMenu);
				});
				$("#principal_6").click(function(){
					$("#menu_6").toggle(velocidadeExibicaoMenu);
				});					
			});
		</script>	
	</head>
	<body>
		<div id="div_go_home" style="text-align: center;">
			<a href="conteudo.php" target="conteudo"><img src="imagens/home.gif"        class="icon_padrao_menu" alt="Página Inicial" title="Página Inicial" border="0"/></a>
			<a href="javascript:void(0)" target="conteudo" onclick="trocarUsuario();" ><img src="imagens/trocar_user.png" class="icon_padrao_menu" alt="Trocar Usuário" title="Trocar Usuário" border="0"/></a>
		</div>
		<div id="div_menu">
		<div id="titulo_menu">Menu</div>
			<?php
				$objConn = new mysqli($host, $user, $senha, $banco);
				$objConn->set_charset("utf8");
				if (mysqli_connect_errno()){
					echo "ERRO: Conexão o banco de dados.";
				}
				
				//Pega as funções raiz do grupo
				$result = "SELECT distinct fr.id_funcao_raiz as cd_menu,
													 fr.ds_funcao_raiz as nm_menu,
													 fr.url_funcao_raiz as caminho
											FROM tb_funcao_grupo_acesso fga,
													 tb_funcao_raiz fr,
													 tb_funcao_sistema fs
										 where fga.CD_FUNCAO    = fs.cd_funcao
											and fs.id_funcao_raiz = fr.id_funcao_raiz
											and fga.CD_GRUPO      = {$_SESSION["usu_grupo_acesso"]} /*Código do grupo de usuário*/
										order by fr.ds_funcao_raiz";
																	
				$objRS = $objConn->query($result);
																 
				echo "<ul>";//Inicio da Lista
					while ($row = $objRS->fetch_object()) {
						echo "<li class='item_principal'>";//Inicio LI menu principal
						echo "<span id='principal_{$row->cd_menu}'><a href='{$row->caminho}' target='conteudo'>".$row->nm_menu."</a></span>";
							echo "<ul id='menu_{$row->cd_menu}' class='ul_itens'>";//inicio da UL dos itens do Menu
								$result2 = "select fs.cd_funcao as cd_funcao,
																	 fs.ds_funcao as nm_funcao,
																	 fs.url_funcao as caminho,
																	 fs.parametros as parametros
															from tb_funcao_grupo_acesso fga,
																	 tb_funcao_sistema fs
														 where fga.CD_FUNCAO = fs.cd_funcao
															 and fga.CD_GRUPO  = {$_SESSION["usu_grupo_acesso"]} /*Código do grupo de usuário*/
															 and fs.id_funcao_raiz = {$row->cd_menu}/*Código do menu raiz*/
														   and fs.tp_funcao = 'SUBMENU'
														 order by fs.ds_funcao";
								$objRS2 = $objConn->query($result2);													 
								while($row2 = $objRS2->fetch_object()){
									echo "<li><a href='{$row2->caminho}{$row2->parametros}' target='conteudo'>".$row2->nm_funcao."</a></li>";//LI Itens do  menu
								}
							echo "</ul>";//Fim da UL dos itens do Menu
						echo "</li>";//Fim LI menu principal
					}
				echo "</ul>";//Inicio da Lista
			?>
		</div>
		<div id="menu_rodape">
			<div>Sistema de Controle de Vendas</div>
			<div>Suporte: (85)8785.0188</div>
			<div>Versão 1.0</div>
		</div>
	</body>
</html>