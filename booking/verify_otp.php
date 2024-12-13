<?php
session_start();

if (isset($_POST['otp']) && isset($_POST['email'])) {
    // Sanitize the OTP and email input
    $userOtp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Verify that the OTP code matches the email address
    if (isset($_SESSION['otp_email']) && $_SESSION['otp_email'] == $email) {
        // Validate OTP format (6 digits)
        if (preg_match('/^[0-9]{6}$/', $userOtp)) {
            // Check if the OTP matches the session-stored OTP
            if ($userOtp == $_SESSION['otp']) {
                // OTP is valid
                echo 'valid';
            } else {
                // OTP is invalid
                echo 'invalid';
            }
        } else {
            echo 'Invalid OTP code format. Please enter a 6-digit OTP.';  // Invalid OTP format
        }
    } else {
        echo 'Email address does not match the OTP email address.';  // Email mismatch
    }
}
?>
