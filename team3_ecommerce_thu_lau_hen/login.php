<?php
session_start();
require_once 'components/db_connect.php';

// TO DO: connect to the sanitizer.php
// require_once("components/sanitizer.php");
// apply sanitizeInput() function on following variables:
// $fname = $lname = $username = $email = $address= $birth_date = $pass


// it will never let you open login page if session is set
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
    exit;
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashBoard.php"); // redirects to home.php
}

$error = false;
$email = $password = $emailError = $passError = '';

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {
        $password = hash('sha256', $pass); // password hashing

        $sql = "SELECT user_id, first_name, password, status FROM users WHERE email = '$email';";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
        $count = mysqli_num_rows($query);
        if ($count == 1 && $row['password'] == $password) {
            if ($row['status'] == 'adm') {
                $_SESSION['adm'] = $row['user_id'];
                header("Location: dashBoard.php");
            } else {
                $_SESSION['user'] = $row['user_id'];
                header("Location: home.php");
            }
        } else {
            $errMSG = "<p class='text-danger'><i class='bi bi-exclamation-triangle'></i> Incorrect Credentials, Try again...</p>";
        }
    }
}

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <!-- [CSS] -->
    <style>
    main {
        height: 100vh;
    }
    </style>
</head>

<body>
    <main class="py-5">
        <div class="container bg-light rounded-3 text-dark border border-success  border-3 w-50 p-0">
            <form class="w-auto rounded mx-auto shadow py-5 px-3 border" method="post"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on">
                <h2 class="display-5 mb-5 mt-0 text-center text-success">Log In</h2>
                <hr class="border border-success">
                <?php
                if (isset($errMSG)) {
                    echo $errMSG;
                }
                ?>
                <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Your Email"
                    value="<?php echo $email; ?>" maxlength="40" />
                <span class="text-danger"><?php echo $emailError; ?></span>

                <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                <span class="text-danger"><?php echo $passError; ?></span>
                <hr class="border border-success">
                <p class="text-center mt-3 mb-5"><button class="btn btn-block btn-primary w-50" type="submit"
                        name="btn-login">Log In</button></p>
                <small>Not registered yet? <a href="register.php">Click here</a></small>
            </form>
        </div>
    </main>
</body>

</html>