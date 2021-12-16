<!-- This page goes into: product/actions folder -->
<?php
session_start();


if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: ../../index.php");
   exit;
}

require_once '../../components/db_connect.php';

if ($_POST) {
   $fk_product_id = $_POST['product_id'];
   $fk_user_id = $_POST['user_id'];
   $review= $_POST['review'];
   $rating = $_POST['rating'];
   
   $sql = "INSERT INTO reviews (`rating`, `review`,`fk_user_id`, `fk_product_id`) VALUES ($rating, '$review', $fk_user_id, $fk_product_id);";

   if (mysqli_query($connect, $sql) === true) {
      $class = "success";
      $message = "Thank you for your review!";
   } else {
      $class = "danger";
      $message = "Error while creating review. Please try again: <br>" . $connect->error;
   }
   mysqli_close($connect);
} else {
   header("location: ../error.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Ngo-Sytchev">
    <title>Add Review</title>
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
               <hr class="bg-<?= $class; ?> py-1 mx-auto w-75">
               <p><?php echo ($message) ?? ''; ?></p>
               
               <a href='../details.php?id=<?php echo $fk_product_id ?>'><button class="btn btn-outline-dark mt-3 mb-2 py-0 px-5 fw-bold w-100"
                     type='button'>Back</button></a>
         </div>
      </div>
   </main>
   <!-- [FOOTER] -->
   <?php 
      require_once("../../components/footer.php"); 
   ?>
</body>

</html>