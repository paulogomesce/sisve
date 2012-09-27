<?php
  $conexao = mysql_connect("fdb3.awardspace.com", "697010_venda", "91545117");
  mysql_select_db("697010_venda");
	
	mysql_set_charset('8tf8_general_ci',$conexao); 
	//mysql_set_charset('utf8',$conexao);

  if($conexao){
    echo"Conexao bem sucedida!";
  }else{
		echo"Não foi possível conectar ao banco!";
	}
	
	
	$sql="SELECT * FROM tb_produto t";

	$sql = mysql_query($sql);
	
	while($arr = mysql_fetch_object($sql)){
		echo "<p>".$arr->DS_PRODUTO."</p>";
	}
	
?>