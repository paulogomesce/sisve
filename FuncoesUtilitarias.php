<?php
#================================================================================
#Função que valida se o CPF é válido.
#Autor: Desconhecido
#Modificado em: 02/03/2011
#================================================================================
function validaCPF($cpf){	// Verifiva se o número digitado contém todos os digitos
  $cpf = str_pad(preg_replace('/[-.]/', '', $cpf), 11, '0', STR_PAD_LEFT);

	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
  if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'){
		return false;
  }
	else{//Calcula os números para verificar se o CPF é verdadeiro
    for($t = 9; $t < 11; $t++){
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf{$c} * (($t + 1) - $c);
      }

      $d = ((10 * $d) % 11) % 10;

      if($cpf{$c} != $d){
        return false;
      }
    }
      return true;
  }
}
//fim da função valida CPF

#================================================================================
#Função que imprime a quantida de anos entre uma data informada no parametro e a
#data corrente do sistema.
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function calculaIdade($dataNascimento){
    $diaCorrente = date("d");
    $mesCorrente = date("m");
    $anoCorrente = date("Y");

    $dataSeparada = explode("/", $dataNascimento);

    $diaNascimento = $dataSeparada[0];
    $mesNascimento = $dataSeparada[1];
    $anoNascimento = $dataSeparada[2];

    //calcula se e maior de idade.
    if(($mesCorrente >= $mesNascimento && $diaCorrente >= $diaNascimento)||($mesCorrente > $mesNascimento)){
        $qtdAno = $anoCorrente - $anoNascimento;
        $qtdMes = $mesCorrente - $mesNascimento;
        echo "<h1>E Maior de idade!</h1>";
    }

    //Calcula se e menor de idade
    if($mesCorrente <= $mesNascimento && $diaCorrente < $diaNascimento || ($mesCorrente < $mesNascimento)){
        $qtdAno = $anoCorrente - $anoNascimento - 1;
        $qtdMes = $mesNascimento - $mesCorrente;
        $qtdMes = 12 - $qtdMes;
        if($qtdMes == 12) $qtdMes = 11;
        echo "<h1>E Menor de idade!</h1>";
    }

    echo "Qtd. Mes idade: ".$qtdMes."<br />";
    echo "Qtd. Ano idade: ".$qtdAno."<br />";
}// fim da funcão calculaIdade

#================================================================================
#Função que mostra se a passoa é maior ou menor de idade
#retorna a quantidade de anos passados entre a data corrente e a data passada no parametro
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function calculaMaiorMenorIdade($dataNascimento){
    $diaCorrente = date("d");
    $mesCorrente = date("m");
    $anoCorrente = date("Y");

    $dataSeparada = explode("/", $dataNascimento);

    $diaNascimento = $dataSeparada[0];
    $mesNascimento = $dataSeparada[1];
    $anoNascimento = $dataSeparada[2];

    //se e maior de idade.
    if(($mesCorrente >= $mesNascimento && $diaCorrente >= $diaNascimento)||($mesCorrente > $mesNascimento)){
        $qtdAno = $anoCorrente - $anoNascimento;
        $qtdMes = $mesCorrente - $mesNascimento;
    }else if($mesCorrente <= $mesNascimento && $diaCorrente < $diaNascimento || ($mesCorrente < $mesNascimento)){
        $qtdAno = $anoCorrente - $anoNascimento - 1;
        $qtdMes = $mesNascimento - $mesCorrente;
    }
    return $qtdAno;
}// Fim da calculaMaiorMenorIdade

#================================================================================
#Função que imprime o numero do CPf Formatado
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function formataCPF($numeroCPF){
    $numeroLimpo = preg_match('/[.-\s]/', "", $numeroCPF);
    $numeroFormatado = $numeroLimpo;

    for($i = 0; $i <= 14; $i++){
        if($i == 2 || $i == 6 || $i == 10){
            $numeroFormatado[3] = ".";
            $numeroFormatado[7] = ".";
            $numeroFormatado[11] = "-";
        }
    }
    return $numeroFormatado;
}

#================================================================================
#03 - Função que imprime o numero do CPf Formatado
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function formataCPF_2($numeroCPF){

    $numeroLimpo = preg_replace("/[.-\s]/", "", $numeroCPF);

    $numeroFormatado[0] = $numeroLimpo[0];  $numeroFormatado[1] = $numeroLimpo[1];
    $numeroFormatado[2] = $numeroLimpo[2];  $numeroFormatado[3] = ".";
    $numeroFormatado[4] = $numeroLimpo[3];  $numeroFormatado[5] = $numeroLimpo[4];
    $numeroFormatado[6] = $numeroLimpo[5];  $numeroFormatado[7] = ".";
    $numeroFormatado[8] = $numeroLimpo[6];  $numeroFormatado[9] = $numeroLimpo[7];
    $numeroFormatado[10] = $numeroLimpo[8]; $numeroFormatado[11] = "-";
    $numeroFormatado[12] = $numeroLimpo[9]; $numeroFormatado[13] = $numeroLimpo[10];

    foreach($numeroFormatado as $cpfFormatado){
        return $cpfFormatado;
    }
}

function formataCPF_CNPJ($campo, $formatado = true) {
    //retira formato
    $codigoLimpo = ereg_replace("[' '-./ t]", '', $campo);

    // pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) - 2);

    //verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
    if ($tamanho != 9 && $tamanho != 12) {
        return false;
    }

    if ($formatado) {
        // seleciona a mÃ¡scara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
        $indice = -1;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#')
                $mascara[$i] = $codigoLimpo[++$indice];
        }
        //retorna o campo formatado
        $retorno = $mascara;
    }else {
        //se nÃ£o quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }

    return $retorno;
}

