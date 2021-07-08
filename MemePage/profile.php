<?php
// Isto faz com que tenhamos uma sessão em todas as partes do nosso website
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Black Cat</title>
  <link rel="icon" href="web_images/favicon.png" type="image/png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="test.js"></script>
  <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
  <?php include_once 'header.php'; ?>
  <div class="container">
    <h2 class="h2 mb-3 mt-3 mb-5 text-center">Profile</h2>
    <div class="row m-3">
      <div class="col-md-3" style=" border-right: 1px solid;">
        <center>
          <?php profileDisplay($conn); ?>
          <h4 class="h4 mt-3">
            <?php
            echo $_SESSION['useruid'];
            if ($_SESSION["userid"] < 4) { echo "(admin)"; }
            ?>
          </h4>
        </center>
        <div class="m-5">
          <form action='upload.php' method='POST' enctype='multipart/form-data' class="form-inline">
            <div class="form-group">
              <input class="form-control-file border" type='file' name='file'>
            </div>
            <center>
              <button class="btn btn-primary mt-2" type='submit' name='submit' style="width: 310px;">Upload</button>
            </center>
          </form>
          <br>
          <?php if ($_SESSION["userid"] < 4) : ?>
            <form action="./pdf/pdfgen.php" method="POST" target="_blank">
              <button class="btn btn-primary" type='submit' name='create_pdf' style="width: 310px;">Create PDF</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-9">
        <div class="container">
        </div><br><br>
        <div class="container m-auto" style="width: 50%;">
          <form action='' method='POST' enctype='multipart/form-data'>
            <div class="form-group row">
              <label for="title_meme" class="col-sm-3 col-form-label"><b>Title</b></label>
              <div class="col-sm-9">
                <input class="form-control " type='text' name='title_meme' required>
              </div>
            </div>
            <div class="form-group row">
              <label for="pub_meme" class="col-sm-3 col-form-label"><b>Upload Image</b></label>
              <div class="col-sm-9">
                <input class="form-control-file border " type='file' name='pub_meme' required>
              </div>
            </div>
            <div class="form-group row">
              <label for="desc_meme" class="col-sm-3 col-form-label"><b>Description</b></label>
              <div class="col-sm-9">
                <input class="form-control " type='text' name='desc_meme'>
              </div>
            </div>
            <button class="btn btn-primary float-right mb-2 btn-lg btn-block" type='submit' name='up_meme'>Upload</button>
          </form>

        </div>
      </div>
    </div>
    <?php
    if (isset($_POST['up_meme'])) {

      $title_meme = $_POST['title_meme'];
      $date_meme = date('d-m-Y');
      $time_meme = date('H:m');
      $desc_meme = $_POST['desc_meme'];
      $user_meme = $_SESSION['useruid'];


      $target_meme = "folder_memes/";
      $pub_meme = $_FILES['pub_meme']['name'];
      $temp_pub_meme = $_FILES['pub_meme']['tmp_name'];
      $target_file = $target_meme . basename($pub_meme);
      $type_file =  mime_content_type($temp_pub_meme);
      $its_ok = 1;
      $its_video = 0;

      if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $its_ok = 0;
      }

      if ($type_file != "video/mp4" && $type_file != "image/jpeg" && $type_file != "image/jpg" && $type_file != "image/gif" && $type_file != "image/png") {
        echo "ficheiro inválido";
        $its_ok = 0;
      }

      if ($type_file == "video/mp4") {
        $its_video = 1;
      }
      if ($its_ok == 1) {
        try {
          $sql = "INSERT INTO `memes`(`date_meme`, `time_meme`, `title_meme`, `pub_meme`, `desc_meme`, `user_meme`, `type_meme`) VALUES(?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $sql);
          mysqli_stmt_bind_param($stmt, 'sssssss', $date_meme, $time_meme, $title_meme, $target_file, $desc_meme, $user_meme, $its_video);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
          move_uploaded_file($temp_pub_meme, $target_file);
        } catch (Exception $e) {
          echo $e->getMessage();
        }
      }
    } ?>
    <?php include_once 'footer.php'; ?>
</body>

</html>
