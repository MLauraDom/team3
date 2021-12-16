<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
   header("Location: dashBoard.php");
   exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}

// select logged-in users details - procedural style
$query = mysqli_query($connect, "SELECT * FROM users WHERE user_id = " . $_SESSION['user']);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

// TO DO: enter a welcome messsage

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome - <?php echo $row['first_name']; ?></title>
<!-- BOOTSTRAP -->
<?php require_once 'components/bootstrap.php'?>
<style>
   main{
      height: 100vh;
   }

   .userImage{
   width: 100px;
   height: 100px;
   border-radius: 10px;
   }

   .hero {
      background: rgb(2,0,36);
      background: linear-gradient(24deg, rgba(2,0,36,1) 0%, rgba(0,212,255,1) 100%);  
   }

   a #prod_link{
      color: whitesmoke;
      font-weight: lighter;
      transition: font-weight .25s, border-bottom .35s;
   }

   a #prod_link:hover{
      font-weight: normal;
   }

   #home_img{
      transition: transform 1.2s;
   }

   #home_img:hover{
      transform: scale(1.35, 1.35);
   }
</style>
</head>
<body>
<main>


<div class="row alert-dark bg-muted m-0">
            <p class="bg-dark text-light text-end pt-1 pb-3">
               <sub>
                  <a class="text-decoration-none text-warning mx-2" href="user_update.php?id=<?php echo $_SESSION['user'] ?>">Update Profile</a> 
                  <span class="text-white"> | </span>
                  <a class="text-decoration-none text-warning mx-2" href="logout.php?logout">LogOut <i class="bi bi-box-arrow-right text-warning"></i></a>
               </sub>
            </p>
   
            <div class="col-4 justify-content-center text-center mb-0">   
               <!-- user picture  -->
                <img class="userImage my-2" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
                <p class="text-center text-dark fw-bolder">User</p>
            </div>
            <!-- welcome message -->
            <div class="col-6 text-center align-self-center">
               <h2 class="fw-lighter text-primary mt-4">Hi, <?php echo $row['first_name']; ?></h2>
                <h2 class="fs-5 fw-bolder mb-3">Welcome to our E-Commerce platform!</h2>
            </div>
            <hr class="bg-dark py-1 mt-3 mb-0">
       </div>

      <!-- Separator -->
      <div class="bg-white py-1 mt-0">
      <a class="nav_link text-decoration-none" href="products/index.php">
         <p id="prod_link" class="text-start text-dark border-top border-bottom border-dark fs-6 px-5 my-0">VIEW PRODUCTS</p>
      </a>
      </div>
      <div class="container container-fluid text-center fs-3 py-5 mx-auto w-75">
         <p class="text-center">
            <a href="products/index.php"><img id="home_img" class="img-fluid mx-auto mt-2 mb-2" width="50vw" src="pictures/layout_img/logo.png" alt="logo"></a>
         </p>
         <p class="fs-4 pb-3"><b class="fs-3 fst-italic">Hey <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?>!</b><br><br>Are you missing anything? If so, we are sure to have what you need!</p>
         <p class="mt-3 mb-5">Visit our <a class="text-primary text-decoration-none" href="products/index.php"><span>Online Store</span></a> to satisfy your most ambitious needs".</p>
      </div>
   <!-- </div> -->
   <!-- [FOOTER] -->
   <?php require_once("components/footer.php"); ?>
</body>
</html>