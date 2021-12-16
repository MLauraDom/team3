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


if ($_GET["id"]) {
    $product_id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE product_id = '{$product_id}';";
    $query = mysqli_query($connect, $sql);

    if (mysqli_num_rows($query) == 1) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC); //fetched row

        foreach ($result as $data) { //loop through array
            $product_name = $data['product_name'];
            $unit_price = $data['unit_price'];
            $fk_category_id = $data['fk_category_id'];
            $fk_manufacturer_id = $data['fk_manufacturer_id'];
            $description = $data['description'];
            $picture = $data['picture'];
        }
        // Get Manufacturer List
        $sql_manu = "SELECT * FROM manufacturers;";
        $res_manu = mysqli_query($connect, $sql_manu);
        $manu_list = "";
        if (mysqli_num_rows($res_manu) > 0) {
            while ($row = $res_manu->fetch_array(MYSQLI_ASSOC)) {
                if ($row['manufacturer_id'] == $fk_manufacturer_id) {
                    $manu_list .= "<option selected value='{$row['manufacturer_id']}'>{$row['company_name']}</option>";
                } else {
                    $manu_list .= "<option value='{$row['manufacturer_id']}'>{$row['company_name']}</option>";
                }
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
                if ($row['category_id'] == $fk_category_id) {
                    $category_list .= "<option selected value='{$row['category_id']}'>{$row['category_name']}</option>";
                } else {
                    $category_list .= "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                }
            }
        } else {
            $category_list = "<li>There are no categories registered</li>";
        }
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}

?>

<!-- 
------------------------
        HTML
------------------------ 
-->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <!-- [BOOTSTRAP] -->
    <?php require_once("../components/bootstrap.php") ?>
    <!-- CSS -->
    <style>
    .label {
        font-weight: lighter;
        color: lightgrey;
    }

    /* PREWORK CSS */
    fieldset {
        margin: auto;
        margin-top: 5vh;
        width: auto;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }
    </style>
    <title>Update the Pruduct</title>
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
        <section class="bg-dark mx-auto py-5 w-50 mt-2 mb-2">

            <form method="POST" action="actions/a_update.php" enctype="multipart/form-data"
                class="rounded-3 bg-dark mx-5">
                <div class="table-responsive">
                    <table class="table table-responsive mx-0 mb-0 text-white fs-6">
                        <tr>
                            <td colspan="2">
                                <h2 class="display-6 my-3 text-center text-white my-4">Update Product Records<br>
                                    <img class="img-fluid mt-4 border border-1 border-warningrounded w-50"
                                        src="../pictures/<?php echo $picture; ?>" alt="<?php echo $product_name ?>">
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">NAME</td>
                            <td><input class="form-control" type="text" name="product_name" value="<?= $product_name ?>"
                                    placeholder="Product name"></td>
                        </tr>
                        <tr>
                            <td class="label">PRICE </td>
                            <td><input class="form-control" type="number" name="unit_price" value="<?= $unit_price ?>"
                                    placeholder="Unitary Price"></td>
                        </tr>
                        <tr>
                            <td class="label">DISCOUNT (% OFF)</td>
                            <td><input class="form-control" type="number" name="discount"
                                    placeholder="If desired. E.g 10, 20 25..."></td>
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
                                    <input class="form-control" type="file" name="picture" value="../<?= $picture ?>"
                                        id="upload_picture">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">DESCRIPTION</td>
                            <td>
                                <textarea class="form-control" name="description" rows="8" value="<?= $description ?>"
                                    placeholder="Leave the description of the product in here..."></textarea>
                            </td>
                        </tr>>
                        <tr>
                            <td></td>
                            <td>
                                <div>
                                    <!-- hidden id and picture -->
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <input type="hidden" name="picture" value="<?= $picture ?>">
                                    <!-- submit button -->
                                    <input class="btn btn-outline-success px-5 py-3 mb-2 mt-4 fw-bold w-100"
                                        type="submit" name="name" placeholder="Name" value="Save changes">
                                </div>
                                <a href="../dashBoard.php">
                                    <p class="btn btn-outline-light py-0 mb-2 fw-bold w-100">Dashboard</p>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </section>
    </main>
    <!-- [FOOTER] -->
    <?php require_once("../components/footer.php"); ?>
</body>

</html>