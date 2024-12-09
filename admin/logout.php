 <?php
require_once("../includes/initialize.php");

// Four steps to closing a session
// (i.e. logging out)
// $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// // Retrieve user details from session
// $userid = $_SESSION['ADMIN_ID']; 
// // Update the user's status in the database to 'logged_out'
// $update_query = "UPDATE tbluseraccount SET status = 'logged_out' WHERE userid = '$userid'";
// mysqli_query($con, $update_query);

// // 1. Find the session
// session_start();

// 2. Unset all the session variables
unset( $_SESSION['ADMIN_ID'] );
unset( $_SESSION['ADMIN_UNAME'] );
unset( $_SESSION['ADMIN_USERNAME'] );
unset( $_SESSION['ADMIN_UPASS'] );
unset( $_SESSION['ADMIN_UROLE'] );
// Destroy the session
// session_destroy();
 	
// 4. Destroy the session
redirect("index.php");
?>