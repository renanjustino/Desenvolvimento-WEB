<?php

session_start();

include("php/protect.php");

// Inclui o arquivo com os dados e funções de conexão
require "php/conexaoMysql.php";
class Funcionario
{
    public $id;
	public $cpf;
    public $nome;
    public $datain;
	public $email;
	public $senha;
	public $celular;
	public $telefone;
	public $endereco;
	public $telcontato;
	public $salario;
    public $cargo;
}

function getFuncionarios($conn)
{
    $arrayFuncionarios = null;

    $SQL = "
        SELECT id, cpf, nome, datain, email, senha, celular, telefone, endereco, telcontato, salario, cargo
        FROM Funcionario
    ";

    // Prepara a consulta
    if (!$stmt = $conn->prepare($SQL))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    // Executa a consulta
    if (!$stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);

    // Indica as variáveis PHP que receberão os resultados
    if (!$stmt->bind_result($id, $cpf, $nome, $datain, $email, $senha, $celular, $telefone, $endereco, $telcontato, $salario, $cargo))
        throw new Exception("Falha na operacao bind_result: " . $stmt->error);

    // Navega pelas linhas do resultado
    while ($stmt->fetch()) {
        $funcionario = new Funcionario();

        $funcionario->id = $id;
		$funcionario->cpf = $cpf;
        $funcionario->nome = $nome;
        $funcionario->datain = $datain;
		$funcionario->email = $email;
		$funcionario->senha = $senha;
		$funcionario->celular = $celular;
		$funcionario->telefone = $telefone;
		$funcionario->endereco = $endereco;
		$funcionario->telcontato = $telcontato;
		$funcionario->salario = $salario;
		$funcionario->cargo = $cargo;
        $arrayFuncionarios[] = $funcionario;
    }

    return $arrayFuncionarios;
}

///////////////////////////////////////////////////////////////////////////
// Código principal PHP
///////////////////////////////////////////////////////////////////////////
$arrayFuncionarios = null;
$msgErro = "";

try {
    $conn = conectaAoMySQL();
    $arrayFuncionarios = getFuncionarios($conn);
} 
catch (Exception $e) {
    $msgErro = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Imobiliária AGR</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<style>
        body {
    background-color: rgb(225, 245, 245);
    background-repeat: no-repeat;
    background-size: 100% 100%;
	margin 20px auto;
        }
		</style>
</head>

<body>
<?php include "php/navbar.php"; ?>
<div class="container">
   
  <div id="listagemfuncionarios">
  <h2 style="margin-bottom: 20px;">4. Listagem dos Funcionários Cadastrados</h2>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Cpf</th>
        <th>Nome</th>
        <th>Data Ingresso</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Celular</th>
        <th>Telefone</th>
		<th>Endereço</th>
		<th>Tel Contato</th>
		<th>Salário</th>
		<th>Cargo</th>
      </tr>
    </thead>
    <tbody>
<?php

        if ($arrayFuncionarios != null) {

            foreach ($arrayFuncionarios as $funcionario) {
                echo "
                    <tr>
                      <td>$funcionario->id</td>
                      <td>$funcionario->cpf</td>
                      <td>$funcionario->nome</td>
                      <td>$funcionario->datain</td>
					  <td>$funcionario->email</td>
					  <td>$funcionario->senha</td>
					  <td>$funcionario->celular</td>
					  <td>$funcionario->telefone</td>
					  <td>$funcionario->endereco</td>
					  <td>$funcionario->telcontato</td>
					  <td>$funcionario->salario</td>
					  <td>$funcionario->cargo</td>
                    </tr>      
                ";
            }
        }

        ?>	
    </tbody>
  </table>
  </div>  
</div>
<?php

    if ($msgErro != "")
        echo "<p class='text-danger'>A operação não pode ser realizada: $msgErro</p>";

    ?>
</body>
 <?php include "php/footer.php"; ?>
</html>
