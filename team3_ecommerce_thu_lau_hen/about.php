<?php
session_start();
require_once("components/db_connect.php");

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}


?>


<!-- 
---------------- 
    HTML
---------------- 
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- [BOOTSTRAP] -->
    <?php
    $url = "../";
    require_once("components/bootstrap.php");
    ?>
    <title>Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .txt {
        color: #f588d8;
    }
    </style>


</head>

<body
    style="background-image: linear-gradient(to left, rgba(200, 133, 189, 0.7), rgba(120, 133, 189, 0.7)); background-repeat: no-repeat;">
    <!-- [HERO/HEADER] -->
    <?php
    require_once("components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout_url = $img_url = "";
    require_once("components/navbar.php");
    ?>

    <!-- [MAIN] -->
    <main>
        <div class="d-flex justify-content-center align-items-center mt-5 ">
            <h3>Expert Team</h3>
        </div>
        <!-- team cards -->
        <div class="d-flex justify-content-center flex-wrap ">
            <div>
                <div class="card border-2 cardcol  m-3 mb-5 shadow-lg" style="width: 18rem; ">
                    <img id="teamimages" src="pictures/team/andrew.jpg" class="card-img-top" alt="team member image">
                    <div class="card-body col">
                        <h2 class="card-text  mt-3 mb-3">
                            Web Developer
                        </h2>
                        <hr>
                        <h3>
                            Andrew Gorman<sup>*</sup>
                        </h3>

                    </div>
                </div>
            </div>
            <div>
                <div class="card border-2 cardcol  m-3 mb-5 shadow-lg" style="width: 18rem; ">
                    <img id="teamimages" src="pictures/team/vegeta.jpg" class="card-img-top" alt="team member image">
                    <div class="card-body col">
                        <h2 class="card-text  mt-3 mb-3">
                            Web Developer
                        </h2>
                        <hr>
                        <h3>
                            Henry Ngo-Sytchev
                        </h3>
                    </div>
                </div>
            </div>
            <div>
                <div class="card border-2 cardcol  m-3 mb-5 shadow-lg" style="width: 18rem; ">
                    <img id="teamimages" src="pictures/team/Prince.jpg" class="card-img-top" alt="team member image">
                    <div class="card-body col">
                        <h2 class="card-text  mt-3 mb-3">
                            Web Developer
                        </h2>
                        <hr>
                        <h3>
                            Hikmet Prizreni
                        </h3>
                    </div>
                </div>
            </div>
            <div>
                <div class="card border-2 cardcol  m-3 mb-5 shadow-lg" style="width: 18rem; ">
                    <img id="teamimages" src="pictures/team/i can do it.jpg" class="card-img-top"
                        alt="team member image">
                    <div class="card-body col">
                        <h2 class="card-text  mt-3 mb-3">
                            Web Developer
                        </h2>
                        <hr>
                        <h3>
                            Marcela-Laura Moldovan
                        </h3>
                    </div>
                </div>
            </div>
            <div>
                <div class="card border-2 cardcol  m-3 mb-5 shadow-lg" style="width: 18rem; ">
                    <img id="teamimages" src="pictures/team/stitch.jpg" class="card-img-top" alt="team member image">
                    <div class="card-body col">
                        <h2 class="card-text  mt-3 mb-3">
                            Web Developer
                        </h2>
                        <hr>
                        <h3>
                            Peter Kluiber
                        </h3>

                    </div>
                </div>
            </div>
        </div>
        <!-- team cards end  -->
    </main>
    <!-- [FOOTER] -->
    <?php
    $url = "";
    require_once("components/footer.php");
    ?>

    <!-- [BOOTSTRAP SCRIPT] -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>