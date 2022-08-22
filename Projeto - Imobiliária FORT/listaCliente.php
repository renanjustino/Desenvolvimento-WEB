<?php

session_start();

include("php/protect.php");

// Inclui o arquivo com os dados e funções de conexão
require "php/conexaoMysql.php";
class Cliente
{
    public $id;
	public $cpf;
    public $nome;
    public $datanasc;
    public $estadocivil;
    public $sexo;
	public $email;
	public $senha;
	public $celular;
	public $telefone;
}

function getClientes($conn)
{
    $arrayClientes= null;

    $SQL = "
        SELECT id, cpf, nome, datanasc, sexo, email, senha, celular, telefone
        FROM Cliente
    ";

    // Prepara a consulta
    if (!$stmt = $conn->prepare($SQL))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    // Executa a consulta
    if (!$stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);

    // Indica as variáveis PHP que receberão os resultados
    if (!$stmt->bind_result($id, $cpf, $nome, $datanasc, $sexo, $email, $senha, $celular, $telefone))
        throw new Exception("Falha na operacao bind_result: " . $stmt->error);

    // Navega pelas linhas do resultado
    while ($stmt->fetch()) {
        $cliente = new Cliente();

        $cliente->id = $id;
		$cliente->cpf = $cpf;
       $cliente->nome = $nome;
        $cliente->datanasc = $datanasc;
        $cliente->sexo = $sexo;
		$cliente->email = $email;
		$cliente->senha = $senha;
		$cliente->celular = $celular;
		$cliente->telefone = $telefone;
        $arrayClientes[] = $cliente;
    }

    return $arrayClientes;
}

///////////////////////////////////////////////////////////////////////////
// Código principal PHP
///////////////////////////////////////////////////////////////////////////
$arrayClientes = null;
$msgErro = "";

try {
    $conn = conectaAoMySQL();
    $arrayClientes = getClientes($conn);
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
  <h2 style="margin-bottom: 20px;">5. Informações Básicas dos Clientes Cadastrados</h2>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Cpf</th>
        <th>Nome</th>
        <th>DataN</th>
        <th>Sexo</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Celular</th>
        <th>Telefone</th>
      </tr>
    </thead>
    <tbody>
<?php

        if ($arrayClientes != null) {

            foreach ($arrayClientes as $cliente) {
                echo "
                    <tr>
                      <td>$cliente->id</td>
                      <td>$cliente->cpf</td>
                      <td>$cliente->nome</td>
                      <td>$cliente->datanasc</td>
                      <td>$cliente->sexo</td>
					  <td>$cliente->email</td>
                                          <td>$cliente->senha</td>
                                          <td>$cliente->celular</td>
                                          <td>$cliente->telefone</td>

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
