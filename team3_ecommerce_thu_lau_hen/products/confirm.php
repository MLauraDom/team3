<?php
session_start();
// Include required phpmailer files
require_once '../components/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

// Get user info
$user_id = ($_SESSION['user']);
$sql_get_user = "SELECT * FROM users WHERE users.user_id = $user_id";
$query_get_email = mysqli_query($connect, $sql_get_user);
$result_get_user = mysqli_fetch_all($query_get_email, MYSQLI_ASSOC);
// var_dump($result_get_user);
$fName = $result_get_user[0]["first_name"];
$lName = $result_get_user[0]["last_name"];
$user_name = $fName . " " . $lName;
$user_email = $result_get_user[0]["email"];
$user_address = $result_get_user[0]["address"];
// echo $user_address;

// Get Order info
$sql_show = "SELECT * FROM user_products up JOIN products p ON up.fk_product_id = p.product_id WHERE up.fk_user_id = $user_id GROUP BY up.fk_product_id";
$query_show = mysqli_query($connect, $sql_show);
$result_show = mysqli_fetch_all($query_show, MYSQLI_ASSOC);
$order_prod = "";
$prod_names = "";
// Calculate total
$sum = array();
$total_price = 0;

if (mysqli_num_rows($query_show) > 0) {
    foreach ($result_show as $row) {
        $subtotal = $row['quantity'] * $row['unit_price'];
        $order_prod .= "<div class='col-sm-12 col-md-6 col-lg-3'>
                            <div class='card text-dark' style='width: 100%;'>
                                <a href='details.php?id={$row["product_id"]}'>
                                    <img class='card-img-top' style='width:100%; height:12rem;' src='../pictures/{$row["picture"]}'>
                                </a>
                                <div class='card-body'>
                                <hr>
                                    <h5 class='card-title'>{$row['product_name']}</h5>
                                    <p class='card-text'>Unit Price: {$row['unit_price']}€</p>
                                    <p class='card-text'>Quantity:{$row['quantity']}</p>
                                    <p class='card-text'>Subtotal: {$subtotal}€</p>
                                </div>
                            </div>
                        </div>
                ";

        $prod_names .= "
                        <li>{$row['product_name']}</li>
        ";

        // get total...
        array_push($sum, $subtotal);
    }
} else {
    $order_prod = "No pending orders";
}

// Show discount if necessary
$total_price = round(array_sum($sum), 2);
if ($total_price > 200 && $total_price <= 500) {
    $total_price = round($total_price * 0.9, 2);
}
if ($total_price > 500) {
    $total_price = round($total_price * 0.85, 2);
}

// echo $total_price;



// Automatic email
require_once '../components/PHPMailer.php';
require_once '../components/SMTP.php';
require_once '../components/Exception.php';
// Define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// This would be where we could add to a separate table to save orders
if ($_POST) {

    $alt_address = $_POST['address'];
    $sql_address = "UPDATE users SET address = '$alt_address' WHERE user_id = $user_id;";
    $alt_addr_query = mysqli_query($connect, $sql_address);
    if ($alt_addr_query) {
        $user_address = $alt_address;
    }

    // Create instance of PHPMailer
    $mail = new PHPMailer();
    // Set mailer to use SMTP
    $mail->isSMTP();
    // Define SMTP host
    $mail->Host = "smtp.gmail.com";
    // Enable SMTP authentication
    $mail->SMTPAuth = "true";
    // Set type of encryption (ssl/tls)
    $mail->SMTPSecure = "tls";
    // Set port to connect SMTP
    $mail->Port = "587";
    // Set Gmail username
    $mail->Username = "noreply.team3@gmail.com";
    // Set Gmail password
    $mail->Password = "n0reply321";
    // Set Gmail subject
    $mail->Subject = "Team3 Order confirmation";
    // Set sender email
    $mail->setFrom("noreply.team3@gmail.com");
    // Enable HTML
    $mail->isHTML(true);
    // Attachment
    $mail->addAttachment('../pictures/attach/attach.jpeg');
    // // Email body
    // $mail->Body = "This is plain text email body";
    // Email body HTML
    $mail->Body = "<h1>Your Team-3 Order is Confirmed!</h1>
                    <br>
                    <p>Your order of:</p>
                    {$prod_names}
                    <p>is on it's way to: </p>
                    <p>{$user_name}</p>
                    <p>Shipping Address:{$user_address}</p>
                    <p>Total Price: {$total_price}€</p>
                    <h3>Thanks for shopping with Team-3!</p>
                    ";
    // Add recipient
    $mail->addAddress("$user_email");
    // Finally send email
    if ($mail->Send()) {
        $sql_confirm = "DELETE FROM user_products WHERE fk_user_id = $user_id;";
        mysqli_query($connect, $sql_confirm);
        header('location: actions/a_confirm.php');
    } else {
        echo "Error!";
    }
    // closing SMTP connection
    $mail->smtpClose();
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Confirm Order</title>
    <!-- BOOTSTRAP -->
    <?php require_once '../components/bootstrap.php' ?>
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
    <fieldset class="w-75 m-auto bg-dark text-light mt-5 p-3 rounded shadow-lg mb-5">
        <h2 class="text-center">Complete your purchase</h2>
        <hr>
        <div class="container m-auto">
            <div class="row">
                <?= $order_prod; ?>
            </div>
            <hr>
            <div class="text-center">
                <h3>Total: </h3> <?= $total_price . "€"; ?>
            </div>
        </div>
        <hr>
        <!-- Address Info -->
        <div class="container">
            <div class="w-50 m-auto border-right">
                <?php echo "<h3 class='text-center'>Current Address</h3>
                <hr>
                            <p class='text-center'>{$user_name}</p>
                            <p class='text-center'>{$user_address}</p>
                            <hr>";
                ?>
            </div>
        </div>
        <div class="container w-50 form-container text-center">
            <form method="POST" id="form">
                <label for="address">Alternative shipping address?</label>
                <input type="text" name="address" class="form-control">
                <input type="submit" value="submit" class="form-control btn-success w-50 m-auto mt-3">
            </form>
        </div>
    </fieldset>

    <!-- [FOOTER] -->
    <?php
    require_once("../components/footer.php");
    ?>


</body>

</html>