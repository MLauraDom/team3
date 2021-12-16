<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$user_id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE status != '$status'";
$query = mysqli_query($connect, $sql);

//this variable will hold the body for the products CRUD
$sql_products = "SELECT sum(unit_price*quantity) as result, product_name, unit_price, product_id FROM user_products join users on user_products.fk_user_id = users.user_id 
join products on user_products.fk_product_id = products.product_id Group by fk_product_id ORDER BY sum(unit_price*quantity)/unit_price DESC;";
$query_products = mysqli_query($connect, $sql_products);
$result_products = mysqli_fetch_all($query_products, MYSQLI_ASSOC);
$products = "";

if (mysqli_num_rows($query_products) > 0) {
    for ($i = 0; $i < 5; $i++) {
        $j = $i + 1;
        $units = $result_products[$i]['result'] / $result_products[$i]['unit_price'];
        $products .= "
        <tr class='align-middle text-center border-top border-bottom border-secondary'>
        <td class='text-center'>$j</small>
            <td><small>{$result_products[$i]['product_name']}</small></td>
            <td><small>€ {$result_products[$i]['unit_price']}</small></td>
            <td class='text-center'>{$units}</small>
            </td>
            <td class='text-center'>
            <a class='d-block btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='products/details.php?id={$result_products[$i]['product_id']}'><small><i class='bi bi-eye text-primary'></i> More</small></a></td>
        </tr>
        ";
    }


    $sql_users = "SELECT sum(unit_price*quantity) as result, first_name, last_name, email, user_id FROM user_products join users on user_products.fk_user_id = users.user_id join products on user_products.fk_product_id = products.product_id Group by fk_user_id ORDER BY result DESC";
    $query_users = mysqli_query($connect, $sql_users);
    $result_users = mysqli_fetch_all($query_users, MYSQLI_ASSOC);
    $users = "";

    if (mysqli_num_rows($query_users) > 0) {
        for ($i = 0; $i < 5; $i++) {
            $j = $i + 1;
            $users .= "
            <tr class='align-middle border-top border-bottom border-secondary'>
                <td class='text-center'>$j
                </td>
                <td><small>{$result_users[$i]['first_name']}</small></td>
                <td><small>{$result_users[$i]['last_name']}</small></td>
                <td><small>{$result_users[$i]['email']}</small></td>
                <td class='text-center'>€ 
                {$result_users[$i]['result']}
                </td>
                <td class='text-center'>
                    <a class='btn btn-sm btn-outline-secondary mx-auto w-5 py-0' href='user_details.php?id={$result_users[$i]['user_id']}'><small><i class='bi bi-eye text-primary'></i> </small></a></td>
            </tr>
            ";
        }
    }
}

$sql_user_count = "SELECT * from users";
$query_users1 = mysqli_query($connect, $sql_user_count);
$result1 = mysqli_fetch_all($query_users1, MYSQLI_ASSOC);
$count_users = 0;
if (mysqli_num_rows($query_users1) > 0) {
    foreach ($result1 as $res) {

        $count_users++;
    }
}

$sql_products_count = "SELECT * from products";
$query_users2 = mysqli_query($connect, $sql_products_count);
$result2 = mysqli_fetch_all($query_users2, MYSQLI_ASSOC);
$count_products = 0;
if (mysqli_num_rows($query_users2) > 0) {
    foreach ($result2 as $res) {

        $count_products++;
    }
}

$sql_total = "SELECT sum(unit_price*quantity) from user_products join products on user_products.fk_product_id = products.product_id";
$query_users3 = mysqli_query($connect, $sql_total);
$result3 = mysqli_fetch_all($query_users3, MYSQLI_ASSOC);
$total_sales = 0;
if (mysqli_num_rows($query_users3) > 0) {
    foreach ($result3 as $res) {

        $total_sales += $res['sum(unit_price*quantity)'];
    }
}

$labels1 = "";
for ($i = 0; $i < 4; $i++) {
    $labels1 .= "'" . $result_users[$i]['first_name'] . " " . $result_users[$i]['last_name'] . "', ";
}
$labels1 .= "'" . $result_users[4]['first_name'] . " " . $result_users[4]['last_name'] . "'";

$labels2 = "";
for ($i = 0; $i < 4; $i++) {
    $labels2 .= "'" . $result_users[$i]['result'] . "', ";
}
$labels2 .= "'" . $result_users[4]['result'] . "'";

$labels3 = "";
for ($i = 0; $i < 5; $i++) {
    $labels3 .= "'" . $result_products[$i]['product_name'] . "', ";
}

