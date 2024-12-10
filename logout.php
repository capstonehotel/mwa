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
// Get the session token from the session
$session_token = $_SESSION['session_token'] ?? null;

// If a session token exists, remove it from the database
if ($session_token) {
    $query = "UPDATE tblguest SET session_token = NULL, last_activity = NULL WHERE session_token = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$session_token]);
}

// Unset all the session variables
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
 	
// 4. Destroy the session
//session_destroy();
redirect("https://mcchmhotelreservation.com/index.php?logout=1");
?>

