<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 400px;
    }
    .container h2 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }
    .container p {
        margin: 10px 0 20px;
        color: #666;
    }
    .container label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #333;
        font-weight: bold;
    }
    .container input[type="password"],
    .container input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .container input[type="password"]:focus,
    .container input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }
    .container button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }
    .container button:hover {
        background-color: #0056b3;
    }
    .input-group {
    position: relative;
    width: 100%;
}

.input-group input {
    width: 100%;
    padding: 10px 40px 10px 10px; /* Space for the eye icon */
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

.input-group i {
    position: absolute;
    right: 10px;
    top: 30%;
    transform: translateY(-50%);
    color: #ccc;
    cursor: pointer;
}

#error-message {
            color: red;
            font-size: 14px;
            text-align: left;
            display: none; /* Initially hidden */
        }

  /* Hide OTP form initially */
#otp-form {
    display: block;
}

/* Hide password reset fields initially */
#password-reset-fields {
    display: none;
}

    /* Hide OTP form after verification */
    #otp-verified {
        display: none;
    }

    
</style>

<div class="container">
    <h2>Reset Your Password</h2>
     <!-- OTP input section -->
     <form id="otpForm" method="POST" action="verify_otp" id="otp-form">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required placeholder="Enter OTP" style="display: none;" id="password-reset-fields">
        <button type="submit">Verify OTP</button>
    </form>

    <form id="resetForm" method="POST" action="reset_password">
        <!-- <label for="username">Enter your email:</label>
        <input type="text" name="username" required placeholder="example@gmail.com"> -->
        
        <!-- <label for="new_password">Enter your new password:</label>
        <input type="password" name="new_password" required placeholder="New Password">
         -->
         <label for="new_password">Enter your new password:</label>
        <div class="input-group">
            <input type="password" id="new_password" name="new_password" minlength="8" maxlength="12" required placeholder="New Password">
            <i class="far fa-eye" id="new_password_toggle"></i>
        </div>
        <label for="confirm_password">Confirm your new password:</label>
        <div class="input-group">
            <input type="password" id="confirm_password" name="confirm_password" minlength="8" maxlength="12" required placeholder="Confirm Password">
            <i class="far fa-eye" id="confirm_password_toggle"></i>
        </div>
        <!--<div id="error-message" style="color: red; font-size: 14px; text-align: left; display: none;"></div>-->
        <div id="error-message"></div>
        <!--<div id="error-message" style="color: red; font-size: 14px; text-align: left; display: none;">Passwords do not match.</div>-->
        <!-- <?php if (!empty($error_message)): ?>
    <div id="error-message" style="color: red; font-size: 14px; text-align: left;"><?php echo $error_message; ?></div>
<?php endif; ?> -->


        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        
        <button type="submit">Reset Password</button>
    </form>
</div>

<?php
require_once '../initialize.php';
// Assuming that you will handle OTP verification in a separate action (verify_otp)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $token = $conn->real_escape_string($_POST['token']);
    $otp = $_POST['otp'];

    // Check OTP validity
    $result = $conn->query("SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = '$token' AND OTP = '$otp' AND OTP_EXPIRE_AT >= NOW()");
    if ($result->num_rows > 0) {
        // OTP verified successfully, show password reset form
        echo "<script>
        document.getElementById('otp-form').style.display = 'none';  // Hide OTP form
        document.getElementById('password-reset-fields').style.display = 'block';  // Show password reset form
    </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid or expired OTP.',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}

// Handle the password reset logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Validate the token and reset the password
        $result = $conn->query("SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = '$token' AND OTP_EXPIRE_AT >= NOW()");
        if ($result->num_rows === 0) {
            $error_message = "Invalid or expired token.";
        } else {
            // Update the password and clear the token and OTP
            $conn->query("UPDATE tblguest SET G_PASS = '$hashed_password', VERIFICATION_TOKEN = NULL, OTP = NULL, OTP_EXPIRE_AT = NULL WHERE VERIFICATION_TOKEN = '$token'");
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Password Reset Successfully',
                    text: 'Your password has been reset successfully.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'https://mcchmhotelreservation.com/booking/index.php?view=logininfo';
                    }
                });
            </script>";
        }
    }
}
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const newPasswordToggle = document.getElementById('new_password_toggle');
        const confirmPasswordToggle = document.getElementById('confirm_password_toggle');
        const errorMessage = document.getElementById('error-message');

        // Add event listeners for toggling visibility
        newPasswordToggle.addEventListener('click', () => {
            toggleVisibility(newPasswordInput, newPasswordToggle);
        });

        confirmPasswordToggle.addEventListener('click', () => {
            toggleVisibility(confirmPasswordInput, confirmPasswordToggle);
        });

        // Function to toggle password visibility
        function toggleVisibility(input, toggleIcon) {
            const isPassword = input.type === 'password';  // Check if it's a password field
            input.type = isPassword ? 'text' : 'password';  // Toggle between text and password

            // Toggle the icon class for eye visibility
            toggleIcon.classList.toggle('fa-eye');  // Show eye icon
            toggleIcon.classList.toggle('fa-eye-slash');  // Show eye-slash icon
        }

        document.getElementById('resetForm').addEventListener('submit', function (event) {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Clear previous error messages
            errorMessage.style.display = 'none'; // Hide previous error messages
            errorMessage.innerHTML = ''; // Reset content

            // Password requirements
            const errors = [];
            if (newPassword.length < 8 || newPassword.length > 12) {
                errors.push('Password must be between 8 and 12 characters.');
            }
            if (!/[a-z]/.test(newPassword)) {
                errors.push('Password must include at least one lowercase letter.');
            }
            if (!/[A-Z]/.test(newPassword)) {
                errors.push('Password must include at least one uppercase letter.');
            }
            if (!/\d/.test(newPassword)) {
                errors.push('Password must include at least one number.');
            }
            if (!/[@$!%*?&#]/.test(newPassword)) {
                errors.push('Password must include at least one special character.');
            }
            if (newPassword !== confirmPassword) {
                errors.push('Passwords do not match.');
            }

            // If there are any errors, prevent the form from submitting and show errors
            if (errors.length > 0) {
                event.preventDefault(); // Prevent form submission
                errorMessage.style.display = 'block'; // Display the error container
                errorMessage.innerHTML = errors.join('<br>'); // Show all error messages
            }
        });
    });
</script>