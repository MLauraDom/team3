<?php
require 'db_connect.php';
$sql_cat = "SELECT * FROM categories";
$query_cat = mysqli_query($connect, $sql_cat);
$result_cat = mysqli_fetch_all($query_cat, MYSQLI_ASSOC);
$categories = "";

if (mysqli_num_rows($query_cat) !== 0) {
    foreach ($result_cat as $cat) {
        $categories .= "<option value=" . $cat['category_name'] . ">" . $cat['category_name'] . "</option>
        ";
    }
}

// fetching user data to display in the card
if(@($_SESSION["user"])){
    $user_id = $_SESSION["user"];
    // select logged-in users details
    $query = mysqli_query($connect, "SELECT * FROM users WHERE user_id = {$user_id}");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

} elseif(@($_SESSION["adm"])){
    $user_id = $_SESSION["adm"];
    // select logged-in users details
    $query = mysqli_query($connect, "SELECT * FROM users WHERE user_id = {$user_id}");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

} else {
    echo"<div class='my-5 py-5 border border-3 border-danger bg-muted'>
        <h3 class='mb-2'>Oops</h3>
        <p>Something went wrong. Try the action again.</p>
        </div>";
}

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap icons-->
    <?php require_once("bootstrap.php") ?>
    <title>Navbar - Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .container {
        margin-top: 0px !important;
    }

    .footer-subscribe-wrapper {
        position: relative;
        z-index: 1;
        height: 100%;
        background: radial-gradient(#92c1ff, #a182ff);
    }

    .footer-heading {
        margin-bottom: 25px;
    }

    .footer-heading h3 {
        font-size: 20px;
        color: black;
        font-weight: 600;
        margin: 0 0 0 0;
        position: relative;
        border-bottom: 1px solid #777;
        padding-bottom: 10px;
    }

    .single-footer-widget .footer-social {
        padding-left: 0;
        margin-bottom: 0;
        margin-top: 20px;
    }

    .single-footer-widget .footer-social li {
        display: inline-block;
        margin-right: 10px;
    }

    .single-footer-widget .footer-social li:last-child {
        margin-right: 0;
    }

    .single-footer-widget .footer-social i {
        display: inline-block;
        height: 35px;
        width: 35px;
        line-height: 35px;
        background-color: #ffffff;
        border: 1px solid #ffffff;
        border-radius: 50px;
        color: black;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        text-align: center;
    }

    .single-footer-widget .footer-social i::before {
        font-size: 15px;
    }

    .single-footer-widget .footer-social i:hover {
        background-color: #7b68ee;
        color: #ffffff;
        border: 1px solid #7b68ee;
    }

    .single-footer-widget p {
        font-size: 15px;
        color: black;
        font-weight: 400;
    }

    .single-footer-widget .footer-heading {
        margin-bottom: 25px;
    }

    .single-footer-widget .footer-heading h3 {
        font-size: 20px;
        color: black;
        font-weight: 700;
        margin: 0 0 0 0;
    }

    .single-footer-widget .footer-quick-links {
        padding-left: 0;
        margin-bottom: 0;
    }

    .single-footer-widget .footer-quick-links li {
        list-style-type: none;
        padding-bottom: 10px;
    }

    .single-footer-widget .footer-quick-links li:last-child {
        padding-bottom: 0;
    }

    .single-footer-widget .footer-quick-links li a {
        display: inline-block;
        color: black;
        font-size: 16px;
        font-weight: 400;
        text-decoration: none;
    }

    .single-footer-widget .footer-quick-links li a:hover {
        color: black;
        text-decoration: underline !important;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    .single-footer-widget .footer-info-contact {
        position: relative;
        padding-left: 35px;
        margin-bottom: 16px;
    }

    .single-footer-widget .footer-info-contact:last-child {
        margin-bottom: 0;
    }

    .single-footer-widget .footer-info-contact i {
        color: #ffffff;
        position: absolute;
        left: 0;
        top: 0px;
    }

    .single-footer-widget .footer-info-contact i::before {
        font-size: 20px;
    }

    .single-footer-widget .footer-info-contact h3 {
        font-size: 16px;
        color: black;
        font-weight: 600;
        margin: 0 0 10px 0;
    }

    .single-footer-widget .footer-info-contact span {
        font-size: 15px;
        color: black;
        font-weight: 400;
    }

    .single-footer-widget .footer-info-contact span a {
        font-size: 15px;
        color: black;
        font-weight: 400;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    .single-footer-widget .footer-info-contact span a:hover {
        color: black;
    }

    .icon {
        width: 25px;
        height: 25px;
    }

    /* profile picture */
    #profile_pic{
        border-radius: 50%;
        width: 7vw;
        /* height: 15vh; */
        margin: 0px 10px 15px;
    }

    </style>

</head>

<body>

    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-md navbar-light sticky-top bg-light border-bottom border-dark py-0">
        <div class="container py-0">
            <a class="nav-link active" aria-current="page" href="<?= $url ?>index.php">
                <img src="<?= $img_url ?>pictures/layout_img/logo.png" alt="Dynamik_Logo" width="35" height="35"
                    class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <!-- links -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= $url ?>index.php">Welcome</a>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? '' : 'd-none'; ?>">
                        <a class="nav-link" aria-current="page" href="<?= $url ?>home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url ?>products/index.php">Products</a>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                        <a class="nav-link" href="<?= $url ?>reviews.php">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url ?>about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url ?>contactus.php">ContactUs</a>
                    </li>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                        <a class="nav-link text-danger fw-bold" href="<?= $url ?>dashBoard.php">Dashboard</a>
                    </li>
                </ul>
                <!-- Filter & Search -->
                <form class="d-flex m-auto" method="POST" action="<?= $url ?>products/filter.php">
                    <select class="form-select form-select-sm px-1 py-0 w-50" aria-label=".form-select-sm example"
                        name="category">
                        <option selected>All</option>
                        <?= $categories; ?>
                    </select>
                    <input class="form-control me-2 py-0" type="search" placeholder="Search" aria-label="Search"
                        name="search">
                    <button class="btn btn-outline-success btn-sm py-0" type="submit" id="dropdownMenuButton1">
                        <small>OK</small>
                    </button>
                </form>
                <div class="d-flex ms-5 justify-content-between py-2">

                   <!-- Cart icon -->
                    <a href="<?= $url ?>products/cart.php"
                        class="btn btn-sm btn-warning py-0 <?= (@($_SESSION['adm'])) ? 'd-none' : ''; ?>"
                        type="submit"><i class="bi bi-cart3 fs-6"></i><small>Cart</small></a>

                    <!-- Profile icon -->
                    <!-- <a id="profile_icon" class="text-decoration-none btn btn-sm btn-outline-dark py-0 mx-1 fs-6"
                        href="#"><small><i class="bi bi-person-fill"></i></small></a> -->


                    <!-- ---- [DROP DOWN BUTTON]: start -------- -->
                    <button class="btn btn-outline-primary dropdown-toggle mx-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-fill"></i></small></button>
                    <ul class="dropdown-menu dropdown-menu-end bg-muted">
                        
                        <p class="text-end pt-1 pb-0 mb-0">
                            <!-- logout -->
                                    <a class="text-decoration-none my-0 mx-1 pt-2 pb-0"
                                    href="<?= $logout_url ?>logout.php?logout"><sup>LogOut <i class="bi bi-box-arrow-right fw-bolder"></i></sup>
                                    </a>
                            <!-- img and links -->
                            <div class="card-body text-center mb-0">
                                <div>
                                    <img id="profile_pic" class="img-fluid" src="<?= $img_url ?>pictures/<?= $row["picture"] ?>" alt="">
                                </div>
                                <!-- full name -->
                                <p class="m-0 fw-bold"><small><?= $row["first_name"] . " " . $row["last_name"] ?></small><br>
                                <sup><?= (@$_SESSION["adm"])?"<span class='text-danger fw-lighter'>(Admin)<span>":"<span class='text-muted'>(User)</span>"; ?></sup>
                                </p>
                                <!-- email -->
                                <p class="m-0"><sup><?= $row["email"] ?></sup></p>
                                <hr class="mt-1 mb-0 py-1 bg-primary">
                            </div>
                            <!-- links -->
                            <li>
                                <a class="dropdown-item mt-0" href="<?= $url ?>products/cart.php"><small>My Cart</small></a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $url ?>user_update.php"><small>Edit Profile</small></a>
                            </li>
                            <li><hr class="dropdown-divider bg-primary"></li>
                            <li>
                                <a class="dropdown-item text-decoration-none my-0 mx-1 py-0" href="<?= $logout_url ?>logout.php?logout"><small>LogOut</small></a>
                            </li>
                    </ul>
                    <!-- ---------[DROP DOWN BUTTON]: end -------- -->
                   
                    <!-- LogOut icon: hidden for now -->
                    <!-- <a class="text-decoration-none btn btn-sm btn-outline-dark py-0 fs-6"
                        href="<?= $logout_url ?>logout.php?logout"><small><i class="bi bi-box-arrow-right"></i></small></a> -->
                </div>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->


    <!-- PROFILE CARD -->
    <!-- <section class="d-flex justify-content-end">
        <div id="profile_card" class="card py-2" style="width: 15rem;">
            <p class="text-end pt-1 pb-0 mb-0">
                <a class="text-decoration-none btn btn-sm btn-outline-warning my-0 mx-1 pt-2 pb-0"
                href="<?= $logout_url ?>logout.php?logout"><sup>LogOut <i class="bi bi-box-arrow-right fw-bolder"></i></sup>
                </a>
            </p>
            <div class="card-body text-center">
               <div><img id="profile_pic" class="img-fluid" src="https://cdn.mytravalet.com/wp-content/uploads/2017/10/pexels-photo-443446-1024x662.jpeg" alt=""></div>
            <p class="m-0"><small><?= $row["first_name"] . " " . $row["last_name"] ?></small></p>
            <p class="m-0"><small><?= $row["email"] ?></small></p>
            <hr>
            <ul class="navbar-nav py-0">
                <li class="nav-item active"><a class="nav-link">My Cart</a></li>
                <li class="nav-item"><a class="nav-link">Edit Profile</a></li>
            </ul>       
            </div>
            <div class="card-footer">Footer</div> 
            </div>
        </div>
    </section> -->


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>