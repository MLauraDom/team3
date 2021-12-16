<?php
session_start();
require_once("../components/db_connect.php");

if (isset($_SESSION['adm']) != "") {
    header("Location: ../dashBoard.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

// Get user's username or actual name (for now username)
$user_id = ($_SESSION['user']);
$sql_get_user = "SELECT * FROM users WHERE users.user_id = $user_id";
$query_get_user = mysqli_query($connect, $sql_get_user);
$result_get_user = mysqli_fetch_all($query_get_user, MYSQLI_ASSOC);
// var_dump($result_get_user);
$username = $result_get_user[0]["username"];
// echo $username;


// Add if coming from details.php
// Query for adding to cart: (QUANTITY NEEDS SORTING)
if ($_POST) {
    $product_id = $_POST["product_id"];
    // echo $product_id . '<br>';
    $quantity = (int)$_POST["quantity"];
    // echo gettype($quantity) . '<br>';
    // echo $user_id;

    // Check quantity
    $sql_qtty_check = "SELECT * FROM user_products WHERE fk_product_id = $product_id AND fk_user_id = $user_id;";
    $res_qtty_check = mysqli_query($connect, $sql_qtty_check);
    if (mysqli_num_rows($res_qtty_check) > 0) {
        $record = mysqli_fetch_assoc($res_qtty_check);
        $current_qtty = (int)$record['quantity'];
        // echo "current is " . $current_qtty;
        $sql_insert = "UPDATE user_products SET quantity = $current_qtty + $quantity WHERE fk_product_id = $product_id;";
        $query_insert = mysqli_query($connect, $sql_insert);
    } else {
        $sql_insert = "INSERT INTO user_products(fk_user_id, fk_product_id, quantity) VALUES ($user_id, $product_id, $quantity);";
        $query_insert = mysqli_query($connect, $sql_insert);
    }
}


// Show user their cart & get total price
$sql_show = "SELECT * FROM user_products up JOIN products p ON up.fk_product_id = p.product_id WHERE up.fk_user_id = $user_id GROUP BY up.fk_product_id";
$query_show = mysqli_query($connect, $sql_show);
$result_show = mysqli_fetch_all($query_show, MYSQLI_ASSOC);
$user_prod = "";

// Calculate total
$sum = array();
$total_price = 0;

if (mysqli_num_rows($query_show) > 0) {
    foreach ($result_show as $row) {
        $subtotal = $row['quantity'] * $row['unit_price'];
        $user_prod .= "
            <tr class='align-middle text-center border-top border-bottom border-secondary'>
                <td>
                    <a href='details.php?id={$row["product_id"]}'>
                        <img class='img-fluid' width='200px' src='../pictures/{$row["picture"]}'>
                    </a>
                </td>
                <td>{$row['product_name']}</td>
                <td>{$row['unit_price']}€</td>
                <td>
                    <div class= 'd-flex justify-content-evenly align-items-center'>
                        <a class='btn btn-sm btn-outline-danger text-center' href='actions/a_cart.php?id={$row["user_product_id"]}'>
                            <img src='../pictures/icons/cart-dash.svg'/>
                        </a>
                        <h4 class='font-weight-bold'>{$row['quantity']}</h4>
                        <a class='btn btn-sm btn-outline-primary text-center' href='actions/a_cart_plus.php?id={$row["user_product_id"]}'>
                            <img src='../pictures/icons/cart-plus.svg'/>
                        </a>
                    </div>    
                </td>
                <td>{$subtotal}€</td>
                <td>
                    <div class='d-flex flex-column align-items-center'>
                        <a class='btn btn-sm btn-outline-danger w-75 p-1' href='actions/a_cart_remove_all.php?id={$row["user_product_id"]}'>
                            <img src='../pictures/icons/cart-x.svg'/>
                            <span>Remove from Cart</span>
                        </a>
                    </div>
                </td>
            </tr>
            ";
        array_push($sum, $subtotal);
    }
} else {
    $user_prod = "nothing in cart";
}


$total_price = round(array_sum($sum), 2);

// echo $total_price;
mysqli_close($connect);

?>


<!-- 
---------------- 
    HTML
---------------- 
-->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <!-- BOOTSTRAP -->
    <?php require_once '../components/bootstrap.php' ?>
    <title>Shopping Cart</title>
</head>

<body
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

    <!-- [MAIN] -->
    <main>
        <div class=" container pt-4 pb-5">
            <h1 class="text-center fw-light display-5"><?php echo $username . "'s Shopping Cart" ?></h1>
            <hr class="bg-success py-1 mb-2 mx-auto">
            <div class="table-responsive">
                <table
                    class="table table-success table-hover border border-light mt-2 mb-5 mx-auto w-100 shadow-lg rounded">
                    <thead class="table-dark text-center">
                        <tr class="align-middle">
                            <td>Picture</td>
                            <td>Name</td>
                            <td>Unit Price</td>
                            <td>Quantity</td>
                            <td>Subtotal</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $user_prod ?>
                    </tbody>
                </table>
            </div>
            <hr class="m-1">
            <div class="total container d-flex">
                <div>

                    <h3 class="">Total:</h3>

                </div>
                <div>
                    <?php
                    if ($total_price > 200 && $total_price <= 500) {
                        $discount_price = round($total_price * 0.9, 2);
                        echo "<h3 class=''><s class='text-danger'>&nbsp;{$total_price}€</s><br>Our price: <b class='text-success'>{$discount_price}€</b> You spent over <u>200€</u> so we added a 10% discount 😊</h3>";
                    }
                    if ($total_price > 500) {
                        $discount_price = round($total_price * 0.85, 2);
                        echo "<h3 class=''><s class='text-danger'>&nbsp;{$total_price}€</s><br> Our price: <b class='text-success'>&nbsp;{$discount_price}€</b> You spent over <u>500€</u> so we added a 15% discount 😊</h3>";;
                    } else {
                        echo "<h3 class=''>&nbsp;" . $total_price . "€</h3>";
                    } ?>
                </div>

            </div>
            <hr class="m-1">
            <div class="btn-wrapper text-center mt-2">
                <a href="confirm.php" class="btn btn-success mt-4 p-3 border rounded">Complete purchase</a>
            </div>
            <div class="btn-wrapper mt-4">
                <a href='index.php'><button class="btn btn-outline-dark mt-4 p-3 border rounded" type='button'>
                        <img src="../pictures/icons/arrow-bar-left.svg" alt="">
                        Continue
                        Shopping</button>
                </a>
            </div>
        </div>
    </main>
    <!-- [FOOTER] -->
    <?php
    require_once("../components/footer.php");
    ?>
</body>

</html>