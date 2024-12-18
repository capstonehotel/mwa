<?php
// insert_session.php
// Receive the session data from the AJAX request
if (isset($_POST['user'], $_POST['device'], $_POST['location'], $_POST['ip_address'])) {
    $user = $_POST['user'];
    $device = $_POST['device'];
    $location = $_POST['location'];
    $ip_address = $_POST['ip_address'];

    // Prepare the session insertion query
    $stmt = $connection->prepare("INSERT INTO sessions (user, device, location, ip_address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user, $device, $location, $ip_address);

    // Execute the query
    if ($stmt->execute()) {
        echo 'success'; // If session is inserted successfully
    } else {
        echo 'error'; // If there was an error with the insertion
    }
}
?>
