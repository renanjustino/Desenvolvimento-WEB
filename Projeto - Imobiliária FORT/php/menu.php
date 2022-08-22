<?php
session_start();
include("protect.php");

// Inclui o arquivo com os dados e funções de conexão
require "conexaoMysql.php";
$conn = conectaAoMySQL();
?>
<?php
$cookie_name = "Usuário";
$cookie_value = "Imobiliária FORT";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>

<!DOCTYPE html>
<html>
<body>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Imobiliária AGR</title>
  
  <!--* Transformar página em .PHP -->
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  body{
    background-color: rgb(225, 245, 245);
    background-repeat: no-repeat;
    background-size: 100% 100%;
    margin: 20px auto;
    width: 100%;
  }
  </style>
</head>
<body>

<div class="container">
<?php
if(!isset($_COOKIE[$cookie_name])) {
} else {
    echo "Olá '" . $cookie_name . "'!<br>";
    echo "Esse é o MENU de opções da : " . $_COOKIE[$cookie_name];
}
?>
<h1 class="card-title text-center">Menu de opções</h1><br>
<a href="/cadastroFuncionario.php"><button class="btn btn-block btn-primary">1. Cadastrar Funcionários</button></a><br>
<a href="/cadastroCliente.php"><button class="btn btn-block btn-primary">2. Cadastrar Clientes</button></a><br>
<a href="/cadastroImovel.php"><button class="btn btn-block btn-primary">3. Cadastrar Imóveis</button></a><br>
<a href="/listaFuncionario.php"><button class="btn btn-block btn-primary">4. Mostrar Funcionários Cadastrados</button></a><br>
<a href="/listaCliente.php"><button class="btn btn-block btn-primary">5. Mostrar Clientes Cadastrados</button></a><br>
<a href="/lista2Cliente.php"><button class="btn btn-block btn-primary">5.1 Mostrar Endereços de Clientes Cadastrados</button></a><br>
<a href="/listaImovel.php"><button class="btn btn-block btn-primary">6. Mostrar Imóveis Cadastrados</button></a><br>
<a href="/fotosImovel.php"><button class="btn btn-block btn-primary">7. Mostrar Fotos Imóveis Cadastrados</button></a><br>
</div>
<a href="sair.php"><button style="width: 10%; margin:20px auto;" class="btn btn-block btn-danger">Sair Do Sistema</button></a>
</body>
</html>