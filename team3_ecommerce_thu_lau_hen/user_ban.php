<?php
// session_start(); // start a new session or continues the previous

if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home page
}

// if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {//redirects non users to the welcome page
//     header("Location: index.php");
//     exit;
// }

require_once 'components/db_connect.php';

$user_ban = "";
$access_restored = "";


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = {$user_id}";
    $user_record = mysqli_query($connect, $sql);

    if (mysqli_num_rows($user_record) == 1) {
        $data = mysqli_fetch_assoc($user_record);
        $status = $data['status'];

        // ban OR restore access of a user
        if ($status == "user") {
            $sql_ban = "UPDATE users SET status = 'ban' WHERE user_id = {$user_id};";
            $user_ban = mysqli_query($connect, $sql_ban);
            $icon = "<i class='bi bi-lock mx-2'>";
            $class = "danger";
            $msg = "Following user has been successfuly <b>banned</b>:";
            $user_ban = "
            <div class='mx-auto px-5'>
                    <tr>
                        <td class='fst-italic'><small><img class='img-fluid rounded' width='40vw' src='pictures/{$data["picture"]}' alt='{$data['first_name']} {$data['last_name']}'></small></td>
                        <td class='fst-italic align-middle'><small>{$data['first_name']} {$data['last_name']}</small></td>
                        <td class='fst-italic align-middle'><small>{$data['email']}</small></td>
                        <td class='fst-italic align-middle'><small>{$data['birth_date']}</small></td>
                    </tr>
            </div>  
            ";
            // header("refresh:3;url=dashboard.php"); // automatic rediraction on dashBoard.php
        } elseif ($status == "ban") {
            $sql_access = "UPDATE users SET status = 'user' WHERE user_id = {$user_id};";
            $user_access = mysqli_query($connect, $sql_access);
            $icon = "<i class='bi bi-unlock mx-2'>";
            $class = "success";
            $msg = "The access of the following user has been <b>restored</b>:";
            $access_restored = "
            <div class='mx-auto px-5'>
                    <tr>
                        <td class='fst-italic'><small><img class='img-fluid rounded' width='40vw' src='pictures/{$data["picture"]}' alt='{$data['first_name']} {$data['last_name']}'></small></td>
                        <td class='fst-italic align-middle'><small>{$data['first_name']} {$data['last_name']}</small></td>
                        <td class='fst-italic align-middle'><small>{$data['email']}</small></td>
                        <td class='fst-italic align-middle'><small>{$data['birth_date']}</small></td>
                    </tr>
            </div>  
            ";
            // header("refresh:3;url=dashboard.php"); // automatic rediraction on dashBoard.php
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
    <title>User Ban</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <!-- [CSS] -->
    <style>
    main {
        height: 100vh;
    }
    </style>
</head>

<!-- ------------------------
        HTML
------------------------ -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php
    require_once("components/bootstrap.php");
    ?>
    <!-- [CSS] -->
    <style>
    main {
        min-height: 80vh;
        padding: 3% 15%;
    }
    </style>
    <title>Product Details</title>
</head>

<body>
    <!-- [HERO/HEADER] -->
    <?php
    require_once("components/hero.php");
    ?>

    <!-- [NAVBAR] -->
    <?php
    $url = $logout = $img_url = "";
    require_once("components/navbar.php");
    ?>

    <!-- [MAIN] -->
    <main>
        <!-- Admin notification: start -->
        <div class="border border-3 border-<?= $class ?> text-center text-dark pt-5 pb-3 mx-auto mt-0 mb-5 w-100">
            <h1 class="text-<?= $class ?>"><?= $icon ?></i>Notifcation</h1>
            <hr class="bg-<?= $class ?> py-1 mx-auto w-75">
            <div class="fs-5 p-3">
                <p class="text-<?= $class ?> fs-5 "><?= $msg ?></p>
                <div class="table-responsive">
                    <table class="table border">
                        <?= $user_ban ?>
                        <?= $access_restored ?>
                    </table>
                </div>
            </div>
            <div class="m-0 p-0">
                <p class="text-center mt-2 mb-3">
                    <a href="dashBoard.php"><span class="btn btn-<?= $class ?> py-0 px-3 mx-2 w-50">Dashboard</span></a>
                </p>
            </div>
        </div>
        <!-- Admin notification: end -->
    </main>

    <!-- [FOOTER] -->
    <?php
    $url = "";
    require_once("components/footer.php");
    ?>
</body>

</html>