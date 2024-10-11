<?php
 require_once ("initialize.php"); 
// require_once ("includes/config.php");
// require_once("includes/database.php");
// require_once("includes/accomodation.php");
// require_once("includes/functions.php");

// //later here where we are going to put our class session
// require_once("includes/session.php");
// require_once("includes/user.php");
// require_once("includes/pagination.php");
// require_once("includes/paginsubject.php");
// require_once("includes/guest.php");
// require_once("includes/reserve.php"); 


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
           redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
        }else{
             message("Invalid Username and Password! Please contact administrator", "error");
             redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
        }
 
 }
 
?>