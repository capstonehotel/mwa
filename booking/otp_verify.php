<?php
session_start();

if (isset($_POST['otp'])) {
    $userOtp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Verify that the OTP code was sent to the correct email address
    if (isset($_SESSION['otp_email']) && $_SESSION['otp_email'] == $email) {
        // Verify that the OTP code is valid
        if (preg_match('/^[0-9]{6}$/', $userOtp)) {
            // User-input OTP is a valid OTP code
            if ($userOtp == $_SESSION['otp']) {
                // OTP is valid, return success message
                echo 'valid';
            } else {
                // OTP is invalid, return error message
                echo 'invalid';
            }
        } else {
            echo 'Invalid OTP code'; // Handle the case where the user-input OTP is not a valid OTP code
        }
    } else {
        echo 'Email address does not match the OTP email address'; // Handle the case where the email address does not match the OTP email address
    }
}
?>