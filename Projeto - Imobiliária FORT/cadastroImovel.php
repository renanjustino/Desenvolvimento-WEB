<?php
session_start();

include("php/protect.php");

require "php/conexaoMysql.php";
$conn = conectaAoMySQL();

// Inclui o arquivo com os dados e funções de conexão


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
    $disponibilidade = $bairro = $vlrimovel = $proprietario  = $tipo = $quartos = $suites = $codprop = $area = $piscinasimcasa = $piscinanaocasa =  $detalhes =  $numap = $andar = $valorcon  = "";


    $disponibilidade     = filtraEntrada($_POST["disponibilidade"]);
$bairro     = filtraEntrada($_POST["bairro"]);
    $vlrimovel           = filtraEntrada($_POST["vlrimovel"]);
	$proprietario        = filtraEntrada($_POST["proprietario"]);
	$tipo               = filtraEntrada($_POST["tipo"]);
	$quartos         = filtraEntrada($_POST["quartos"]);
	$suites            = filtraEntrada($_POST["suites"]);
	$codprop       = filtraEntrada($_POST["codprop"]);
	$area              = filtraEntrada($_POST["area"]);
    $piscinasimcasa              = filtraEntrada($_POST["piscinasimcasa"]);
    $piscinanaocasa          = filtraEntrada($_POST["piscinanaocasa"]);
    $detalhes               = filtraEntrada($_POST["detalhes"]);
    $numap             = filtraEntrada($_POST["numap"]);
    $andar              = filtraEntrada($_POST["andar"]);
    $valorcon               = filtraEntrada($_POST["valorcon"]);
   
    try 
    {
        // Função definida no arquivo conexaoMysql.php
        
        $sql = "
        INSERT INTO Imovel (id, disponibilidade , bairro , vlrimovel , proprietario , tipo , area, codprop, quartos, suites, detalhes, piscinasimcasa, piscinanaocasa, numap, andar, valorcon)
          VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        ";

        // prepara a declaração SQL (stmt é uma abreviação de statement)
        if (!$stmt = $conn->prepare($sql))
            throw new Exception("Falha na operacao prepare: " . $conn->error);

        // Faz a ligação dos parâmetros em aberto com os valores.
        if (!$stmt->bind_param("ssissiiiisssiii", $disponibilidade , $bairro , $vlrimovel , $proprietario , $tipo, $area, $codprop , $quartos , $suites , $detalhes , $piscinasimcasa , $piscinanaocasa , $numap, $andar, $valorcon))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);

        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);

        $formProcSucesso = true;

    } 
    catch (Exception $e) {
        $msgErro = $e->getMessage();
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
    <link href="css/cadastroImovel.css" rel="stylesheet">
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/cadastroImovel.js"></script>
</head>
<body>
<?php include "php/navbar.php"; ?>
<br>
<h1 class="card-title text-center">3. Cadastro de Imóveis</h1>
<br>
    <div class="container">

        <div class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <form enctype="multipart/form-data"method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="disponibilidade">Disponível para:</label>
                                <select class="form-control" id="disponibilidade" name="disponibilidade">
                                              <option>Venda</option>
                                              <option>Locação</option>
                                            </select>
                            </div>
                            <div class="form-group col-3">
                                <label for="dtconstrucao">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro"required>
                            </div>
                            <div class="form-group col-3">
                                <label for="vlrimovel">Valor do Imóvel:</label>
                                <input type="number" class="form-control" id="vlrimovel" name="vlrimovel"required>
                            </div>
                            <div class="form-group col-3">
                                <label for="proprietario">Proprietário:</label>
                                <input type="text" class="form-control" id="proprietario" name="proprietario"required>
                            </div>
                            <div class="form-group col-3">
                                <label for="disponibilidade">Tipo Imóvel:</label>
                                <select class="form-control" id="disponibilidade" name="tipo">
                                              <option value="Casa">Casa</option>
                                              <option value="Apartamento">Apartamento</option>
                                            </select>
                            </div>
                            <div class="form-group col-3">
                                        <label for="proprietario">Área:</label>
                                <input type="text" class="form-control" id="proprietario" name="area"required>
                            </div>
                              <div class="form-group col-2">
                                        <label for="proprietario">Código Proprietário:</label>
                                <input type="text" class="form-control" id="proprietario" name="codprop"required>
                            </div>
                            <div class="form-group col-2">
                                        <label for="proprietario">Quartos:</label>
                                <input type="text" class="form-control" id="proprietario" name="quartos"required>
                            </div>
                            <div class="form-group col-2">
                                        <label for="proprietario">Suítes:</label>
                                <input type="text" class="form-control" id="proprietario" name="suites"required>
                            </div>
                                                    <div class="form-group col-12">
                            <label for="detalhesCasa">Detalhes</label>
                            <textarea class="form-control" id="detalhesCasa" rows="1" name="detalhes"></textarea>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                        <h5 class="card-title text-left ">Fotos do Imóvel</h5>
                        <div class="form-group">
                            <label for="foto1">Foto 1:</label>
                            <input  id="foto1" type="file" required name="file" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                        <div class="form-group">
                            <label for="foto2">Foto 2:</label>
                            <input id="foto2" type="file"  name="file2" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file2"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file2"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file2"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                                                <div class="form-group">
                            <label for="foto2">Foto 3:</label>
                            <input id="foto2" type="file"  name="file3" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file2"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file3"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file3"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                                                <div class="form-group">
                            <label for="foto2">Foto 4:</label>
                            <input id="foto2" type="file"  name="file4" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file4"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file4"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file2"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                                                <div class="form-group">
                            <label for="foto2">Foto 5:</label>
                            <input id="foto2" type="file"  name="file5" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file2"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file5"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file5"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                                                <div class="form-group">
                            <label for="foto2">Foto 6:</label>
                            <input id="foto2" type="file"  name="file6" accept="image/*" /><br>
                                                    <?php
// Include the database configuration file
include 'php/dbConfig.php';
$statusMsg = '';

// File upload path
$targetDir = "upload/";
$fileName = basename($_FILES["file2"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file6"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file6"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "A imagem ".$fileName. " foi enviada com sucesso.";
            }else{
                $statusMsg = "O envio falhou, tente novamente.";
            } 
        }else{
            $statusMsg = "Erro de upload no arquivo.";
        }
    }else{
        $statusMsg = 'Somente JPG, JPEG, PNG, GIF, & ETC são permitidos para upload.';
    }
}else{
    $statusMsg = 'Selecione um arquivo para upload';
}

