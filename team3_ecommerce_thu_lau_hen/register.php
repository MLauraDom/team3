<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to login page
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashboard.php"); // redirects to dashBOard
}

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
// refer to the sanitize function
require_once("components/sanitizer.php");


$error = false;
$fname = $lname = $username = $email = $address = $birth_date = $pass1 = $pass2 = $picture = '';
$fnameError = $lnameError = $usernameError = $emailError = $addressError = $dateError = $passError = $picError = '';
if (isset($_POST['btn-signup'])) {

    // set variables from POST method
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $address = ($_POST['address']);
    $birth_date = ($_POST['birth_date']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if ($pass1 === $pass2) {
        $pass = $pass1;
    } else {
        $pass = $pass1;
        $error = true;
        $passError = "Passwords do not match.";
    }

    //sanitize variables above through the funciton in sanitize.php file 
    $clean = sanitize(array($fname, $lname, $username, $email, $address, $birth_date, $pass));
    $fname = $clean[0];
    $lname = $clean[1];
    $username = $clean[2];
    $email = $clean[3];
    $address = $clean[4];
    $birth_date = $clean[5];
    $pass = $clean[6];

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);

    // basic name validation
    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your full name and surname";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $fnameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic user name validation
    if (empty($username)) {
        $error = true;
        $usernameError = "Please enter your user name";
    } else if (strlen($username) < 1) {
        $error = true;
        $usernameError = "The user name must have at least 6 characters.";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $error = true;
        $usernameError = "User must contain only letters, digits (0-9) and no spaces.";
    }

    //basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    //checks if the address input was left empty
    //    if (empty($address)) {
    //     $error = true;
    //     $addressError = "Please enter your date of birth.";
    // }
    //checks if the date input was left empty
    if (empty($birth_date)) {
        $error = true;
        $dateError = "Please enter your date of birth.";
    }
    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users(first_name, last_name, username, address, password, birth_date, email, picture)
                 VALUES('$fname', '$lname', '$username', '$address', '$password', '$birth_date', '$email', '$picture->fileName');";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "<p><i class='bi bi-shield-fill-check'></i> Successfully registered, you may login now.</p>";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
            header("refresh:2;url=login.php"); //redirect to login page after successful registration
        } else {
            $errTyp = "danger";
            $errMSG = "<i class=bi bi-shield-fill-exclamation></i>Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <title>Account Registration</title>
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
    <main>
        <!-- container -->
        <div class="container shadow bg-light rounded-3 text-dark border border-success  border-3 w-50 py-5 my-5">
            <!-- form -->
            <form class="w-75 mx-auto" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                autocomplete="on" enctype="multipart/form-data">
                <h2 class="display-5 mb-4 mt-0 text-center text-success">
                    <!-- logos -->
                    <img class="mb-3" width="80px" src="pictures/layout_img/logo.png" alt="logo"><br>
                    Sign Up
                </h2>
                <hr />
                <?php
                if (isset($errMSG)) {
                ?>
                <div class="alert alert-muted border border-<?= $errTyp ?> text-<?= $errTyp ?>">
                    <p><?= $errMSG; ?></p>
                    <p><?= $uploadError; ?></p>
                </div>

                <?php
                }
                ?>
                <!-- first name -->
                <input type="text" name="fname" class="form-control my-1 py-1" placeholder="First name" maxlength="50"
                    value="<?= $fname ?>" />
                <span class="text-danger"> <?= $fnameError; ?> </span>
                <!-- last name -->
                <input type="text" name="lname" class="form-control my-1 py-1" placeholder="Surname" maxlength="50"
                    value="<?= $lname ?>" />
                <span class="text-danger"> <?= $fnameError; ?> </span>
                <!-- user name -->
                <input type="text" name="username" class="form-control my-1 py-1" placeholder="User Name" maxlength="50"
                    value="<?= $username ?>" />
                <span class="text-danger"> <?= $usernameError; ?> </span>
                <!-- date of birth -->
                <input class='form-control my-1 py-1' type="date" name="birth_date" value="<?= $birth_date ?>" />
                <span class="text-danger"> <?= $dateError; ?> </span>
                <!-- email -->
                <input type="email" name="email" class="form-control my-1 py-1" placeholder="Email"
                    maxlength="40" value="<?= $email ?>" />
                <span class="text-danger"> <?= $emailError; ?> </span>
                <!-- address -->
                <input type="text" name="address" class="form-control my-1 py-1"
                    placeholder="Address" value="<?= $address ?>" />
                <!-- <span class="text-danger"> <?= $addressError; ?> </span> -->
                <!-- picture -->
                <div class="input-group my-1 py-0">
                    <label class="input-group-text" for="upload_picture"><i class="bi bi-camera-fill"></i></label>
                    <input class="form-control" type="file" name="picture" id="upload_picture">
                </div>
                <span class="text-danger"> <?= $picError; ?> </span>
                <!-- password -->
                <input type="password" name="pass1" class="form-control my-1 py-1" placeholder="Enter Password"
                    maxlength="15" />
                <input type="password" name="pass2" class="form-control my-1 py-1" placeholder="Confirm Password"
                    maxlength="15" />
                <span class="text-danger"> <?= $passError; ?> </span>
                <hr>
                <!-- submit button -->
                <p class="text-end my-0">
                    <button type="submit" class="btn btn-block btn-primary justify-content-end text-end"
                        name="btn-signup">Let' Go</button>
                </p>
                <hr class="p-0 mb-1">
                <small><span class="text-secondary my-0">Already registered?</span> <a href="login.php">Log in here...</a></small>
            </form>
        </div>
    </main>
</body>

</html>