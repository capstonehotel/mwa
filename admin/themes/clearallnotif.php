<?php
require_once("../../includes/initialize.php");
// Check if the clear_all_notifications parameter is set
    // Prepare the SQL query to delete all notifications
    $query = "DELETE FROM notifications"; // Adjust this table name if necessary

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // If successful, return a success response
        echo "successfully deleted";
    } else {
        // If there was an error, return an error response
        echo "error";
    }


// Close the database connection

?>



