<?php
require_once("initialize.php");
require_once("booking/sendOTP.php");

if (isset($_POST['gsubmit'])) {
    $email = trim($_POST['username']);
    $upass  = trim($_POST['pass']);
    $h_upass = sha1($upass);

    // Check if the email or password fields are empty
    if ($email == '' OR $upass == '') { 
        message("Invalid Username and Password!", "error");
        redirect("https://mcchmhotelreservation.com/index.php?page=6");
    } else {   
        $guest = new Guest();
        $res = $guest::guest_login($email, $h_upass);

        // Check if login was successful
        if ($res == true) {
            // Set session variable for email for OTP verification
            $_SESSION['username'] = $email;

            // Send OTP to the user's email
            $name = ''; // You might want to fetch the user's name from the database if necessary
            $lastname = ''; // Same for lastname
            $otp = sendOTP($email, $name, $lastname); // Call the sendOTP function

            // Store the generated OTP in session for verification
            $_SESSION['otp'] = $otp;

            // Return a success response to be handled by AJAX in logininfo.php
            echo 'success';
        } else {
            message("Invalid Username and Password! Please contact administrator", "error");
            redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
        }
    }
}
?>
