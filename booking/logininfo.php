
<style>
        .login-container {
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 1000px;
        }

        .form-control {
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
    </style>
<?php 

if (!isset($_SESSION['monbela_cart'])) {
  # code...
  redirect('https://mcchmhotelreservation.com/index.php');
}



 ?>
<div class="card rounded" style="padding: 10px;">
  <div  class="pagetitle">   
        <h1  >Your Booking Cart 
        </h1> 
    </div>
    <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/index.php">Home</a></li>
        <li class="breadcrumb-item "><a href="https://mcchmhotelreservation.com/booking/">Booking Cart</a></li>
        <li class="breadcrumb-item active">Verify Accounts</li>
      </ol>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Login</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Register</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
              <div class="col-md-12">
                <h4>Service Two</h4> 
                    <?php echo logintab(); ?>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
              <?php  require_once 'personalinfo.php'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>



<?php

  function logintab(){

    ?>  
  <div class="login-container">
        <form id="loginForm" method="post">
            <div class="form-group">             
                <input type="email" class="form-control" id="username" name="username" placeholder="Enter your email" required>
            </div>
            <div class="form-group" style="margin-top: 10px;">                
                <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password" required>
            </div>

            <div class="form-group" style="margin-top: 10px;">
                <div class="h-captcha" data-sitekey="09b62f1c-dad4-40c4-8394-001ef4d0a126"></div>
                <p id="captchaMessage" style="color:red; display:none;">Please complete the hCaptcha.</p>
            </div>
            <p  style="margin-top: 10px; margin-left: 10px;">
                <a href="<?php echo  "https://mcchmhotelreservation.com/booking/forgot_password.php"; ?>">Forgot Password?</a>
            </p>
            <button type="submit" name="gsubmit" id="signInButton" class="btn btn-primary btn-block" style="margin-top: 10px;">Sign In</button>
        </form>
    </div>
 
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    <script>
    document.getElementById('signInButton').addEventListener('click', function() {
        const hcaptchaResponse = document.querySelector('input[name="h-captcha-response"]').value;
        const email = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (!hcaptchaResponse) {
            document.getElementById('captchaMessage').style.display = 'block'; // Show message
        } else {
            document.getElementById('captchaMessage').style.display = 'none'; // Hide message if hCaptcha is completed
            
            // Create a FormData object to send the form data
            const formData = new FormData();
            formData.append('username', email);
            formData.append('pass', password);
            formData.append('h-captcha-response', hcaptchaResponse);

            // Send the data using fetch
            fetch('https://mcchmhotelreservation.com/login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Handle response data here (you can redirect or show a message)
                console.log(data); // For debugging
                // You can redirect or show a success message based on the response
                // For example, if login is successful, redirect to the payment page
                // window.location.href = 'https://mcchmhotelreservation.com/booking/index.php?view=payment';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>
<?php
  }

function listofbooking(){



$payable = 0;
if (isset( $_SESSION['monbela_cart'])){ 
$count_cart = count($_SESSION['monbela_cart']);

?>
      <!-- list -->
<div class="row">
<div class="col-md-4">

     <div style="overflow:scroll;  height:300px;">


<?php
for ($i=0; $i < $count_cart  ; $i++) {  

  $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND ROOMID=" . $_SESSION['monbela_cart'][$i]['monbelaroomid'];
   $mydb->setQuery($query);
   $cur = $mydb->loadResultList(); 
    foreach ($cur as $result) { 


?>             
      
        <div class="row"> 
          <div class="col-md-12">
             <div class="panel panel-default">
                <div class="panel-heading">
                <!-- <h4>Payment</h4> -->
                </div>
                <div class="panel-body">

                    <div class="col-md-12">
                      <label>Room:</label><br/>
                      <?php echo  $result->ROOM.' '. $result->ROOMDESC; ?>
                    </div>
                   
                    <div class="col-md-6">
                      <label>Checkedin:</label>
                      <?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckin']),"m/d/Y"); ?>
                    </div> 

                    <div class="col-md-6">
                       <label>Checkedout:</label>
                      <?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckout']),"m/d/Y"); ?>
                    </div>   
                  
 
                      <div class="col-md-12" style="float:left;border-top:1px solid #000;">
                          <label>Summary</label> 
                      </div>
                
                      <div style="float:right">  

                          <div class="col-md-12"  >
                              <label>Price:</label>
                            <?php echo  ' &#8369 '. $result->PRICE; ?>
                         </div> 

                         <div class="col-md-12"  >
                              <label>Days:</label>
                            <?php echo   $_SESSION['monbela_cart'][$i]['monbeladay']; ?>
                         </div> 

                         <div class="col-md-12" >
                              <label>Total:</label>
                            <?php echo ' &#8369 '.   $_SESSION['monbela_cart'][$i]['monbelaroomprice']; ?>
                         </div> 

                      </div>    
                      
                 </div>

                 <div class="panel-footer">
                   
                 </div>
              </div>   

          </div>
        </div> 
  <?php 
    }

                      $payable += $_SESSION['monbela_cart'][$i]['monbelaroomprice'] ;
  }
                      $_SESSION['pay'] = $payable;
}
?>
      <div class="col-md-12" >
      <div class="row">
          <label style="float:left">Overall Price</label> <h2 style="float:right"> &#8369 <?php echo   $_SESSION['pay'] ;?></h2> 
      </div>
        </div>


  </div>  
    
  </div>  
</div>
      <!-- end list -->
    
<!-- end content -->
<!-- =========================================================================== -->
<?php } ?>