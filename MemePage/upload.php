<?php
session_start();
include_once 'includes/dbh.inc.php';
$id = $_SESSION["userid"];
// O propósito deste if é ver se o utilizador acedeu
// ao uploads.php clicando mesmo no botão de submit no index
if (isset($_POST['submit'])) {
    // A variável global "$_FILES" é para receber as informações da
    // imagem que foi enviada pelo form
    // Depois adicionamos parenteses retos com 'file' escrito pois
    // é nesse input chamado file que vai ser enviado o ficheiro
    $file = $_FILES['file'];
    // Aqui estamos a agarrar em todas as informações que temos do ficheiro e a
    // igualar essas informações a variáveis para mais tarde as usarmos
    // Todas estas informações pelo nome nós percebemos o que são mas por exemplo
    // tmp_name é o nome temporário que o ficheiro tem e costuma ser o diretório do ficheiro
    // error é quando no processo de upload do ficheiro existe um problema/erro
    // O name é o nome do ficheiro com a extensão incluído
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    // Aqui vamos querer usar a função explode do php para podermos separar a extensão do ficheiro ao nome
    // para podermos aseguir dizer que só queremos certos tipos de ficheiro a serem uploaded/enviados
    // Primeiro dentro desta função escrevemos onde está a divisão desta string (nome) e depois dizemos que
    // a string é o nome do ficheiro
    $fileExt = explode('.', $fileName);
    // Aqui nós vamos usar mesmo a extensão do ficheiro e como muitas vezes nós temos ficheiros png com a extensão
    // em maiusculas (PNG) então, com esta função built-in no php (strtolower) temos a certeza que recebemos sempre a extensão em minusculas
    // Com a função end nós vamos obter a ultima parte do explode que nós fizemos, e a última parte vai ser sempre a extensão
    // de seguida introduzimos a variável a qual igualámos o explode
    $fileActualExt = strtolower(end($fileExt));
    // Aqui dizemos quais são as extensões possíveis
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    // Aqui vamos fazer um if que tem como propósito ver se a extensão do ficheiro ($fileActualExt) está mesmo no array de
    // extensões possíveis ($allowed)
    if (in_array($fileActualExt, $allowed)) {
      // Aqui é para vermos se ao darmos upload da imagem se deu erro
      if ($fileError === 0) {
        // Aqui vemos se a imagem tem menos de 50MB, se sim então pode seguir
        if ($fileSize < 50000000) {
          // Por exemplo um utilizador 1 der upload de um ficheiro chamado teste.png e depois
          // outro utilizador 2 der upload de um ficheiro com o mesmo nome, o ficheiro do utilizador 1 seria apagado e é aqui que vamos prevenir isso
          // Com esta função que está built-in no php, estamos a dizer que o novo nome do ficheiro é as horas, os minutos, segudos e até os milisegundos de quando foi uploaded
          // desta maneira é impossível existirem ficheiros com o mesmo nome
          // Como este novo nome do ficheiro não tem a extensão incluída então vamos ter que adicionar a extensão
          // Para isso vamos escrever .".". e o que isto faz é escrever um ponto no nome do ficheiro (o ponto que está dentro das aspas) e depois introduzimos a extensão
          // Os pontos que estão fora das aspas são para separar o que estamos a adicionar ao nome, porque nós não podemos simplesmente adicionar tudo junto
          $fileNameNew = "profile".$id.".".$fileActualExt;
          // Aqui dizemos qual é o destino do ficheiro enviado e guardamos essa informação numa variável
          $fileDestination = 'profileimages/'.$fileNameNew;
          // E agora com esta função built-in no php vamos fazer com que o ficheiro seja movido da sua localização temporaria
          // para a localização que nós desejamos e que guardámos há pouco numa variável
          move_uploaded_file($fileTmpName, $fileDestination);
          $sql = "UPDATE profile SET status=0 WHERE userid='$id';";
          $result = mysqli_query($conn, $sql);
          header("Location: profile.php?uploadsuccess");
        }else {
          echo "This file is too big!";
        }
      } else {
        echo "There was an error uploading this file!";
      }
    } else {
      echo "You cannot upload files of this type!";
    }
}
