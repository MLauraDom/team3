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
   $product_name = $_POST['product_name'];
   $unit_price = $_POST['unit_price'];
   $description = $_POST['description'];
   $category = $_POST['category'];
   $manufacturer = $_POST['manufacturer'];

   $uploadError = '';
   $picture = file_upload($_FILES['picture'], 'product');  //this function exists in the service file upload.

   $sql = "INSERT INTO products (product_name, fk_category_id, unit_price, fk_manufacturer_id, description, picture) VALUES ('$product_name', $category, $unit_price, $manufacturer, '$description', '$picture->fileName');";

   if (mysqli_query($connect, $sql) === true) {
      $title = "<i class='bi bi-check2-circle'></i> CONGRATULATIONS";
      $class = "success";
      $message = "<p class='my-2 fs-4'>The entry below was successfully created</p> <br>
            <div class='table-responsive'>
               <table class='table table-dark table-hover border border-2 border-muted rounded-3 mx-auto w-75'>
                  <tr>
                  <td>PICTURE</td><td> <img class='img-fluid' src='../../pictures/{$picture->fileName}' style='width:12rem'></td>
                  </tr>
                  <tr>
                  <td>NAME</td><td> $product_name </td>
                  </tr>
                  <tr>
                  <td>CATEGORY</td><td> $category </td>
                  </tr>
                  <tr>
                  <td>PRICE (unit)</td><td> € $unit_price </td>
                  </tr>
                  <td>MANUFACTURER</td><td> $manufacturer </td>
                  </tr>
                  </tr>
                  <td>DESCRIPTION</td><td> $description </td>
                  </tr>
               </table>
            </div>
            <hr>";
      $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
   } else {
      $title = "<i class='bi bi-exclamation-octagon'></i> ATTENTION";
      $class = "danger";
      $message = "Error while creating record. Try again: <br>" . $connect->error;
      $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <meta name="author" content="Team3 :-)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Create</title>
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php") ?>
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
        <!-- [MESSAGE of created reocrd] -->
        <div class="container py-5 w-50">
            <div
                class="alert alert-<?= $class; ?> border border-3 border-<?= $class; ?> text-start pt-5 pb-3 mx-auto mt-0 mb-5 w-100">
                <h1><?= $title; ?></h1>
                <hr class="bg-<?= $class; ?> py-1 mx-auto w-75">
                <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <div class="btn-wrapper d-flex justify-content-around">
                    <a href='../index.php'><button class="btn btn-outline-dark mt-3 mb-2 py-0 px-5 fw-bold"
                            type='button'>All Products</button></a>
                    <a href='../create.php'><button class="btn btn-outline-dark mt-3 mb-2 py-0 px-5 fw-bold"
                            type='button'>Add Another</button></a>
                </div>
            </div>
        </div>
    </main>
    <!-- [FOOTER] -->
    <?php
   require_once("../../components/footer.php");
   ?>
</body>

</html>