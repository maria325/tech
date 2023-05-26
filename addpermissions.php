<?php
require('config.php');
// handle sessions
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the RoleName value
    $Description = $_POST["Description"];
    // Perform the database insertion to the 'roles' table
    $sql = "INSERT INTO permissions (Description) VALUES ('$Description')";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title> Permissions </title>
    <link rel="stylesheet" href="lib/permissions.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Add a Permissions</div>
                <form action="" method="POST">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <input type="text" name="Description" placeholder="Enter The Permissions Description" required>
                        </div>
                    <div class="button input-box">
                        <input type="submit" value="Add">
                    </div>
                </form>
            </div>
        </div>
   
