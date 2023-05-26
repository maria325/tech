    <?php
    session_start();
    require('config.php');
    if (!isset($_SESSION['Username']) && !isset($_SESSION['RolesID']) && !isset($_SESSION['PermissionID'])) {
        // User is not logged in, redirect to the login page
        header('Location: login.php');
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="lib/menustyle.css">
        <title>Menu</title>
    </head>

    <body>
        <div class="button-container">
            <button type="submit" onclick="location.href='users.php'"><b>Users</b></button>
            <button type="submit" onclick="location.href='products.php'"><b>Products</b></button>
            <button type="submit"onclick="location.href='permissions.php'"><b>Permissions</b></button>
            <button type="submit" onclick="location.href='roles.php'"><b>Roles</b></button>
            <button type="submit" onclick="location.href='logout.php'"><b>Logout</b></button>
        </div>
    </body>
    </html>
