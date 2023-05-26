<?php
require('config.php');
// Search functionality
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    // Query to search for permissions
    $query = "SELECT * FROM permissions WHERE 
              PermissionID LIKE '%$searchTerm%' OR
              Description LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
} else {
    // Query to retrieve all permissions records
    $query = "SELECT * FROM permissions";
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
    <title>Users</title>
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
    <h2>Users</h2>
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
                    <th>Permission ID</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display permissions data
                while ($permissions = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $permissions['PermissionID'] . "</td>";
                    echo "<td>" . $permissions['Description'] . "</td>";
                }
                // Display a message if no permissions are found
                if (mysqli_num_rows($result) === 0 && isset($_POST['search'])) {
                    echo "<tr><td colspan='8'>No permission found found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
