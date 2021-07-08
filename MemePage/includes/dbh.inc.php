<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dbName = "phpproject01";

// A variavel conn é uma variavel que vai conectar o nosso website à database
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dbName);

if (!$conn) {
  // A função mysqli_connect_error irá retornar um string com o erro que ocorreu
  die("Connection Failed: " . mysqli_connect_error());
}
