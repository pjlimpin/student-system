<?php

$db_server= "127.0.0.1";
$db_username= "root";
$db_password= "$121511johncel";
$db_name = "student_db";

if($conn = mysqli_connect($db_server,$db_username,$db_password,$db_name)){
    echo "connected";
}


?>