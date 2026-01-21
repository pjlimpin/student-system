<?php

$db_server= "127.0.0.1";
$db_username= "root";
$db_password= "$121511johncel";
$db_name = "student_systemdb";

$conn = new mysqli($db_server,$db_username,$db_password,$db_name);
$conn->set_charset("utf8mb4");

if($conn->connect_error){
       error_log("Connection failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
 
}   
?>