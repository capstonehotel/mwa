<?php
session_start();
require_once("../includes/initialize.php");

$response = array('newBooking' => false);

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if there are new bookings today that the admin hasn't viewed
$query = "SELECT COUNT(*) as newBookings FROM tblreservation WHERE DATE(TRANSDATE) = CURDATE() AND STATUS = 'pending'";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($data['newBookings'] > 0 && (!isset($_SESSION['booking_notification_viewed']) || $_SESSION['booking_notification_viewed'] == false)) {
    $response['newBooking'] = true;
}

echo json_encode($response);

$conn->close();
?>
