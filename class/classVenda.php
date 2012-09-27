<?php
class classProduto{
	/*Falta incluir mais alguns campos na tabela venda e na tabela fechamento caixa*/
	private $dtVenda;
	private $vlVenda;
	private $cdVendedor;
	private $statusVenda;
	private $cdCliente;
	private $cdCaixa;
	private $dBconexao;

	function __construct($conexao){
		$this->dBconexao = $conexao;	
	}

	function setDtVenda($dtVenda){
		$this->dtVenda = $dtVenda;
	}

	function setVlVenda($vlVenda){
		$this->vlVenda = $vlVenda;
	}

	function setCdVendedor($cdVendedor){
		$this->cdVendedor = $cdVendedor;
	}

	function setStatusVenda($statusVenda){
		$this->statusVenda = $statusVenda;
	}

	function setCdCliente($cdCliente){
		$this->cdCliente = $cdCliente;
	}

	function setCdCaixa($cdCaixa){
		$this->cdCaixa = $cdCaixa;
	}

	function gravaVenda(){
		$sql = "insert into tb_venda(cd_venda, dt_venda, vl_venda, cd_vendedor, status_venda, cd_cliente, venda_cd_caixa)
                          values(null, now(), 10.00, 1, 1, 'Teste manual', 1)";
	}

	function cancelaVenda(){
		null;
	}
	
	function addItemVenda(){
		null;
	}
}
?>