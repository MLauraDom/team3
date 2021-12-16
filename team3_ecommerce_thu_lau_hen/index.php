<?php
session_start();
require_once("components/db_connect.php");

$sql_count ="SELECT  COUNT(review) as c from reviews where rating=5";
$query_count = mysqli_query($connect, $sql_count);
$result_count = mysqli_fetch_all($query_count, MYSQLI_ASSOC);
$no=0;

if ($result_count[0]['c'] >= 5 ) { 
    $no=5;
} else {
    $no = $result_count[0]['c'];
}

$sql_review = "SELECT users.picture as upic, first_name, last_name, review, product_name, fk_user_id FROM users join reviews on reviews.fk_user_id=users.user_id join products on reviews.fk_product_id=products.product_id WHERE rating=5 group by fk_user_id";
$query_review = mysqli_query($connect, $sql_review);
$result_review = mysqli_fetch_all($query_review, MYSQLI_ASSOC);
$reviews = "";


if ($no!=0) {
    for ($i=0; $i<=$no; $i++) {
        $reviews .= "<div class='col'>
            <div class='shadow border border-muted rounded-3 border-2 py-3 px-3 mx-2 mb-5' style='width: 30ch;'>

                    <!-- user avatar  -->
                    <img class='img-fluid mb-3' width='80px;' src='pictures/{$result_review[$i]['upic']}' alt='{$result_review[$i]['first_name']} {$result_review[$i]['last_name']}'>

                    <!-- user information: name, location, review date -->
                    <h6 class='text-start'>{$result_review[$i]['first_name']} {$result_review[$i]['last_name']}<br>
                        <small class='text-secondary fw-lighter'>About {$result_review[$i]['product_name']}</small>
                    </h6>
                    <hr class='mt-0 mb-2'>

                    <!-- stars -->
                    <p class='text-center text-warning'>&starf;&starf;&starf;&starf;&starf;</p>
                    <!-- text -->
                    <p>{$result_review[$i]['review']}</p>
                </div></div>";
    }
} else {
    header("location: error.php");
}
mysqli_close($connect);
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
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&display=swap" rel="stylesheet">
    <style>
        header {
            position: relative;
            margin: 0;
            height: 35vh;
            background: black url('pictures/heroindex.jpg') no-repeat center center;
            background-size: auto;
        }
    </style>
    <title>Welcome to our magical Kingdom!</title>
</head>

<body>
    <!-- HEADER -->
    <!-- [Here comes the code for HEADER] -->
    <!-- temporary header: 
    --------------------------------------------
    ATTENTION: TAKE OUT THE INLINE CSS STYLING 
    -------------------------------------------- --->
    <header style="position: relative; margin: 0;">
        <!-- <img  style="width: 100%; margin-top:-500px; object-fit: cover" src="https://cdn.pixabay.com/photo/2017/10/11/21/24/analogue-2842521_960_720.jpg" alt="hero_image"> -->
        <p style="position: absolute; font-size: 2.5rem; font-weight: lighter; font-style: italic; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', 'serif'; color: white; bottom: 20px; left: 50px;">Magic Kingdom</p>
    </header>

    <!-- NAVBAR -->
    <!-- [Here comes the code for NAVBAR] -->



    <!-- MAIN -->
    <!-- [Here comes the code for MAIN] -->
    <main class="py-5">
        <div class="container text-center mt-0">

            <!-- REGISTRATION & LOGIN -->
            <p class="text-end border-top border-bottom border-dark py-2">
                <span class="<?= (@($_SESSION['adm']) or @($_SESSION["user"])) ? '' : 'd-none'; ?>">
                    <a class="mx-2" href="products/index.php">Return to Website</a>
                </span>
                <!-- registration -->
                <span class="<?= (@($_SESSION['adm']) or @($_SESSION["user"])) ? 'd-none' : ''; ?>">|
                    <a class="mx-2" href="register.php"> Register </a>
                </span>
                <!-- login -->
                <span class="<?= (@($_SESSION['adm']) or @($_SESSION["user"])) ? 'd-none' : ''; ?>">|
                    <a class="mx-2 <?= (@($_SESSION['adm']) or @($_SESSION["user"])) ? 'd-none' : ''; ?>" href="login.php"> Login</a>
                </span>
            </p>


            <!-- CONTENT: Title, text -->
            <h1 class="fw-lighter display-5 text-dark" style="font-family: 'UnifrakturMaguntia', cursive;">Welcome,</h1>
            <h3 class="fw-lighter fs-3 m-0 text-dark" style="font-family: 'UnifrakturMaguntia', cursive;">to</h1>
                <h1 class="display-2 fw-bolder mb-5 text-success" style="font-family: 'Fleur De Leah', cursive;">The Magic Kingdom</h1>
                <img class="img-fluid rounded" src="pictures/book.jpg" alt="banner">
        </div>

        <!-- Article -->
        <article class="mx-auto w-75" style="width: 100%;">
            <br><br><br>
            <h3 class="mb-3 py-0 fw-lighter">Your <span class="fw-bold text-success">Wishes</span> are Our outmost <span class="fw-bold text-success">Priority</span></h3>
            <p class="mt-5 mb-3">Step inside into our magical world, and all your Wishes can bekome true! </p>
            <p class="mt-5 mb-3">Let's see how satisfied our locals are:  </p>
        </article>

        <br><br><br>

        <!-- reviews -->
        <section class="d-flex justify-content-around mb-5 mx-auto w-75">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <!-- [CUSTOMER REVIEW] -->
                <?php echo $reviews ?>
            </div>
        </section>

        <!-- Temporary Footer -->
        <p class="text-center text-muted border-top border-bottom border-dark py-5">- All rights reserved -<br> <small class="">Team 3&copy;2021</small>
        </p>


        </div>
    </main>

    <!-- FOOTER -->
    <!-- [Here comes the code for FOOTER] -->
    <!-- <footer class="py-5">

    </footer> -->

</body>

</html>