<?php
session_start();
require 'config.php';
$error = '';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted username and password
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    // Prepare and execute a query to retrieve the user record based on the submitted username
    $query = "SELECT * FROM users WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    // Get the result of the query
    $result = $stmt->get_result();
    // Check if a matching user is found
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];
        $isActive = $row['Active'];
        // Check if the user is active
        if ($isActive == 1) {
            // Verify the submitted password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                // Successful login
                $_SESSION['RolesID'] = $row['RolesID'];
                $_SESSION['PermissionID'] = $row['PermissionID'];
                $_SESSION['Username'] = $row['Username'];
                header('location: menu.php');
                exit;
            } else {
                $error = "Wrong Username or Password
                <script>
                setTimeout(function() {
                    var errorContainer = document.querySelector('.error-message');
                    if (errorContainer) {
                        errorContainer.style.display = 'none';
                    }
                 }, 2000);         
                </script> ";               
            }
        } else {
            // User is not active
            $error = "User Not Active
            <script>
            setTimeout(function() {
                var errorContainer = document.querySelector('.error-message');
                if (errorContainer) {
                    errorContainer.style.display = 'none';
                }
             }, 2000);         
            </script>";
        }
    } else {
        // Invalid username
        $error = "Invalid username or password!
        <script>
        setTimeout(function() {
            var errorContainer = document.querySelector('.error-message');
            if (errorContainer) {
                errorContainer.style.display = 'none';
            }
         }, 2000);         
        </script>";
    }
    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="lib/loginstyle.css">
    <title>Login</title> 
</head>
<body> 
<div class="container">
        <?php if (!empty($error)) : ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>  
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
                <form action="login.php"  method="POST" >
                    <div class="input-field">
                        <input type="text" name="Username" placeholder="Enter your Username" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password"  name="Password" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="checkbox-text">                                          
                    <div class="input-field button">
                         <input type="submit" value="Login">
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
