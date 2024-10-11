<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> -->

<?php
require_once 'sendOTP.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['submit'])) {
      // Verify OTP
      if(isset($_POST['otp'])) {
          if(isset($_SESSION['otp']) && $_POST['otp'] == $_SESSION['otp']) {
              // OTP is correct, proceed with form processing

              // Handle image upload
              $targetDirectory = "../images/user_avatar/";  // Directory where uploaded images will be stored
              $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
              $fileName = basename($_FILES["image"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

              if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                  echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.<br>";
              } else {
                  echo "Sorry, there was an error uploading your file.<br>";
              }

              // Server-side DOB validation
              $dob = $_POST['dbirth'];
              $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
              $today = new DateTime();
              $ageInterval = $today->diff($dobDate);
              $age = $ageInterval->y;

              if ($age < 18) {
                  $_SESSION['ERRMSG_ARR'][] = 'You must be at least 18 years old.';
              } else {
                  // Proceed with form processing if age is valid
                  $arrival = $_SESSION['from']; 
                  $departure = $_SESSION['to'];
                  $ROOMID = $_SESSION['ROOMID'];

                  $_SESSION['image'] = $fileName;
                  $_SESSION['name'] = $_POST['name'];
                  $_SESSION['last'] = $_POST['last'];
                  $_SESSION['gender'] = $_POST['gender'];
                  $_SESSION['dbirth'] = $_POST['dbirth'];
                  $_SESSION['zip'] = $_POST['zip'];
                  $_SESSION['nationality'] = $_POST['nationality'];
                  $_SESSION['city'] = $_POST['city'];
                  $_SESSION['address'] = $_POST['address'];
                  $_SESSION['company'] = $_POST['company'];
                  $_SESSION['caddress'] = $_POST['caddress'];
                  $_SESSION['phone'] = $_POST['phone'];
                  $_SESSION['username'] = $_POST['username'];
                  $_SESSION['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Always hash passwords
                  $_SESSION['pending'] = 'pending';
                  
                  // Optionally, unset the OTP after successful verification
                  unset($_SESSION['otp']);

                  // Redirect to the next page (e.g., payment page)
                  header('Location: index.php?view=payment');
                  exit();
              }
          } else {
              $_SESSION['ERRMSG_ARR'][] = 'Invalid OTP. Please try again.';
          }
      } else {
          $_SESSION['ERRMSG_ARR'][] = 'Please enter the OTP.';
      }
  }
}
?>

<?php
// session_start(); // Start the session at the beginning

// Check if the form was submitted and OTP was entered
if (isset($_POST['submit']) && isset($_POST['otp'])) {
    
    // Check if OTP session key exists
    if (isset($_SESSION['otp'])) {
        
        // Verify OTP
        if ($_POST['otp'] == $_SESSION['otp']) {
            // OTP verified, proceed with registration or other actions
            echo "OTP verified for user: " . $_SESSION['username'];
            
            // Redirect to the next page (e.g., payment page)
            header('Location: index.php?view=payment');
            exit();
        } else {
            echo "Invalid OTP. Please try again.";
        }
        
    } else {
        echo "OTP session expired. Please request a new OTP.";
    }
} else {
    echo "Please enter the OTP.";
}
?> 

<?php
        // // Redirect to OTP verification page
        // header('Location: otp_verify.php');
//         // exit();
//     }
// }
// //         // Redirect to payment page
//         header('Location: index.php?view=payment');
//         exit();
//     }
// }
?>


 
                 <?php //include'navigator.php';?>


			 
					<?php
					if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
							echo '<ul class="err">';
							foreach($_SESSION['ERRMSG_ARR'] as $msg) {
								echo '<li>',$msg,'</li>'; 
							}
							echo '</ul>';
							unset($_SESSION['ERRMSG_ARR']);
						}
					?>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   
         		<form class="form-horizontal" action="index.php?view=logininfo" method="post"  name="personal" enctype="multipart/form-data" onsubmit="return false;">
					 <h2>Personal Details</h2> 

					 <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class ="control-label" for="image">Avatar</label>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)" required>
        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 150px; max-height: 150px;">
      </div>
			<style>
  /* Ensure the image preview is fixed at 300x300 pixels (2x2) */
  #imagePreview {
    display: none;
    width: 150px;
    height: 150px;
    object-fit: cover; /* Ensures the image fits inside the preview box */
    border: 2px solid #ddd;
    margin-top: 10px;
  }
</style>

<script>
  function previewImage(event) {
    const input = event.target;
    const imagePreview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
      const reader = new FileReader();

      reader.onload = function (e) {
        imagePreview.style.display = 'block';
        imagePreview.src = e.target.result;
      };

      reader.readAsDataURL(input.files[0]);
    } else {
      imagePreview.style.display = 'none';
      imagePreview.src = '#';
    }
  }
