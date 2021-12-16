<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home page
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) { //redirects non users to the welcome page
    header("Location: index.php");
    exit;
}

require_once 'components/db_connect.php';
require_once 'components/file_upload_user.php';
// refer to the sanitize function
require_once("components/sanitizer.php");


$error = false;
$fname = $lname = $username = $email = $address = $birth_date = $pass1 = $pass2 = $picture = '';
$fnameError = $lnameError = $usernameError = $emailError = $addressError = $dateError = $passError = $picError = '';
if (isset($_POST['btn_create_user'])) {

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
            $errMSG = "<p class='text-center fs-5'><i class='bi bi-check2-circle fs-3'></i> New User has been created.</p>";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
            header("refresh:2;url=dashBoard.php"); //redirect to Dashboard page after creating a user
        } else {
            $errTyp = "danger";
            $errMSG = "<i class='bi bi-exclamation-circle fs-5'></i> Creation of a New User failed. Please, try again.";
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
    <title>User Creation</title>
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
        <div class="container shadow bg-light rounded-3 text-dark border border-dark  border-3 w-50 py-5 my-5">
            <!-- form -->
            <form class="w-75 mx-auto" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                autocomplete="on" enctype="multipart/form-data">
                <!-- Icon -->
                <p class="text-center"><i class="bi bi-person-plus-fill display-2 fw-bolder"></i></p>
                <h2 class="display-3 mb-4 mt-0 text-center text-dark">
                    Create User
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
                <input type="email" name="email" class="form-control my-1 py-1" placeholder="Email" maxlength="40"
                    value="<?= $email ?>" />
                <span class="text-danger"> <?= $emailError; ?> </span>
                <!-- address -->
                <input type="text" name="address" class="form-control my-1 py-1" placeholder="Address"
                    value="<?= $address ?>" />
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
                <div class="text-end my-0">
                    <p class="py-0 mb-0"><button type="submit" class="btn btn-success justify-content-end w-100"
                            name="btn_create_user">Create User</button></p>
                    <p><a class="btn btn-outline-dark my-1 py-0 w-100" href="dashBoard.php">Dashboard</a></p>
                    </divp>

            </form>
        </div>
    </main>
</body>

</html>