function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
		
		var t = new String(objTextBox.value);
		if (whichCode == 8){
		objTextBox.value = t.substring(0, t.length-1);
		} 
		
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}
function Mascara(tipo, campo, teclaPress) {
        if (window.event)
        {
                var tecla = teclaPress.keyCode;
        } else {
                tecla = teclaPress.which;
        }
 
        var s = new String(campo.value);
        /*Remove todos os caracteres*/
        s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
        tam = s.length + 1;
 
        if ( tecla != 9 && tecla != 8 ) {
                switch (tipo)
                {
                case 'CPF' :
                        if (tam > 3 && tam < 7)
                                campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
                        if (tam >= 7 && tam < 10)
                                campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
                        if (tam >= 10 && tam < 12)
                                campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
                break;
 
                case 'CNPJ' :
 
                        if (tam > 2 && tam < 6)
                                campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
                        if (tam >= 6 && tam < 9)
                                campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
                        if (tam >= 9 && tam < 13)
                                campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
                        if (tam >= 13 && tam < 15)
                                campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
                break;
 
                case 'TEL' :
                        if (tam > 2 && tam < 4)
                                campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
                        if (tam >= 7 && tam < 11)
                                campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
                break;
 
                case 'DATA' :
                        if (tam > 2 && tam < 4)
                                campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
                        if (tam > 4 && tam < 11)
                                campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
                break;
                
                case 'CEP' :
                        if (tam > 5 && tam < 7)
                                campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
                break;
				
                }
        }
}

/*Essa função só aceita a digitação de numeros e nada mais*/
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if(((charCode >= 8) && (charCode <= 57))||((charCode >= 91) && (charCode <= 105))     ){
		//alert('Ceitou!');
		return true;
	}else{
		return false;
	}
}

/*Essa função só aceita a digitação de numeros e o .(ponto)*/
function soNumeroEPonto(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if(((charCode >= 8) && (charCode <= 57))||((charCode >= 91) && (charCode <= 105))||(charCode == 194 || charCode == 190 /*Permitir "."*/)     ){
		//alert('Ceitou!');
		return true;
	}else{
		return false;
	}
}

function FormataData(Campo, teclapres){
    var tecla = teclapres.keyCode;
    var vr = new String(Campo.value);
    vr = vr.replace("/", "");
    vr = vr.replace("/", "");
    vr = vr.replace("/", "");
    tam = vr.length + 1;
    if (tecla != 8 && tecla != 8)
    {
            if (tam > 0 && tam < 2)
                    Campo.value = vr.substr(0, 2) ;
            if (tam > 2 && tam < 4)
                    Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
            if (tam > 4 && tam < 7)
                    Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
    }
}

function upperCase(x){
	var y=document.getElementById(x).value;
	document.getElementById(x).value=y.toUpperCase();
}

function mascara_data(data){ 
	var mydata = ''; 
	mydata = mydata + data; 
	if (mydata.length == 2){ 
			mydata = mydata + '/'; 
			document.forms[0].data.value = mydata; 
	} 
	if (mydata.length == 5){ 
			mydata = mydata + '/'; 
			document.forms[0].data.value = mydata; 
	} 
	if (mydata.length == 10){ 
			verifica_data(); 
	} 
}

//seta um campo com o atributo ReadOnly
function setReadOnly(campo){
	document.getElementById(campo).readOnly = true;
}

//Seta um campo como readOnly
function removeReadOnly(campo){
	document.getElementById(campo).readOnly = false;
}

//Desabilita um campo como disabled
function setDisabled(campo){
	document.getElementById(campo).disabled = true;
}

//Remove um campo como disabled
function removeDisabled(campo){
	document.getElementById(campo).disabled = false;
}

//Copia valor de um campo para aoutro
function copiaVlrCampo(origem, destino){
	var vlrOrigem = document.getElementById(origem).value;
	document.getElementById(destino).value = vlrOrigem;
}

//Fecha a div da mensagem de erro
function closeDivErro(){
	document.getElementById("conteiner_modal").style.visibility = 'hidden';
	$("#dados_res").empty();
}

function bkgColor(idElemento, cor){
	document.getElementById(idElemento).style.backgroundColor = cor;
}

