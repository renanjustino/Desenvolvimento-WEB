<?php

define("HOST", "");
define("USER", "");
define("PASSWORD", "");
define("DATABASE", "");

function conectaAoMySQL()
{
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conn->connect_error)
        throw new Exception('Falha na conexão com o MySQL: ' . $conn->connect_error);

    return $conn;
}

?>