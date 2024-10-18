<?php
// session_start();
require 'sendOTP.php';  // Ensure sendOTP function is accessible

if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Make sure the email matches the current session email
    if (isset($_SESSION['username']) && $_SESSION['username'] == $email) {
        // Regenerate the OTP and send it
        $name = $_SESSION['name'];
        $last = $_SESSION['last'];
        $_SESSION['otp'] = sendOTP($email, $name, $last);  // Resend OTP

        if ($_SESSION['otp']) {
            echo 'OTP resent successfully';
        } else {
            echo 'Error resending OTP';
        }
    } else {
        echo 'Email does not match the session email';
    }
}
?>
