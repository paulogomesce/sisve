<?php
class prateleira{
	/*Propriedades da classe*/
	public $cdPrateleira;
	public $cdProduto;
	public $cdReposicao;
	public $precoVenda;
	public $qtdRestante;
	public $dtReposicao;
	public $objConn;
	public $msgErro;
	
	/*GRAVA A PRATELEIRA DO PRODUTO*/
	function addProdutoPrateleira(){		
		$sql = "INSERT INTO tb_prateleira (cd_produto
																			,cd_reposicao
																			,preco_venda
																			,qtd_restante
																			,dt_reposicao
																			,nm_usuario)
															VALUES ({$this->cdProduto}
																		 ,{$this->cdReposicao}
																		 ,{$this->precoVenda}
																		 ,{$this->qtdRestante}
																		 ,now()
																		 ,'".$_SESSION["nm_usuario"]."'";
																		
		$resultQuery = $this->objConn->query($sql);
		$msgErro = $this->objConn->error;
		$this->msgErro = $msgErro;

		if($resultQuery){
			$rRdProduto = $this->objConn->insert_id;
			return $rRdProduto;
		}else{
			return false;
		}
	}//Fim da funчуo	
	
	function reporProdutoPrateleira(){
		$sql = "UPDATE tb_prateleira
               SET preco_venda  = {$this->precoVenda}
									,qtd_restante = {$this->qtdRestante}
									,dt_reposicao = now()
									,nm_usuario   = '{$this->cdProduto}'
						 WHERE cd_produto = {$this->cdProduto}";
																		
		$resultQuery = $this->objConn->query($sql);
		$msgErro = $this->objConn->error;
		$this->msgErro = $msgErro;

		if($resultQuery){
			return true;
		}else{
			return false;
		}
	}
}//fim da classe
?>