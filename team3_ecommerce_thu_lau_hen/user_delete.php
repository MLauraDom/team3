<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
   header("Location: index.php");
   exit;
}
if (isset($_SESSION["user"])) {
   header("Location: home.php");
   exit;
}

//initial bootstrap class for the confirmation message
$class = 'd-none';
//the GET method will show the info from the user to be deleted
if ($_GET['id']) {
   $id = $_GET['id'];
   $sql = "SELECT * FROM users WHERE user_id = {$id}";
   $result = mysqli_query($connect, $sql);
   $data = mysqli_fetch_assoc($result);
   if (mysqli_num_rows($result) == 1) {
      $f_name = $data['first_name'];
      $l_name = $data['last_name'];
      $email = $data['email'];
      $birth_date = $data['birth_date'];
      $picture = $data['picture'];
   }
}
//the POST method will actually delete the user permanently
if ($_POST) {
   $id = $_POST['id'];
   $picture = $_POST['picture'];
   ($picture == "avatar.png") ?: unlink("pictures/$picture");

   $sql = "DELETE FROM users WHERE user_id = {$id}";
   if ($connect->query($sql) === TRUE) {
      $class = "alert alert-success";
      $message = "Successfully Deleted!";
      header("refresh:3;url=dashboard.php");
   } else {
      $class = "alert alert-danger";
      $message = "The entry was not deleted due to: <br>" . $connect->error;
   }
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Delete User</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <style type="text/css">
    main {
        height: 100vh;
    }

    fieldset {
        margin: auto;
        margin-top: 100px;
        width: 70%;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }
    </style>
</head>

<body>
    <div class="<?php echo $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
    </div>
    <fieldset>
                <!-- alert box -->
                <div class='border border-3 border-danger text-center text-danger pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
                    <h1><i class='bi bi-shield-exclamation pe-2 '></i>ALERT</h1>
                    <hr class='bg-danger py-1 mx-auto w-75'>

                    <div class="alert alert-danger border border-1 mx-auto px-5">
                        <p class="text-dark fs-5 mt-4">Following User is about to be <b>removed</b>:</p>
                        <!-- user records -->
                        <table class="table table-light border border-muted rounded-3 px-5 mx-auto mt-0 mb-3">
                            <tr>
                                <td class="fst-italic"><img class="img-fluid" width="40vw" src="pictures/<?php echo "$picture" ?>" alt="<?php echo "$f_name $l_name" ?>"></td>
                                <td class="fst-italic align-middle"><?php echo "$f_name $l_name" ?></td>
                                <td class="fst-italic align-middle"><?php echo $email ?></td>
                                <td class="fst-italic align-middle"><?php echo $birth_date ?></td>
                            </tr>
                        </table>
                    </div>  
                    <!-- confrimation request -->
                    <p class="h2 mt-4">Carry on with the action?</p>
                    <!-- buttons (in a form) -->
                    <form class='mt-0 mb-4 p-0' method='POST'>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="picture" value="<?php echo $picture ?>">
                        <p class='text-center mt-3 mb-0'>
                            <button class='btn btn-outline-danger py-1 px-3 mx-2 w-25' type='submit'>Yes, please</button>
                            <a href='dashBoard.php'><span class='btn btn-outline-primary py-1 px-3 mx-2 w-25'>No, thanks</span></a>
                        </p>
                    </form>
                </div>
    </fieldset>
</body>

</html>