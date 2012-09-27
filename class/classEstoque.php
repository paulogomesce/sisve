<?php
class estoque{
	/*Propriedades da classe*/
	private $cdProduto;
	private $qtdEntrada;
	private $qtdRestante;	
	private $dtFabricacao;
	private $dtValidade;
	private $precoCusto;
	private $precoVenda;
	private $lote;
	private $cdStatus;
	private $nmUsuarioCadastrou;
	public $msgErro;
	private $linkConn;
	
	/*METODO CONSTRUTOR*/
	function __construct($conexaoDB){
		$this->linkConn = $conexaoDB;
	}
	//Quantidade de entrada de produtos
	function setCdProduto($pCdProduto){
		$this->cdProduto = $pCdProduto;
	}
	
	//Quantidade de entrada de produtos
	function setQtdEntrada($pQtdEntrada){
		$this->qtdEntrada = str_replace(" ", "", $pQtdEntrada);
	}
	//Quantiade de produtos restantes no estoque
	function setQtdRestante($pQtdRestante){
		$this->qtdRestante = str_replace(" ", "", $pQtdRestante);
	}
	//Data de fabricação
	function setDtFabricacao($pDtFabricacao){
		$this->dtFabricacao = converteFormatoData($pDtFabricacao);
	}
	//Data de validade
	function setDtValidade($pValidade){
		$this->dtValidade = converteFormatoData($pValidade);
	}
	//Preço de custo
	function setPrecoCustoProduto($pPrecoCusto){
		$this->precoCusto = str_replace(" ", "", $pPrecoCusto);
	}
	//Preço de venda
	function setPrecoVendaProduto($pPrecoVenda){
		$this->precoVenda = str_replace(" ", "", $pPrecoVenda);
	}	
	//Lote
	function setLote($pLote){
		$this->lote = $pLote;
	}
	//Status
	function setCdStatus($pCdStatus){
		$this->cdStatus = $pCdStatus;
	}
	//Nome do usuário que cadastrou
	function setNmUsuarioCadastrou($pNmUsuario){
		$this->nmUsuarioCadastrou = $pNmUsuario;
	}

	function incluirProduto($pCdProduto){
		$dtFabricacao = ($this->dtFabricacao != "") ? "'$this->dtFabricacao'" : "null";
		$dtValidade   = ($this->dtValidade != "") ? "'$this->dtValidade'" : "null";		
		$lote = ($this->lote != "") ? "'$this->lote'" : "null";
		
		$sql = "insert into tb_reposicao_estoque(cd_reposicao, cd_produto, qtd_produto, qtd_restante, dt_reposicao, dt_fabricacao, dt_validade, preco_custo_produto, preco_venda_produto, lote, cd_status, nm_usuario_cadastro)
            values(null, ".$pCdProduto.", ".$this->qtdEntrada.", ".$this->qtdRestante.", now(), ".$dtFabricacao.", ".$dtValidade.",
						       ".$this->precoCusto.", ".$this->precoVenda.", ".$lote.", ".$this->cdStatus.", '".$this->nmUsuarioCadastrou."')";
						
		$resultado = $this->linkConn->query($sql);
		$msgErro   = $this->linkConn->error;
		$this->msgErro = $msgErro;
		return $resultado;
	}
}
?>