<?php
require_once("../includes/initialize.php");
require_once("sendOTP.php");

session_start();
// Start the session
// Example login check


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="wave.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.hcaptcha.com/1/api.js" async defer></script> <!-- hCaptcha JS -->
    <style>
        body {
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .title {
            text-align: center;
            color: #7fb6dc;
            padding: 15px 0;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
            position: absolute;
            top: 50px; /* Adjusts position at the top of the page */
            z-index: 2;
        }
        .container {
            display: flex;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            height: auto;
            width: 500px; /* Reduced width */
            max-width: 100%;
            position: relative;
            z-index: 1;
            padding: 40px; /* Added padding for spacing */
        }
        .right {
            padding: 0; /* Reset padding */
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%; /* Full width */
        }
        .right h2 {
            text-align: center;
            color: black;
            font-size: 24px;
            margin-bottom: 50px;
        }
        .right form {
            display: flex;
            flex-direction: column;
        }
        .right form .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%; /* Ensures the input group takes full width */
        }
        .right form .input-group input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; /* Ensures padding is included in total width */
        }
        .right form .input-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
        }
        .right form button[type="submit"] {
            padding: 10px;
            background-color: #337AB7;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        /* .right form .links {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .right form .links a {
            color: #337AB7;
            font-size: 16px;
            text-decoration: none;
        } */
         /* Your existing styles */
        .links-container {
            display: flex;
            justify-content: space-between; /* Space between the links */
            margin-top: 10px; /* Add some margin on top */
            width: 100%; /* Ensure it takes full width */
        }
        .links-container a {
            color: #337AB7; /* Link color */
            font-size: 16px; /* Font size */
            text-decoration: none; /* Remove underline */
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Stack elements vertically on mobile */
                height: auto; /* Allow height to adjust */
                width: 90%;
                margin: 0 auto;
            }
            .title {
                max-width: 90%; /* Set a max width to allow wrapping */
                white-space: normal; /* Allow text to wrap onto the next line */
                padding: 10px 0; /* Adjust padding for mobile */
            }
            .right {
                padding: 20px; /* Add padding for mobile */
            }
            .right form {
                max-width: 90%;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>

  <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
  viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
      <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="#cfe8f9" opacity="0.7" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="#cfe8f9" opacity="0.5" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="#cfe8f9" opacity="0.3" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="#cfe8f9" />
    </g>
  </svg>

  <?php

  // Define the max number of attempts and lockout time (5 minutes)
define('MAX_ATTEMPTS', 3);
define('LOCKOUT_TIME', 300); // 5 minutes in seconds

// Check if the user is already locked out
if (isset($_SESSION['lockout_time']) && (time() - $_SESSION['lockout_time'] < LOCKOUT_TIME)) {
    // User is locked out, show the countdown message
    $remaining_time = LOCKOUT_TIME - (time() - $_SESSION['lockout_time']);
    $lockout_message = "You have " . ceil($remaining_time / 60) . " minute(s) remaining before you can try again.";
} else {
    // Reset lockout message if the lockout period has passed
    unset($_SESSION['lockout_time']);
    $lockout_message = '';
}

// Handle OTP verification
if (isset($_POST['otp'])) {
    $entered_otp = sanitize_input($_POST['otp']);
    if (isset($_SESSION['OTP']) && $entered_otp == $_SESSION['OTP'] && time() < $_SESSION['OTP_EXPIRY']) {
        // OTP is valid, log the user in
        $_SESSION['ADMIN_ID'] = $_SESSION['TEMP_ADMIN_ID'];
        $_SESSION['ADMIN_UNAME'] = $_SESSION['TEMP_ADMIN_UNAME'];
        $_SESSION['ADMIN_USERNAME'] = $_SESSION['TEMP_ADMIN_USERNAME'];
        $_SESSION['ADMIN_UPASS'] = $_SESSION['TEMP_ADMIN_UPASS'];
        $_SESSION['ADMIN_UROLE'] = $_SESSION['TEMP_ADMIN_UROLE'];

        // Clear OTP session variables
        unset($_SESSION['OTP']);
        unset($_SESSION['OTP_EXPIRY']);
        unset($_SESSION['TEMP_ADMIN_ID']);
        unset($_SESSION['TEMP_ADMIN_UNAME']);
        unset($_SESSION['TEMP_ADMIN_USERNAME']);
        unset($_SESSION['TEMP_ADMIN_UPASS']);
        unset($_SESSION['TEMP_ADMIN_UROLE']);

        $user = "admin"; // This should be fetched from the session or login credentials
        $device = $_SERVER['HTTP_USER_AGENT']; // Device info (User-Agent)
        $ip_address = $_SERVER['REMOTE_ADDR']; // IP Address
        $location = "Unknown"; // Location can be determined via a geolocation API
        // Fetch location using ip-api
        $response = file_get_contents("http://ip-api.com/json/$ip_address");
        if ($response) {
            $data = json_decode($response, true);
            if ($data['status'] === 'success') {
                $location = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
            }
        }
        $stmt = $connection->prepare("INSERT INTO sessions (user, device, location, ip_address) VALUES (?, ?, ?, ?)");
                     $stmt->bind_param("ssss", $user, $device, $location, $ip_address);
                     if ($stmt->execute()) {
                       
                     } 
        header("Location: index");
        exit();
    } else {
        // Invalid OTP
        $otp_error = "Invalid OTP! Please try again.";
    }
}


  // Function to sanitize inputs for XSS protection
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
if (admin_logged_in()) { ?>
    <script>
        window.location = "index";
    </script>
<?php
}

if (isset($_POST['btnlogin'])) {
    $uname = sanitize_input($_POST['email']);
    $upass = sanitize_input($_POST['pass']);
    $hcaptcha_response = $_POST['h-captcha-response'];  // Get the hCaptcha response

    // Verify hCaptcha response
    $secret_key = 'ES_84f7194c2cd04982851c0b2c910b33f3';  // Replace with your hCaptcha Secret Key
    $url = 'https://hcaptcha.com/siteverify';
    $data = [
        'secret' => $secret_key,
        'response' => $hcaptcha_response,
    ];

    // Use cURL to send request to hCaptcha
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);

    $verification = json_decode($result);

    if (!$verification->success) {
        // hCaptcha failed
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'hCaptcha Verification Failed',
                text: 'Please verify that you are not a robot.'
            }).then(() => {
                    window.location = 'login';
                });
        </script>";
        return;
    }
       // Check for login attempt limits
       if (isset($_SESSION['attempts']) && $_SESSION['attempts'] >= MAX_ATTEMPTS) {
        // Lockout user if they exceeded the max attempts
        $_SESSION['lockout_time'] = time();
        $lockout_message = 'You have reached the maximum number of login attempts. Please try again later.';
        $lockout_error = true;
    }
    if ($uname == '' || $upass == '') {
        $_SESSION['attempts'] = isset($_SESSION['attempts']) ? $_SESSION['attempts'] + 1 : 1;
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid Username and Password!'
            });
        </script>";
    } elseif (!validate_email($uname)) {
        $_SESSION['attempts'] = isset($_SESSION['attempts']) ? $_SESSION['attempts'] + 1 : 1;
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email Format',
                text: 'Please enter a valid email address.'
            });
        </script>";
    } else {
      
        $sql = "SELECT * FROM tbluseraccount WHERE USER_NAME = '$uname'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Database query failed: " . mysqli_error($connection));
        }

        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($upass, $row['UPASS'])) {
           
 
// Function to check if the device is new
function isNewDevice($connection, $user, $device, $ip_address) {
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM sessions WHERE user = ? AND (device != ? OR ip_address != ?)");
    $stmt->bind_param("sss", $user, $device, $ip_address);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}


$user = "admin"; // This should be fetched from the session or login credentials
$device = $_SERVER['HTTP_USER_AGENT']; // Device info (User-Agent)
$ip_address = $_SERVER['REMOTE_ADDR']; // IP Address
$location = "Unknown"; // Location can be determined via a geolocation API
// Fetch location using ip-api
$response = file_get_contents("http://ip-api.com/json/$ip_address");
if ($response) {
    $data = json_decode($response, true);
    if ($data['status'] === 'success') {
        $location = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
    }
}
if (isNewDevice($connection, $user, $device, $ip_address)) {
    // Log the session
         // Generate OTP
          // Store temporary user data in session
 $_SESSION['TEMP_ADMIN_ID'] = $row['USERID'];
 $_SESSION['TEMP_ADMIN_UNAME'] = $row['UNAME'];
 $_SESSION['TEMP_ADMIN_USERNAME'] = $row['USER_NAME'];
 $_SESSION['TEMP_ADMIN_UPASS'] = $row['UPASS'];
 $_SESSION['TEMP_ADMIN_UROLE'] = $row['ROLE'];
         $otp = random_int(100000, 999999); // Generate a 6-digit OTP
         $_SESSION['OTP'] = $otp; // Store OTP in session for verification
         $_SESSION['OTP_EXPIRY'] = time() + 300; // Set OTP expiry time (5 minutes)
     
         
                     // Send OTP to user's email
                     if (sendOTPEmail($row['USER_NAME'], $otp)) {
                         // Redirect to OTP verification
                         echo "<script>
                             Swal.fire({
                                 title: 'OTP Sent!',
                                 text: 'An OTP has been sent to your email. Please enter it to continue.',
                                 input: 'text',
                                 confirmButtonText: 'Verify',
                                 showCancelButton: false,
                                 preConfirm: (input) => {
                                     return new Promise((resolve) => {
                                         if (input === '') {
                                             Swal.showValidationMessage('Please enter the OTP');
                                         } else {
                                             // Submit OTP for verification
                                             $.post('login', { otp: input }, function(response) {
                                                 if (response === 'success') {
                                                     Swal.fire('Invalid OTP!', 'Please try again.', 'error').then(() => {
                                                         window.location = 'login';
                                                     });
                                                 } else {
                                                     Swal.fire('Welcome back, {$row['UNAME']}!', '', 'success').then(() => {
                                                         window.location = 'index';
                                                     });
                                                 }
                                             });
                                         }
                                     });
                                 }
                             });
                         </script>";
                     } else {
                         echo "<script>
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Error',
                                 text: 'Failed to send OTP. Please try again later.'
                             });
                         </script>";
                     }
                     

} else {

     // OTP is valid, log the user in
  $_SESSION['ADMIN_ID'] = $row['USERID'];
  $_SESSION['ADMIN_UNAME'] = $row['UNAME'];
  $_SESSION['ADMIN_USERNAME'] = $row['USER_NAME'];
  $_SESSION['ADMIN_UPASS'] = $row['UPASS'];
  $_SESSION['ADMIN_UROLE'] = $row['ROLE'];

 $stmt = $connection->prepare("INSERT INTO sessions (user, device, location, ip_address) VALUES (?, ?, ?, ?)");
                     $stmt->bind_param("ssss", $user, $device, $location, $ip_address);
                     if ($stmt->execute()) {
                        echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: '',
                            text: 'Welcome back, {$row['UNAME']}!'
                        }).then(() => {
                            window.location.href = 'index';
                        });v
                      </script>";
                     } 
    


 
}






















   
        } else {
            $_SESSION['attempts'] = isset($_SESSION['attempts']) ? $_SESSION['attempts'] + 1 : 1;
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Username or Password Not Registered! Contact Your administrator.',
                }).then(() => {
                    window.location = 'login';
                });
            </script>";
        }
    }
}



