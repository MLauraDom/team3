<?php
session_start();
    require_once("components/db_connect.php");
    
    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
        header("Location: ../index.php");
        exit;
    }
    //if session user exist it shouldn't access dashboard.php
    if (isset($_SESSION["user"])) {
        header("Location: home.php");
        exit;
    }
    
    if(@$_GET["id"]){
        $user_id = $_GET["id"];
        $sql = "SELECT * FROM users WHERE user_id = '{$user_id}'";
        $query = mysqli_query($connect, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $display = "";

        if(mysqli_num_rows($query) == 1){
            foreach($result as $row){
                $display = "
                <div class='card shadow mt-3 mb-5 mx-auto' style='width: 25rem;'>
                    <img class='card-img-top img-fluid' src='pictures/{$row["picture"]}' alt='Card image cap'>
                    <div class='card-body'>
                        <h3 class='card-title text-center mt-3 mb-0'>{$row["username"]}</h3>
                        <h6 class='card-title text-center mt-3 mb-0'>Status: </span>{$row["status"]}</h6>

                        <hr class='py-1 mt-1 mb-3'>


                        <p class='py-2 m-0'><span class='text-secondary fw-bold'>First Name: </span>{$row["first_name"]}</p> 
                        <p class='py-2 m-0'><span class='text-secondary fw-bold'>Last Name: </span>{$row["last_name"]}</p> 
                        <p class='py-2 m-0'><span class='text-secondary fw-bold'>Birth Date: </span>{$row["birth_date"]}</p> 
                        <p class='py-2 m-0'><span class='text-secondary fw-bold'>Email: </span>{$row["email"]}</p> 
                        <p class='p-0 m-0'><span class='text-secondary fw-bold'>Address: </span>{$row["address"]}</p> 
                        
                    </div>

                        <p class='card-footer text-end m-0'>
                            <small'>
                                <a class='btn btn-outline-dark py-0 m-0' href='dashBoard.php'>Return</a>
                            </small>
                        </p>
                </div>
                ";
            }
        } else {
            header("error.php");
        }
    } else {
        echo "
        <div class='border border-3 border-danger text-center text-danger py-5 mx-auto my-5 w-75'>
        <h1><i class='bi bi-shield pe-2 '></i>ALERT!</h1>
        <hr class='bg-danger py-1 mx-auto w-75'>
        <p>The record you are trying to reach is not available</p>
        </div>";
        header("error.php");
    }
?>



<!-- ------------------------
        HTML
------------------------ -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Henry Ngo-Sytchev">
    <!-- [BOOTSTRAP] -->
    <?php 
    $url="../";
    require_once("components/bootstrap.php");
    ?>
    <!-- [CSS] -->
    <style>
        main{
            min-height: 100vh;
            padding: 3% 15%;
        }

    </style>
    <title>Product Details</title>
</head>
<body>
        <!-- [NAVBAR] -->
    <?php 
    $url = $img_url = "";
    require_once("components/navbar.php"); ?>

        <!-- [MAIN] -->
    <main>
    <?php echo ($display)?:"";?>
    </main>
    
        <!-- [FOOTER] -->
    <?php require_once("components/footer.php"); ?>
</body>
</html>