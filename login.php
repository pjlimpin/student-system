<?php

include("html/header.html");
include("php/connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form method="POST" action="login.php">
        <div id="login-section" style="text-align: center;">
            <h1>Login here</h1>
            <label>Username:</label>
            <input type="text" name="username"><br>
            <label>Password:</label>
            <input type="password" name="password"><br>
            <input type="submit" name="login" value="LOGIN">
        </div>
    </form>
</body>
</html>
<?php

if(isset($_POST["login"])){
    $username=filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $password=filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        echo "Please fill in all fields!";
    } else {
        $stmt = $conn->prepare("SELECT password FROM student_info WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                // Login successful, redirect to records page
                header("Location: php/students_record.php");
                exit();
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "Username not found!";
        }
        $stmt->close();
    }
    $conn->close();
}

?>