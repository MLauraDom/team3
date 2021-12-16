<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$user_id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE status != '$status';";
$query = mysqli_query($connect, $sql);

//this variable will hold the body for the products CRUD
$sql_products = "SELECT * FROM products;";
$query_products = mysqli_query($connect, $sql_products);
$result = mysqli_fetch_all($query_products, MYSQLI_ASSOC);
$products = "";

if (mysqli_num_rows($query_products) > 0) {
    foreach ($result as $row) {
        $products .= "
        <tr class='align-middle text-center border-top border-bottom border-secondary'>
            <td class='text-center'><small>
                <a href='products/details.php?id={$row["product_id"]}'>
                <img class='img-fluid' width='135px' src='pictures/{$row["picture"]}'>
                </a></small>
            </td>
            <td><small>{$row['product_name']}</small></td>
            <td><small>{$row['unit_price']}</small></td>
            <td class='text-center'>
                <a class='d-block btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='products/details.php?id={$row['product_id']}'><small><i class='bi bi-eye text-primary'></i> More</small></a>

                <a class='d-block btn btn-sm btn-outline-secondary mx-auto w-5 py-0 my-1' href='products/update.php?id={$row['product_id']}'><small><i class='bi bi-pencil-square text-warning'></i> Edit</small></a>

                <a class='d-block btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='products/delete.php?id={$row['product_id']}'><small><i class='bi bi-trash text-danger'></i> Drop</small></a>
            </td>
        </tr>
        ";
    }

    //USERS: these variables will hold the body for the userss CRUD
    $sql_users = "SELECT * FROM users ORDER BY last_name ASC;";
    $query_users = mysqli_query($connect, $sql_users);
    $result = mysqli_fetch_all($query_users, MYSQLI_ASSOC);
    $users = "";

    if (mysqli_num_rows($query_users) > 0) {
        foreach ($result as $user) {
            $users .= "
            <tr class='align-middle border-top border-bottom border-secondary'>
                <td class='text-center'><small>
                    <a href='user_details.php?id={$user["user_id"]}'>
                    <img class='img-fluid rounded' width='35px' src='pictures/{$user["picture"]}'></a>
                    </small>
                </td>
                <td><small>{$user['first_name']} {$user['last_name']}</small></td>
                <td><small>{$user['email']}</small></td>
                <td><small class='" . (($user['status'] == 'ban') ? 'text-danger fw-bold' : 'text-success') . "'>{$user['status']}</small></td>
                <td class='text-center'>
                    <a class='btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='user_details.php?id={$user['user_id']}'><abbr class='text-decoration-none' title='View user'><small><i class='bi bi-eye text-primary'></i> </small></abbr></a>

                    <a class='btn btn-sm btn-outline-secondary mx-auto w-5 py-0 my-1' href='user_update.php?id={$user['user_id']}'><abbr class='text-decoration-none' title='Edit user'><small><i class='bi bi-pencil-square text-warning'></i> </small></abbr></a>

                    <a class='btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='user_delete.php?id={$user['user_id']}'><abbr class='text-decoration-none' title='Remove user'><small><i class='bi bi-person-dash-fill text-danger'></i> </small></abbr></a>

                    <a class='btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='user_ban.php?id={$user['user_id']}'>"
                . (($user['status'] == 'ban') ? '<abbr class="text-decoration-none" title="Grant access"><small><i class="bi bi-unlock-fill text-success"></i> </small></abbr>' : '<abbr class="text-decoration-none" title="Ban user"><small><i class="bi bi-lock-fill text-danger"></i> </small></abbr>') .
                "</a>
                </td>
            </tr>
            ";
        }
    }
}


// Getting Admin Data
$adm = "SELECT * FROM users WHERE user_id = '{$user_id}'";
$query_adm = mysqli_query($connect, $adm);
if ($query_adm) {
    $adm_data = mysqli_fetch_assoc($query_adm);
    while ($adm_data) {
        $full_name = $adm_data["first_name"] . " " . $adm_data["last_name"];
        $admin_picture = $adm_data["picture"];
        //    var_dump($full_name);
        break;
    }
    // var_dump($adm_data);
} else {
    echo "<h1>Fetching of the admin data failed!</h1>";
}
mysqli_close($connect);
?>

<!-- 
---------------------
        HTML
