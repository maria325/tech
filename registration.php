<?php
session_start();
if (!isset($_SESSION['Username']) && !isset($_SESSION['RolesID']) && !isset($_SESSION['PermissionID'])) {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
require_once 'config.php';
$error = '';
$registrationSuccess = false;

$roles = [];
$permissions = [];
$query = "SELECT RolesID, RoleName FROM roles";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $roles[$row['RolesID']] = $row['RoleName'];
    }
}
$query = "SELECT PermissionID, Description FROM permissions";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $permissions[$row['PermissionID']] = $row['Description'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = sanitizeInput($_POST['FName']);
    $lastName = sanitizeInput($_POST['LName']);
    $username = sanitizeInput($_POST['Username']);
    $email = sanitizeInput($_POST['Email']);
    $password = $_POST['Password'];
    $roleId = sanitizeInput($_POST['RolesID']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Use bcrypt hashing algorithm
    if ($conn) {
        $checkUserQuery = "SELECT * FROM users WHERE Email = ? OR Username = ?";
        $stmt = $conn->prepare($checkUserQuery);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = 'Invalid username or password!';
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters.';
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/', $password)) {
            $error = 'Password must contain both letters and numbers.';
        } else {
            $insertQuery = "INSERT INTO users (FName, Lname, Username, Email, Password, RolesID) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $hashedPassword, $roleId);
            if ($stmt->execute()) {
                $registrationSuccess = true;
                $userID = $stmt->insert_id;
                // Insert UserID and UserPermission into userpermission table
                $permissions = $_POST['permissions'];
                foreach ($permissions as $permission) {
                    $insertUserPermissionQuery = "INSERT INTO userpermission (UserID, PermissionID) VALUES (?, ?)";
                    $stmtUserPermission = $conn->prepare($insertUserPermissionQuery);
                    $stmtUserPermission->bind_param("ss", $userID, $permission);
                    $stmtUserPermission->execute();
                }
                $_SESSION['RolesID'] = $roleId;
                $_SESSION['PermissionID'] = $_POST['PermissonID'];
                $_SESSION['Username'] = $username;
                header("Location: login.php");
                exit;
            } else {
                $error = "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }
    } else {
        $error = "Error: Database connection failed.";
    }
}

function sanitizeInput($input)
{
    global $conn;
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="lib/regstyle.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!----======== JavaScript ======== -->
    <script src="script.js"></script>
    <title>Registration Form</title>
</head>

<body>
    <div class="container">
        <header>Registration</header>
        <!-- Display the error message if it exists and registration was not successful -->
        <?php if (!empty($error) && !$registrationSuccess) { ?>
            <div class="alert alert-light">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form action="" method="POST" onsubmit="return validateForm(event)">
            <div class="form first">
                <div class="details personal">

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" name="FName" id="FName" placeholder="Enter your First name" required>
                        </div>
                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" name="LName" id="LName" placeholder="Enter your Last name" required>
                        </div>
                        <div class="input-field">
                            <label>Username</label>
                            <input type="text" name="Username" placeholder="Enter your Username" required value="">
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="Email" placeholder="Enter your email" required value="">
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" name="Password" placeholder="Enter your Password" required>
                        </div>
                        <div class="input-field">
                            <label>Role</label>
                            <select name="RolesID" required value="">
                                <option value="RolesID">Select a role</option>
                                <?php
                                // Loop through the roles and generate the options
                                foreach ($roles as $roleId => $roleName) {
                                    echo "<option value=\"$roleId\">$roleName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Permissions checkboxes section -->
                        <div class="input-field">
                            <label style="  text-decoration: underline;color: blue;">Permissions</label>
                            <div class="checkbox-group">
                                <?php
                                $count = 0;
                                foreach ($permissions as $permissionID => $permissionName) {
                                    if ($count % 3 === 0) {
                                        echo '<div class="checkbox-row">';
                                    }
                                    ?>
                                    <label class="checkbox">
                                        <input type="checkbox" name="permissions[]" value="<?php echo $permissionID; ?>">
                                        <?php echo $permissionName; ?>
                                    </label>
                                    <?php
                                    $count++;
                                    if ($count % 3 === 0) {
                                        echo '</div>';
                                    }
                                }
                                if ($count % 3   !== 0) {
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                        <button type="submit">Register</button>
                    </div>
                </div>
            </div>
        </form>
        <script src="script.js"></script>
    </div>
</body>

</html>
