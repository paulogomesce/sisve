//Processa gravação do cadastro de um novo produto
function processaGravacaoProduto(nome_div){
  //alert("Entoru na função AJAX!\n"+nome_div +"\n"+cd_procedimento +"\n"+sequenciaProc);
  //alert("Entoru na função AJAX!\n"+cdPrestador);
	var opcao = confirm('Confirma o cadastro do produto?');
	if(opcao == true){
		var str = $("form").serialize();		
		$.ajax({
			type: "POST",
			url: "processa_gravacao_produto.php?",
			data: str,
			//beforeSend: function(){},
			success: function(txt){$(nome_div).html(txt);},
			error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
			}
		);
	}else{alert('O cadastro do produto foi cancelado.');}
}

//Processa gravação das vendas
function processaGravacaoVenda(nome_div){
  //alert("Entoru na função AJAX!\n"+nome_div +"\n"+cd_procedimento +"\n"+sequenciaProc);
  //alert("Entoru na função AJAX!\n"+cdPrestador);
	var opcao = confirm('Confirma a venda?');
	if(opcao == true){
		var str = $("form").serialize();
		
		$.ajax({
			type: "POST",
			url: "processa_gravacao_venda.php?",
			data: str,
			//beforeSend: function(){},
			success: function(txt){$(nome_div).html(txt);},
			error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
			}
		);
	}else{alert('Venda cancelada.');}
}

//Processa gravação da alteração de um produto.
function processaAlteracaoProduto(nome_div){
  //alert("Entoru na função AJAX!\n"+nome_div +"\n"+cd_procedimento +"\n"+sequenciaProc);
  //alert("Entoru na função AJAX!\n"+cdPrestador);
	var opcao = confirm('Confirma a alteração do produto?');
	if(opcao == true){
		var str = $("form").serialize();		
		$.ajax({
			type: "POST",
			url: "processa_alteracao_produto.php?",
			data: str,
			//beforeSend: function(){},
			success: function(txt){$(nome_div).html(txt);},
			error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
			}
		);
	}else{alert('Alteração cancelada.');}
}

//Processa gravação da alteração de um produto.
function processaExclusaoProduto(nome_div){
  //alert("Entoru na função AJAX!\n"+nome_div +"\n"+cd_procedimento +"\n"+sequenciaProc);
  //alert("Entoru na função AJAX!\n"+cdPrestador);
	var opcao = confirm('Confirma a exclusão do produto?');
	if(opcao == true){
		var str = $("form").serialize();		
		$.ajax({
			type: "POST",
			url: "processa_exclusao_produto.php?",
			data: str,
			//beforeSend: function(){},
			success: function(txt){$(nome_div).html(txt);},
			error: function(txt){alert('ERRO AO PROCESSAR AJAX!');}
			}
		);
	}else{alert('Alteração cancelada.');}
}












//O bloco de código abaixo está implementado em AJAX, foi feito para gravar informações dos formulários mas está em desuso.
var comunicacao;
function enviaDados(){
  comunicacao = null;

  var str = $("form").serialize();

  if(window.XMLHttpRequest){
    comunicacao = new XMLHttpRequest();
    comunicacao.onreadystatechange = trataRetorno;
    comunicacao.open("GET", "processa_gravacao_produto.php?"+str, true);
    comunicacao.send(null);
  }else if(window.ActiveXObject){
    comunicacao = new ActiveXObject("Microsoft.XMLHTTP");
    if(comunicacao){
      comunicacao.onreadystatechange = trataRetorno;
      comunicacao.open("GET", "processa_gravacao_produto.php?"+str, true);
      comunicacao.send();
    }
  }
}

function trataRetorno(){
  if(comunicacao.readyState == 4){
    if(comunicacao.status == 200){
      document.getElementById("resultado").innerHTML = comunicacao.responseText;
      domument.location = "http://www.google.com.br"
    }else{
      alert("Ocorreu um problema ao obter os dados:\n "+comunicacao.statusText);
    }
  }

}


