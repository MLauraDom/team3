<?php
session_start();
require_once '../../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_GET) {
    $user_prod_id = $_GET["id"];
    $sql_check = "SELECT * FROM user_products up JOIN products p ON up.fk_product_id = p.product_id WHERE user_product_id = $user_prod_id;";
    $res_check = mysqli_query($connect, $sql_check);
    $data = mysqli_fetch_assoc($res_check);
    $product_name = $data['product_name'];
    $quantity = (int)$data['quantity'];

    $new_qtty = $quantity + 1;
    $sql = "UPDATE user_products SET quantity = $new_qtty WHERE user_product_id = $user_prod_id;";
    $decrease = mysqli_query($connect, $sql);

    if ($decrease) {
        header("location: ../cart.php");
    }


    mysqli_close($connect);
} else {
    header("location: ../error.php");
}