#================================================================================
#04 - Valida se uma data é valida ou não
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function validaData($data){
  $elementosData = explode("/", $data);//divide a data em partes

  $dia = 0;
  $mes = 0;
  $ano = 0;
  $checagem = false;

  if(sizeof($elementosData) == 3){//verifica se o dia, mês e ano foram preenchidos
    $dia = $elementosData[0];
    $mes = $elementosData[1];
    $ano = $elementosData[2];
    if($dia != "" && $mes != "" && $ano != "" && $ano >= 1900){
            $checagem = checkdate($mes, $dia, $ano);
    }
  }

  return $checagem;
}

#================================================================================
#04 - Converte uma data no formato brasileiro para o padrão americano
#Autor: Paulo Gomes
#Criado em: 05/01/2012
#Parametros:
# - $pSeparadorE: Caracter usado na separação(Ex. /)
# - $pSeparadorI: Caracter usado na junção (Ex. -)
# - $pData: Data que será convertida (Ex. 01/02/2012)
#Retorno: Data no padrão americano (Ex. 2012-02-01)
#================================================================================
function converteFormatoData($pData, $pSeparadorE = "/", $pSeparadorI = "-"){
	$rData = "";
	if($pData != ""){
		$arrData = explode($pSeparadorE, $pData);
		$rData = $arrData[2].$pSeparadorI.$arrData[1].$pSeparadorI.$arrData[0];
	}else{
		$rData = "";
	}
	return $rData;
}

#================================================================================
#05 - Verifica se foi digitado nome de pessoa abreviado
#OBS: Precisa fazer ajustes antes de usar.
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function ValidaNomeAbreviado($strNome){
  $palavrasUpper = strtoupper($strNome);//coloca a string para letras maiúsculas
  $palavras = str_word_count($palavrasUpper, 1);//divide a string por palavras

  //array com todas as palavras proibídas
  $proibidos = array("A.", "B.", "C.", "D.", "E.", "F.", "G.", "H.", "I.", "J.", "K.", "L.", "M.", "N.", "O.", "P.", "Q.", "R.", "S.", "T.", "U.", "V.", "X.", "Z.", "W.", "Y.",
  "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Z", "W", "Y", "MA", "MA.");

  foreach($palavras as $partes){
    foreach($proibidos as $proibido){
      if((string)$partes == (string)$proibido){
        return false;//se alguma palavra proibida for encontrada.
      }else{
        return true;//se nenhuma palavra proibída for encontrada
      }
    }
  }
}//fim da função validaNomeAbreviado

#================================================================================
#06 - Pega duas data e verifica se uma é maior que a outra
#Autor: Paulo Gomes
#Modificado em: 02/03/2011
#================================================================================
function comparaDataProcedimento($autorizacao, $realizacao){
  $dtAutorizacao = explode("/", $autorizacao);
  $novaDtAutorizacao = $dtAutorizacao[2]."-".$dtAutorizacao[1]."-".$dtAutorizacao[0];
  //echo $novaDtAutorizacao."<br />";

  $dtProcedimento = explode("/", $realizacao);
  $novaDtProcedimento = $dtProcedimento[2]."-".$dtProcedimento[1]."-".$dtProcedimento[0];
  //echo $novaDtProcedimento."<br />";

  if ($novaDtProcedimento == $novaDtAutorizacao) return "IGUAL";
  else return ($novaDtProcedimento > $novaDtAutorizacao) ? "MAIOR" : "MENOR";
}

#================================================================================
#07 - Recebe uma String e retorna falso se não for encontrado numeros na string e
#verdadeiro se for encontrado caracteres numéricos na string.
#Autor: Paulo Gomes
#Criado em: 04/03/2011
#================================================================================
function contemNumero($nome){
	$resultado = false;
	$nome = str_split($nome);		
	foreach($nome as $letras){
		if(is_numeric($letras)){
			$resultado = true;
		}
	}
	return $resultado;
}

/*================================================================================
07 - Retorna informações do erro oracle
Parametros:
1: Array
2: [exibir código do erro] aceito 1 ou 0
3: [exibir mensagem do erro] aceito 1 ou 0
4: [exibir código fonte SQL] aceito 1 ou 0
5: [exibir a posição do erro] aceito 1 ou 0
Autor: Paulo Gomes
Criado em: 04/03/2011
================================================================================*/
function mostraErroOracle($erro, $code=1, $message=1, $sqlText=1, $offSet=1){
	if($erro){
		if($code){
			echo "<b>Código do erro: </b><br />".$erro["code"]."<br/>";
		}
		if($message){
			echo "<b>Mensagem do erro: </b><br />".htmlentities($erro['message'])."<br/>";
		}
		if($sqlText){
			echo "<b>Código SQL:<br/></b>";
			print "<pre>".htmlentities($erro['sqltext'])."</pre>";
		}
		if($offSet){
			echo "<b>Offset:</b> <br />".$erro['offset']."<br/>";
		}
	}
}
#================================================================================
#07 - Recebe um número que se estiver com a separação das decimais com "," muda po r um ponto
#Autor: Paulo Gomes
#Criado em: 02/07/2011 15:20 
#================================================================================
function trataFloat($numero){
	$numero = str_replace(",", ".", $numero);
	return $numero;
}
?>
