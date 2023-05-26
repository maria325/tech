<?php
session_start();
require_once('config.php');
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
// Redirect to the login page or any other page
header("Location: login.php");
exit;
?>
