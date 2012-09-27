<?php
session_start();
include "seguranca/checaSessao.php";
?>
<html>
  <head>
		<script type="text/javascript">
			//window.setInterval("window.location.reload()",12000);			
			function logoff(){
					var opcao = confirm('Deseja realmente sair do sistema?');
					if(opcao == true){
						parent.window.location = 'index.php?sair=y';
					}
				}
		</script>
    <style type="text/css">
      #conteudo{
        width: 100%;
        height: 100%;
        border: solid gray 1px;
        margin: 0px 0px 0px 0px;
        background-image: url('imagens/bg_cabecalho.png');
      }

      #logo_empresa{
        height: 100%;
        width: 210px;
        border: 0px;
        background-color: none;
        float: left;
        margin-left: 0px;
        height: 100px;
        text-align: center;
      }

      #texto_logo{
        font-size: 18;
        margin-top: -20px;
        font-family: Gill, Helvetica, sans-serif;
		color: white;
      }
	  
      #titulo{
            margin-top: 4px;
            color: white;
      }

      h1{
        font-family: Gill, Helvetica, sans-serif;
      }
			
			#div_login{
				width: 400px;
				float: right;
				border: solid gray 0px;
				height: 50px;
				margin-top: 28px;
			}
			#icone_user{
				float: left;
				width: 43px;
				border: solid gray 0px;
			}
			#txt_nm_usu{
				width: 240px;
				height: 35px;
				float: left;			
				border: solid gray 0px;
				font-family: tahoma;
				font-size: 14px;
				color: white;
				font-weight: bold;
			}
			#icone_logoff{
				width: 35px;
				float: left;
				border: solid gray 0px;
			}
    </style>
    <title></title>
  </head>
  <body>
    <div id="conteudo">
      <div id="logo_empresa">
        <h1 id="titulo">SISVE</h1>
        <h1 id="texto_logo">Sistemas de Vendas</h1>
      </div>
			<div id="div_login">
				<div id="icone_user">
					<img src="icones/user.png" width="30px" height="35px">
				</div>
				<div id="txt_nm_usu">
				<?php
					echo $_SESSION["cd_usuario"]." - ".ucwords(strtolower($_SESSION['nm_usuario']));
				?>
				</div>
				<div id="icone_logoff">
					<a href="#" onclick="logoff()"><img src="icones/sair.png" width="30px" height="35px" title="Sair do sistema" border="0" target="_blanck"/></a>
				</div>
			</div>			
    </div>
  </body>
</html>