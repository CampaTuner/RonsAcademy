<?php
$host = "localhost";
$username = "root";
$password = null;
$database = "ronsacademy";

$conn = new mysqli($host, $username, $password, $database);

if($conn->connect_error){
    die("Connection Failled!".$conn->connect_error);
}
?>