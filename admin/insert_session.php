<?php
require_once("../includes/initialize.php");

// Receive the session data from the AJAX request
if (isset($_POST['user'], $_POST['device'], $_POST['location'], $_POST['ip_address'])) {
    $user = $_POST['user'];
    $device = $_POST['device'];
    $location = $_POST['location'];
    $ip_address = $_POST['ip_address'];

    // Prepare the session insertion query
    $stmt = $connection->prepare("INSERT INTO sessions (user, device, location, ip_address) VALUES (?, ?, ?, ?)");
    
    // Check for errors in the preparation step
    if (!$stmt) {
        echo 'Error preparing statement: ' . $connection->error;
        exit();
    }

    // Bind the parameters to the statement
    $stmt->bind_param("ssss", $user, $device, $location, $ip_address);

    // Execute the query
    if ($stmt->execute()) {
        echo 'success'; // If session is inserted successfully
    } else {
        echo 'Error executing query: ' . $stmt->error; // If there was an error with the insertion
    }
} else {
    echo 'Missing required parameters'; // If any required POST data is missing
}
?>
