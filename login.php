<?php
//user
require_once("initialize.php"); 

if (isset($_POST['gsubmit'])) { 
    $email = trim($_POST['username']);
    $upass = trim($_POST['pass']); // use the plain password
    
    if ($email == '' OR $upass == '') { 
        message("Invalid Username and Password!", "error");
        redirect("https://mcchmhotelreservation.com/index.php?page=6");
    } else {   
        $guest = new Guest();
        // Pass plain password instead of hashed password
        $res = $guest::guest_login($email, $upass);

        if ($res == true) {
            redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
        } else {
            message("Invalid Username and Password! Please contact administrator", "error");
            redirect("https://mcchmhotelreservation.com/booking/index.php?view=logininfo");
        }
    }
}
?>