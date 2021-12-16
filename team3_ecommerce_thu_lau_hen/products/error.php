<?php 
    session_start();
    require_once("../components/db_connect.php");
    
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit;
    }
?>
<!-- ------------------------
        HTML
------------------------ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../components/bootstrap.php")?>
    <!-- [CSS] -->
    <style>
        main{
           min-height: 100vh;
       }
    </style>
    <title>Error Page!</title>
</head>
<body>
    <!-- [HERO/HEADER] -->
    <?php
        require_once("../components/hero.php"); 
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout_url = $img_url = "../";
    require_once("../components/navbar.php"); 
    ?>

    <!-- [MAIN] -->
<main>
    <section class="container-fluid">
        <div class='border border-3 border-danger text-center text-danger pt-5 pb-3 mx-auto my-5 w-75'>
            <h1><i class='bi bi-exclamation-octagon pe-2'></i>ERROR</h1>
            <hr class='bg-danger py-1 mx-auto w-75'>

            <p class="my-5">There is an issue with the action you have performed.
            <br>Please, try again.</p>

            <a href="index.php"><button class='btn btn-danger py-0 px-3 mx-2 w-25' type='submit'>OK</button>
            </p></a>
        </div>
    </section>    
</main>
    <!-- [FOOTER] -->
    <?php 
        require_once("../components/footer.php"); 
    ?>
</body>
</html>