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
 // You need to fetch the guest's first and last name
//  $_SESSION['G_FNAME'] = $res['G_FNAME']; // Ensure guest_login returns these values
//  $_SESSION['G_LNAME'] = $res['G_LNAME'];
       
        if ($res == true) {
        //  // Send OTP
        //  $_SESSION['otp']  = sendOTP($email, $_SESSION['name'], $_SESSION['last']); // Use actual names
        //  if (  $_SESSION['otp'] ) {
             // Store the OTP in session if needed
             //$_SESSION['otp'] = $otp;
             // Redirect to a page to enter OTP
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment&verify=true");
         } else {
             message("Failed to send OTP. Please try again.", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
         }
     }
 
 
?>