<?php
session_start();

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$backBtn = '';
//if it is a user it will create a back button to home.php
if (isset($_SESSION["user"])) {
    $backBtn = "home.php";
}
//if it is a adm it will create a back button to dashboard.php
if (isset($_SESSION["adm"])) {
    $backBtn = "dashBoard.php";
}

//fetch and populate form
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = {$user_id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $username = $data['username'];
        $birth_date = $data['birth_date'];
        $email = $data['email'];
        $address = $data['address'];
        $picture = $data['picture'];
    }
}

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $birth_date = $_POST['birth_date'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    //variable for upload pictures errors is initialized
    $uploadError = '';
    $pictureArray = file_upload($_FILES['picture']); //file_upload() called
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username',  email = '$email', birth_date = '$birth_date', address = '$address', picture = '$pictureArray->fileName' WHERE user_id = {$user_id}";
    } else {
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username',  email = '$email', birth_date = '$birth_date', address = '$address' WHERE user_id = {$user_id}";
    }
    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "Your profile was successfully updated";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:1;url=dashBoard.php");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:1;url=dashBoard.php");
    }
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <style type="text/css">
    fieldset {
        margin: auto;
        margin-top: 100px;
        width: 60%;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }

    main {
        height: 100vh;
    }
    </style>
</head>

<body>

    <!-- [MAIN] -->
    <main>
        <div class="container py-5">
            <div class="<?php echo $class; ?>" role="alert">
                <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
            </div>
            <section class="bg-dark shadow rounded-3 py-5 px-3 mx-auto w-75">
                <h2 class="text-warning text-center">Update Profile</h2>
                <hr class="bg-warning py-1 mb-3 mx-auto w-75">
                <p class="text-center"><img class='rounded-circle border border-3 border-warning' height="200vh"
                        src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $first_name ?>"></p>
                <form method="post" enctype="multipart/form-data">
                    <table class="table table-hover table-muted rounded-3 text-muted ">
                        <tr>
                            <th>First Name</th>
                            <td><input class="form-control" type="text" name="first_name" placeholder="Your First Name"
                                    value="<?php echo $first_name ?>" /></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td><input class="form-control" type="text" name="last_name" placeholder="Your Last Name"
                                    value="<?php echo $last_name ?>" /></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><input class="form-control" type="text" name="username" placeholder="Your Username"
                                    value="<?php echo $username ?>" /></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input class="form-control" type="email" name="email" placeholder="Your Email"
                                    value="<?php echo $email ?>" /></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><input class="form-control" type="text" name="address" placeholder="Your Address"
                                    value="<?php echo $address ?>" /></td>
                        </tr>
                        <tr>
                            <th>Date of birth</th>
                            <td><input class="form-control" type="date" name="birth_date"
                                    value="<?php echo $birth_date ?>" /></td>
                        </tr>
                        <tr>
                            <th>Picture</th>
                            <td>
                                <div class="input-group my-1 py-0">
                                    <label class="input-group-text" for="upload_picture"><i
                                            class="bi bi-camera-fill text-success"></i></label>
                                    <input class="form-control" type="file" name="picture" id="upload_picture">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="user_id" value="<?php echo $data['user_id'] ?>">
                            <input type="hidden" name="picture" value="<?php echo $picture ?>">
                            <td><a href="<?php echo $backBtn ?>"><button class="btn btn-warning py-0 px-3 w-100"
                                        type="button">Back</button></a></td>
                            <td class="text-center"><button name="submit" class="btn btn-success py-0 w-75"
                                    type="submit">Save Changes</button></td>
                        </tr>
                    </table>
                </form>
            </section>
        </div>
    </main>
</body>

</html>