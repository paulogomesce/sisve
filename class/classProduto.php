<?php
class produto{
	/*Propriedades da classe*/
	public $cdProduto;
	private $codBarras;
	private $dsProduto;
	private $referencia;
	private $fabricante;
	private $categoria;
	private $nmUsuCadastro;
	private $flAtivo;
	private $flDesconto;
	private $cdMedida;
	private $qtdVolume;
	private $flPerecivel;	
	private $objConn;
	public $msgErro;
	
	//Mйtodo Construtor
	function __construct($conexao){
		$this->objConn = $conexao;
	}
	//Cуdigo de barras
	function setCodBarras($cdBarras){
		$this->codBarras = $cdBarras;
	}
	//Descriзгo do produto
	function setDsProduto($dsProduto){
		$this->dsProduto = $dsProduto;
	}
	//Fabricante	
	function setFabricante($prFabricante){
		$this->fabricante = $prFabricante;
	}
	//Categoria	
	function setCategoria($prCategoria){
		$this->categoria = $prCategoria;
	}
	//Referкncia
	function setReferencia($referencia){
		$this->referencia = $referencia;
	}
	//Nome do usuбrio que cadastrou
	function setNmUsuCadastro($prNmUsuario){
		$this->nmUsuCadastro = $prNmUsuario;
	}	
	//Produto ativo
	function setFlAtivo($prFlativo){
		$this->flAtivo = $prFlativo;
	}
	//Desconto
	function setFlDesconto($prFlDesconto){
		$this->flDesconto = $prFlDesconto;
	}
	//Unidade de medida
	function setCdMedida($prCdMedida){
		$this->cdMedida = $prCdMedida;
	}
	//Quantidade do volume
	function setQtdVolume($prQtdVolume){
		$this->qtdVolume = $prQtdVolume;
	}
	//Produto Perecнvel
	function setFlPerecivel($prFlPerecivel){
		$this->flPerecivel = $prFlPerecivel;
	}	
	
	/*GRAVA O PRODUTO E RETORNA O CODIGO DO PRODUTO GRAVADO*/
	function gravaProduto(){
		$cdBarras      = ($this->codBarras != "") ? "'$this->codBarras'"     : "null";
		$fabricante    = ($this->fabricante != "") ? "'$this->fabricante'"   : "null";
		$qtdVolume     = ($this->qtdVolume != "") ? "'$this->qtdVolume'"     : "null";
		$nReferencia   = ($this->referencia != "") ? "'$this->referencia'"   : "null";
		
		$sql = "INSERT INTO tb_produto(CD_PRODUTO, CODIGO_BARRAS, DS_PRODUTO, REFERENCIA, FABRICANTE, CD_CATEGORIA, DT_CADASTRO, NM_USU_CADASTRO, FL_ATIVO, FL_DESCONTO, FL_PERECIVEL, CD_UNIDADE_MEDIDA, QTD_VOLUME)
														VALUES(NULL, ".$cdBarras.", '{$this->dsProduto}', ".$nReferencia.", ".$fabricante.", {$this->categoria}, NOW(), '{$this->nmUsuCadastro}',
														        'S', '{$this->flDesconto}', '{$this->flPerecivel}', '{$this->cdMedida}', ".$qtdVolume.")";
																		
		$resultQuery = $this->objConn->query($sql);
		$msgErro = $this->objConn->error;
		$this->msgErro = $msgErro;

		if($resultQuery){
			$cdProduto = $this->objConn->insert_id;
			return $cdProduto;
		}else{
			return false;
		}
	}
	
	/*EDITA AS DADOS DE CADASTRO DE UM PRODUTO*/
	function updateProduto($cdProduto){
		$resultQuery   = false;
		$cdBarras      = ($this->codBarras != "") ? "'$this->codBarras'"     : "null";
		$fabricante    = ($this->fabricante != "") ? "'$this->fabricante'"   : "null";
		$qtdVolume     = ($this->qtdVolume != "") ? "'$this->qtdVolume'"     : "null";
		$nReferencia   = ($this->referencia != "") ? "'$this->referencia'"   : "null";
		
		$sql = "update tb_produto pr
							 set pr.codigo_barras     = ".$cdBarras.",
							 		 pr.ds_produto        = '".$this->dsProduto."',
							 		 pr.referencia        = ".$nReferencia.",
							 		 pr.fabricante        = ".$fabricante.",
							 		 pr.cd_categoria      = '".$this->categoria."',
							 		 pr. nm_usu_cadastro  = '".$this->nmUsuCadastro."',
							 		 pr.fl_ativo          = '".$this->flAtivo."',
							 		 pr.fl_desconto       = '".$this->flDesconto."',
									 pr.fl_perecivel      = '".$this->flPerecivel."',
									 pr.cd_unidade_medida = '".$this->cdMedida."',
									 pr.qtd_volume        = ".$qtdVolume."
						 where pr.cd_produto       = '".$cdProduto."'";
		$resultQuery = $this->objConn->query($sql);
		$msgErro = $this->objConn->error;
		$this->msgErro = $msgErro;
		
		if($resultQuery){
			return true;
		}else{
			return false;
		}	
	}

	/*Verifica se o produto jб estб cadastrodo e retorna o nome, cуdigo e estado no produto separado por ";"*/
	function existeProduto($codBarras){
		$dadosRetorno = "";
		$sql = "select p.cd_produto, p.ds_produto, if(p.fl_ativo = 'N', 'CANCELADO', 'ATIVO') estado
              from tb_produto p
             where p.CODIGO_BARRAS = '{$codBarras}'";
		$resultQuery = $this->objConn->query($sql);
		while($dados = $resultQuery->fetch_assoc()){
			$dadosRetorno = $dados["cd_produto"].";".$dados["ds_produto"].";".$dados["estado"];
		}
		return $dadosRetorno;
	}
	
}//fim da classe
?>