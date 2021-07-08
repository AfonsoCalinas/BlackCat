<?php

  // Agora aqui vamos fazer o nosso logout
  // Comecamos por comecar uma sessão porque sem uma não conseguimos apagar nenhuma
  session_start();
  // Esta função do php apaga as informações da sessão mas a sessão ainda existe
  session_unset();
  // E aqui finalmente apagamos a sessão por completo
  session_destroy();

  header("location: ../index.php");
  exit();
?>