</script>
									
			            </div>
			          </div> 
<br>
					 <!-- Form Fields in Two Columns -->
  <div class="row">
    <!-- First Column -->
    <div class="col-md-6 col-sm-12">
      <div class="form-group">
        <label class ="control-label" for="name">First Name:</label>
        <input name="name" type="text" class="form-control input-sm" id="name" maxlength="16" onkeyup="capitalizeInput(this)" required>
      </div>

      <div class="form-group">
        <label class ="control-label" for="last">Last Name:</label>
        <input name="last" type="text" class="form-control input-sm" id="last" maxlength="16" onkeyup="capitalizeInput(this)" required>
      </div>

      <div class="form-group">
        <label class ="control-label" for="gender">Gender:</label>
        <select name="gender" class="form-control input-sm" id="gender" required>
          <option value="" disabled selected>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <div class="form-group">
    <label class ="control-label" for="dbirth">Date of Birth:</label>
    <input type="date" name="dbirth" class="form-control input-sm" 
           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" 
           onchange="validateDOB(this)" required>
    <span id="dob-error" style="color: red;"></span>
</div>

      <div class="form-group">
        <label class ="control-label" for="phone">Phone:</label>
        <input name="phone" type="tel" class="form-control input-sm" pattern="09\d{9}" id="phone" value="09" required oninput="this.value = this.value.replace(/\D/, ''); if(this.value.length > 11) this.value = this.value.slice(0, 11);">
      </div>
    <!-- </div> -->

    <!-- Second Column -->
    
      <div class="form-group">
        <label class ="control-label" for="city">City:</label>
        <input name="city" type="text" class="form-control input-sm" id="city" onkeyup="capitalizeInput(this)">
      </div>

      
      <div class="form-group">
        <label class ="control-label" for="address">Address:</label>
        <input name="address" type="text" class="form-control input-sm" id="address" maxlength="50" onkeyup="capitalizeInput(this)">
      </div>
	  </div>
	  <!-- Second Column -->
	  <div class="col-md-6 col-sm-12">
      
      <div class="form-group">
        <label class ="control-label" for="zip">Zip Code:</label>
        <input name="zip" type="number" class="form-control input-sm" id="zip" maxlength="4" required oninput="this.value = this.value.replace(/\D/, ''); if(this.value.length > 10) this.value = this.value.slice(0, 10);">
      </div>
	  
      <div class="form-group">
        <label class ="control-label" for="nationality">Nationality:</label>
        <input name="nationality" type="text" class="form-control input-sm" id="nationality" maxlength="17" onkeyup="capitalizeInput(this)">
      </div>

      <div class="form-group">
        <label class ="control-label" for="company">Company:</label>
        <input name="company" type="text" class="form-control input-sm" id="company" required onkeyup="capitalizeInput(this)">
      </div>

      <div class="form-group">
        <label class ="control-label" for="caddress">Company Address:</label>
        <input name="caddress" type="text" class="form-control input-sm" id="caddress" required onkeyup="capitalizeInput(this)">
      </div>

      <div class="form-group">
    <label class="control-label" for="username">Email:</label>
    <div class="input-group">
        <input 
            name="username" 
            type="email" 
            class="form-control input-sm" 
            id="username" 
            required 
            placeholder="User@gmail.com">
        <div class="input-group-append">
            <button 
                type="button" 
                class="btn btn-secondary" 
                id="sendOtpButton">Send OTP</button>
        </div>
    </div>
    <small id="emailHelp" class="form-text text-muted">
        Click "Send OTP" to receive a verification code.
    </small>
</div>
      <div class="form-group">
    <label  class ="control-label" for="password">Password:</label>
    <input name="pass" type="password" class="form-control input-sm" id="password"  required onkeyup="validatePassword()" placeholder="Ex@mple123">
    <span id="password-error" style="color: red;"></span>
</div>

      <!-- OTP input after email submission -->
      <div class="form-group" id="otp-section" style="display: none;">
    <label for="otp">Enter OTP:</label>
    <input 
        type="text" 
        name="otp" 
        class="form-control input-sm" 
        id="otp" 
        maxlength="6" 
        required>
    <small id="otpHelp" class="form-text text-muted">
        Please enter the 6-digit OTP sent to your email.
    </small>
</div>

<p id="email-msg" style="color: green; display: none;">
    An OTP has been sent to your email. Please check your inbox.
