<?php
 require_once ("initialize.php"); 
 //require_once ("sendOTP.php");


//  if(isset($_POST['gsubmit'])){

    

//   $email = trim($_POST['username']);
//   $upass  = trim($_POST['pass']);

//   }
//    if ($email == '' OR $upass == '') { 
//       message("Invalid Username and Password!", "error");
//        redirect("https://mcchmhotelreservation.com/index.php?page=6");
         
//     } else {   
//         $guest = new Guest();
//         $res = $guest::guest_login($email,$upass);

//         if ($res == true) {
       
//              redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
//          } else {
//              message(" Please try again.", "error");
//              redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
//          }
//      }
 

// if (!isset($_SESSION['login_attempts'])) {
//     $_SESSION['login_attempts'] = 0;
//     $_SESSION['block_time'] = null;
// }

// if (isset($_POST['gsubmit'])) {
//     if ($_SESSION['login_attempts'] >= 3) {
//         if (time() < $_SESSION['block_time']) {
//             $remaining_time = $_SESSION['block_time'] - time();
//             die("Too many attempts. Please try again in " . ceil($remaining_time) . " seconds.");
//         } else {
//             $_SESSION['login_attempts'] = 0; // Reset attempts after block time
//         }
//     }

//     $email = trim($_POST['username']);
//     $upass = trim($_POST['pass']);
//     $hcaptcha_response = $_POST['h-captcha-response'];

//     // Verify hCaptcha
//     $secret = 'ES_84f7194c2cd04982851c0b2c910b33f3';
//     $response = file_get_contents("https://hcaptcha.com/siteverify?secret=$secret&response=$hcaptcha_response");
//     $responseKeys = json_decode($response, true);

//     if ($responseKeys["success"]) {
//         // Proceed with login
//         if ($email == '' OR $upass == '') { 
//             message("Invalid Username and Password!", "error");
//             redirect("https://mcchmhotelreservation.com/index.php?page=6");
//         } else {   
//             $guest = new Guest();
//             $res = $guest::guest_login($email, $upass);

//             if ($res == true) {
//                 $_SESSION['login_attempts'] = 0; // Reset attempts on successful login
//                 redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
//             } else {
//                 $_SESSION['login_attempts']++;
//                 if ($_SESSION['login_attempts'] >= 3) {
//                     $_SESSION['block_time'] = time() + 300; // Block for 5 minutes
//                 }
//                 message("Please try again.", "error");
//                 redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
//             }
//         }
//     } else {
//         message("hCaptcha verification failed!", "error");
//         redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
//     }
// }
 
// ?



if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['block_time'] = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gsubmit'])) {
    
    if ($_SESSION['login_attempts'] >= 3) {
        if (time() < $_SESSION['block_time']) {
            $_SESSION['error_message'] = "Too many login attempts. Please try again later.";
            redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
        } else {
            $_SESSION['login_attempts'] = 0; // Reset attempts after block time
        }
    }

    // Sanitize input
    $email = filter_var(trim($_POST['username']), FILTER_SANITIZE_EMAIL);
    $upass = htmlspecialchars(trim($_POST['pass']), ENT_QUOTES, 'UTF-8');
    $hcaptcha_response = $_POST['h-captcha-response'];

    // Validate hCaptcha
    $secret = 'ES_84f7194c2cd04982851c0b2c910b33f3';
    $response = file_get_contents("https://hcaptcha.com/siteverify?secret=$secret&response=$hcaptcha_response");
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        if (empty($email) || empty($upass)) {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['block_time'] = time() + 300; // Block for 5 minutes
                $_SESSION['error_message'] = "Too many login attempts. Please try again later.";
                redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
            }
            message("Invalid Username and Password!", "error");
            redirect("https://mcchmhotelreservation.com/index.php?page=6");
        } else {
            $guest = new Guest();
            $res = $guest::guest_login($email, $upass);

            if ($res === true) {
                
                $_SESSION['login_attempts'] = 0; // Reset attempts
                //setcookie("user_logged_in", "true", time() + 3600, "/"); 
                // Generate and send OTP
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_expiry'] = time() + 300; // OTP expires in 5 minutes
                $_SESSION['user_email'] = $email;
                // After successful login
$session_token = bin2hex(random_bytes(32)); // Generate a random session token
$_SESSION['session_token'] = $session_token; // Store it in the session

// Update the session token and last activity in the database
$query = "UPDATE tblguest SET session_token = ?, last_activity = NOW() WHERE GUESTID = ?";
$stmt = $db->prepare($query);
$stmt->execute([$session_token, $userId]); // Assuming $userId is the ID of the logged-in user

                // Example email sending function (implement PHPMailer or similar)
                mail($email, "Your OTP Code", "Your OTP code is: $otp");
                //session_regenerate_id(true); // Regenerate session ID
                redirect("https://mcchmhotelreservation.com/booking/index?view=payment");
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 3) {
                    $_SESSION['block_time'] = time() + 300; // Block for 5 minutes
                    $_SESSION['error_message'] = "Too many login attempts. Please try again later.";
                } else {
                    $_SESSION['error_message'] = "Invalid Username or Password. You have " . (3 - $_SESSION['login_attempts']) . " attempts left.";
                }
                message("Please try again.", "error");
                redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
            }
        }
    } else {
        message("hCaptcha verification failed!", "error");
        redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
    }
}

// OTP Verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $user_otp = trim($_POST['otp']);

    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $user_otp && time() < $_SESSION['otp_expiry']) {
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
    } else {
        $_SESSION['error_message'] = "Invalid or expired OTP.";
        redirect("https://mcchmhotelreservation.com/booking/index.php?view=verify_otp");
    }
}
?>
