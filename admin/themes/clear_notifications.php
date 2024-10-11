<?php
session_start();
require_once("../includes/initialize.php");

if (isset($_GET['viewed'])) {
    if ($_GET['viewed'] == 'bookings') {
        $_SESSION['booking_notification_viewed'] = true;
    }

    if ($_GET['viewed'] == 'chat') {
        $email = $_SESSION['email'];
        $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE messages SET is_read = 1 WHERE user_email = '$email' AND is_read = 0";
        $conn->query($sql);

        $conn->close();
    }
}

$response = array('success' => true);
echo json_encode($response);
?>
