<?php

// isset é uma função built-in em php
// Basicamente vê se o utilizador entrou corretamente nesta página
// Ou seja, sem ter simplesmente escrito o diretorio no URL mas pelo submit
if (isset($_POST["submit"])) {
  // aqui estamos a agarrar nas informações que o utilizador submeteu na pagina de sign up
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdrepeat"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  // Daqui para baixo vamos tentar apanhar todos os erros possíveis
  // E todas estas funcoes iram estar declaradas em functions.inc.php

  // Cada função tem entre parênteses uma variavel, isto é porque, para
  // essa função funcionar como desejado precisa dos parâmetros que nos estamos a referir

  // Uma nota adicional é que aqui usamos "!==" para dizer que
  // se o utilizador conseguir fazer com que esta função dê qualquer
  // outro valor sem ser true então dá erro
  if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
    // a funcao header escreve em cima do link onde estavamos e não só leva-nos ao
    // sitio pretendido (dentro desta função), como também descreve o erro ocorrido
    header("location: ../signup.php?error=emptyinput");
    // exit para esta função quando o seu propósito foi cumprido
    exit();
  }
  // esta funcao vê se o utilizador introduziu um nome de utilizador válido
  if (invalidUid($username) !== false) {
    header("location: ../signup.php?error=invaliduid");
    // exit para esta função quando o seu propósito foi cumprido
    exit();
  }
  // esta funcao vê se o utilizador introduziu um email válido
  if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
    // exit para esta função quando o seu propósito foi cumprido
    exit();
  }
  // esta funcao vê se as palavras passe são iguais e se não foram feitos erros
  // na sua introdução
  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
    // exit para esta função quando o seu propósito foi cumprido
    exit();
  }
  // esta funcao irá verificar se um indivíduo está a tentar inscrever-se
  // no website com um nome de utilizador já usado
  // EX: Utilizador1 chama-se Paulo, logo o Utilizador2 não pode inscrever-se
  // no website com o nome Paulo, pois esse username já está inscrito
  // precisamos da nossa conexão à database ($conn), pois só desta maneira
  // podemos ver se já existe ou não o utilizador em questão
  if (uidExists($conn, $username, $email) !== false) {
    header("location: ../signup.php?error=usernameemailtaken");
    // exit para esta função quando o seu propósito foi cumprido
    exit();
  }

  // esta função, que irá ser declarada em functions.inc.php, vai criar o nosso user
  // na nossa database, pois se chegou até aqui não fez erros nenhuns
  createUser($conn, $name, $email, $username, $pwd);

}
// este "else" vai levar-nos para a pagina de signup no caso de o utilizador tentar
// entrar neste signup.inc.php de forma incorreta, ou seja, manipulando o link
// A unica maneira de "entrar" será fazendo mesmo um submit com dados de um utilizador
else {
  header("location: ../signup.php");
  // exit para esta função quando o seu propósito foi cumprido
  exit();
}
