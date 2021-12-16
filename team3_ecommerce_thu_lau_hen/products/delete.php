<?php
session_start();
require_once '../components/db_connect.php';

if (isset($_SESSION['user']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$delete = "";
$errorDelete = ""; //setting the empty variable for the error message

if ($_GET["id"]) {
    $product_id = $_GET["id"];
    $sql = "SELECT product_name, picture, unit_price, description, category_name FROM products p JOIN categories c ON p.fk_category_id = c.category_id WHERE product_id = '{$product_id}';";
    $query = mysqli_query($connect, $sql);

    if (mysqli_num_rows($query) == 1) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $data) {
            $delete .= "
                <div class='border border-3 border-danger text-center text-danger pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
                    <h1><i class='bi bi-shield-exclamation pe-2 '></i>ALERT</h1>
                    <hr class='bg-danger py-1 mx-auto w-75'>
                    <p>You are about to <b>delete</b> this record. <br>Would you REALLY like to do it?</p>
                    <form class='m-0 p-0' action='actions/a_delete.php' method='POST'>
                        <input type='hidden' name='product_id' value='{$product_id}'>
                        <input type='hidden' name='picture' value='{$data["picture"]}'>
                        <p class='text-center mt-3 mb-0'>
                        <button class='btn btn-outline-danger py-1 px-3 mx-2 w-25' type='submit'>Yes, please</button>
                        <a href='index.php'><span class='btn btn-outline-primary py-1 px-3 mx-2 w-25'>No, keep it</span></a>
                        </p>
                    </form>
                </div>
                
                <div class='card shadow mt-3 mb-5 mx-auto' style='width: 20rem;'>
                    <img class='card-img-top img-fluid' src='../pictures/{$data["picture"]}' alt='Card image cap'>
                    <div class='card-body'>
                        <h3 class='card-title text-center mt-3 mb-0'>{$data["product_name"]}</h3>
                        <h6 class='card-subtitle text-center text-secondary fst-italic mt-0 mb-2'>(Category: {$data["category_name"]})</h6>

                        <hr class='py-1 mt-1 mb-5'>

                        <p class='p-0 m-0'><span class='text-secondary fw-bold'>Price: </span>{$data["unit_price"]}</p> 
                        
                        <hr>
                        <p class='card-text'><i class='bi bi-book-half'></i> <b class='text-secondary'>Description</b><br>{$data["description"]}</p>
                        
                    </div>
                </div>
";
        }
    } else {
        $errorDelete = "<div class='alert alert-primary m-5 p-3 border-3 border-primary text-dark text-center fs-4 mx-auto w-75'><h1 class='text-primary mt-5 mb-3 pb-0'><i class='bi bi-exclamation-diamond-fill fs-1'></i> SORRY</h1>
            <p class='mb-5'>No record could be identified.</p></div>";
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
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
    <?php require_once("../components/bootstrap.php") ?>
    <!-- [CSS] -->
    <style>
    main {
        min-height: 100vh;
        padding: 3% 15%;
    }
    </style>
    <title>Delete Product?</title>
</head>

<body>
    <!-- [HERO/HEADER] -->
    <?php
    require_once("../components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout_url = $img_url = "../";
    require_once("../components/navbar.php");
    ?>

    <!-- [MAIN] -->
    <main>
        <section class="container-fluid m-0 mx-auto py-5 w-100">

            <!-- [Here comes a selected item to be deleted or an Message] -->
            <?= $delete ?>
            <?= $errorDelete ?>
        </section>
    </main>
    <!-- [FOOTER] -->
    <?php
    require_once("../components/footer.php");
    ?>
</body>

</html>