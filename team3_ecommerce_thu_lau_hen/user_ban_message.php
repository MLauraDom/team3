<?php
// session_start(); // start a new session or continues the previous

if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home page
}

// if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {//redirects non users to the welcome page
//     header("Location: index.php");
//     exit;
// }

require_once 'components/db_connect.php';

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Ban</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <!-- [CSS] -->
    <style>
    main {
        height: 100vh;
    }
    </style>
</head>

<!-- ------------------------
        HTML
------------------------ -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php
    require_once("components/bootstrap.php");
    ?>
    <!-- [CSS] -->
    <style>
    main {
        min-height: 80vh;
        padding: 3% 15%;
    }
    </style>
    <title>Product Details</title>
</head>

<body>
    <!-- [HERO/HEADER] -->
    <?php
    require_once("components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout = $img_url = "";
    require_once("components/navbar.php");
    ?>

    <!-- [MAIN] -->
    <main>
        <!-- notification banned user: start -->
        <div class="border border-3 border-danger text-center text-dark pt-5 pb-3 mx-auto mt-0 mb-5 w-100">
            <h1 class="text-danger"><i class="bi bi-shield-exclamation pe-2"></i>WARNING</h1>
            <hr class="bg-danger py-1 mx-auto w-75">
            <div class="fs-5 p-3">
                <p>The access of your account has been <b>restricted</b>.</p>
                <p>For additional information, please get in touch with us.</p>
            </div>
            <div class="m-0 p-0">
                <p class="text-center mt-2 mb-3">
                    <a href="contactus.php"><span class="btn btn-danger py-0 px-3 mx-2 w-25">Contact</span></a>
                    <a href="index.php"><span class="btn btn-outline-dark py-0 px-3 mx-2 w-25">No, thanks</span></a>
                </p>
            </div>
        </div>
        <!-- notification banned user: end -->
    </main>

    <!-- [FOOTER] -->
    <?php
    $url = "";
    require_once("components/footer.php");
    ?>
</body>

</html>