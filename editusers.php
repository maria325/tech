<?php
require('config.php');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user ID from the form data
    $userID = $_POST['user_id'];
    // Retrieve the updated user information from the form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $roleId = $_POST['role_id'];
    $activity = $_POST['activity'];
    // Query to update the user information
    $updateQuery = "UPDATE users SET Fname = '$firstName', Lname = '$lastName', Username = '$username', Email = '$email', RolesID = '$roleId', Active = '$activity' WHERE ID = $userID";
    mysqli_query($conn, $updateQuery);
    // Redirect to the main page after the update
    header('Location: checkusers.php');
    exit();
}
// Check if the user ID is provided as a query parameter
if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    // Query to retrieve the user by ID
    $query = "SELECT * FROM users WHERE ID = $userID";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    // Redirect to the main page if the user ID is not provided
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib\style.css">
    <title>Edit User</title>
</head>
<body>
<div class="container">
<header>Edit Users</header>
        <form action="" method="POST" onsubmit="return validateForm(event)">
            <div class="form first">
                <div class="details personal">
                    <div class="fields">
                            <input type="hidden" name="user_id" value="<?php echo $user['ID']; ?>">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo $user['Fname']; ?>">
                        </div>
                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo $user['Lname']; ?>">
                        </div>
                        <div class="input-field">
                            <label>Username</label>
                            <input type="text" id="username" name="username" value="<?php echo $user['Username']; ?>">
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>">
                        </div>
                        <div class="input-field">
                            <label>Roles ID</label>
                            <input type="text" id="role_id" name="role_id" value="<?php echo $user['RolesID']; ?>">
                        </div>
                        <div class="input-field">
                            <label>Active</label>
                            <input type="text" id="activity" name="activity" value="<?php echo $user['Active']; ?>">
                        </div>
                            </div>
                        </div>
                        <button type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
        <script src="script.js"></script>
    </div>
</body>
</html>
