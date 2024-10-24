<?php
session_start();
include '../includes/initialize.php'; // Include your database connection file

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the reservation ID from the AJAX request
    $data = json_decode(file_get_contents("php://input"), true);
    $reservationId = intval($data['id']); // Assuming it's an integer

    // Update the notification status in the database
    $update_query = "UPDATE tblreservation SET is_read = 1 WHERE RESERVEID = '$reservationId'";
    if (mysqli_query($connection, $update_query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
}
?>