</p>

    </div>
  </div>
 

    

    <p id="email-msg" style="color: green; display: none;">An OTP has been sent to your email. Please check your inbox.</p>



					 &nbsp; &nbsp;
				 <div class="form-group">
			        <div class="col-md-6">
					<p>
				I <input type="checkbox" name="condition" value="checkbox" />
					 <small>Agree the <a class="toggle-modal"  onclick="OpenPopupCenter('terms_condition.php','Terms And Codition','600','600')" ><b>TERMS AND CONDITION</b></a> of this Hotel</small>
			
					 <br />
						<!-- <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><a href='javascript: refreshCaptcha();'><img src="<?php echo WEB_ROOT;?>images/refresh.png" alt="refresh" border="0" style="margin-top:5px; margin-left:5px;" /></a>
						<br /><small>If you are a Human Enter the code above here :</small><input id="6_letters_code" name="6_letters_code" type="text" class="form-control input-sm" width="20"></p><br/>
					 -->	<div class="col-md-4">
    <input name="submit" type="submit" value="Confirm" id="confirmButton" class="btn btn-primary" onclick="return personalInfo();" />
</div>
					</div>
					NOTE: 
					We recommend that your password should be at least 8 characters long and should be different from your username.
					Your e-mail address must be valid. We use e-mail for communication purposes (order notifications, etc). Therefore, it is essential to provide a valid e-mail address to be able to use our services correctly.
					All your private data is confidential. We will never sell, exchange or market it in any way. For further information on the responsibilities of both parties, you may refer to us.
			    </div>

			</form>   


<script type="text/javascript">
function capitalizeInput(input) {
    var inputValue = input.value;
    input.value = inputValue.charAt(0).toUpperCase() + inputValue.slice(1);
}
</script>
<script>
function validateDOB(input) {
    const selectedDate = new Date(input.value);
    const todayMinus18 = new Date();
    todayMinus18.setFullYear(todayMinus18.getFullYear() - 18);

    const dobError = document.getElementById('dob-error');
    if (selectedDate > todayMinus18) {
        dobError.textContent = "You must be at least 18 years old.";
        input.setCustomValidity("You must be at least 18 years old.");
    } else {
        dobError.textContent = "";
        input.setCustomValidity("");
    }
}
</script>


<script>
function validatePassword() {
    var passwordInput = document.getElementById("password");
    var password = passwordInput.value;
    var passwordError = document.getElementById("password-error");
    
    var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
    var hasNumber = /\d/.test(password);
    var hasCapital = /[A-Z]/.test(password);
    
    if (password.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters long.";
        passwordInput.setCustomValidity("Password must be at least 8 characters long.");
        return false; // Prevent form submission
    } else if (!hasCapital) {
        passwordError.textContent = "Password must contain at least one capital letter.";
        passwordInput.setCustomValidity("Password must contain at least one capital letter.");
        return false; // Prevent form submission
    } else if (!hasSpecialChar) {
        passwordError.textContent = "Password must contain at least one special character.";
        passwordInput.setCustomValidity("Password must contain at least one special character.");
        return false; // Prevent form submission
    } else if (!hasNumber) {
        passwordError.textContent = "Password must contain at least one number.";
        passwordInput.setCustomValidity("Password must contain at least one number.");
        return false; // Prevent form submission
    } else {
        passwordError.textContent = ""; // Clear error message
        passwordInput.setCustomValidity(""); // Clear custom validity
        return true; // Password is valid
    }
}

document.querySelector('form').onsubmit = function () {
    return validatePassword(); // Validate password before form submission
};
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#sendOtpButton').click(function(){
        // Collect necessary data
        var name = $('#name').val().trim();
        var last = $('#last').val().trim();
        var email = $('#username').val().trim();

        // Basic validation
        if(name === '' || last === '' || email === ''){
            alert('Please fill in your First Name, Last Name, and Email before requesting an OTP.');
            return;
        }

        // Simple email format validation
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailPattern.test(email)){
            alert('Please enter a valid email address.');
            return;
        }

        // Disable the button to prevent multiple clicks
        $('#sendOtpButton').prop('disabled', true).text('Sending...');

        // Send AJAX request to sendOTP.php
        $.ajax({
            url: 'sendOTP.php',
            type: 'POST',
            data: {
                name: name,
                last: last,
                username: email
            },
            success: function(response){
                // Parse JSON response
                try {
                    var res = JSON.parse(response);
                    if(res.status === 'success'){
                        alert(res.message);
                        // Show OTP section
                        $('#otp-section').show();
                        $('#email-msg').show();
                    } else {
                        alert(res.message);
                    }
                } catch(e){
                    alert('An unexpected error occurred.');
                }
            },
            error: function(){
                alert('Failed to send OTP. Please try again.');
            },
            complete: function(){
                // Re-enable the button
                $('#sendOtpButton').prop('disabled', false).text('Send OTP');
            }
        });
    });
});
</script>

