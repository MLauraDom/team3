<?php
session_start();
require_once '../../components/db_connect.php';

if (isset($_SESSION['user']) != "") {
    header("Location: ../../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_POST) {
    $review_id = $_POST["review_id"];
    $question = $_POST["question"];

    if ($question !== NULL) {
        $sql = "Update reviews SET rating = NULL, review = NULL WHERE review_id = '{$review_id}';";
    } else {
        $sql = "DELETE FROM reviews WHERE review_id = '{$review_id}';";
    }

    if (mysqli_query($connect, $sql) === true) {
        $title = "<i class='bi bi-check2-circle pe-2'></i>Congratulations";
        $class = "success";
        $message = "<p class='mt-4 mb-5 fs-5'>The Review has been successfully <b>Deleted</b>!</p>";
    } else {
        $title = "<i class='bi bi-shield-exclamation-octagon pe-2'></i>ATTENTION";
        $class = "danger";
        $message = "<h2></h2>
            <p class='mt-3 mb-5'>The review has not been deleted: <br>"
            . $connect->error . "</p>";
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}

?>


<!-- 
------------------
    HTML
------------------ 
-->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php") ?>
    <title>Delete</title>
</head>

<body>
    <!-- [HERO/HEADER] -->
    <?php
    require_once("../../components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout_url = $img_url = "../../";
    require_once("../../components/navbar.php");
    ?>

    <!-- [MAIN] -->
    <main>
        <main class="m-0 py-5">
            <div class="container mb-3">
                <div
                    class='alert alert-muted border border-3 border-<?= $class; ?> text-center text-<?= $class; ?> pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
                    <h1><?= $title ?></h1>
                    <hr class='bg-<?= $class; ?> py-1 mx-auto w-75'>
                    <p><?= $message; ?></p>
                    <a href='../../reviews.php'><button
                            class="btn btn-outline-<?= $class; ?> mx-auto mb-2 py-0 px-5 fw-bold w-25"
                            type='button'>OK</button></a>
                </div>
            </div>
        </main>
        <!-- [FOOTER] -->
        <?php
        $url = "../../";
        require_once("../../components/footer.php");
        ?>
</body>

</html>