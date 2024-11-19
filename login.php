<?php
 require_once ("initialize.php"); 
 require_once ("sendOTP.php");


 if(isset($_POST['gsubmit'])){

    

  $email = trim($_POST['username']);
  $upass  = trim($_POST['pass']);

  }
   if ($email == '' OR $upass == '') { 
      message("Invalid Username and Password!", "error");
       redirect("https://mcchmhotelreservation.com/index.php?page=6");
         
    } else {   
        $guest = new Guest();
        $res = $guest::guest_login($email,$upass);
        if ($res == true) {
            // Send OTP
            $_SESSION['otp']  = sendOTP($email, $_SESSION['name'], $_SESSION['last']); // Use actual names
            if (  $_SESSION['otp'] ) {
       
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment&verify=true");
         } else {
             message(" Please try again.", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
         }
     }
    }
 
?>