?>
    <div class="container">
        <div class="right">
            <h2>LOGIN CREDENTIALS</h2>
            <form method="POST" action="login">
                <div class="input-group">
                    <input placeholder="Username" type="text" name="email" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input id="password" placeholder="Password" type="password" name="pass" minlength="8" maxlength="12" required>
                    <i class="far fa-eye" id="eyeIcon"></i>
                </div>
                 <!-- hCaptcha widget -->
                 <div class="h-captcha" data-sitekey="09b62f1c-dad4-40c4-8394-001ef4d0a126"></div> <!-- Replace with your hCaptcha Site Key -->
                 <div id="hCaptchaError" style="display: <?php echo $lockout_error ? 'block' : 'none'; ?>; color: red; font-size: 14px; text-align: center; margin-top: 10px;"></div>
                <button type="submit" name="btnlogin">Login</button>
               
                
                <div class="links-container">
                    <a href="../index" class="text-primary">Back to website</a>
                    <a href="<?php echo  "https://mcchmhotelreservation.com/admin/forgot_password"; ?>"  class="text-primary">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
    <script>
    const eyeIcon = document.getElementById('eyeIcon');
    const passwordInput = document.getElementById('password');

    eyeIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
    // Add form submission listener to validate hCaptcha completion
document.getElementById('loginForm').addEventListener('submit', function (event) {
    const hCaptchaResponse = grecaptcha.getResponse(); // Ensure you're using hCaptcha's method if this is for hCaptcha

    if (hCaptchaResponse.length == 0) {
        // Prevent form submission if hCaptcha is not completed
        event.preventDefault();

        // Display inline error message
        const hCaptchaError = document.getElementById('hCaptchaError');
        hCaptchaError.textContent = 'Please complete the hCaptcha to proceed.';
        hCaptchaError.style.display = 'block';
    }
});

    </script>
    
