<?php
// Start the session or use a token for security
session_start();

// Include your database connection file
require_once '../initialize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $otp = $_POST['otp'];  // OTP entered by user
    $token = $_POST['token'];  // Verification token

    // Validate OTP (check if it's valid and not expired)
    $result = $conn->query("SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = '$token' AND OTP = '$otp' AND OTP_EXPIRE_AT >= NOW()");
    
    if ($result->num_rows > 0) {
        // OTP verified successfully
        echo json_encode(['success' => true]);
    } else {
        // OTP is invalid or expired
        echo json_encode(['success' => false]);
    }

    // Close the connection
    $conn->close();
}
?>
