<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Black Cat</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="test.js"></script>
  <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
  <?php include_once 'header.php'; ?>
  <div class="container">
    <h1 class="h1 text-center">Sign Up</h1>
    <div class="container">
      <form action="includes/signup.inc.php" method="post">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" class="form-control" name="name" placeholder="Full Name...">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" class="form-control" name="email" placeholder="Email...">
        </div>
        <div class="form-group">
          <label for="uid">Username</label>
          <input type="text" class="form-control" name="uid" placeholder="Username...">
        </div>
        <div class="form-group">
          <label for="pwd">Password</label>
          <input type="password" class="form-control" name="pwd" placeholder="Password...">
        </div>
        <div class="form-group">
          <label for="pwdrepeat">Repeat Password</label>
          <input type="password" class="form-control" name="pwdrepeat" placeholder="Repeat Password...">
        </div>
        <button class="btn btn-primary" type="submit" name="submit">Sign Up</button>
      </form>
      <?php
      // Aqui vamos ver se existe um certo URL que nós queremos no URL em que o utilizador se encontra
      // Ou seja, se o utilizador está no URL que nós pensamos que está então vamos fazer algo sobre isso.
      // Quando estamos a declarar este método GET, estamos a declará-lo como uma variável "super global"
      // que é uma variável que vem com o "$" como as outras variáveis mas com um "_" logo aseguir
      // Isso é o que faz uma variável, global
      // Agora queremos ver se o URL dá uma resposta com a palavra "error"
      if (isset($_GET["error"])) {
        // Agora aqui em baixo vamos dar todas as opções de erro que demos nas signup.inc.php
        // Vamos primeiro ver a "emptyinput"
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Fill in all fields!</p>";
        } elseif ($_GET["error"] == "invaliduid") {
          echo "<p>Choose a proper username!</p>";
        } elseif ($_GET["error"] == "invalidemail") {
          echo "<p>Choose a proper email!</p>";
        } elseif ($_GET["error"] == "passwordsdontmatch") {
          echo "<p>Passwords don't match each other!</p>";
        } elseif ($_GET["error"] == "stmtfailed") {
          echo "<p>Something went wrong, try again!</p>";
        } elseif ($_GET["error"] == "usernameemailtaken") {
          echo "<p>Username/Email already taken!</p>";
        } elseif ($_GET["error"] == "none") {
          echo "<p>You have signed up!</p>";
        }
      }
      ?>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>
