<?php
$servername = "localhost";
$username = "root";
$password = "anuMySQL@682";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error );
}
?>