<?php
 require_once ("initialize.php"); 
 require_once 'mcchmhotelreservation.com/booking/sendOTP.php'; 


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

        if ($res==true){
           redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment&verify=true");
        }else{
             message("Invalid Username and Password! Please contact administrator", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
        }
 
 }
 
?>