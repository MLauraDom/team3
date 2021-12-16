<?php
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST) {
    $product_id = $_POST["product_id"];
    $product_name = $_POST['product_name'];
    $unit_price = $_POST['unit_price'];
    $discount = (int)$_POST['discount'];
    $unit_price = round(((100 - $discount) / 100) * $unit_price, 2); // change if discount added otherwise same
    $category = $_POST['category'];
    $manufacturer = $_POST['manufacturer'];
    $description = $_POST['description'];
    //variable for upload pictures errors is initialized
    $uploadError = '';
    $picture = file_upload($_FILES['picture'], 'product');

    if ($picture->error === 0) {
        ($_POST["picture"] == "product.png") ?: unlink("../../pictures/$_POST[picture]");
        $sql = "UPDATE products SET product_name = '$product_name', fk_category_id = $category, unit_price = '$unit_price', fk_manufacturer_id = $manufacturer, description = '$description', picture = '$picture->fileName' WHERE product_id = '{$product_id}'";
    } else {
        $sql = "UPDATE products SET product_name = '$product_name', fk_category_id = $category, unit_price = '$unit_price', fk_manufacturer_id = $manufacturer, description = '$description' WHERE product_id = '{$product_id}'";
    }

    if (mysqli_query($connect, $sql) === TRUE) {
        $title = "<i class='bi bi-check2-circle pe-2 '></i> CONGRATULATIONS";
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $title = "<i class='bi bi-shield-exclamation-octagon pe-2'></i> ATTENTION";
        $class = "danger";
        $message = "An Error has occured while updating the record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
?>



<!-- 
------------------------
        HTML
------------------------ 
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php") ?>
    <title>Update Product</title>
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
        <!-- Notification message -->
        <div class="container py-5 m-0 mx-auto w-75">
            <div
                class='alert alert-muted border border-3 border-<?= $class; ?> text-center text-<?= $class; ?> pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
                <h1><?= $title ?></h1>
                <hr class='bg-<?= $class; ?> py-1 mx-auto w-75'>
                <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <div>
                    <a href='../index.php'><button
                            class="btn btn-outline-<?= $class; ?> mx-auto mb-2 py-0 px-5 fw-bold w-25"
                            type='button'>OK</button></a>
                    <a href='../update.php?id=<?= $product_id; ?>'><button class="btn btn-danger py-0 w-25"
                            type='button'>Back </button></a>
                </div>
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