<script>
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector("form");
    const loginButton = document.querySelector("button[name='btnlogin']");
    const locationStatus = document.createElement("div");
    locationStatus.id = "location-status";
    locationStatus.style.marginBottom = "10px";
    loginButton.parentNode.insertBefore(locationStatus, loginButton);

    // Disable login button by default
    loginButton.disabled = true;

    // Variable to track location state
    let isLocationEnabled = false;

    // Function to request location and check if it's enabled
    function checkLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Location access granted
                    if (isLocationEnabled === false) {
                        locationStatus.textContent = "";  // Remove any existing messages
                        isLocationEnabled = true; // Mark location as enabled
                        loginButton.disabled = false; // Enable login button
                    }
                },
                (error) => {
                    // Handle location access errors
                    let message = "Unable to get location.";
                    if (error.code === error.PERMISSION_DENIED) {
                        message = "Location access denied. Please enable location to proceed.";
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        message = "Location information is unavailable.";
                    } else if (error.code === error.TIMEOUT) {
                        message = "The request to get location timed out.";
                    }

                    // Display error as text instead of SweetAlert
                    locationStatus.textContent = message;
                    locationStatus.style.color = "red";
                    isLocationEnabled = false; // Reset location state
                    loginButton.disabled = true; // Disable login button
                }
            );
        } else {
            // Geolocation not supported
            locationStatus.textContent = "Your browser does not support geolocation. Please use a compatible browser.";
            locationStatus.style.color = "red";
            isLocationEnabled = false;
            loginButton.disabled = true; // Disable login button
        }
    }

    // Function to continuously monitor location status
    function monitorLocation() {
        // Call checkLocation every 2 seconds to ensure location status is updated
        setInterval(checkLocation, 1000);
    }

    // Start monitoring the location
    monitorLocation();

    // Validate location on form submit
    loginForm.addEventListener("submit", function (event) {
        if (!isLocationEnabled) {
            // Prevent form submission if location is not enabled
            event.preventDefault();
            locationStatus.textContent = "You must enable location services to log in.";
            locationStatus.style.color = "red";
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const loginButton = document.querySelector("button[name='btnlogin']");
    const lockoutMessageDiv = document.getElementById("hCaptchaError");

    // Check if the user is locked out
    <?php if (isset($lockout_error) && $lockout_error) { ?>
        loginButton.disabled = true; // Disable login button
    <?php } else { ?>
        loginButton.disabled = false; // Enable login button
    <?php } ?>

    // Start countdown for lockout time if user is locked out
    let countdownTimer;
    if (<?php echo isset($remaining_time) ? $remaining_time : 0; ?> > 0) {
        let remainingTime = <?php echo $remaining_time; ?>;
        countdownTimer = setInterval(function() {
            remainingTime--;
            let minutes = Math.floor(remainingTime / 60);
            let seconds = remainingTime % 60;
            lockoutMessageDiv.innerHTML = `You have ${minutes}:${seconds < 10 ? '0' : ''}${seconds} minute(s) remaining.`;
            if (remainingTime <= 0) {
                clearInterval(countdownTimer);
                location.reload(); // Refresh the page after countdown ends
            }
        }, 1000);
    }
});
</script>


</body>
</html>