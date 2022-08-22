<?php
session_start();

include("php/protect.php");

// Inclui o arquivo com os dados e funções de conexão
require "php/conexaoMysql.php";

// Valida uma string removendo alguns caracteres
// especiais que poderiam ser provenientes
// de ataques do tipo HTML/CSS/JavaScript Injection
function filtraEntrada($dado)
{
    $dado = trim($dado);               // remove espaços no inicio e no final da string
    $dado = stripslashes($dado);       // remove contra barras: "cobra d\'agua" vira "cobra d'agua"
    $dado = htmlspecialchars($dado);   // caracteres especiais do HTML (como < e >) são codificados

    return $dado;
}

$msgErro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Define e inicializa as variáveis
    $cpf = $nome = $datain = $email = $senha = $celular = $telefone = $endereco = $telcontato = $salario = $cargo ="";

    $cpf = filtraEntrada($_POST["cpf"]);
	$nome = filtraEntrada($_POST["nome"]);
    $datain = filtraEntrada($_POST["datain"]);
	$email = filtraEntrada($_POST["email"]);
    $senha = filtraEntrada($_POST["senha"]);
	$celular = filtraEntrada($_POST["celular"]);
	$telefone = filtraEntrada($_POST["telefone"]);
	$endereco = filtraEntrada($_POST["endereco"]);
	$telcontato = filtraEntrada($_POST["telcontato"]);
	$salario = filtraEntrada($_POST["salario"]);
	$cargo = filtraEntrada($_POST["cargo"]);

    try 
    {
        // Função definida no arquivo conexaoMysql.php
        $conn = conectaAoMySQL();

        $conn->begin_transaction();

        $sql = "
          INSERT INTO Funcionario (id, cpf, nome, datain, email, senha, celular, telefone, endereco, telcontato, salario, cargo)
          VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        ";
       
        
        // prepara a declaração SQL (stmt é uma abreviação de statement)
        if (!$stmt = $conn->prepare($sql))
            throw new Exception("Falha na operacao prepare: " . $conn->error);

        // Faz a ligação dos parâmetros em aberto com os valores.
        if (!$stmt->bind_param("sssssssssis", $cpf, $nome, $datain, $email, $senha, $celular, $telefone, $endereco, $telcontato, $salario, $cargo))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);

        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);

        $conn->commit();
        $formProcSucesso = true;
    } 
    catch (Exception $e) {
        $conn->rollback();
 echo "Ocorreu um erro na transacao: " . $e->getMessage();
        $msgErro = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Imobiliária AGR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cadastro.css" rel="stylesheet">
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</head>

<body>
<?php include "php/navbar.php"; ?>
<br>
    <div class="container">

        <h1 class="card-title text-center">1. Cadastro de Funcionários</h1>
        <br>
        <h5 class="card-title text-left">Dados Pessoais</h5>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<div class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
            <div class="row">

                <div class="form-group col-2">
                    <label for="cpf">CPF:</label>
                    <input type="cpf" class="form-control"  name="cpf" required placeholder="Digite seu cpf">
                </div>

                <div class="form-group col-7 ">
                    <label for="nome ">Nome:</label>
                    <input type="text " class="form-control " id="nome" name="nome"required placeholder="Digite seu nome">
                </div>

                <div class="form-group col-3 ">
                    <label for="date">Data de ingresso na Imobiliária:</label>
                    <input type="date" class="form-control " id="datain" name="datain"required >
                </div>
            </div>

            <div class="row ">

                <div class="form-group col-5 ">
                    <label for="email ">Email:</label>
                    <input type="email " class="form-control " id="email " name="email"required placeholder="Digite seu e-mail">
                </div>

                <div class="form-group col-3 ">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control " id="senha" name="senha" maxlength="128" required placeholder="Digite sua senha">
                </div>

                <div class="form-group col-2 ">
                    <label for="celular ">Celular:</label>
                    <input type="text" class="form-control " id="celular " name="celular"required placeholder="Digite seu celular">
                </div>

                <div class="form-group col-2 ">
                    <label for="telefone ">Telefone:</label>
                    <input type="text" class="form-control " id="telefone " name="telefone"required placeholder="Digite seu telefone">
                </div>
            </div>




                <div class="row ">
                    <div class="form-group col-4 ">
                        <label for="end">Endereço:</label>
                        <input type="text " class="form-control " id="end" name="endereco"required placeholder="Digite seu endereço">
                    </div>
                    <div class="form-group col-2 ">
                        <label for="logradouro ">Telefone Contato:</label>
                        <input type="text " class="form-control " id="telcontato" name="telcontato"required placeholder="Telefone de alguém">
                    </div>
                    <div class="form-group col-2 ">
                        <label for="salario">Salário:</label>
                        <input type="number" class="form-control " id="salário" name="salario"required placeholder="Digite seu salário">
                    </div>
                    <div class="form-group col-4 ">
                        <label for="cargo">Cargo:</label>
                        <input type="text" class="form-control " id="cargo" name="cargo"required placeholder="Digite seu cargo">
                    </div>
                </div>
				</div>
				</div>
				</div>
				<br>
               <div class="row ">
                <div class="form-group col-3">
                    <input type="submit" class="btn btn-block btn-primary" value="Cadastrar"></button>
                </div>
                <div class="form-group col-3 ">
                    <input type= "reset" class="btn btn-block btn-secondary " value="Limpar"></button>
                </div>
				</div>
        </form>

 <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($msgErro == "")
            echo "<h3 class='text-success'>Cadastro realizado com sucesso!</h3>";
        else
            echo "<h3 class='text-danger'>Cadastro não realizado: $msgErro</h3>";
    }
    ?>




    </div>




</body>
    <?php include "php/footer.php"; ?>
</html>