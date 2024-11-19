<?php
 require_once ("initialize.php"); 
 //require_once ("sendOTP.php");


 if(isset($_POST['gsubmit'])){

    

  $email = trim($_POST['username']);
  $upass  = trim($_POST['pass']);

  }
   if ($email == '' OR $upass == '') { 
      message("Invalid Username and Password!", "error");
       redirect("https://mcchmhotelreservation.com/index.php?page=6");
         
    } else {   
        $guest = new Guest();
        $res = $guest::guest_login($email,$h_upass);

        if ($res == true) {
       
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
         } else {
             message(" Please try again.", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
         }
     }
 
 
?>