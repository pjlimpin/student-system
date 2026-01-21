<?php
session_start();
include("html/header.html");
include("php/connection.php");

$errorMessage = '';
$successMessage = '';

// Process form submission
if(isset($_POST["register"])){
    $firstname = trim($_POST["first_name"] ?? '');
    $lastname = trim($_POST["last_name"] ?? '');
    $birthday = trim($_POST["birthday"] ?? '');
    $contactNum = trim($_POST["phone"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';

    // Validation
    if (empty($firstname) || empty($lastname) || empty($birthday) || empty($contactNum) || 
        empty($email) || empty($username) || empty($password)) {
        $errorMessage = "All fields are required! Please fill out the form completely.";
    } 
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    }
    // Validate phone number (must be 11 digits)
    elseif (!preg_match('/^[0-9]{11}$/', $contactNum)) {
        $errorMessage = "Contact number must be exactly 11 digits.";
    }
    // Validate password length
    elseif (strlen($password) < 6) {
        $errorMessage = "Password must be at least 6 characters long.";
    }
    else {
        // Check if username already exists
        $checkStmt = $conn->prepare("SELECT username FROM student_info WHERE username = ?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            $errorMessage = "Username already exists! Please choose a different username.";
            $checkStmt->close();
        } else {
            $checkStmt->close();
            
            // Sanitize inputs and hash password
            $firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO student_info (first_name, last_name, birthday, contact_number, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $firstname, $lastname, $birthday, $contactNum, $email, $username, $hash);
            
            if ($stmt->execute()) {
                $successMessage = "Registration successful! You can now login or view your record.";
                $stmt->close();
            } else {
                $errorMessage = "Registration failed: " . $stmt->error;
                $stmt->close();
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student System</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .alert {
            padding: 15px 20px;
            margin: 20px auto;
            border-radius: 8px;
            max-width: 500px;
            font-size: 16px;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .alert-close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            color: inherit;
            opacity: 0.7;
        }
        
        .alert-close:hover {
            opacity: 1;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .required {
            color: red;
        }
        
        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="tel"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php if ($errorMessage): ?>
    <div class="alert alert-error" id="errorAlert">
        <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        <strong>✗ Error!</strong> <?php echo htmlspecialchars($errorMessage); ?>
    </div>
    <?php endif; ?>
    
    <?php if ($successMessage): ?>
    <div class="alert alert-success" id="successAlert">
        <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        <strong>✓ Success!</strong> <?php echo htmlspecialchars($successMessage); ?>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="register.php">
        <div id="register-section" style="text-align: center;">
            <h1>Register here</h1>
            
            <label>First Name <span class="required">*</span></label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required><br>
            
            <label>Last Name <span class="required">*</span></label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required><br>
            
            <label>Birthday <span class="required">*</span></label><br>
            <input type="date" name="birthday" value="<?php echo htmlspecialchars($_POST['birthday'] ?? ''); ?>" required><br>
            
            <label>Contact Number <span class="required">*</span></label>
            <input type="tel" name="phone" 
                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                   pattern="[0-9]{11}"
                   placeholder="09123456789"
                   title="Please enter 11 digits (e.g., 09123456789)"
                   required><br>
            
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required><br>
            
            <label>Username <span class="required">*</span></label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required><br>
            
            <label>Password <span class="required">*</span></label>
            <input type="password" name="password" minlength="6" placeholder="At least 6 characters" required><br>
            
            <input type="submit" name="register" value="REGISTER">
            <br><br>
            <a href="index.php">Go Back</a>
            <br><br>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var errorAlert = document.getElementById('errorAlert');
            var successAlert = document.getElementById('successAlert');
            
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                errorAlert.style.transition = 'opacity 0.5s';
                setTimeout(() => errorAlert.style.display = 'none', 500);
            }
            
            if (successAlert) {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 0.5s';
                setTimeout(() => successAlert.style.display = 'none', 500);
            }
        }, 5000);
    </script>
</body>
</html>

<?php
include("html/footer.html");
?>