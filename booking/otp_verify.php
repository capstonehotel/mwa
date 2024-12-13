<?php
session_start();

if (isset($_POST['otp'])) {
    $userOtp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);

    // Retrieve the email from the session
    if (isset($_SESSION['otp_email'])) {
        $email = $_SESSION['otp_email'];

        // Check if the OTP exists in the session
        if (isset($_SESSION['otp'])) {
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
                echo 'invalid_format';
            }
        } else {
            echo 'otp_not_found';
        }
    } else {
        echo 'email_not_found';
    }
} else {
    echo 'otp_not_provided';
}