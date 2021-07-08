<?php

if (empty($_SESSION['useruid'])) : ?>
  <form class="form-inline my-2 my-lg-0 ml-auto" action="includes/login.inc.php" method="post">
    <div class="form-group">
      <input class="form-control mr-sm-2" type="text" name="uid" placeholder="Username/Email...">
    </div>
    <div class="form-group">
      <input class="form-control mr-sm-2" type="password" name="pwd" placeholder="Password...">
    </div>
    <button class="btn btn-outline-success my-2 my-sm-0" name="submit" type="submit">Entrar</button>
  </form>
  <a href="signup.php"><button class="btn btn-outline-success my-2 my-sm-0" name="registar" id="registar" type="submit">Registar</button></a>
<?php
endif;
// Aqui vamos ver se existe um certo URL que nós queremos no URL em que o utilizador se encontra
// Ou seja, se o utilizador está no URL que nós pensamos que está então vamos fazer algo sobre isso.
// Quando estamos a declarar este método GET, estamos a declará-lo como uma variável "super global"
// que é uma variável que vem com o "$" como as outras variáveis mas com um "_" logo aseguir
// Isso é o que faz uma variável, global
// Agora queremos ver se o URL dá uma resposta com a palavra "error"
?>