<?php
require_once("initialize.php");


// 1. Find the session
@session_start();
$user_id = $_SESSION['GUESTID'];

// Get active sessions
$active_sessions = get_active_sessions();

// Remove the session for the user
unset($active_sessions[$user_id]);
save_active_sessions($active_sessions);
//session_regenerate_id(true);
// 2. Unset all the session variables
unset($_SESSION['GUESTID']);	
unset($_SESSION['name']); 		
unset($_SESSION['last']);	
unset($_SESSION['country']);
unset($_SESSION['city']); 		
unset($_SESSION['address']); 	
unset($_SESSION['zip']); 		
unset($_SESSION['phone']); 	
unset($_SESSION['email']); 		
unset($_SESSION['pass']); 	
unset($_SESSION['from']); 
unset($_SESSION['to']); 	
unset($_SESSION['monbela_cart']);
// Unset all the session variables

session_destroy(); // Destroy the session
 	
// 4. Destroy the session
//session_destroy();
redirect("https://mcchmhotelreservation.com/index.php?logout=1");
?>

