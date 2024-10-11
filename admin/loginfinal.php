<?php

require_once("../includes/initialize.php");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>HM Hotel Reservation</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
<style>
   body {
    background-image: url("../images/room.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}
.title{
    text-align: center;
    font-size: 66px;
    font-family: serif;
    color:ghostwhite;
    text-shadow: 2px 2px 2px black;

}


</style>
  <body>
<?php
 if (admin_logged_in()) {
?>
   <script type="text/javascript">
            redirect('index.php');
    </script>
    <?php
}
if (isset($_POST['btnlogin'])) {
    //form has been submitted1
    
   $uname = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    $h_upass = sha1($upass);
     //check if the email and password is equal to nothing or null then it will show message box
   
    if ($uname == '' OR $upass == '') {
?>    <script type="text/javascript">
                alert("Invalid Username and Password!");
                </script>
            <?php
        
    } else {
    
    $sql = "SELECT * FROM tbluseraccount WHERE USER_NAME = '$uname' AND UPASS = '$h_upass'";
    $result = $connection->query($sql);

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    if (!$result) {
        die("Database query failed: " . mysqli_error($connection));
    }
    $row = mysqli_fetch_assoc($result);

    if($row){
            $_SESSION['ADMIN_ID'] 	 		=  $row['USERID'] ;
            $_SESSION['ADMIN_UNAME']    	=  $row['UNAME'] ;
            $_SESSION['ADMIN_USERNAME']		=  $row['USER_NAME'] ;
            $_SESSION['ADMIN_UPASS']		=  $row['UPASS'] ;
            $_SESSION['ADMIN_UROLE']    	=  $row['ROLE'];
      ?>  
      <style> 
      /* Adjust the width of the alert */
.swal2-popup {
    width: 400px !important; /* Ensure the width is applied */
}

/* Adjust the font size */
.swal2-title {
    font-size: 2.5rem !important; /* Ensure the font size is applied */
}

/* Adjust the button size */
.swal2-confirm {
    padding: 10px 20px !important; /* Ensure the padding is applied */
}
</style>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    Swal.fire({
        title: `Hello, <?php echo $row['UNAME']; ?>! Welcome back!`,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "index.php";
        }
    });
</script>


      <?php
    
    
    } else {
?>  
<script src="sweetalert.js"></script>  
<script type="text/javascript">
                swal({
                    text: "Username or Password Not Registered!\nContact Your administrator."
                }).then((value) => {
               window.location = "login.php";
            });
                </script>
        <?php
        }
        
    }
} else {
    
    $email = "";
    $upass = ""; 
}

?>        <div class="title">
    
        <p><b><span style="color:#ffd6bb;">HM Hotel </span> <span style="color:whitesmoke;">Reservation </span><span style="color:WG;">System   </span></b></p>
     </div>
       </br>
        <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" >
                <div class="login-panel panel panel-default"style="  border-radius:8px; box-shadow: 0 2px 2px 0 rgba(2,2,2,2.1);">
                    <div class="panel-heading" style="border-top-right-radius:8px; border-top-left-radius: 8px;">
                        <h2 class="panel-title" style="font-size: 30px; font-family: Georgia;"><center>Login Credential</h2>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="#">
                            <fieldset>
                                <div class="form-group">
                                    <h5>Email</h5>
                                    <input class="form-control" required placeholder="ex.gmail.com" name="email" type="email" required  >
                                </div>
                                <div class="form-group">
                                    <h5>Password</h5>
                                    <input class="form-control" placeholder="* * * * * * * * *" name="pass" type="password" value="" minlength="6" maxlength="8">
                                    <a href="javascript:void(0)" class="text-reset text-decoration-none pass_view"> <i class="fa fa-eye-slash"></i></a>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit"  name="btnlogin" class="btn btn-lg btn-success btn-block">Login</button><br>
                                <div class="text-center mt-3">
                    <a href="../index.php" class="text-primary">Back to the website</a>
                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
