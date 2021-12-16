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

// Get Manufacturer List
$sql_manu = "SELECT * FROM manufacturers;";
$res_manu = mysqli_query($connect, $sql_manu);
$manu_list = "";
if (mysqli_num_rows($res_manu) > 0) {
    while ($row = $res_manu->fetch_array(MYSQLI_ASSOC)) {
        $manu_list .= "<option selected value='{$row['manufacturer_id']}'>{$row['company_name']}</option>";
    }
} else {
    $manu_list = "<li>There are no manufacturers registered</li>";
}
// Get Category List
$sql_category = "SELECT * FROM categories;";
$res_category = mysqli_query($connect, $sql_category);
$category_list = "";
if (mysqli_num_rows($res_category) > 0) {
    while ($row = $res_category->fetch_array(MYSQLI_ASSOC)) {

        $category_list .= "<option selected value='{$row['category_id']}'>{$row['category_name']}</option>";
    }
} else {
    $category_list = "<li>There are no categories registered</li>";
}

?>


<!-- 
------------------------
        HTML
------------------------ 
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../components/bootstrap.php") ?>
    <!-- CSS -->
    <style>
    input {
        width: 100%;
    }

    main {
        min-height: 100vh;
    }

    .label {
        font-weight: lighter;
        color: lightgrey;
    }
    </style>
    <title>Add Product</title>
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
        <!-- [FORM] -->
        <form method="POST" action="actions/a_create.php" enctype="multipart/form-data" class="mx-5 my-0">
            <section class="table-responsive bg-dark rounded-3 px-5 mx-auto" style="max-width: 600px">

                <table class="table table-dark text-muted fs-6 m-0  mx-auto w-auto">
                    <tr>
                        <td colspan="2">
                            <h2 class="display-4 mb-5 text-center text-white my-4">New Product Record</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">NAME</td>
                        <td><input class="form-control" type="text" name="product_name"></td>
                    </tr>
                    <tr>
                        <td class="label">PRICE</td>
                        <td><input class="form-control" type="number" name="unit_price"></td>
                    </tr>
                    <tr>
                        <td class="label">CATEGORY</td>
                        <td>
                            <select class="form-select" name="category" aria-label="Default select example">
                                <?php echo $category_list; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class=" label">MANUFACTURER
                        </td>
                        <td>
                            <select class="form-select" name="manufacturer" aria-label="Default select example">
                                <?php echo $manu_list; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">PICTURE</td>
                        <td>
                            <div class="input-group">
                                <label class="input-group-text" for="upload_picture"><i
                                        class="bi bi-camera-fill"></i></label>
                                <input class="form-control" type="file" name="picture" id="upload_picture">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">DESCRIPTION</td>
                        <td>
                            <textarea class="form-control" name="description" rows="8"
                                placeholder="Leave the description of the product in here..."></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <input class="btn btn-outline-success px-5 py-3 mb-2 mt-4 fw-bold" type="submit"
                                value="Create Product">
                            <a href="../dashBoard.php">
                                <p class="btn btn-outline-light py-0 mb-2 fw-bold w-100">Dashboard</p>
                            </a>
                            <br>
                            <br>
                            <br>
                        </td>
                    </tr>
                </table>
            </section>
        </form>
    </main>
    <!-- [FOOTER] -->
    <?php
    require_once("../components/footer.php");
    ?>
</body>

</html>