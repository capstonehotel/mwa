
<?php
// check_login.php
session_start();

// Read the global token from the file
$globalToken = file_get_contents('global_admin_token.txt');

// Check if the session token matches the global token
if (!isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
    // Token mismatch; logout the session
    session_destroy();
    header('Location: login.php');
    exit();
}
?>