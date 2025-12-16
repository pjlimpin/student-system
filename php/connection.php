<?php

$db_server= "127.0.0.1";
$db_username= "root";
$db_password= "$121511johncel";
$db_name = "student_systemdb";

try {
    $conn = mysqli_connect($db_server,$db_username,$db_password,$db_name);
} catch (mysqli_sql_exception) {
    echo "<script>alert('Cannot connect. Please check connections @ php/connection.php');</script>";
}

?>