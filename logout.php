<?php
require_once("initialize.php");


// 1. Find the session
@session_start();
// $user_id = $_SESSION['GUESTID']; // Assuming this is set during login

// // Clear the session token in the database
// $query = "UPDATE tblguest SET session_token = NULL WHERE GUESTID = ?";
// $stmt = $db->prepare($query);
// $stmt->bind_param("i", $user_id);
// $stmt->execute();


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

