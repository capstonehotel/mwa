


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
        
.input-group input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; /* Ensures padding is included in total width */
        }
.input-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
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
    <br>
    <!-- <nav aria-label="breadcrumb" >
      <ol class="breadcrumb" style="margin-top: 10px;">
        <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/index.php">Home</a></li>
        <li class="breadcrumb-item "><a href="https://mcchmhotelreservation.com/booking/">Booking Cart</a></li>
        <li class="breadcrumb-item active">Verify Accounts</li>
      </ol>
    </nav> -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Login</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Register</button>
            </div>
          </nav>
          <br>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
              <div class="col-md-12">
                <h4>Sign In</h4> 
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php

function logintab() {
  $isBlocked = isset($_SESSION['block_time']) && time() < $_SESSION['block_time'];
    $remaining_time = $isBlocked ? ceil($_SESSION['block_time'] - time()) : 0;
    $remaining_attempts = max(0, 3 - ($_SESSION['login_attempts'] ?? 0));
    ?>
  <div class="login-container">
  <?php if ($isBlocked): ?>
            <p id="remaining-time" class="text-danger">You are locked out. Please try again in <?= $remaining_time ?> seconds.</p>
            <?php elseif ($remaining_attempts > 0 && isset($_SESSION['login_attempts'])): ?>
            <!-- Show remaining attempts only if attempts have been made -->
            <p class="text-info" id="remaining-attempts">You have <?= $remaining_attempts ?> attempts left.</p>
            
        <?php endif; ?>
        <form action="<?php echo "https://mcchmhotelreservation.com/login"; ?>" method="post">
            <div class="form-group">             
                <input type="email" class="form-control" id="username" name="username" placeholder="Enter your email" <?= ($remaining_attempts == 0 && $isBlocked) ? 'disabled' : '' ?>  required>
            </div>
            <div class="input-group" style="margin-top: 10px;">                
                <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password"  minlength="8" maxlength="12" <?= ($remaining_attempts == 0 && $isBlocked) ? 'disabled' : '' ?>  required>
                <i class="far fa-eye" id="eyeIcon"></i>
            </div>
            <div class="form-group" style="margin-top: 10px;">
                <div class="h-captcha" data-sitekey="09b62f1c-dad4-40c4-8394-001ef4d0a126" data-callback="onSuccess" data-error-callback="onError" data-expired-callback="onExpired" disabled <?= ($remaining_attempts == 0 && $isBlocked) ? 'style="display:none;"' : '' ?>></div>
            </div>
            <!-- <div class="form-group" style="margin-top: 10px;">
                <div class="h-captcha" data-sitekey="09b62f1c-dad4-40c4-8394-001ef4d0a126" data-callback="onSuccess"
                 data-error-callback="onError"
                 data-expired-callback="onExpired"></div>
                
            </div> -->
            <!-- <p  style="margin-top: 10px; text-align: right;">
                <a href="<?php echo  "https://mcchmhotelreservation.com/booking/forgot_password.php"; ?>">Forgot Password?</a>
            </p> -->
            <button id="signin-button" type="submit" name="gsubmit" class="btn btn-primary btn-block" style="margin-top: 10px;" <?= ($remaining_attempts == 0 && $isBlocked) ? 'disabled' : '' ?>>Sign In</button>
            <p  style="margin-top: 10px; text-align: left;">
                <a href="<?php echo  "https://mcchmhotelreservation.com/booking/forgot_password"; ?>">Forgot Password?</a>
            </p>
        </form>
    </div>
 
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    <script>
      
    const eyeIcon = document.getElementById('eyeIcon');
    const passwordInput = document.getElementById('password');

    eyeIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
    // Function called when hCaptcha is successful
    function onSuccess(token) {
        document.getElementById('signin-button').disabled = false; // Enable the button
    }

    // Function called when hCaptcha fails
    function onError() {
        document.getElementById('signin-button').disabled = true; // Disable the button
    }

    // Function called when hCaptcha expires
    function onExpired() {
        document.getElementById('signin-button').disabled = true; // Disable the button
    }
      // Countdown Timer
    <?php if ($remaining_attempts == 0 && $isBlocked): ?>
        var remainingTime = <?= $remaining_time ?>;
        var countdownElement = document.getElementById("remaining-time");

        function updateRemainingTime() {
            remainingTime--;
            countdownElement.textContent = "You are locked out. Please try again in " + remainingTime + " seconds.";
            if (remainingTime <= 0) {
                location.reload(); // Reload to enable login again after time is up
            }
        }

        setInterval(updateRemainingTime, 1000); // Update the remaining time every second
    <?php endif; ?>
    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
