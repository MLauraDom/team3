<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Hooray</title>
    <!-- [BOOTSTRAP] -->
    <?php require_once("../../components/bootstrap.php") ?>
</head>

<body>
    <div class="container mt-3 mb-3">
        <div
            class='alert alert-muted border border-3 border-success text-center text-info pt-5 pb-3 mx-auto mt-0 mb-5 w-100'>
            <h1>Order Confirmed!</h1>
            <hr class='bg-success py-1 mx-auto w-75'>
            <p>Your items are on the way.</p>
            <p>Email confirmation will arrive shortly.</p>
            <p>Have a great day!</p>
            <a href='../index.php'><button class="btn btn-outline-dark mx-auto mb-2 py-0 px-5 fw-bold w-25"
                    type='button'>Keep Shopping</button>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="btn-wrapper text-center w-50 d-flex">
            <a href="../../home.php" class="btn btn-outline-dark rounded p-2 shadow">Home</a>
        </div>
    </div>

</body>

</html>