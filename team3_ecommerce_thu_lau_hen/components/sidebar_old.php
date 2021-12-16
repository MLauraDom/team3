<!-- This page goes on the same level with dashboard.php -->
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
mysqli_close($connect);
?>


<!-- 
----------------------------------------
                HTML
----------------------------------------
-->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- [BOOTSTRAP] -->
    <?php
    $url = "../";
    require_once("../components/bootstrap.php");
    ?>
    <title>Sidebar</title>
</head>

<body>
    <aside class="d-flex flex-column flex-shrink-0 py-4 px-3 text-white bg-dark" style="max-width: 280px;">
        <p class="text-end"><a class="text-decoration-none text-info pt-2 pb-0  mx-2"
                href="../logout.php?logout"><sup>Sign Out</sup></a></p>
        <div class="mt-2 mb-1 mx-auto">
            <!-- TO DO: ADD SOURCE OF USER IMG -->
            <img src="../pictures/avatar.png" alt="user_image" width="60px">
        </div>
        <div href="/" class="d-flex align-items-center mb-1 mb-md-0 mx-md-auto text-white text-decoration-none">
            <p class="fs-4 mb-0">User Name</p>
        </div>
        <hr class="mb-4">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="<?= (@($_SESSION['user'])) ? 'd-none' : ''; ?>">
                <a href="../dashBoard.php" class="nav-link text-warning">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#speedometer2" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="../index.php" class="nav-link" aria-current="page">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#home" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <a href="index.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#grid" />
                    </svg>
                    Products
                </a>
            </li>
            <!-- Filter & Search -->
            <li class="nav-item">
                <form class="d-flex m-auto" method="POST" action="../filter_admin.php">

                    <select class="form-select form-select-sm px-1 w-50" aria-label=".form-select-sm example"
                        name="category">
                        <option selected>All</option>
                        <?= $categories; ?>
                    </select>
                    <input class="form-control me-2" type="search" placeholder="Product" aria-label="Search"
                        name="search">
                    <button class="btn btn-outline-success btn-sm py-0" type="submit" id="dropdownMenuButton1">
                        <small>OK</small>
                    </button>
                </form>
            </li>
            <!-- end -->
            <li>
                <a href="../reviews.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    Reviews
                </a>
            </li>
            <li>
                <a href="../about.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    About
                </a>
            </li>
            <li>
                <a href="../contactus.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    Contact Us
                </a>
            </li>
            <li>
                <a href="../shopping_cart/index.php" class="nav-link text-warning">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    Shopping Cart<b><br>(from Peter)</b>
                </a>
            </li>
            <li>
                <a href="../shopping_cart.php" class="nav-link text-info">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    Shopping Cart<br>(<b>empty page</b>)
                </a>
            </li>
            <li>
                <a href="../rest_api/products_api.php" class="nav-link text-muted">
                    <svg class="bi me-2" width="16" height="12">
                        <use xlink:href="#table" />
                    </svg>
                    API (Products)
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>User Name</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </aside>
    <!-- [BOOTSTRAP JS] -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>