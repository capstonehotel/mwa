 <?php
require_once("../includes/initialize.php");

// Four steps to closing a session
// (i.e. logging out)


// // 1. Find the session
session_start();

// 2. Unset all the session variables
unset( $_SESSION['ADMIN_ID'] );
unset( $_SESSION['ADMIN_UNAME'] );
unset( $_SESSION['ADMIN_USERNAME'] );
unset( $_SESSION['ADMIN_UPASS'] );
unset( $_SESSION['ADMIN_UROLE'] );
// Destroy the session
// session_destroy();
 	// Invalidate the global token
file_put_contents('global_admin_token.txt', '');

// Destroy the current session
session_destroy();

// Redirect to the login page
header('Location: login.php');
exit();
// 4. Destroy the session
//redirect("index.php");
?>