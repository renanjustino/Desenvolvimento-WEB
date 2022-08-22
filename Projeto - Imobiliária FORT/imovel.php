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
<?php


// Inclui o arquivo com os dados e funções de conexão

class Imovel
{
    public $id;
	public $disponibilidade;
    public $bairro;
    public $vlrimovel;
    public $proprietario;
    public $casa;
	public $quartosc;
	public $suitescasa;
	public $codprop;
	public $areacasa;
        public $piscinasimcasa;
        public $piscinanaocasa;
        public $detalhescasa;
            public $ap;
	public $quartosap;
	public $suitesap;
	public $codpropap;
	public $areaap;
        public $numap;
        public $andar;
        public $valorcon;
        public $detalhesap;

}

function getImoveis($conn)
{
    $arrayImoveis= null;
    $min = $_POST['min'];
    $max = $_POST['max'];
    $SQL = "
        SELECT tipo, disponibilidade, vlrimovel, bairro, detalhes
        FROM Imovel
        WHERE vlrimovel BETWEEN $min and $max
    ";

    // Prepara a consulta
    if (!$stmt = $conn->prepare($SQL))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    // Executa a consulta
    if (!$stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);

    // Indica as variáveis PHP que receberão os resultados
    if (!$stmt->bind_result($tipo, $disponibilidade, $vlrimovel, $bairro, $detalhes))
        throw new Exception("Falha na operacao bind_result: " . $stmt->error);

    // Navega pelas linhas do resultado
    while ($stmt->fetch()) {
        $imovel = new Imovel();
        $imovel->tipo = $tipo;
        $imovel->detalhes = $detalhes;
        $imovel->bairro = $bairro;
        $imovel->disponibilidade = $disponibilidade;
        $imovel->vlrimovel = $vlrimovel;
        $arrayImoveis[] = $imovel;
    }

    return $arrayImoveis;
}

///////////////////////////////////////////////////////////////////////////
// Código principal PHP
///////////////////////////////////////////////////////////////////////////
$arrayImoveis = null;
$msgErro = "";

try {
    $conn = conectaAoMySQL();
    $arrayImoveis = getImoveis($conn);
} 
catch (Exception $e) {
    $msgErro = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		 <title>Imobiliaria AGR</title>
		 <meta charset="utf-8">
		 <meta name="viewport" content="width=device-width, initial-scale=1">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		 	<link rel="stylesheet" href="css/imovel.css">
	<script src="js/imovel.js"></script>

	</head>

	<body>
<header>
        <ul class="topnav">

            <li><a href="index.php"><i class="fa fa-fw fa-home"></i>Página Inicial</a></li>
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
	<main><br>
	<center><h1 style="color:red"><b><i>Busca Imóveis FORT !</b></i></h1></center>
		<div class="container">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		 	<form>
		 	<br>
		 		<div class="row">
		 		
		 			<div class="form-group col-md-3">
					    <label for="proposito">Propósito</label>
					    <select class="form-control" id="proposito" name="disp">
					      <option value="Venda">Venda</option>
						  <option value="Locação">Locação</option>
					    </select>
					</div>
				    <div class="form-group col-md-3">
				      <label for="bairro">Bairro</label>
				      <input type="text" class="form-control" id="bairro" name="bai">
				    </div>
				    <div class="form-group col-md-3">
				      <label for="min">Valor mínimo</label>
				      <input type="text" class="form-control" name="min" id="min">
				    </div>
				    <div class="form-group col-md-3">
				      <label for="max">Valor máximo</label>
				      <input type="text" class="form-control" name="max" id="max">
				    </div>
				</div>	
			    <br>
			    <button input type="submit" class="btn btn-primary">Buscar</button>
			</form>

			<br><br>


		          <div style="float: center; text-align: center;"class="container">
		            <?php

        if ($arrayImoveis != null) {

            foreach ($arrayImoveis as $imovel) {
                echo "
                    <h1>Tipo: $imovel->tipo</h1>
                    <p>V/L: $imovel->disponibilidade</p>
                    <p>Valor: $imovel->vlrimovel</p>
                    <p>Bairro: $imovel->bairro</p>
                    <p>Detalhes: $imovel->detalhes</p><br>

                ";
            }
        }

        ?>		
</div>
		         
	</main>

	</body>
        <?php include "php/footer.php"; ?>
</html>