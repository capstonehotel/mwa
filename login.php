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
            $remaining_time = $_SESSION['block_time'] - time();
            die("Too many attempts. Please try again in " . ceil($remaining_time) . " seconds.");
        } else {
            $_SESSION['login_attempts'] = 0; // Reset attempts
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
            message("Invalid Username and Password!", "error");
            redirect("https://mcchmhotelreservation.com/index.php?page=6");
        } else {
            $guest = new Guest();
            $res = $guest::guest_login($email, $upass);

            if ($res === true) {
                $_SESSION['login_attempts'] = 0; // Reset attempts
                session_regenerate_id(true); // Regenerate session ID
                redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 3) {
                    $_SESSION['block_time'] = time() + 300; // Block for 5 minutes
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
?>
