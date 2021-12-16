<?php
session_start();
require_once("../components/db_connect.php");

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

//  add from Laura***********************************************
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


// get product and category
if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
    $sql = "SELECT product_name, picture, unit_price, description, category_name, company_name FROM products p JOIN categories c ON p.fk_category_id = c.category_id JOIN manufacturers m ON p.fk_manufacturer_id = m.manufacturer_id WHERE product_id = '{$product_id}';";
    $query = mysqli_query($connect, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $display = "";

    if (isset($_SESSION['adm'])) {
        $delBtn =  "<a class='btn btn-outline-danger py-0 m-0' href='delete.php?id={$product_id}''>Delete</a>";
    } else {
        $delBtn = " <form method='POST' action='cart.php' class='m-auto mb-3'>
        <div class='row'>
        <div class='col-md-4'>
            <label for='quantity'>Quantity</label>
        </div>
        <div class='col-md-4'>
            <input class='form-control form-control-sm' type='number' name='quantity' value='1' placeholder='1'>
        </div>
        <div class='col-md-4'>
            <input type='hidden' name='product_id' value='{$product_id}'>
            <input class='form-control form-control-sm' type='submit' value='Add to Cart'>
        </div>
        </div>
        </form>";
    }


    if (mysqli_num_rows($query) == 1) {
        foreach ($result as $row) {
            $display = "
                <div class='card shadow mt-3 mb-5 mx-auto' style='width: 25rem; background-image: linear-gradient(to left, rgba(170, 163, 189, 0.7), rgba(120, 163, 209, 0.6));'>
                    <img class='card-img-top img-fluid' src='../pictures/{$row["picture"]}' alt='product image'>
                    <div class='card-body'>
                        <h3 class='card-title text-center mt-3 mb-0'>{$row["product_name"]}</h3>
                        <h6 class='card-subtitle text-center text-secondary fst-italic mt-0 mb-2'>(Category: {$row["category_name"]})</h6>
                        <hr class='py-1 mt-1 mb-3'>
                        <h6 class='card-subtitle text-center text-secondary fst-italic mt-0 mb-2'>(Produced by: {$row["company_name"]})</h6>
                        <hr class='py-1 mt-1 mb-3'>
                        <p class='p-0 m-0'><span class='text-secondary fw-bold'>Price: </span>{$row["unit_price"]}</p> 
                        <hr>
                        <p class='card-text mb-4'><i class='bi bi-book-half'></i> <b class='text-secondary'>Description</b><br>{$row["description"]}</p>
                        
                    </div>
                    <hr>
                    <div class='btn-wrapper text-center p-3'>
                        
                        <div>" . $delBtn . "</div>
                        <a class='btn btn-outline-dark py-0 m-0' href='index.php'>Return</a>
                        
                        
                    </div>
                    
                </div>
                ";
        }
    } else {
        header("error.php");
    }
    // Add from Laura Display average stars ERROR on line 91
    $sql_avg = "SELECT avg(rating) as average FROM reviews WHERE fk_product_id = '{$product_id}'";
    $query_avg = mysqli_query($connect, $sql_avg);
    $result_avg = mysqli_fetch_all($query_avg, MYSQLI_ASSOC);
    $avg = "";

    $avg_round = ROUND($result_avg[0]['average'], 2);

    $round = round($avg_round, 0);

    $star = $avg_round - $round;

    if ($result_avg[0]['average'] !== NULL) {
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
    } else {
        $avg = "<p>Not rated yet.</p>";
    }



    $sql_count = "SELECT COUNT(*) FROM reviews WHERE fk_product_id = {$product_id} and rating!=''";
    $query_count = mysqli_query($connect, $sql_count);
    $result_count = mysqli_fetch_all($query_count, MYSQLI_ASSOC);
    $count = $result_count[0]['COUNT(*)'];

    // From Laura Display Reviews & Questions ******************************************
    $sql_rev = "SELECT users.picture as pic, first_name, last_name, review, question, rating, review_id FROM reviews JOIN products on reviews.fk_product_id=products.product_id JOIN users on reviews.fk_user_id=users.user_id WHERE fk_product_id = '{$product_id}'";
    $query_rev = mysqli_query($connect, $sql_rev);
    $result_rev = mysqli_fetch_all($query_rev, MYSQLI_ASSOC);
    $comment = "";
    $question = "";
    $no = 0;





    if (mysqli_num_rows($query_rev) !== 0) {
        foreach ($result_rev as $rev) {
            if (isset($_SESSION['adm'])) {
                $delrev =  "
                <div class='card-footer text-end'>
                <form method='POST'
                action='actions/delete_review.php'>
                <input class='form-control' type='hidden' name='review_id' value=" . $rev['review_id'] . ">
                <input class='form-control' type='hidden' name='question' value=" . $rev['question'] . ">
                <div class='text-end'><button class='btn btn-outline-danger py-0 m-0' type='submit'
                        value='submit'>Delete</button></div>
            </form>
                
                </div>";
            } else {
                $delrev = "";
            }

            if (isset($_SESSION['adm'])) {
                $delq =  "
                <div class='card-footer text-end'>
                <form method='POST'
                action='actions/delete_question.php'>
                <input class='form-control' type='hidden' name='review_id' value=" . $rev['review_id'] . ">
                <input class='form-control' type='hidden' name='review' value=" . $rev['review'] . ">
                <div class='text-end'><button class='btn btn-outline-danger py-0 m-0' type='submit'
                        value='submit'>Delete</button></div>
            </form>
                
                </div>";
            } else {
                $delq = "";
            }
            $no = $no + 1;
            if ($rev['review'] !== NULL) {
                $comment .= "
            <div class='card mb-3'>
                <div class='row g-0'>
                     <div class='col-md-2'>
                        <img src='../pictures/{$rev['pic']}' class='img-fluid rounded-start' alt='{$rev['first_name']} {$rev['last_name']}'>
                    </div>
                    <div class='col-md-10'>
                        <div class='card-body'>
                            <h5 class='card-title text-warning'>";

                for ($i = 1; $i <= $rev['rating']; $i++) {
                    $comment .= "<i class='bi bi-star-fill text-warning'></i>";
                };

                for ($i = 0; $i < (5 - $rev['rating']); $i++) {
                    $comment .= "<i class='bi bi-star text-warning'></i>";
                };

                $comment .= "</h5>
                            <p class='card-text'>{$rev['review']}</p>
                            <p class='card-text'><small>{$rev['first_name']} {$rev['last_name']}</small></p>
                        </div>
                        {$delrev}
                    </div>
                </div>
            </div>
            ";
            }
            if ($rev['question'] !== NULL) {
                $question .= "
            <div class='card mb-3' stye='background-image: linear-gradient(to left, rgba(170, 163, 189, 0.7), rgba(120, 163, 209, 0.6));'>
                <div class='row g-0'>
                     <div class='col-md-2'>
                        <img src='../pictures/{$rev['pic']}' class='img-fluid rounded-start' alt='{$rev['first_name']} {$rev['last_name']}'>
                    </div>
                    <div class='col-md-10'>
                        <div class='card-body'>
                            <h5 class='card-title'>Question #{$no}</h5>
                            <p class='card-text'>{$rev['question']}</p>
                            <p class='card-text'><small><i>{$rev['first_name']} {$rev['last_name']}</i></small></p>
                        </div>
                        {$delq}
                    </div>
                </div>
            </div>
            ";
            }
        }
    } else {
        header("error.php");
    }
} else {
    echo "
        <div class='border border-3 border-danger text-center text-danger py-5 mx-auto my-5 w-75'>
        <h1><i class='bi bi-shield pe-2 '></i>ALERT!</h1>
        <hr class='bg-danger py-1 mx-auto w-75'>
        <p>The record you are trying to reach is not available</p>
        </div>";
    header("error.php");
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <title>Product Details</title>
    <style>
    main {
        min-height: 100vh;
        padding: 3% 15%;
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


<body
    style="background-image: linear-gradient(to left, rgba(200, 133, 189, 0.7), rgba(120, 133, 189, 0.7)); background-repeat: no-repeat;">
    <!-- [HERO/HEADER] -->
    <header class="text-center border-bottom text-light"
        style="background: black url('https://static.vecteezy.com/system/resources/previews/000/381/740/original/vector-abstract-technology-header-background.jpg') no-repeat; background-size: cover;">
        <br><br>
        <h1>TEAM 3: Header <br><small class="text-info fs-6 fw-lighter">(Let us choose a name :) )</small></h1>
        <div class="fst-italic">"Our Customer is Our Priority"</div>
        <br><br>
    </header>

    <!-- [NAVBAR] -->
    <nav class="navbar navbar-expand-md navbar-light sticky-top bg-light border-bottom border-dark py-0">
        <div class="container">
            <a class="nav-link active" aria-current="page" href="../index.php">
                <img src="../pictures/layout_img/logo.png" alt="Dynamik_Logo" width="35" height="35"
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
                        <a class="nav-link" aria-current="page" href="../index.php">Welcome</a>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? '' : 'd-none'; ?>">
                        <a class="nav-link" aria-current="page" href="../home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Products</a>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                        <a class="nav-link" href="../reviews.php">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contactus.php">ContactUs</a>
                    </li>
                    </li>
                    <li class="nav-item <?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                        <a class="nav-link text-danger fw-bold" href="../dashBoard.php">Dashboard</a>
                    </li>
                </ul>
                <!-- Filter & Search -->
                <form class="d-flex m-auto" method="POST" action="filter.php">
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
                    <a href="cart.php" class="btn btn-sm btn-warning py-0 <?= (@($_SESSION['adm'])) ? 'd-none' : ''; ?>"
                        type="submit"><i class="bi bi-cart3 fs-6"></i> Cart<small></small></a>
                    <!-- Profile icon -->
                    <a class="text-decoration-none btn btn-sm btn-outline-dark py-0 mx-1 fs-6" href="#"><small><i
                                class="bi bi-person-fill"></i></small></a>
                    <!-- LogOut icon -->
                    <a class="text-decoration-none btn btn-sm btn-outline-dark py-0 fs-6"
                        href="../logout.php?logout"><small><i class="bi bi-box-arrow-right"></i></small></a>


                </div>
            </div>
        </div>
    </nav>


    <!-- [MAIN] -->
    <main>
        <?php echo ($display) ?: ""; ?>

        <!-- Copied from Laura ******************************************************************** -->
        <hr>

        <div class="text-center">

            <!-- Stars -->
            <p class="h6">Rating:</p>
            <p class="h1 text-warning">

                <?php echo $avg
                ?>
            </p>
            <p class="text-end small"><?php echo $avg_round . " / " . $count ?> Ratings
        </div>
        <hr>

        <a class="btn btn-outline-success py-0" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
            aria-expanded="false" aria-controls="multiCollapseExample1"><small>Ratings & Reviews</small></a>
        <a class="btn btn-outline-success py-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"
            href="#ques"><small>Questions from our users</small>
        </a>
        </p>
        <div class="container border d-flex justify-content-start align-items-center">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <p class="h4">Product Ratings</p>
                            <section class="mx-auto w-75 <?= (@($_SESSION['adm'])) ? 'd-none' : ''; ?>">
                                <h3 class="mb-3">Leave us a review:</h3>
                                <form method="POST" class="form-control shadow mb-5 py-3 bg-muted"
                                    action="actions/a_review.php">

                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="First name"
                                                aria-label="First name">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Last name"
                                                aria-label="Last name">
                                        </div>
                                    </div>

                                    <input class="form-control" type="hidden" name="user_id"
                                        value=<?php echo $user_id ?>>
                                    <input class="form-control" type="hidden" name="product_id"
                                        value=<?php echo $product_id ?>>

                                    <!-- rating -->
                                    <label for="rating"><small class="text-muted mb-0">Rating(1-5)<small></label>
                                    <input class="form-range my-1 py-0" name="rating" type="range" id="rating" min="1"
                                        max="5">

                                    <textarea class="form-control" name="review" rows="5"
                                        placeholder="Let us know what you think about our products"></textarea>
                                    <div class="text-end"><button class="btn btn-primary mt-3 py-1" type="submit"
                                            value="submit">Send
                                            Review</button></div>
                                </form>
                            </section>
                            <?php echo $comment ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="collapse multi-collapse" id="multiCollapseExample2" id="ques">
                        <div class="card card-body">
                            <section class="mx-auto w-75 <?= (@($_SESSION['adm'])) ? 'd-none' : ''; ?>">
                                <h3 class="mb-3">Do you have a Question about this product?</h3>

                                <form method="POST" class="form-control shadow mb-5 py-3 bg-muted"
                                    action="actions/a_question.php">
                                    <input class="form-control" type="hidden" name="user_id"
                                        value=<?php echo $user_id ?>>
                                    <input class="form-control" type="hidden" name="product_id"
                                        value=<?php echo $product_id ?>>
                                    <!-- question -->

                                    <input class="form-control my-2 py-0" name="question" type="text"
                                        placeholder="Write Your question in here">

                                    <div class="text-end"><button class="btn btn-primary mt-3 py-1" type="submit"
                                            value="submit">Submit</button></div>
                                </form>
                            </section>
                            <?php echo $question ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- [FOOTER] -->
    <footer>
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
                                    <a href="https://www.facebook.com/CodeFactoryVienna/ "> <i
                                            class="fa fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/accounts/login/ "> <i
                                            class="fa fa-instagram "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/codefactoryvie "> <i class="fa fa-twitter-square "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/channel/UCJE5xsfz-bLmVb5emobgOkw "> <i
                                            class="fa fa-youtube-play "></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/codefactory-vienna "> <i
                                            class="fa fa-linkedin "></i>
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
                                <li><a href="../rest_api/products_api.php">API Products</a></li>
                                <li><a href="../reviews.php">Reviews</a></li>
                                <li><a href="../about.php">About</a></li>
                                <li><a href="../contactus.php">Contact Us</a></li>
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
                                            <span><a class="text-decoration-none"
                                                    href="mailto:office@codefactory.wien ">office@codefactory.wien</a></span>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>