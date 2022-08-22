<?php
session_start();
include("php/conexaoMysql.php");
$conn = conectaAoMySQL(); 
if(!isset($_SESSION['email']) and !isset($_SESSION['senha'])){

}
else{
echo "<script>location.href='php/menu.php'</script>";
}
if(isset($_POST['submit'])==1){
   $email = str_replace("'","", $_POST['email']);
$senha = str_replace("'","",$_POST['senha']);
$_SESSION['email'] = $email;
$_SESSION['senha'] = $senha;
$sql = ("SELECT * FROM Funcionario where email = '$email' and senha = '$senha'");
$resultado = $conn->query($sql);
if($resultado->num_rows == 0){
echo "Usuário informado não encontrado!";
}else{
echo "<script>location.href='php/menu.php'</script>";
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<!--Renan Justino 11921BSI223
Gabriel Alexandre 11411GIN038
Ademar Neto 11521BSI231-->
    <title>Imobiliária AGR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/home.css">
	<script src="js/home.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <ul class="topnav">

            <li><a class="active" href="index.php"><i class="fa fa-fw fa-home"></i>Página Inicial</a></li>
            <li><a href="imovel.php">Imóveis</a></li>

            <li class="right"><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;"><i class="fa fa-fw fa-user"></i>Logar</button></li>
        </ul>

        <div id="id01" class="modal">

            <form class="modal-content animate" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="img/img_avatar2.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <label for="uname"><b>Usuário</b></label>
                    <input type="text" placeholder="Digite seu email" name="email" value="<?php echo $_SESSION['email'];?>" required>

                    <label for="psw"><b>Senha</b></label>
                    <input type="password" placeholder="Digite sua senha" name="senha" required>

                    <input style="  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 16px 32px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;" type="submit" name="submit" value="Logar">
                    <label>
        <input type="checkbox" checked="checked" name="remember"> Lembre-me
      </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancelar</button>
                </div>
            </form>
        </div>
    </header>

    <div id="dv">
        <center>
            <h1 style="color:red"><b><i>Bem Vindo á Imobiliária FORT !</b></i></h1>
            </h1>
            <div class="btn-group-vertical">
                <button onclick="myFunction()" type="button" class="button btn btn-primary">Missão</button><br><br>
                <h1 style="display:none" id="myDIV">Nossa missão é oferecer as melhores formas para aquisição de seu imóvel.</h1>
                <button onclick="myFunction2()" type="button" class="button btn btn-primary">Valores</button><br><br>
                <h1 style="display:none" id="myDIV2">Nossos valores são de alta responsabilidade e fidelidade com nossos clientes, possuindo seriedade e honestidade durante todo o procedimento.</h1>
                <button onclick="myFunction3()" type="button" class="button btn btn-primary">Quem Somos</button><br><br>
                <h1 style="display:none" id="myDIV3">Somos uma empresa com foco total ao cliente, uma empresa qualificada para atender todas as necessidades durante a busca e compra de seu imóvel ideal.</h1>
                <img src="img/im1.png" id="img" alt="Imobiliária AGR"><br>
        </center>
        </div>
    </div>

</body>
<?php include "php/footer.php"; ?>
</html>