$products_sold = 0;
foreach ($result_products as $res) {
    $products_sold += $res['result'] / $res['unit_price'];
}

$sum = 0;
$labels4 = "";
for ($i = 0; $i < 5; $i++) {
    $x = $result_products[$i]['result'] / $result_products[$i]['unit_price'];
    $y = ($x / $products_sold) * 100;
    $labels4 .= "'" . $y . "', ";
    $sum += $y;
}

$rest = 100 - $sum;

$sql_review_chart = "SELECT COUNT(fk_user_id) as result, first_name, last_name from reviews join users on reviews.fk_user_id=users.user_id group by users.user_id";
$query_review = mysqli_query($connect, $sql_review_chart);
$result_review = mysqli_fetch_all($query_review, MYSQLI_ASSOC);
if (mysqli_num_rows($query_review) > 0) {
    $labels5 = "";
    $labels6 = "";
    for ($i = 0; $i < 5; $i++) {
        $labels6 .= "'" . $result_review[$i]['result'] . "', ";
        $labels5 .= "'" . $result_review[$i]['first_name'] . " " . $result_review[$i]['last_name'] . "', ";
    }
    $labels6 .= "'" . $result_review[5]['result'] . "'";
    $labels5 .= "'" . $result_review[5]['first_name'] . " " . $result_review[5]['last_name'] . "'";
}


$labels7 = "";
for ($i = 0; $i < 4; $i++) {
    $labels7 .= "'" . $result_products[$i]['product_name'] . "', ";
}
$labels7 .= "'" . $result_products[4]['product_name'] . "'";
$units = 0;
$labels8 = "";
for ($i = 0; $i < 4; $i++) {
    $units = $result_products[$i]['result'] / $result_products[$i]['unit_price'];
    $labels8 .= "'" . $units . "', ";
}
$units = $result_products[4]['result'] / $result_products[4]['unit_price'];
$labels8 .= "'" . $units . "'";

// Getting Admin Data
$adm = "SELECT * FROM users WHERE user_id='{$user_id}'";
$query_adm = mysqli_query($connect, $adm);
if ($query_adm) {
    $adm_data = mysqli_fetch_assoc($query_adm);
    while ($adm_data) {
        $full_name = $adm_data["first_name"] . " " . $adm_data["last_name"];
        //    echo $full_name;
        break;
    }
    // var_dump($adm_data);
} else {
    echo "<h1>Fetching of the admin data failed!</h1>";
}
mysqli_close($connect);
?>

<!-- 
---------------------
        HTML
--------------------- 
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- BOOTSTRAP -->
    <?php require_once 'components/bootstrap.php' ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"
        integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
    body {
        background: whitesmoke url("https://cdn-images-1.medium.com/max/1200/1*5fz2sKKTKjUmlVkWjtIUnQ.jpeg") black center center;
        background-size: cover;
    }

    main,
    aside {
        position: relative;
        /* min-height: 100vh; */
        margin: 0;
        padding: 0;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }

    td {
        text-align: left;
        vertical-align: middle;
    }

    tr {
        text-align: center;
    }

    .userImage {
        width: 100px;
        height: auto;
    }
    </style>
</head>

