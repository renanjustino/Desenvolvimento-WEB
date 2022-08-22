<?php

session_start();

include("php/protect.php");

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
    $cpf = $nome = $datanasc = $estadocivil = $sexo = $email = $senha = $celular = $telefone = $rua = $logradouro = $numero = $bairro = $cep = $cidade = $estado ="";

    $cpf = filtraEntrada($_POST["cpf"]);
	$nome = filtraEntrada($_POST["nome"]);
    $datanasc = filtraEntrada($_POST["datanasc"]);
	$estadocivil = filtraEntrada($_POST["estadocivil"]);
        $sexo = filtraEntrada($_POST["sexo"]);
	$email = filtraEntrada($_POST["email"]);
    $senha = filtraEntrada($_POST["senha"]);
	$celular = filtraEntrada($_POST["celular"]);
	$telefone = filtraEntrada($_POST["telefone"]);
	$rua = filtraEntrada($_POST["rua"]);
	$logradouro = filtraEntrada($_POST["logradouro"]);
	$numero = filtraEntrada($_POST["numero"]);
	$bairro = filtraEntrada($_POST["bairro"]);
	$cep = filtraEntrada($_POST["cep"]);
	$cidade = filtraEntrada($_POST["cidade"]);
	$estado = filtraEntrada($_POST["estado"]);

    try 
    {
        // Função definida no arquivo conexaoMysql.php
        $conn = conectaAoMySQL();
        
        $conn->begin_transaction();
        
        $sql = "
          INSERT INTO Cliente (id, cpf, nome, datanasc, estadocivil, sexo, email, senha, celular, telefone, rua, logradouro, numero, bairro, cep, cidade, estado)
          VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        ";

        // prepara a declaração SQL (stmt é uma abreviação de statement)
        if (!$stmt = $conn->prepare($sql))
            throw new Exception("Falha na operacao prepare: " . $conn->error);

        // Faz a ligação dos parâmetros em aberto com os valores.
        if (!$stmt->bind_param("ssdssssssssissss", $cpf, $nome, $datanasc, $estadocivil, $sexo,  $email, $senha, $celular, $telefone, $rua, $logradouro, $numero, $bairro, $cep, $cidade, $estado))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);

        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);
            
        $conn->commit();
        
        $formProcSucesso = true;

    } 
    catch (Exception $e) {
        $msgErro = $e->getMessage();
        $conn->rollback(); 
        echo "Ocorreu um erro na transacao: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Imobiliária AGR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <link href="css/cadastro.css" rel="stylesheet">
    <script>

        function buscaEndereco(cep)
        {
            if (cep.length != 9)
                return;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function (e)
            {
                if (xmlhttp.status == 200)
                {
                    if (xmlhttp.responseText != "")
                    {
                        try
                        {
                            cliente = JSON.parse(xmlhttp.responseText);
                            document.forms[0]["rua"].value = cliente.rua;
                            document.forms[0]["bairro"].value = cliente.bairro;
                            document.forms[0]["cidade"].value = cliente.cidade;
                            document.forms[0]["estado"].value = cliente.cidade;
                        }
                        catch (e)
                        {
                            alert("A string retornada pelo servidor não é um JSON válido: " + xmlhttp.responseText);
                        }
                    }
                    else
                        alert("CEP não encontrado");
                }
            }

            xmlhttp.open("GET", "php/buscaEndereco.php?cep=" + cep, true);
            xmlhttp.send();
        }

    </script>
</head>

<body>
<?php include "php/navbar.php"; ?><br>
    <div class="container">

        <h1 class="card-title text-center">2. Cadastro de Clientes</h1>
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
                    <input type="text" class="form-control" placeholder="000.000.000-00" maxlength="14" id="cpf" name="cpf" required>
                </div>

                <div class="form-group col-4 ">
                    <label for="nome ">Nome:</label>
                    <input type="text " class="form-control " id="nome " name="nome"required>
                </div>

                <div class="form-group col-3">
                    <label for="date">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="dtnascimento" name="datanasc"required>
                </div>
                <div class="form-group col-3">
                    <label for="estadoCivil">Estado Civil:</label>
                    <select class="form-control" id="estadoCivil" name="estadocivil">
                      <option>Solteiro</option>
                      <option>Casado</option>
                      <option>Divorciado</option>
                    </select>
                </div>
            </div>

            <div class="row ">
                <div class="form-group col-3">
                    <label for="sexo">Sexo:</label>
                    <select class="form-control" id="sexo" name="sexo">
                      <option>Masculino</option>
                      <option>Feminino</option>
                    </select>
                </div>
                <div class="form-group col-3 ">
                    <label for="email ">Email:</label>
                    <input type="email" class="form-control " placeholder="exemplo@site.com" id="email " name="email"required>
                </div>

                <div class="form-group col-2">
                    <label for="pwd">Senha:</label>
                    <input type="password" class="form-control" id="pwd" name="senha"required>
                </div>

                <div class="form-group col-2 ">
                    <label for="celular ">Celular:</label>
                    <input type="text" class="form-control " placeholder="Ex.: (34) 99222-2222" id="celular " name="celular"required>
                </div>

                <div class="form-group col-2 ">
                    <label for="telefone ">Telefone:</label>
                    <input type="text" class="form-control " placeholder="Ex.: (34) 3222-2222" id="telefone " name="telefone"required>
                </div>
            </div>
		</div>
	</div>
</div>
            <br>
            <h5 class="card-title text-left ">Endereço</h5>
            <br>

<div class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
            <div class="row ">
                <div class="form-group col-4 ">
                    <label for="rua">Rua:</label>
                    <input type="text " class="form-control " id="rua" name="rua" required>
                </div>
                <div class="form-group col-4 ">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" class="form-control " id="logradouro" name="logradouro" required>
                </div>
                <div class="form-group col-1 ">
                    <label for="numresid">Nº:</label>
                    <input type="number" class="form-control " id="numresid" name="numero"required>
                </div>
                <div class="form-group col-3 ">
                    <label for="bairro">Bairro:</label>
                    <input type="text" class="form-control " id="bairro" name="bairro" required>
                </div>
            </div>
            <div class="row ">
                <div class="form-group col-4 ">
                    <label for="cep">CEP:</label>
                    <input type="text" class="form-control " id="cep" name="cep" onkeyup="buscaEndereco(this.value)" required>
                </div>
                <div class="form-group col-5 ">
                    <label for="cidade">Cidade:</label>
                    <input type="text" class="form-control " id="cidade" name="cidade" required>
                </div>
                <div class="form-group col-3 ">
                    <label for="estado ">Estado:</label>
                    <input type="text" class="form-control " id="estado" name="estado" required>
                </div>
            </div>
            <br>
			</div>
			</div>
			</div><br>
            <div class="row ">
                <div class="form-group col-3">
                    <input type="submit" class="btn btn-block btn-primary" value="Cadastrar"></button>
                </div>
                <div class="form-group col-3 ">
                    <input type="reset"class="btn btn-block btn-secondary "value="Limpar"></button>
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