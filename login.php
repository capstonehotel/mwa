<?php
 require_once ("initialize.php"); 
 require_once ("sendOTP.php");


 if(isset($_POST['gsubmit'])){

  $email = trim($_POST['username']);
  $upass  = trim($_POST['pass']);
  $h_upass = sha1($upass);
  }
   if ($email == '' OR $upass == '') { 
      message("Invalid Username and Password!", "error");
       redirect("https://mcchmhotelreservation.com/index.php?page=6");
         
    } else {   
        $guest = new Guest();
        $res = $guest::guest_login($email,$h_upass);

       
        if ($res == true) {
         // Send OTP
         $otp = sendOTP($email, $_SESSION['G_FNAME'], $_SESSION['G_LNAME']); // Use actual names
         if ($otp) {
             // Store the OTP in session if needed
             $_SESSION['otp'] = $otp;
             // Redirect to a page to enter OTP
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment&verify=true");
         } else {
             message("Failed to send OTP. Please try again.", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
         }
     }
 }
 
?>