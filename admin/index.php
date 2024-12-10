<?php
require_once("../includes/initialize.php");
// Generate a unique global token
session_start();
$globalToken = bin2hex(random_bytes(16));

// Store it in a global variable (accessible to all sessions)
$_SESSION['global_admin_token'] = $globalToken;

// Save the global token in a file (to share across sessions)
file_put_contents('global_admin_token.txt', $globalToken);

// Store the token in the session
$_SESSION['admin_token'] = $globalToken;

 if (!isset($_SESSION['ADMIN_ID'])) {
	 // Token mismatch; logout the session
	 session_destroy();
	 //echo "<script>alert('test12');</script>";
	 header('Location: login.php');
	 exit();
 }


 
$content='home.php';

 include 'themes/backendTemplate.php';

?>
