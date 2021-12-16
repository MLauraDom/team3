<?php
session_start();
require_once("components/db_connect.php");

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

// fetch the id of the connected person
if (isset($_SESSION["adm"])) {
    $user_id = $_SESSION['adm'];
} elseif (isset($_SESSION["user"])) {
    $user_id = $_SESSION['user'];
}

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
// extract data and save into variables for the hidden input fiels of the form
$sql = "SELECT avg(rating) as average, products.picture as ppic, product_name, unit_price, fk_product_id FROM reviews join products on reviews.fk_product_id = products.product_id WHERE rating != '' group by fk_product_id;";
$query = mysqli_query($connect, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
$display = "";
$id = 0;

foreach ($result as $row) {
    $sql_count = "SELECT COUNT(*) FROM reviews WHERE fk_product_id = {$row['fk_product_id']} AND rating != ''";
    $query_count = mysqli_query($connect, $sql_count);
    $result_count = mysqli_fetch_all($query_count, MYSQLI_ASSOC);
    $count = $result_count[0]['COUNT(*)'];
    $id +=1;

    $avg = "";


    $avg_round = ROUND($row['average'], 2);

    $round = round($avg_round,0);

    $star = $avg_round - $round;

    if ($row['average'] !== NULL) {
        if ($star == 0) {

            for ($i = 0; $i < $round; $i++) {
                $avg .= "<i class='bi bi-star-fill text-warning h1'></i>";
            };

            for ($i = 0; $i < (5 - $round); $i++) {
                $avg .= "<i class='bi bi-star text-warning h1'></i>";
            };

        } elseif ($star > 0) {


            for ($i = 0; $i < $round; $i++) {
                $avg .= "<i class='bi bi-star-fill text-warning h1'></i>";
            };
            $avg .= "<i class='bi bi-star-half text-warning h1'></i></i>";
            for ($i = 0; $i < (4 - $round); $i++) {
                $avg .= "<i class='bi bi-star text-warning h1'></i>";
            };

        } elseif ($star < 0) {


            for ($i = 0; $i < ($round - 1); $i++) {
                $avg .= "<i class='bi bi-star-fill text-warning h1'></i>";
            };
            $avg .= "<i class='bi bi-star-half text-warning h1'></i></i>";
            for ($i = 0; $i < (5 - $round); $i++) {
                $avg .= "<i class='bi bi-star text-warning h1'></i>";
            };
        }
       $avg.="</p>";
    }  else {
        $avg = "<p>Not rated yet.</p>";
    }




    $sql_acc = "SELECT fk_product_id, users.picture as upic, first_name, last_name, rating, review, question, review_id FROM users join reviews on reviews.fk_user_id=users.user_id WHERE rating != '' and fk_product_id={$row['fk_product_id']}";
    $query_acc = mysqli_query($connect, $sql_acc);
    $result_acc = mysqli_fetch_all($query_acc, MYSQLI_ASSOC);
    $accordion = "";
  


    $display .= "<div class='accordion-item mx-auto w-75'>
    <h2 class='accordion-header text-center' id='flush-heading{$id}'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse{$id}' aria-expanded='false' aria-controls='flush-collapseThree'>
            <!-- ACCORDEON HEADER:start -->


            <table class='mx-3 w-100'>
                <tr class='h-25'>
                    <td><small><img class='img-fluid ppic' widtd='135px' src='pictures/{$row['ppic']}'></small></td>
                    <td>{$row['product_name']}</td>
                    <td class='text-warning h1'>{$avg}</td>
                    <td><small>{$avg_round} / {$count} Ratings</small></td>
                    <td class='text-center'>
                        <a class='d-block btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='products/details.php?id={$row['fk_product_id']}'><small><i class='bi bi-eye text-primary'></i> More</small></a>
                    </td>
                </tr>
            </table>
<!-- ACCORDEON HEADER: end -->
</button>
</h2>
<div id='flush-collapse{$id}' class='accordion-collapse collapse' aria-labelledby='flush-heading{$id}' data-bs-parent='#accordionFlushExample'>
<div class='accordion-body'>
<!-- HIDE/SHOW: start -->
<table class='mx-auto w-100'>
<thead class='table-secondary'>
    <tr class='align-middle'>
        <th class='text-center'>Picture</th>
        <th class='text-start'>Full Name</th>
        <th class='text-start'>Review</th>
        <th class='text-center'>Rating</th>
        <th class='text-center'>Actions</th>
    </tr>
</thead>
</table>";
foreach ($result_acc as $acc) {
    $accordion .= "<table class='mx-auto w-100'>
    <tr>
        <td class='text-center'><small><img class='ppic img-fluid' width='135px' src='pictures/{$acc['upic']}'></small></td>

        <td class='text-start'>{$acc['first_name']} {$acc['last_name']}</td>

        <td class='text-start'>{$acc['review']}</td>

        <td class='text-center'>
            <p class='text-warning'>";

    for ($i = 1; $i <= $acc['rating']; $i++) {
        $accordion .= "<span>&#9733;</span>";
    };

    for ($i = 0; $i < (5 - $acc['rating']); $i++) {
        $accordion .= "<span>&#9734;</span>";
    };

    $accordion .= "</p>
    </td>
    <td class='text-center'>
        <form method='POST' action='products/actions/delete_review.php'>
            <input class='form-control' type='hidden' name='review_id' value=" . $acc['review_id'] . ">
            <input class='form-control' type='hidden' name='question' value=" . $acc['question'] . ">

            <button class='btn btn-outline-danger py-0 m-0' type='submit' value='submit'>Delete Review</button>
        </form>
    </td>
</tr>
</table>";}


$display .="{$accordion}</div>
                </div>
            </div>
        </div>
    </main>";
}

/* 
    --------------------
    TO DO:
    --------------------
    Andrew, feel free to update the form according to the project's needs. I saved some information for the form (from the top of my head) as seen above.
    */

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


    <title>Reviewspage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&display=swap" rel="stylesheet">
<style>
        .ppic {
            height: 20vh;
            object-fit: cover;
        }

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
    </style>
</head>

<body>
    <?php
    $url = $logout_url = "";
    $img_url = "";;
    ?>
    <header class="text-center border-bottom text-dark" style="background: black url('https://i.quotev.com/img/q/u/15/4/17/magi.jpg') no-repeat; background-size: cover;background-position:center;text-shadow:7px 1px 9px #38121E;-webkit-text-stroke: 0.2px #8E2E4C;">
        <br><br>
        <p class="display-4" style="font-family: 'Fleur De Leah', cursive;">The Magic Kingdom</p>
         <div class="fst-italic"><p class="h5">"Make your WISHES come true!"</p></div>
        <br><br>
    </header> 
    <nav class="navbar navbar-expand-md navbar-light sticky-top bg-light border-bottom border-dark py-0">
        <div class="container">
            <a class="nav-link active" aria-current="page" href="<?= $url ?>index.php">
                <img src="pictures/layout_img/logo.png" alt="Dynamik_Logo" width="35" height="35" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= $url ?>index.php">Start</a>
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

                    <select class="form-select form-select-sm px-1 w-50" aria-label=".form-select-sm example" name="category">
                        <option selected>All</option>
                        <?= $categories; ?>
                    </select>
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-success btn-sm py-0" type="submit" id="dropdownMenuButton1">
                        <small>OK</small>
                    </button>
                </form>
                <div class="d-flex">

                    <!-- [COMMENT: uncomment the next line in order to enable a hidden button for the admin (it will be visible for the normal user)] -->
                    <a href="<?= $url ?>products/cart.php" class="btn btn-sm btn-warning py-0 mx-2 <?= (@($_SESSION['adm'])) ? 'd-none' : ''; ?>" type="submit"><i class="bi bi-cart3"></i> <small>Cart</small></a>


                    <a class="text-decoration-none btn btn-sm btn-outline-primary py-0" href="<?= $logout_url ?>logout.php?logout"><small>Sign Out</small></a>
                </div>
            </div>
        </div>
    </nav>


    <!-- [MAIN] -->
    <main class="py-5">
        <div class="d-flex justify-content-center align-items-center backgroundimg py-5">

            <h1 class="">Reviews Page</h1>
        </div>

        <table class="mx-auto w-75 table table-striped">
            <tr class="align-middle">
                <th class="text-center">Picture</th>
                <th class="text-start">Product Name</th>
                <th class="text-start">Average Rating</th>
                <th class="text-center">Ratings</th>
                <th class="text-center">Actions</th>
            </tr>
        </table>
        <div class="accordion accordion-flush" id="accordionFlushExample">


            <?= $display ?>

        </div>
    </main>

    <footer class="pt-5">
        <div class="footer-area ptb-100 pt-4 border-top border-dark">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5">
                        <div class="single-footer-widget ">
                            <div class="footer-heading ">
                                <h3>About Us</h3>
                            </div>
                            <p>demo</p>
                            <ul class="footer-social ">
                                <li>
                                    <a href="https://www.facebook.com/CodeFactoryVienna/ "> <i class="fa fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/accounts/login/ "> <i class="fa fa-instagram "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/codefactoryvie "> <i class="fa fa-twitter-square "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/channel/UCJE5xsfz-bLmVb5emobgOkw "> <i class="fa fa-youtube-play "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/codefactory-vienna "> <i class="fa fa-linkedin "></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5 ">
                        <div class="single-footer-widget ">
                            <div class="footer-heading ">
                                <h3>Useful Links</h3>
                            </div>
                            <ul class="footer-quick-links ">
                                <!-- <li><a href="<?= $url ?>rest_api/products_api.php">API Products</a></li> -->
                                <li><a href="rest_api/products_api.php">API Products</a></li>
                                <li><a href="reviews.php">Reviews</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="contactus.php">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-5 ">
                        <div class="single-footer-widget">
                            <div class="footer-heading ">
                                <h3>Contact Info</h3>
                            </div>
                            <table>
                                <tr class="align-top">
                                    <td><i class="fa fa-phone"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Phone:</b>  -->
                                            <span>0660 6673655</span></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-top">
                                    <td><i class="fa fa-envelope"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Email:</b>  -->
                                            <span><a class="text-decoration-none" href="mailto:office@codefactory.wien ">office@codefactory.wien</a></span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="align-top">
                                    <td><i class="fa fa-map-marker"></i></td>
                                    <td>
                                        <div class="footer-info-contact ps-2">
                                            <!-- <p class="mb-0"><b>Address:</b> <br> -->
                                            <span>Kettenbrückengasse 23/2/12,<br> 1050 Vienna, <br>Austria</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>


<!-- <p>
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
        Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
      </div>
    </div>
  </div>
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
        Some placeholder content for the second collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
      </div>
    </div>
  </div>
</div> -->