<?php
session_start();
require_once("components/db_connect.php");

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$errMsg = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') { // Check if the User coming from a request
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // simple validation if you insert an email
    $msg = filter_var($_POST["msg"], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    // mail function in php look like this  (mail(To, subject, Message, Headers, Parameters))
    $headers = "FROM : " . $email . "\r\n";
    $myEmail = "noreply.team3@gmail.com";
    if (mail($myEmail, "Email through team3 site from " . $email, $msg, $headers)) {
        $class = "success";
        $errMsg = "Thanks for contacting team3! We will be in touch soon.";
    } else {
        $class = "danger";
        $errMsg = "There was an error sending your message. Please check and try again.";
    }
}

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
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .card-header {
        font-weight: bolder;
    }
    </style>
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
        <div class="d-flex justify-content-center align-items-center mt-5 mb-3">
            <h3>Contact Us</h3>
        </div>

        <!-- Contact Us from Contact & Address -->
        <div class="contact-container container-fluid p-3">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-6 form-container w-50">
                    <h2 class="text-left">Contact Team3 directly:</h2>
                    <div class="errMsg m-auto alert alert-<?= $class ?> p-2 rounded" role="alert">
                        <?php echo $errMsg ?>
                    </div>
                    <form method="POST" class="m-auto shadow p-4 rounded">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Your Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Your Message</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="msg"></textarea>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Send</button>
                        </div>
                    </form>
                    <div class="m-auto mt-5 phone-box border rounded p-2 shadow">
                        <p>Alternatively call us on +43 660 333 3333</p>
                        <p>or email us at noreply.team3@gmail.com</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-6 m-auto">
                    <div class="card m-auto border-0 shadow  mb-3" style="max-width: 35rem;">
                        <div class="card-header">Address</div>
                        <div class="card-body m-auto text-secondary">
                            <div class="container-contact">
                                <h5 class="card-title">CodeFactory GmbH <br>Kettenbrückengasse 23/2/12, 1050 Vienna</h5>
                                <p class="card-text">Directly with the subway U4 to the station Kettenbrückengasse –
                                    right
                                    next to the famous Viennese Naschmarkt!</p>
                            </div>
                            <div id="map" style="width:100%; height:28rem; margin:auto;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <!-- [FOOTER] -->
    <?php
    $url = "";
    require_once("components/footer.php");
    ?>

    <!-- [SCRIPT - GOOGLE MAP] -->
    <script>
    var map;

    function initMap() {
        var vienna = {
            lat: 48.19648,
            lng: 16.35950
        };
        map = new google.maps.Map(document.getElementById('map'), {
            center: vienna,
            zoom: 16
        });
        var pinpoint = new google.maps.Marker({
            position: vienna,
            map: map
        })

    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtjaD-saUZQ47PbxigOg25cvuO6_SuX3M&callback=initMap"
        async defer></script>
</body>

</html>