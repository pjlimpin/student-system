<?php

include("html/header.html");
include("php/connection.php");

// Friendly error message holder
$loginError = "";

if(isset($_POST["login"])){
    $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $loginError = "Please enter both your username and password.";
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
                $loginError = "The password you entered is incorrect. Please try again.";
            }
        } else {
            $loginError = "We couldn't find an account with that username.";
        }
        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Google Fonts for old-school / gothic vibe -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form method="POST" action="login.php">
        <div id="login-section" style="text-align: center;">
            <h1>Login here</h1>

            <?php if (!empty($loginError)): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($loginError); ?>
                </div>
            <?php endif; ?>

            <label>Username:</label>
            <input type="text" name="username"><br>
            <label>Password:</label>
            <input type="password" name="password"><br>
            <input type="submit" name="login" value="LOGIN">
            <br><br>
            <a href="index.php">Go Back</a>
            <br><br>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>
</body>
</html>
<?php

$conn->close();

include("html/footer.html");
?>