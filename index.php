<?php

include("html/header.html");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div id="register-section" style="text-align: center;">
    <h1 >Register here</h1>
    <label>First Name:</label>
    <input type="text" name="name"><br>
    <label>Last Name:</label>
    <input type="text" name="name"><br>
    <label>Birthday:</label>
    <input type="text" name="name"><br>
    <label>Contact Number:</label>
    <input type="tel" name="phone" 
       pattern="[0-9]{11}" 
       placeholder="09123456789"
       title="Please enter 11 digits (e.g., 09123456789)"><br>
    <label>Email:</label>
    <input type="text" name="name"><br>
    <label>Username:</label>
    <input type="text" name="name"><br>
    <label>Password:</label>
    <input type="password" name="name"><br>
    <input type="submit" name="register" value="REGISTER">
    </div>
</body>
</html>