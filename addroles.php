<?php
// handle sessions
require('config.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the RoleName value
    $roleName = $_POST["RoleName"];
    // Perform the database insertion to the 'roles' table
    $sql = "INSERT INTO roles (RoleName) VALUES ('$roleName')";
    $conn->query($sql);
    // Retrieve the newly inserted RoleID
    $roleID = $conn->insert_id;
    // Retrieve the selected PermissionID(s)
    $selectedPermissions = $_POST["RolePermission"];
    // Insert the PermissionID and RoleID into the 'rolespermission' table
    if (!empty($selectedPermissions)) {
        foreach ($selectedPermissions as $permissionID) {
            $sql = "INSERT INTO rolespermission (PermissionID, RolesID) VALUES ('$permissionID', '$roleID')";
            $conn->query($sql);
        }
    }
}
// Fetch the permissions from the database
$sql = "SELECT PermissionID, Description FROM permissions";
$result = $conn->query($sql);
$permissions = [];
if ($result->num_rows > 0) {
    // Store the permissions in an array
    while ($row = $result->fetch_assoc()) {
        $permissions[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title> Roles </title>
    <link rel="stylesheet" href="lib/rolesstyle.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="Roles.png" alt="" style="height:350px;">
        </div>
        <div class="back">
            <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Add a Role</div>
                <form action="" method="POST">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <input type="text" name="RoleName" placeholder="Enter The Role Name" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <select name="RolePermission[]" multiple placeholder="Enter The Role Permissions(s)">
                                <?php
                                // Generate the <option> elements using the permissions array
                                foreach ($permissions as $permission) {
                                    $permissionID = $permission['PermissionID'];
                                    $description = $permission['Description'];
                                    echo "<option value=\"$permissionID\">$description</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="button input-box">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
        </div>
   
