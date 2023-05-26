<?php
require('config.php');
if(isset($_GET['id'])) {
    $roleID = $_GET['id'];
    // Fetch the role data for the given ID
    $query = "SELECT * FROM roles WHERE RolesID = $roleID";
    $result = mysqli_query($conn, $query);
    $roleData = mysqli_fetch_assoc($result);
    if (!$roleData) {
        // If no role is found, redirect back to the roles page
        header("Location: roles.php");
        exit();
    }
} else {
    // If no ID is provided, redirect back to the roles page
    header("Location: roles.php");
    exit();
}
// Update functionality
if(isset($_POST['update'])) {
    $newRoleName = $_POST['roleName'];
    $newActivityStatus = $_POST['activity'];
    // Update the role in the database
    $updateQuery = "UPDATE roles SET RoleName = '$newRoleName', Active = '$newActivityStatus' WHERE RolesID = $roleID";
    mysqli_query($conn, $updateQuery);
    // Redirect back to the roles page after updating
    header("Location: roles.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/editrolestyle.css">  
    <title>Edit Roles</title>
    
</head>
<body>
    <div class="container">
        <header>Edit Users</header>
        <form action="" method="POST" onsubmit="return validateForm(event)">
            <div class="form">
                <div class="details personal">
                    <div class="input-field">
                        <input type="text" name="roleName" value="<?php echo $roleData['RoleName']; ?>">
                    </div>
                    <div class="input-field">
                        <select name="activity" style="width:225px">
                            <option value="1" <?php if($roleData['Active'] == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if($roleData['Active'] == 0) echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="update">Update</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