--------------------- 
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <style type="text/css">
    body {
        background: whitesmoke url("https://cdn-images-1.medium.com/max/1200/1*5fz2sKKTKjUmlVkWjtIUnQ.jpeg") black center center;
        background-size: cover;
    }

    main,
    aside {
        position: relative;
        /* min-height: 100vh; */
        margin: 0;
        padding: 0;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }

    td {
        text-align: left;
        vertical-align: middle;
    }

    tr {
        text-align: center;
    }

    .userImage {
        width: 100px;
        height: auto;
    }
    </style>
</head>

<body class="d-flex">
    <div class="container-fluid p-0">
        <!-- [DASHBOARD] -->
        <!-- <aside class="border border-danger"> -->
        <div class="row border border-warning border-3 alert alert-secondary p-0 m-0">
            <!-- navigation bar with log out, update profile functions -->
            <p class="bg-dark text-light text-end pb-2">
                <sub>
                    <a class="text-decoration-none text-light mx-2"
                        href="user_update.php?id=<?php echo $_SESSION['adm'] ?>">Update Profile</a>
                    <span class="text-light"> | </span>
                    <a class="text-decoration-none text-light mx-2" href="logout.php?logout">LogOut <i
                            class="bi bi-box-arrow-right text-warning"></i></a>
                </sub>
            </p>
            <!-- welcome message with 2 buttons(create function and view website as a normal user) -->
            <section class="row">
                <div class="col-2">
                    <div class="text-center ">
                        <img class="userImage rounded-3 mb-0" src="pictures/<?= $admin_picture ?>" alt="Adm avatar">
                        <p class="text-center text-danger fw-bolder">Administrator</p>
                    </div>
                </div>
                <div class="col-10">
                    <div class="text-center">
                        <h2 class="fs-5 fw-bolder mb-3">Welcome to the Dashboard!</h2>
                        <h2 class="fw-lighter text-danger mt-2 mb-4"><?= $full_name ?></h2>

                        <p class="text-center mt-5">
                            <a class="btn btn-outline-primary fw-bolder py-0 px-2" href="products/index.php">View
                                Website</a>
                            <a class="btn btn-outline-dark fw-bolder py-0 my-1 text-decoration-none"
                                href="reviews.php">Reviews</a>
                            <a class="btn btn-outline-warning fw-bolder py-0 my-1 text-decoration-none"
                                href="statistics.php">Statistics</a>
                        </p>
                    </div>
                </div>
                <section>
                    <!-- <hr class="bg-dark py-1 mt-3 mb-0"> -->
        </div>
        <!-- </aside> -->


        <!-- [PRODUCTS' LIST]...
        ATTENTION: create PRODUCT function in the dashboard -->
        <main>
            <section class="my-5 p-0">
                <h1 class='display-6 text-center m-0'>Products' Registry</h1>
                <hr class="bg-dark shadow py-1 w-50 mx-auto mb-4 mt-1">
                <div class="container border border-secondary border-2 rounded rounded-danger">
                    <!-- create product button -->
                    <div class="text-start align-items-center"><a
                            class="text-decoration-none btn btn-sm btn-success py-0 my-1"
                            href="products/create.php"><span class="align-middle"><i
                                    class="bi bi-bag-plus-fill fs-5"></i> Create Product</span></a></div>
                    <div class="table-responsive">
                        <table class="table table-light table-striped border border-secondary my-0">
                            <thead class="table-secondary">
                                <tr class="align-middle">
                                    <th>Picture</th>
                                    <th class="text-start">Name</th>
                                    <th class="text-start">Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= $products ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- [USERS' LIST]... -->
            <section class="my-5 p-0">
                <h1 class='display-6 text-center m-0'>Users' Registry</h1>
                <hr class="bg-dark shadow py-1 w-50 mx-auto mb-4 mt-1">
                <div class="container border border-secondary border-2 rounded rounded-danger">
                    <!-- create user button -->
                    <div class="text-start align-items-center"><a
                            class="text-decoration-none btn btn-sm btn-success py-0 my-1" href="user_create.php"><span
                                class="align-middle"><i class="bi bi-person-plus-fill fs-5"></i> Create User</span></a>
                    </div>
                    <!-- users' table -->
                    <div class="table-responsive">
                        <table class="table table-light table-striped border border-secondary my-0">
                            <thead class="table-secondary">
                                <tr class="align-middle">
                                    <th class="text-center">Picture</th>
                                    <th class="text-start">Name</th>
                                    <th class="text-start">Email</th>
                                    <th class="text-start">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= $users ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>