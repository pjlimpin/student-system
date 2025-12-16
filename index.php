<?php

include("html/header.html");
include("php/connection.php");


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
    <form method="POST" action="index.php">
        <div id="register-section" style="text-align: center;">
            <h1>Register here</h1>
            <label>First Name:</label>
            <input type="text" name="first_name"><br>
            <label>Last Name:</label>
            <input type="text" name="last_name"><br>
            <label>Birthday:</label><br>
            <input type="date" name="birthday"><br>
            <label>Contact Number:</label>
            <input type="tel" name="phone" 
                   pattern="[0-9]{11}"
                   placeholder="09123456789"
                   title="Please enter 11 digits (e.g., 09123456789)"><br>
            <label>Email:</label>
            <input type="text" name="email"><br>
            <label>Username:</label>
            <input type="text" name="username"><br>
            <label>Password:</label>
            <input type="password" name="password"><br>
            <input type="submit" name="register" value="REGISTER">
        </div>
    </form>
</body>
</html>
<?php

if(isset($_POST["register"])){
    $firstname=$_POST["first_name"];
    $lastname=$_POST["last_name"];
    $birthday=$_POST["birthday"];
    $contactNum=$_POST["phone"];
    $email=$_POST["email"];
    $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $password=filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($firstname)) {
            echo "Please fill the form completely!!";
        }elseif (empty($lastname)) {
            echo "Please fill the form completely!!";
        }elseif (empty($birthday)) {
            echo "Please fill the form completely!!";
        }elseif (empty($contactNum)) {
            echo "Please fill the form completely!!";
        }elseif (empty($username)) {
            echo "Please fill the form completely!!";
        }elseif (empty($password)) {
            echo "Please fill the form completely!!";
        }else{
            $hash=password_hash($password,PASSWORD_DEFAULT);
         $stmt = $conn->prepare("INSERT INTO student_info (first_name,last_name,birthday,contact_number,email,username,password) VALUES (?,?,?,?,?,?,?)");

           $stmt->bind_param("sssssss", $firstname, $lastname, $birthday, $contactNum, $email, $username, $hash);
        }
                    if ($stmt->execute()) {
                        echo "Registration successful!";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
        $stmt->close();
        $conn->close();
}else{
    echo "cannot submit";
}

?>