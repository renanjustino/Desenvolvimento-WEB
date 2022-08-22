<?php

session_start();


// Inclui o arquivo com os dados e funções de conexão
require "php/conexaoMysql.php";
class Imovel
{
    public $id;
	public $disponibilidade;
    public $bairro;
    public $vlrimovel;
    public $proprietario;
    public $tipo;
	public $quartos;
	public $suites;
	public $codprop;
	public $area;
        public $piscinasimcasa;
        public $piscinanaocasa;
        public $detalhes;
        public $numap;
        public $andar;
        public $valorcon;

}

function getImoveis($conn)
{
    $arrayImoveis= null;

    $SQL = "
        SELECT id, disponibilidade, bairro, vlrimovel, proprietario, tipo,quartos, suites, codprop, area, piscinasimcasa, piscinanaocasa, detalhes, numap, andar, valorcon
        FROM Imovel
    ";

    // Prepara a consulta
    if (!$stmt = $conn->prepare($SQL))
        throw new Exception("Falha na operacao prepare: " . $conn->error);

    // Executa a consulta
    if (!$stmt->execute())
        throw new Exception("Falha na operacao execute: " . $stmt->error);

    // Indica as variáveis PHP que receberão os resultados
    if (!$stmt->bind_result($id, $disponibilidade, $bairro, $vlrimovel, $proprietario, $tipo, $quartos, $suites, $codprop, $area, $piscinasimcasa, $piscinanaocasa, $detalhes, $numap, $andar, $valorcon))
        throw new Exception("Falha na operacao bind_result: " . $stmt->error);

    // Navega pelas linhas do resultado
    while ($stmt->fetch()) {
        $imovel = new Imovel();

        $imovel->id = $id;
        $imovel->disponibilidade = $disponibilidade;
	$imovel->bairro = $bairro;
	$imovel->vlrimovel = $vlrimovel;
        $imovel->proprietario = $proprietario;
        $imovel->tipo = $tipo;
        $imovel->quartos = $quartos;
        $imovel->suites = $suites;
        $imovel->codprop = $codprop;
        $imovel->area = $area;
        $imovel->piscinasimcasa = $piscinasimcasa;
        $imovel->piscinanaocasa = $piscinanaocasa;
        $imovel->detalhes = $detalhes;
        $imovel->numap = $numap;
        $imovel->andar = $andar;
        $imovel->valorcon = $valorcon;
 
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
  <h2 style="margin-bottom: 20px;">6. Imóveis Cadastrados</h2>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>V/L</th>
        <th>Bairro</th>
        <th>Valor</th>
        <th>Dono</th>
        <th>Tipo</th>
        <th>Quartos</th>
        <th>Suites</th>
        <th>CodDono</th>
        <th>Área</th>
        <th>PiscinaS</th>
        <th>PiscinaN</th>
        <th>Detalhes</th>     
        <th>NºAp</th>
        <th>Andar</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>
<?php

        if ($arrayImoveis != null) {

            foreach ($arrayImoveis as $imovel) {
                echo "
                    <tr>
                       <td>$imovel->id</td>
         <td>$imovel->disponibilidade</td> 
	 <td>$imovel->bairro</td>
	 <td>$imovel->vlrimovel</td>
         <td>$imovel->proprietario</td> 
         <td>$imovel->tipo</td>
         <td>$imovel->quartos</td>
         <td>$imovel->suites</td>
         <td>$imovel->codprop</td>
         <td>$imovel->area</td>
         <td>$imovel->piscinasimcasa</td>
         <td>$imovel->piscinanaocasa</td>
         <td>$imovel->detalhes</td>
         <td>$imovel->numap</td>
         <td>$imovel->andar</td>
         <td>$imovel->valorcon</td>
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
