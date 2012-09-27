<?php
class pxls{

	public $bgColor; //Cor de fundo da célula
	public $size;    //tamanho da font
	public $color;   //Cor da font
	
	//Define a formatação para o texto e para a célula
	function setFormatacao($bgColor,$size,$color){
		$this->bgColor = $bgColor;
		$this->size    = $size;
		$this->color   = $color;
	}

	//Inicia o arquivo Excel, recomendável utilizar undeline(_) ao invés de espaço
	function abrirArquivo($nmArquivo){
		header("Content-type: application/msexcel");
		header("Content-Disposition: attachment; filename={$nmArquivo}.xls");
	}

	//Insere quebras de linha, o parâmetro é a quantidade de linhas que serão quebradas
	function quebraLinha($qtdQuebras="1"){
		for($i=1;$i<=$qtdQuebras;$i++){
			echo "<br />";
		}
	}
	
	//Adiciona um tírulo para a tabela
	function addTitulo($txtTitulo, $pAlign="L"){
		$align = "L";
		
		switch(strtoupper($pAlign)){
			case "C":
				$align = "center";
				break;
			case "R":
				$align = "right";
				break;
			default:
				$align = "left";
		}
	
		echo "<div align={$align}><b><font size={$this->size} color={$this->color}>".$txtTitulo."</font></b></div>";
	}
	
	//Adiciona o cabeçalho da tabela
	function addCabecalho($valor, $pAlign="C"){
		$align = "C";
		
		switch(strtoupper($pAlign)){
			case "L":
				$align = "left";
				break;
			case "R":
				$align = "right";
				break;
			default:
				$align = "center";
		}
		
		echo "<th align={$align} bgcolor={$this->bgColor}><font size={$this->size} color={$this->color}>".$valor."</font></th>";
	}
	
	//Inicia a abertura de uma tabela
	function abreTabela($border="0"){
		echo "<table border=".$border.">";
	}

	//Indica o fim da tabela
	function fechaTabela(){
		echo "</table>";
	}
	
	//Inicia uma linha para tabela
	function abreLinha(){
		echo "<tr>";
	}

	//Indica o fim de uma linha aberta anteriormente
	function fechaLinha(){
		echo "</tr>";
	}

	//Adiciona uma célula
	function addCel($valor, $pAlign="C"){
		$align = "C";
		switch(strtoupper($pAlign)){
			case "L":
				$align = "left";
				break;
			case "R":
				$align = "right";
				break;
			default:
				$align = "center";
		}
		echo "<td bgcolor={$this->bgColor} align={$align}><font size={$this->size} color={$this->color}>".$valor."</font></td>";
	}

	//Mesclar Células
	function addColSpan($valor, $qtdColl, $pAlign="C"){
		$align = "C";		
		switch(strtoupper($pAlign)){
			case "L":
				$align = "left";
				break;
			case "R":
				$align = "right";
				break;
			default:
				$align = "center";
		}		
		echo "<td colspan={$qtdColl} bgcolor={$this->bgColor} align={$align}><font size={$this->size} color={$this->color}>".$valor."</font></td>";
	}
}
?>