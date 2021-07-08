  <?php
  require 'includes/dbh.inc.php';
    require 'includes/functions.inc.php';
  ?>
  <nav class="navbar navbar-expand-md justify-content-between" id="topo">
    <a class="navbar-brand" href="./index.php">
      <img class="img-responsive" src="./web_images/favicon.png" width="15%">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about_us.php">About Us</a>
        </li>
        <?php if (isset($_SESSION["useruid"])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="see_memes.php">See Memes</a>
          </li>
        <?php endif; ?>
      </ul>
      <?php
      // Agora aqui vamos ver se o utilizador está logged-in ou não
      if (isset($_SESSION["useruid"])) : ?>
        <ul class="navbar-nav my-2 my-lg-0 ml-auto">
          <li class="nav-item">
            <a class="nav-link" href='profile.php'>
              <?php profileDisplaySmall($conn); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link mt-2" href='includes/logout.inc.php'><b>Log out</b></a>
          </li>
        </ul>
      <?php endif; ?>
      <?php include 'login.php'; ?>
    </div>
  </nav