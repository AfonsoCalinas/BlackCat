<?php

  // Aqui em functions.inc.php vamos declarar todas as funcoes que chama-mos em
  // signup.inc.php, cada uma precisa do nome e dos parâmetros necessários.
  // As funções vão ser sempre declaradas dentro de chavetas e chamadas "function"
  // logo ao inicio, para dizer ao php que isto é uma funcao, qual é e o que faz

  function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    // Esta variavel "$result" é aquela que vai retornar true ou false para
    // os "if's" que vamos declarar
    $result;
    // esta funcao empty está built-in no php e vai ver se existem dados ou não
    // dentro dos parametros que inserir nesta função
    // Usamos "||" para dizer "OU", ou seja, sempre que houver um destes campos/parametros
    // vazios, então temos que retornar um erro
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
      // $result é true porque se houver algum dos campos vazios o utilizador não pode inscrever-se
      // no website, ou seja dá um erro ($result = true)
      $result = true;
    }
    else {
      // Aqui $result é false porque o utilizador preencheu todos os campos
      $result = false;
    }
    // Aqui temos de dar à nossa função o resultado para que em signup.inc.php
    // A função decorra normalmente
    return $result;
  }

  function invalidUid($username) {
    $result;
    // preg_match é uma função built-in em php que diz quais são os
    // caratéres possíveis de introduzir neste parâmetro de Username
    // neste caso deixamos que as letras maiúsculas e minúsculas de A a Z
    // possam fazer parte e também os números de 0 a 9, todos os carateres
    // tais como "/&%$#!_-.:,;", por exemplo, não vão ser aceites

    // Como nós queremos declarar primeiro o erro, então vamos escrever
    // um "!" antes do preg_match para dizer ao php que
    // Se o utilizador escrever um username que NÃO esteja neste grupo de
    // carateres, então retorna um erro
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
      // $result é true porque o utilizador escreveu um carater que não
      // faz parte do grupo de carateres disponíveis
      $result = true;
    }
    else {
      // Aqui $result é false porque o utilizador escreveu um username disponível
      $result = false;
    }
    // Aqui temos de dar à nossa função o resultado para que em signup.inc.php
    // A função decorra normalmente
    return $result;
  }

  function invalidEmail($email) {
    $result;
    // filter_var é uma função built-in em php que filtra a variável
    // dentro desta função e com o método de validação descrito aseguir
    // Neste exemplo filtra-mos o email introduzido com o método "FILTER_VALIDATE_EMAIL"

    // Como queremos que $result seja true quando existe um erro então
    // introduzimos um "!" antes desta função
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $result = true;
    }
    else {
      $result = false;
    }
    // Aqui temos de dar à nossa função o resultado para que em signup.inc.php
    // A função decorra normalmente
    return $result;
  }

  function pwdMatch($pwd, $pwdRepeat) {
    $result;
    // Aqui dizemos, SE a password introduzida não for igual à repetição
    // da password então retorna um erro ($result = true)
    if ($pwd !== $pwdRepeat) {
      $result = true;
    }
    else {
      $result = false;
    }
    // Aqui temos de dar à nossa função o resultado para que em signup.inc.php
    // A função decorra normalmente
    return $result;
  }

  function uidExists($conn, $username, $email) {
    // Aqui declaramos uma variável que é um comando sql
    // Escrevemos "?" e dizemos que é um placeholder porque vamos usar "prepared statements"
    // para nos conectarmos à database, o que quer dizer que nós NÃO agarramos na informação
    // que o utilizador nos deu e enviamos logo para a database, porque isso pode fazer a nossa
    // database vulnerável a ataques (Injeção de SQL)

    // Nota adicional 1, "prepared statements" são comandos SQL

    // Nota adicional 2, "users" é o nome da tabela dentro da nossa database e "usersUid","usersEmail" é a coluna
    // de usernames/emails dentro da tabela "users"

    // Nota adicional 3, o primeiro ";" é para fechar o comando SQL e o segundo ";" é para o código PHP
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    // Aqui estamos a iniciar uma prepared statement e para a iniciarmos precisamos
    // de lhe dar conexão à database ($conn)
    // Depois vamos dar attach do comando SQL ou seja $sql, para termos a certeza
    // que a informação dada não é executada na nossa database
    // No fim, estamos a deixar o utilizador escrever informação separadamente e a este
    // processo todo chamamos de Preparação da Prepared Statement
    $stmt = mysqli_stmt_init($conn);
    // Aqui em baixo vamos ver se a Preparação da Prepared Statement foi bem sucedida
    // com "mysqli_stmt_prepare"

    // Adicionamos um "!" para fazermos o erro primeiro
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../signup.php?error=stmtfailed");
      // exit para esta função quando o seu propósito foi cumprido
      exit();
    }

    // Se o utilizador conseguir registar-se então aqui é aqui que vai mandar a
    // informação para a database

    // "mysqli_stmt_bind_param" serve para juntarmos a informação que o utilizador introduziu
    // à prepared statement

    // Dentro desta função vamos introduzir a nossa prepared statement em primeiro
    // e depois perguntamo-nos que tipo de informação é que estamos a introduzir na
    // nossa database. Como neste caso so queremos o username e o email, ou seja duas strings,
    // escrevemos "ss" que representa duas strings.
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    // Agora que temos a nossa prepared statement completa, vamos executá-la
    // Esta execução baseia-se em agarrar na informação igual à introduzida pelo utilizador
    // se esta função conseguiu agarrar algo username ou email igual ao que o utilizador
    // introduziu então temos que dizer ao utilizador que esse username/email já foi usado
    mysqli_stmt_execute($stmt);

    // "mysqli_stmt_get_result" vai ver qual foi o resultado da prepared statement
    // ou seja $stmt
    $resultData = mysqli_stmt_get_result($stmt);

    // esta função "mysqli_fetch_assoc" vai buscar à database a informação que foi introduzida
    // pelo utilizador. Se conseguir encontrar essa informação equivalente, então vai dar true
    // senão irá dar false

    // Nós vamos vamos usar esta função com um propósito duplo. Nós não só queremos que se der false
    // continue com o signup do user, mas também queremos ver se a função "mysqli_fetch_assoc" encontrou
    // mesmo informação então podemos utiliza-la para perguntar ao utilizador se já se registou e utilizar esta informação para
    // a página de login, por isso é que igualá-mos esta função a $row e retorna-mos $row.

    // Nota Adicional 1, a função corre na mesma mesmo tendo igualado a função a uma variável nova

    if ($row = mysqli_fetch_assoc($resultData)) {
      // estamos a dar return de $row para podermos usar para outros propósitos, tais como,
      // levar o utilizador à pagina de login com o nome de utilizador já existente que ele introduziu
      return $row;
    }
    else {

      $result = false;
      return $result;
    }
    // Agora só precisamos de fechar a prepared statement
    mysqli_stmt_close($stmt);
  }

  // Agora que o utilizador conseguiu não errar em absolutamente nada enquanto dava
  // sign-up, vamos passar à parte em que o inscrevemos na plataforma
  function createUser($conn, $name, $email, $username, $pwd) {
    // Aqui em baixo, vamos escrever então um novo comando SQL que vai inserir os dados que o utilizador
    // introduziu. "INSERT INTO" é para inserir informações numa tabela ou seja na tabela users que está na nossa base de dados.
    // "users" é o nome da tabela. Dentro dos parênteses estão as informações que a nossa database precisa. E se te perguntares
    // porque é que de entre os valores, a PwdRepeat não está lá, é porque a PwdRepeat era apenas para ter a certeza que o
    // utilizador se inscreve com a password que quer e não uma com um erro.
    // Temos 4 "?" pois, como vimos há pouco, estamos a usar placeholders, prepared statements e claro que estamos a trabalhar com
    // 4 valores
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    // Depois vamos fazer muito parecido ao que fizemos em cima, ou seja, vamos chamar uma prepared statement,
    // que vai precisar da conexão à nossa database, e depois o "if" aseguir vai dizer se o comando sql ($sql)
    // é possível de executar ou não. Se não, então o utilizador é redirecionado para a pagina de signup com um erro
    // no URL
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../signup.php?error=stmtfailed");
      exit();
    }
    // Esta função "password_hash" é uma função built-in no php que faz com que as passwords
    // sejam encriptadas com o algoritmo mais recente de hashing em php
    // No caso de o php achar que este algoritmo está outdated ele atualiza automáticamente para ter
    // a versão mais recente de encriptação.
    // Aqui escrevemos "$pwd" que é a password introduzida pelo utilizador e depois escrevemos como a vamos
    // encriptar ou seja "PASSWORD_DEFAULT".
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    // Se a prepared statement não falhar então continuamos para o sign up do utilizador
    // Aqui temos 4 strings, por isso em vez de termos "ss" como fizemos na função declarada anteriormente
    // colocamos 4 ou seja "ssss"

    // Agora vamos fazer password hashing, para no caso de algum hacker conseguir ter acesso à nossa
    // database NÃO ter acesso a todas as palavras passe de todos os utilizadores no website
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT * FROM users WHERE usersUid='$username' AND usersName='$name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // Aqui estamos a dizer que row é a informação do utilizador que acabamos de inscrever na database
      while ($row = mysqli_fetch_assoc($result)) {
        // Agora nós precisamos do id do utilizador que está dentro da coluna dele
        $userid = $row['usersId'];
        $useruid = $row['usersUid'];
        $sql = "INSERT INTO profile (userid, userUid, status) VALUES ('$userid', '$useruid', 1)";
        mysqli_query($conn, $sql);
      }
    } else {
      echo "You have an error!";
    }
    // Agora levamos o utilizador para a página de signup mas desta vez com uma mensagem de
    // sucesso ao registar-se nas duas databases
    header("location: ../signup.php?error=none");
    exit();
  }

  function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }

  function loginUser($conn, $username, $pwd) {
    // Lembraste quando fizemos uma função que tinha dois sentidos? Pois é aqui que a vamos chamar
    // Agora vamos criar uma variavel chamada "uidExists" e dizemos que é equivalente à função que
    // criamos em cima chamada uidExists. Esta função comunicava com a database e escrevia um comando SQL para
    // saber se existia ou não um username ou email igual ao que o utilizador introduziu.
    // Agora o que vai acontecer pode confundir um pouco. A função uidExists trabalha com os parâmetros
    // $conn, a conexão coma  database, $username, ou seja o nome de utlizador e o email. O problema aqui é que
    // a função que estamos neste momento a declarar não precisa do email, ou seja, o que vamos fazer é o seguinte.
    // Ao escrevermos em vez de "$conn, $username, $email" escrevemos "$conn, $username, $username", o que vai acontecer
    // aqui é, no comando SQL que esta função declara está "$sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";"
    // Ou seja, o php fica tranquilo pois um dos dois parâmetros "usersUid" ou "usersEmail" está correto e aquele que vai ficar sempre
    // correto é o usersUid pois nós só vamos trabalhar no login com o username e não o email. Por isso é que o email vai ficar sempre
    // false em todas as ocasiões. SE O UTILIZADOR DECIDIR FAZER LOGIN COM O EMAIL EM VEZ DO USERNAME, então no SQL o parâmetro username vai
    // dar false e o parâmetro email vai dar true, mas não nos preocupa porque aqui em baixo escrevemos dois usernames para funcionar tanto
    // com o username como tambem o email
    $uidExists = uidExists($conn, $username, $username);
    // Aqui em baixo tratamos de se o utilizador se enganar a fazer o login (enganado nalgum dos parâmetros de username ou email)
    if ($uidExists === false) {
      header("location: ../login.php?error=wronglogin");
      exit();
    }
    // Aqui vamos ver se a password introduzida está certa
    // Escrevemos parênteses retos com "usersPwd" pois uidExists está a selecionar um dos utilizadores
    // E nesse momento queremos ver se a password introduzida correponde a esse utilizador
    // Por isso temos que dizer ao parâmetro que coluna da nossa database é que queremos a informação
    $pwdHashed = $uidExists["usersPwd"];
    // A função "password_verify" vai ver se os dois parâmetros dentro dela se são iguais, se forem
    // retorna true senão retorna false
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
      // Aqui o utilizador enganou-se na password
      header("location: ../login.php?error=wrongpassword");
      exit();
    }
    else if ($checkPwd === true) {
      // Aqui o utilizador conseguiu entrar e agora temos que abrir uma sessão, com uma função
      // que está built-in no php
      session_start();
      // Agora podemos criar variáveis da sessão, as variáveis globais $_SESSION, para podermos ter acesso a elas
      $_SESSION["userid"] = $uidExists["usersId"];
      $_SESSION["useruid"] = $uidExists["usersUid"];
      // Aqui sendo que o utilizador conseguiu dar login então levamo-lo para a página index
      header("location: ../index.php");
      exit();
    }

  }

  function profileDisplay($conn) {
    // Aqui vamos selecionar a nossa table e pedir informação
    $userId = $_SESSION["userid"];
    $sql = "SELECT * FROM users WHERE usersId='$userId'";
    $result = mysqli_query($conn, $sql);
    // Agora vemos se existem users nesta database com a função built-in no php que nos diz quantas linhas(utilizadores) existem na nossa database
    if (mysqli_num_rows($result) > 0) {
      // Então se temos mesmo utilizadores nesta database então vamos espetá-los num array e guardamos esse array em $row
      while ($row = mysqli_fetch_assoc($result)) {
        // Agora estamos a tirar o id do utilizador e a guardá-lo numa variavel $id
        $id = $row['usersId'];
        // Agora vamos ver à outra database se o utilizador já mudou ou não a sua profile image, que é o valor que vai aparecer em status na database
        $sqlImg = "SELECT * FROM profile WHERE userid = '$id'";
        // Aqui tiramos a informação da linha do utilizador que fomos ver em cima e guardamos essa informação na variável $resultImg
        $resultImg = mysqli_query($conn, $sqlImg);
        // Agora neste while vamos decidir o que vai aparecer no website
        while ($rowImg = mysqli_fetch_assoc($resultImg)) {
          //echo "<div class='user-container'>";
            if ($rowImg['status'] == 0) {
              // Aqui estamos a dizer que a nova foto terá o seguinte nome, profile."id do utilizador".jpg
              // Mais tarde podemos mudar para um gif por exemplo
              echo "<img class='img-responsive rounded' src='profileimages/profile".$id.".jpg?'".mt_rand()." width='50%' height='50%'>";
            } else {
              // Se o utilizador ainda não mudou a foto de perfil então vamos deixar a default
              echo "<img class='img-responsive rounded' src='default/profiledefault.jpg' width='50%' height='50%'>";
            }
            //echo "<br><br><p><b>".$row['usersUid']."</b></p>";
          //echo "</div>";
        }
      }
    }
  }


  function profileDisplaySmall($conn) {
    // Aqui vamos selecionar a nossa table e pedir informação
    $userId = $_SESSION["userid"];
    $sql = "SELECT * FROM users WHERE usersId='$userId'";
    $result = mysqli_query($conn, $sql);
    // Agora vemos se existem users nesta database com a função built-in no php que nos diz quantas linhas(utilizadores) existem na nossa database
    if (mysqli_num_rows($result) > 0) {
      // Então se temos mesmo utilizadores nesta database então vamos espetá-los num array e guardamos esse array em $row
      while ($row = mysqli_fetch_assoc($result)) {
        // Agora estamos a tirar o id do utilizador e a guardá-lo numa variavel $id
        $id = $row['usersId'];
        // Agora vamos ver à outra database se o utilizador já mudou ou não a sua profile image, que é o valor que vai aparecer em status na database
        $sqlImg = "SELECT * FROM profile WHERE userid = '$id'";
        // Aqui tiramos a informação da linha do utilizador que fomos ver em cima e guardamos essa informação na variável $resultImg
        $resultImg = mysqli_query($conn, $sqlImg);
        // Agora neste while vamos decidir o que vai aparecer no website
        while ($rowImg = mysqli_fetch_assoc($resultImg)) {
          //echo "<div class='user-container'>";
            if ($rowImg['status'] == 0) {
              // Aqui estamos a dizer que a nova foto terá o seguinte nome, profile."id do utilizador".jpg
              // Mais tarde podemos mudar para um gif por exemplo
              //echo "<img class='img-responsive rounded' src='profileimages/profile".$id.".jpg?'".mt_rand()." width='50%' height='50%'>";
              echo "<img class='rounded-circle' src='profileimages/profile".$id.".jpg?'".mt_rand()." width='40' height='40'>";
            } else {
              // Se o utilizador ainda não mudou a foto de perfil então vamos deixar a default
              echo "<img class='rounded-circle' src='default/profiledefault.jpg' width='40' height='40'>";
            }
            //echo "<br><br><p><b>".$row['usersUid']."</b></p>";
          //echo "</div>";
        }
      }
    }
  }

