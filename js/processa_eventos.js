//Recedo o código do produto e preenche o item com as informações do produto
function preencheProduto(nome_div, cd_produto, nuItem){
  //alert("Entoru na função AJAX!);
  //var str = $("form").serialize();
  $.ajax({
    type: "POST",
    url: "preenche_produto.php?cd_produto="+cd_produto+"&nu_item="+nuItem,
    success: function(txt){$(nome_div).html(txt);},
    error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
    });
}
//Processa pesquisa de produto para venda
function pesquisaProduto(nome_div, nuItem, nmProduto){
  //alert("Entoru na função AJAX!);
  //var str = $("form").serialize();
  $.ajax({
    type: "POST",
    url: "processa_pesquisa_produto_venda.php?nm_produto="+nmProduto+"&nu_item="+nuItem,
    success: function(txt){$(nome_div).html(txt);},
    error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
    }
  );
}

//Processa pesquisa de produto para alteração
function pesquisaProdutoAlteracao(nome_div, nmProduto, cdProduto){
  //alert('Entoru na função AJAX!');
  //var str = $("form").serialize();
  $.ajax({
    type: "POST",
    url: "processa_pesquisa_produto_alteracao.php?nm_produto="+nmProduto+"&cd_produto="+cdProduto,
    success: function(txt){$(nome_div).html(txt);},
    error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
    }
  );
}

//Processa checagem do login do usuário
function loginUsuario(nmDiv){
		var campos = $("form").serialize();
		$.ajax(
			{
				type: "POST",
				url: "controler/processa_login.php",
				data: campos,
				beforeSend: function(txt){$(nmDiv).html('<img src=\'../imagens/ajax-loader.gif\' />');},
				success: function(txt){$(nmDiv).html(txt);},
				error: function(txt){alert('Erro no envio das informações!');}
			}
		);
}

//Efetualogin quando o usuário preciona a tecla ENTER
function loginUsuarioEnter(nmDiv, evento){
	var tecla = (evento.which) ? evento.which : event.keyCode;
	if(tecla == 13){
		loginUsuario(nmDiv);
	}	
}

/*Chama a tela de login*/
function trocarUsuario(){
	var left = (screen.width - 300)/2;
	var mtop = (screen.availHeight - 270)/2;
	window.open("index.php?origem=app&sair=y","_blank","width=300,height=270,resizable=0,scrollbars=0,left="+left+",top="+mtop);
}

//Ao precionar a tecle enter o foco vai para o campo informado no parametro
function proxItem(pxItem, evento){
	var tecla = (evento.which) ? evento.which : event.keyCode;
	if(tecla == 13){
		document.getElementById(pxItem).focus();
	}	
}





