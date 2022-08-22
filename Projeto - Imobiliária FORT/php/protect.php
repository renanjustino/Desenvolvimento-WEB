<?php
if(!isset($_SESSION['login']) and !isset($_SESSION['senha'])){
echo "<script>location.href='/index.php'</script>";
}

?>