// Display status message
echo $statusMsg;
?>
                        </div>
                </div>
            </div>
        </div>
        <br>
        <div id="casa" class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" onclick ="esconde2()" type="checkbox" value="casa" id="casa" name="casa">
                            <label class="form-check-label" for="casa">Casa</label>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-12">
                                <label> Possui piscina?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="armarioSimCasa" value="sim" name="piscinasimcasa">
                                    <label class="form-check-label" for="armarioSimCasa">Sim</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="armarioNaoCasa" value="nao" name="piscinanaocasa">
                                    <label class="form-check-label" for="armarioNao">Não</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
           <br>
        <div id="ap" class="card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" onclick = "esconde()" type="checkbox" value="ap" id="ap" name="ap">
                            <label class="form-check-label" for="casa">Apartamento</label>
                        </div>
                        <br>
                        <div class="row">

                            <div class="form-group col-4">
                                <label for="suitesCasa">Nº Ap:</label>
                                <input type="number" class="form-control" id="suitesAp" name="numap">
                            </div>

                            <div class="form-group col-4">
                                <label for="salaEstarCasa ">Andar: </label>
                                <input type="number" class="form-control " id="codprop" name="andar">
                            </div>

                            <div class="form-group col-4">
                                <label for="areaCasa">Valor Condomínio:</label>
                                <input type="number" class="form-control " id="areaAp" name="valorcon">
                            </div>
             
                </div>
            </div>
        </div>
        <br>
        </div>
            <div class="row ">
                <div class="form-group col-3">
                    <input type="submit" name="submit" class="btn btn-block btn-primary" value="Cadastrar"></button>
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
