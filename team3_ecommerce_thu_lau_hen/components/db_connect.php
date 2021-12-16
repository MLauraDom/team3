<?php

$host = "localhost";
$username_db = "root";
$password = "";
$dbname = "team3_db_bu";   // Andrew
// $dbname = "team3_laura"; // Laura

$connect = new mysqli($host, $username_db, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} else {
    // echo "Successfully connected to " . $dbname;
}