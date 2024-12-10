<?php
require_once("initialize.php");


// 1. Find the session
@session_start();
//session_regenerate_id(true);
// 2. Unset all the session variables

// unset($_SESSION['GUESTID']);	
// unset($_SESSION['name']); 		
// unset($_SESSION['last']);	
// unset($_SESSION['country']);
// unset($_SESSION['city']); 		
// unset($_SESSION['address']); 	
// unset($_SESSION['zip']); 		
// unset($_SESSION['phone']); 	
// unset($_SESSION['email']); 		
// unset($_SESSION['pass']); 	
// unset($_SESSION['from']); 
// unset($_SESSION['to']); 	
// unset($_SESSION['monbela_cart']); 	

// Unset all session variables

// Unset all session variables
$_SESSION = array();


// Destroy the session
session_destroy();

setcookie("user_logged_in", "", time() - 3600, "/"); // Expire the cookie	
// 4. Destroy the session
//session_destroy();
redirect("https://mcchmhotelreservation.com/index.php?logout=1");
?>

