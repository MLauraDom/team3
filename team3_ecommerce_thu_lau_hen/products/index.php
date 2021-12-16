<?php
session_start();
require_once("../components/db_connect.php");
// if (isset($_SESSION['user']) != "") {
//     header("Location: ../home.php");
//     exit;
//  }

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT * FROM products;";
$query = mysqli_query($connect, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
$products = ""; //For the TABLE verion
$products2 = ""; //For THE FLEX Version

if (mysqli_num_rows($query) > 0) {
    foreach ($result as $row) {
        $products .= "
            <tr class='align-middle text-center border-top border-bottom border-secondary'>
                <td>
                    <a href='details.php?id={$row["product_id"]}'>
                        <img class='img-fluid' width='200px' src='../pictures/{$row["picture"]}'>
                    </a>
                </td>
                <td>{$row['product_name']}</td>
                <td>{$row['unit_price']}€</td>
                <td>
                    <div><a class='btn btn-sm btn-outline-light w-100 py-0' href='details.php?id={$row["product_id"]}'><span>Show more</span>
                    </a></div>
                    <div class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-warning w-100 py-0' href='update.php?id={$row["product_id"]}'><span>Update</span>
                    </a></div>
                    <div class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-danger w-100 py-0' href='delete.php?id={$row["product_id"]}'><span>Remove</span>
                    </a></div>
                </td>
            </tr>
            ";
    }
    if (mysqli_num_rows($query) > 0) {
        foreach ($result as $row) {
            $products2 .= "
            <div class='card mx-3 mb-5' style='width: 16rem; background-image: linear-gradient(to left, rgba(170, 163, 189, 0.7), rgba(120, 163, 209, 0.6));'>
                <img src='../pictures/{$row['picture']}' class='card-img-top img-thumbnail' style='height: 16rem; width:100%; object-fit: cover;' alt='...'>
                <hr>
                <div class='card-body'>
                    <h4 class='card-title text-center'>{$row['product_name']}</h4>
                    <hr class='w-50 mx-auto mt-0 mb-4'>
                    <p class='card-subtitle text-secondary text-center'>€{$row['unit_price']}</p>
                </div>
                <div class='card-footer bg-transparent text-center p-3'>
                <a class='btn btn-sm btn-outline-dark p-2' href='details.php?id={$row["product_id"]}'>More info</a>
                <div class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-warning mt-2 p-2' href='update.php?id={$row["product_id"]}'>Edit</div></a>
                <div class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-danger mt-2 p-2' href='delete.php?id={$row["product_id"]}'>Drop</div></a>
                </div>
            </div>
        ";
        }
    }
}

?>

<!-- ------------------------
        HTML
------------------------ -->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="author" content="Team3">
    <!-- [BOOTSTRAP] -->
    <?php
    $url = "../";
    require_once("../components/bootstrap.php");
    ?>
    <!-- [CSS] -->
    <style>
    main {
        min-height: 100vh;
    }
    </style>
    <title>Products home page</title>
</head>

<body class="m-0 p-0"
    style="background-image: linear-gradient(to left, rgba(200, 133, 189, 0.7), rgba(120, 133, 189, 0.7)); background-repeat: no-repeat;">
    <!-- [HERO/HEADER] -->
    <?php
    require_once("../components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout_url = $img_url = "../";
    require_once("../components/navbar.php");
    ?>

    <!-- container for the main content of the page -->
    <div class="d-flex p-0 mx-auto">

        <!-- [MAIN] -->
        <main class="w-auto m-0 p-0">
            <!-- [ADMIN COMMANDS] -->
            <section
                class="<?= (@($_SESSION['user'])) ? 'd-none' : ''; ?> shadow border border-3 border-success bg-muted pt-3 pb-3 px-4 m-0">
                <h6 class="mb-1">Admin Commands</h6>
                <hr class="bg-success py-1 mt-0 mb-4 mx-auto w-100">
                <div class="row">
                    <div class="col-2">
                        <img class="img-fluid me-5" width="90px"
                            src="https://cdn.pixabay.com/photo/2021/01/04/10/37/icon-5887113_960_720.png" alt="admin">
                    </div>
                    <div class="col-9"><span>Welcome Administrator! From here you may Create, Retrieve, Update & Delete
                            Products to sell on your Ecommerce site</span>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="create.php"><button class="btn-sm btn-success py-0">CREATE</button></a>

                </div>
            </section>

            <div class="container pt-4 pb-5 <?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                <h1 class="text-center fw-light display-5">Available Products</h1>
                <hr class="bg-success py-1 mb-2 mx-auto">
                <div class="table-responsive">
                    <table class="table table-dark table-hover border border-light mt-2 mb-5 mx-auto w-75">
                        <thead class="table-dark text-center">
                            <tr class="align-middle">
                                <td>Picture</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $products ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <h1 class="text-center fw-light display-4 mt-3">All Our Products</h1>
            <hr class="bg-success py-1 mb-2 mx-auto w-75">
            <div class="d-flex flex-wrap justify-content-center">
                <?= $products2 ?>
            </div>
        </main>
    </div>
    <!-- [FOOTER] -->
    <?php
    require_once("../components/footer.php");
    ?>

</body>

</html>