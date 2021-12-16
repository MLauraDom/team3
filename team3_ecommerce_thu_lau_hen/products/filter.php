<!-- this page goes into folder products -->
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
if ($_POST) {
    $search = $_POST['search'];
    $category = $_POST['category'];

    if (($category == 'All') && ($search == '')) {
        $sql = "SELECT * FROM products";
    } elseif (($category !== 'All') && ($search == '')) {
        $sql = "SELECT * FROM products JOIN categories ON products.fk_category_id = categories.category_id WHERE category_name='$category'";
    } elseif (($category == 'All') && ($search !== '')) {

        $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%' OR description LIKE '%$search%'";
    } elseif (($category !== 'All') && ($search !== '')) {
        $sql = "SELECT * FROM products JOIN categories ON products.fk_category_id = categories.category_id WHERE (product_name LIKE '%$search%' OR description LIKE '%$search%') AND category_name='$category'";
    }

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
            <div class='card mx-3 mb-5' style='width: 12rem;'>
                <img src='../pictures/{$row['picture']}' class='card-img-top' alt='...'>
                <div class='card-body'>
                    <h4 class='card-title text-center'>{$row['product_name']}</h4>
                    <hr class='w-50 mx-auto mt-0 mb-4'>
                    <p class='card-subtitle text-secondary text-end'>€{$row['unit_price']}</p>
                </div>
                <div class='card-footer bg-transparent text-center p-1'>
                <a class='btn btn-sm btn-outline-dark py-0' href='details.php?id={$row["product_id"]}'>More</a>
                <span class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-warning py-0' href='update.php?id={$row["product_id"]}'>Edit</span></a>
                <span class=" . ((@($_SESSION['user'])) ? 'd-none' : '') . "><a class='btn btn-sm btn-outline-danger py-0' href='delete.php?id={$row["product_id"]}'>Drop</span></a>
                </div>
            </div>
        ";
            }
        }
    }
}
?>

<!-- ------------------------
        HTML
------------------------ -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
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

<body class="m-0 p-0">
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
                    <div class="col-9"><span>Here Comes some text for the admin or even additional options</span>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="create.php"><button class="btn-sm btn-success py-0">CREATE</button></a>
                    <a href="#"><button class="btn-sm btn-outline-dark py-0">Btn 2</button></a>
                    <a href="#"><button class="btn-sm btn-outline-dark py-0">Btn 3</button></a>
                    <a href="#"><button class="btn-sm btn-outline-dark py-0">Btn 4</button></a>
                    <a href="#"><button class="btn-sm btn-outline-dark py-0">Btn 5</button></a>
                </div>
            </section>

            <div class="container pt-4 pb-5">
                <h1 class="text-center fw-light display-5">Available Products</h1>
                <hr class="bg-success py-1 mb-2 mx-auto w-75">
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

            <h1 class="text-center fw-light display-4">Alternative display: Cards</h1>
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