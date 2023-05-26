<?php
require('config.php');
// Check if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $deleteID = $_GET['delete_id'];
    // Query to delete the role
    $deleteQuery = "DELETE FROM roles WHERE RolesID = $deleteID";
    mysqli_query($conn, $deleteQuery);
}
// Search functionality
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    // Query to search for roles
    $query = "SELECT * FROM roles WHERE 
              RolesID LIKE '%$searchTerm%' OR
              RoleName LIKE '%$searchTerm%' OR
              Active LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
} else {
    // Query to retrieve all roles records
    $query = "SELECT * FROM roles";
    $result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/table.css">
    <title>Roles</title>
    <style>
        .active {
            color: green;
        }
        
        .inactive {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Roles</h2>
    <div class="search-form">
        <form method="POST" action="">
            <input type="text" name="searchTerm" placeholder="Search">
            <button type="submit" name="search">Search</button>
        </form>
    </div>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Role ID</th>
                    <th>RoleName</th>
                    <th>Activity</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display roles data
                while ($roles = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $roles['RolesID'] . "</td>";
                    echo "<td>" . $roles['RoleName'] . "</td>";
                    $activityStatus = ($roles['Active'] == 1) ? 'Active' : 'Inactive';
                    $activityClass = ($roles['Active'] == 1) ? 'active' : 'inactive';
                    echo "<td class='$activityClass'>" . $activityStatus . "</td>";
                    echo "<td>
                            <a href='editroles.php?id=" . $roles['RolesID'] . "' class='edit-button'>Edit</a>
                            <a href='?delete_id=" . $roles['RolesID'] . "' class='delete-button'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                // Display a message if no roles are found
                if (mysqli_num_rows($result) === 0 && isset($_POST['search'])) {
                    echo "<tr><td colspan='8'>No role found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
