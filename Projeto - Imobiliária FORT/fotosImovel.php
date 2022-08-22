<?php
session_start();

include("php/protect.php");
// Include the database configuration file
include 'php/dbConfig.php';
require "php/conexaoMysql.php";
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
  <h2 style="margin-bottom: 20px;">7. Fotos dos Imóveis Cadastrados</h2>
  <table class="table table-striped centered table-hover">
    <tbody>
<?php
$query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'upload/'.$row["file_name"];
?><tr>
    <td align="center"><img src="<?php echo $imageURL; ?>" alt="" width="70px" height="70px" /></td>
    </tr>
<?php }
}else{ ?>
    <p>Nenhuma imagem encontrada...</p>
<?php } ?>	
    </tbody>
  </table>
  </div>  
</div>
</body>
 <?php include "php/footer.php"; ?>
</html>