<?php
require_once("../includes/initialize.php");

$globalToken = file_get_contents('global_admin_token.txt');
 if (!isset($_SESSION['ADMIN_ID']) || !isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
	 // Token mismatch; logout the session
	 session_destroy();
	 echo "<script>alert('test');</script>";
	 header('Location: login.php');
	 exit();
 }


 
$content='home.php';

 include 'themes/backendTemplate.php';

?>
