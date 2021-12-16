<?php
session_start();
require_once '../../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_GET) {
    $user_prod_id = $_GET["id"];
    $sql_check = "SELECT * FROM user_products up JOIN products p ON up.fk_product_id = p.product_id WHERE user_product_id = $user_prod_id;";
    $res_check = mysqli_query($connect, $sql_check);
    $data = mysqli_fetch_assoc($res_check);
    $product_name = $data['product_name'];
    $sql = "DELETE FROM user_products WHERE user_product_id = $user_prod_id;";
    if (mysqli_query($connect, $sql) === true) {
        $title = "<i class='bi bi-check2-circle pe-2'></i>We've taken care of that for you";
        $class = "success";
        $message = "<p class='mt-4 mb-5 fs-5'><i>" . $product_name . "</i> has been successfully <b>Removed</b>!</p>";
    } else {
        $title = "<i class='bi bi-shield-exclamation-octagon pe-2'></i>ATTENTION";
        $class = "danger";
        $message = "<h2></h2>
    <p class='mt-3 mb-5'>Unable to remove from cart now pay or die!!: <br>"
            . $connect->error . "</p>";
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Remove All from Cart</title>
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php") ?>
</head>

<body>
    <div class="container mt-3 mb-3">
        <div
            class='alert alert-muted border border-3 border-<?= $class; ?> text-center text-<?= $class; ?> pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
            <h1><?= $title ?></h1>
            <hr class='bg-<?= $class; ?> py-1 mx-auto w-75'>
            <p><?= $message; ?></p>
            <a href='../index.php'><button class="btn btn-outline-dark mx-auto mb-2 py-0 px-5 fw-bold w-25"
                    type='button'>Back to shop</button></a>
        </div>
    </div>
    <div class="container">
        <div class="btn-wrapper text-center w-50 d-flex">
            <a href="../cart.php" class="btn btn-outline-primary rounded p-2 shadow me-3">Back to cart</a>
            <a href="../../home.php" class="btn btn-outline-dark rounded p-2 shadow">Home</a>
        </div>
    </div>
    <script>
    alert(
        'Are you sure you want to remove this item from your cart altogether?');
    </script>

</body>

</html>