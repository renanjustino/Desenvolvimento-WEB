<?php


require "conexaoMysql.php";

class Cliente
{
	public $rua;
	public $bairro;
	public $cidade;
        public $estado;
}

try
{
	$conn = conectaAoMySQL();

	$cep = "";
	if (isset($_GET["cep"]))
		$cep = $_GET["cep"];

	$SQL = "
		SELECT rua, bairro, cidade, estado
		FROM Cliente
		WHERE CEP = '$cep';
	";
	
	if (! $result = $conn->query($SQL))
		throw new Exception('Ocorreu uma falha ao buscar o endereco: ' . $conn->error);
	
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();

		$cliente = new Cliente();

		$cliente->rua    = $row["rua"];
		$cliente->bairro = $row["bairro"];
		$cliente->cidade = $row["cidade"];
                $cliente->estado = $row["estado"];

		// A função json_encode do PHP retorna uma string JSON correspondente ao objeto PHP
		// Neste exemplo, $jsonStr será uma string JSON, ou seja: { "rua": "nome rua", "bairro": "nome do bairro", "cidade": "nome da cidade" }
		// Essa string será retornada para o cliente (navegador), que por sua vez
		// fará a conversão para um objeto JavaScript		
		// IMPORTANTE: a função json_encode exige que toda string no objeto esteja codificada como UTF-8.
		// Erros são comuns quando o MySQL utiliza outros padrões de codificação para caracteres
		// especiais, como cedilhas e acentos.
		if (! $jsonStr = json_encode($cliente))
			throw new Exception("Falha na funcao json_encode do PHP");
		
		echo $jsonStr;
	} 
}
catch (Exception $e)
{
	echo $e->getMessage();
}

if ($conn != null)
	$conn->close();

?>