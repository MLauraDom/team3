<?php
    // setting the type of data and the applicable method 
    header("Content-Type: application/json");
    header("Access-Control-Allow-Method: GET");

    // connection to the Database as well as to the file containing the $response function
    require_once("../components/db_connect.php");
    require_once("tool_box.php");
    

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        // fetch all data
        $sql = "SELECT * FROM products;";
        $query = mysqli_query($connect, $sql);

        // if query is successful, encode in JSON format, then print it
        if($query){
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
            // check the result after encoding with echo json_encode($data);
            // display to user that the response is successful AND display data
            response(200, "Data accessed!", $data);
        } 
        else {
            response (400, "Error:" . mysqli_error($connect));
        }
    }
    mysqli_close($connect);
?>
