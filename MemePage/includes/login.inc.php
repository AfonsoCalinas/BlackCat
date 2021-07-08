<?php
// Aqui vamos querer saber se o utilizador está a tentar fazer login, ou seja,
// a tentar aceder a login.inc.php da maneira correta que será introduzir os seus
// dados e clicar login/submit
if (isset($_POST["submit"])) {
  echo "aqui";
  // Aqui vamos introduzir métodos POST para quando o utilizador nos mandar tanto o
  // nome de utilizador como também a password, temos que ir a nossa database
  // ver se ele está a introduzir os dados certos como vamos ver aseguir "require_once..."
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  // Agora vamos fazer um error handler que irá ser declarado em "functions.inc.php"
  if (emptyInputLogin($username, $pwd) !== false) {
    header("location: ../index.php?error=emptyinput");
    exit();
  }

  loginUser($conn, $username, $pwd);
  
}
else {
  header("location: ../index.php");
  exit();
}
