<?php
// Isto faz com que tenhamos uma sessão em todas as partes do nosso website
session_start();
require 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Black Cat</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="web_images/favicon.png" type="image/png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="test.js"></script>

</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class=" mb-5" style="background-color: #0A1F33;">
            <h1 class="h1 mb-5 text-white">The Memes Page</h1>
            <?php
            if ($_SESSION['useruid']) :
                $sql = "SELECT `title_meme`, `pub_meme`, `desc_meme`, `user_meme`, `type_meme` FROM `memes`";
                $state = mysqli_query($conn, $sql);
                $rows = mysqli_num_rows($state);

                while ($row = mysqli_fetch_assoc($state)) :

                    if ($row['type_meme'] == 1) :
            ?>
                        <div class="container" style="width: min-content;">
                            <div class="float-left">
                                <h3 class="h3 mb-3 text-white"><?php echo $row['title_meme'] ?></h3>
                            </div>
                            <div class="float-right mb-0">
                                <p class="text-white" style="text-align: right;">Created by: <?php echo $row['user_meme'] ?></p>
                            </div>
                            <center>
                                <video controls width="600px">
                                    <source src="<?php echo $row['pub_meme'] ?>" type="video/mp4">
                                </video>
                            </center>
                            <p class="lead mt-3 mb-5 text-white"><?php echo $row['desc_meme'] ?></p>
                        </div>
                        <br><br>
                    <?php
                    endif;
                    if ($row['type_meme'] == 0) :
                    ?>
                        <div class="container mb-5" style="width: min-content;">

                            <div class="float-left">
                                <h3 class="h3 mb-3 text-white"><?php echo $row['title_meme'] ?></h3>
                            </div>
                            <div class="float-right mb-0">
                                <p class="text-white" style="text-align: right;">Created by: <?php echo $row['user_meme'] ?></p>
                            </div>
                            <center>
                                <img class="img-responsive" src="<?php echo $row['pub_meme'] ?>" alt="image meme" width="600px">
                            </center>
                            <p class="lead mt-3 mb-5 text-white"><?php echo $row['desc_meme'] ?></p>
                        </div>
                        <br><br>
            <?php
                    endif;
                endwhile;
                mysqli_close($conn);
            endif;
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>