<body class="d-flex">
    <div class="container-fluid p-0">
        <!-- [DASHBOARD] -->
        <!-- <aside class="border border-danger"> -->
        <div class="row border border-warning border-3 alert alert-secondary p-0 m-0">
            <!-- navigation bar with sign out, update profile functions -->
            <p class="bg-dark text-light text-end pb-2">
                <sub>
                    <a class="text-decoration-none text-light mx-2"
                        href="user_update.php?id=<?php echo $_SESSION['adm'] ?>">Update your profile</a>
                    <span class="text-light"> | </span>
                    <a class="text-decoration-none text-light mx-2" href="logout.php?logout">Sign Out</a>
                </sub>
            </p>
            <!-- welcome message with 2 buttons(create function and view website as a normal user) -->
            <section class="row">
                <div class="col-2">
                    <div class="text-center ">
                        <img class="userImage mb-0" src="pictures/<?= $user['picture'] ?>" alt="Adm avatar">
                        <p class="text-center text-danger fw-bolder">Administrator</p>
                    </div>
                </div>
                <div class="col-10">
                    <div class="text-center">
                        <h2 class="fs-5 fw-bolder mb-2">Welcome to the Dashboard!</h2>
                        <h2 class="fw-lighter text-danger"><?= $full_name ?></h2>

                        <p class="text-center mt-3">
                            <a class="btn btn-outline-primary fw-bolder py-0 px-2" href="products/index.php">View
                                Website</a>
                            <a class="btn btn-outline-dark fw-bolder py-0 my-1 text-decoration-none"
                                href="reviews.php">Reviews</a>
                            <a class="btn btn-outline-warning fw-bolder py-0 my-1 text-decoration-none"
                                href="statistics.php">Statistics</a>
                        </p>
                    </div>
                </div>
            </section>
        </div>
        <main>
            <p class="h1 text-center">Statistics</p>
            <div class="container w-50 p-2">
                <div class="row">
                    <div class="col border-1 shadow-lg mx-2">
                        <p class="p-2 text-center"><b>Users</b></br>
                            <?= $count_users ?>
                        </p>
                    </div>
                    <div class="col border-1 shadow-lg mx-2">
                        <p class="p-2 text-center"><b>Products</b></br>
                            <?= $count_products ?>
                        </p>
                    </div>
                    <div class="col border-1 shadow-lg mx-2">
                        <p class="p-2 text-center"><b>Total Sales</b></br>
                            € <?= $total_sales ?>
                        </p>
                    </div>
                </div>
            </div>


            <section class="p-5">
                <div class="row p-2 w-75 m-auto">
                    <div class="col-lg-6">
                        <div class="card p-3 m-auto">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Sales per User
                            </div>
                            <div class="card-body"><canvas id="myBarChart1" width="100%" height="50"></canvas></div>
                            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        </div>
                        <div class="card p-3 m-auto">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Sales per Product
                            </div>
                            <div class="card-body"><canvas id="myBarChart2" width="100%" height="50"></canvas></div>
                            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                Most sold Products
                            </div>
                            <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        </div>
                    </div>

                </div>
                <div class="card p-3 m-auto w-75">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Reviews per user
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                    <div class="card-footer small text-muted">Updated today at 00:00 AM</div>
                </div>


            </section>

            <section class="my-5 p-0">
                <h1 class='display-6 text-center m-0'>Top 5 Products</h1>
                <hr class="bg-dark shadow py-1 w-50 mx-auto mb-4 mt-1">
                <div class="container border border-secondary border-2 rounded rounded-danger">
                    <table class="table table-light table-striped border border-secondary my-0">
                        <thead class="table-secondary">
                            <tr class="align-middle">
                                <th>Rank</th>
                                <th class="text-start">Name</th>
                                <th class="text-start">Price</th>
                                <th class="text-start">Units Sold</th>
                                <th class="text-start">Activity</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?= $products ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- [PRODUCT LIST]... -->
            <section class="my-5 p-0">
                <h1 class='display-6 text-center m-0'>Top 5 Customers</h1>
                <hr class="bg-dark shadow py-1 w-50 mx-auto mb-4 mt-1">
                <div class="container border border-secondary border-2 rounded rounded-danger">
                    <table class="table table-light table-striped border border-secondary my-0">
                        <thead class="table-secondary">
                            <tr class="align-middle">
                                <th class="text-center">Rank</th>
                                <th class="text-start">First Name</th>
                                <th class="text-start">Last Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Buyes</th>
                                <th class="text-center">Activity</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?= $users ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <script>
        var a = document.getElementById("myAreaChart");
        var myLineChart = new Chart(a, {
            type: 'line',
            data: {
                labels: [<?php echo $labels5; ?>],
                datasets: [{
                    label: "Reviews",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [<?php echo $labels6; ?>],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 40000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        </script>
        <script>
        // Bar Chart Example
        var b = document.getElementById("myBarChart1");
        var myLineChart = new Chart(b, {
            type: 'bar',
            data: {
                labels: [<?= $labels1 ?>],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [<?= $labels2 ?>],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        </script>
        <script>
        // Bar Chart Example
        var b = document.getElementById("myBarChart2");
        var myLineChart = new Chart(b, {
            type: 'bar',
            data: {
                labels: [<?= $labels7 ?>],
                datasets: [{
                    label: "Units",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [<?= $labels8 ?>],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        </script>
        <script>
        // Bar Chart Example
        var b = document.getElementById("myBarChart2");
        var myLineChart = new Chart(b, {
            type: 'bar',
            data: {
                labels: [<?= $labels3 ?>],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [<?= $labels4 ?>],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        </script>
        <script>
        // Pie Chart Example
        var c = document.getElementById("myPieChart");
        var myPieChart = new Chart(c, {
            type: 'pie',
            data: {
                labels: [<?= $labels3 ?> "others"],
                datasets: [{
                    data: [<?= $labels4 ?> <?= $rest ?>],
                    backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6a329f', '#f48536'],
                }],
            },
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
</body>

</html>