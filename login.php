<?php
// Include required initialization and classes
require_once("initialize.php");

if (isset($_POST['gsubmit'])) {
    // Get the hCaptcha response from the form
    $hcaptchaResponse = $_POST['h-captcha-response'];
    $secretKey = 'ES_84f7194c2cd04982851c0b2c910b33f3';  // Replace with your actual hCaptcha secret key
    $remoteIp = $_SERVER['REMOTE_ADDR'];
    
    // Verify the hCaptcha response
    $verifyResponse = file_get_contents("https://hcaptcha.com/siteverify?secret=$secretKey&response=$hcaptchaResponse&remoteip=$remoteIp");
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        // hCaptcha was successful, proceed with login
        $email = trim($_POST['username']);
        $upass = trim($_POST['pass']); // plain password

        if ($email == '' || $upass == '') { 
            message("Invalid Username and Password!", "error");
            redirect(web_root . "index.php?page=6");
        } else {   
            $guest = new Guest();
            // Pass plain password for login
            $res = $guest::guest_login($email, $upass);

            if ($res == true) {
                redirect(WEB_ROOT . "booking/index.php?view=payment");
            } else {
                message("Invalid Username and Password! Please contact administrator", "error");
                redirect(WEB_ROOT . "booking/index.php?view=logininfo");
            }
        }
    } else {
        // hCaptcha verification failed
        message("hCaptcha verification failed. Please try again.", "error");
        redirect(web_root . "index.php?page=6");
    }
}
?>
