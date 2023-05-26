<?php
require('config.php');
// Check if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $deleteID = $_GET['delete_id'];
    // Query to delete the user
    $deleteQuery = "DELETE FROM users WHERE ID = $deleteID";
    mysqli_query($conn, $deleteQuery);
}
// Search functionality
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm']; 
    // Query to search for users
    $query = "SELECT * FROM users WHERE 
              FName LIKE '%$searchTerm%' OR
              LName LIKE '%$searchTerm%' OR
              Active LIKE '%$searchTerm%' OR
              Username LIKE '%$searchTerm%' OR
              Email LIKE '%$searchTerm%' OR
              ID LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
} else {
    // Query to retrieve all user records
    $query = "SELECT * FROM users";
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
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role ID</th>
                    <th>Activity</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display user data
                while ($user = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $user['ID'] . "</td>";
                    echo "<td>" . $user['Fname'] . "</td>";
                    echo "<td>" . $user['Lname'] . "</td>";
                    echo "<td>" . $user['Username'] . "</td>";
                    echo "<td>" . $user['Email'] . "</td>";
                    echo "<td>" . $user['RolesID'] . "</td>"; 
                    $activityStatus = ($user['Active'] == 1) ? 'Active' : 'Inactive';
                    $activityClass = ($user['Active'] == 1) ? 'active' : 'inactive';
                    echo "<td class='$activityClass'>" . $activityStatus . "</td>";
                    echo "<td>
                            <a href='editusers.php?id=" . $user['ID'] . "' class='edit-button'>Edit</a>
                            <a href='?delete_id=" . $user['ID'] . "' class='delete-button'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                // Display a message if no users are found
                if (mysqli_num_rows($result) === 0 && isset($_POST['search'])) {
                    echo "<tr><td colspan='8'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
