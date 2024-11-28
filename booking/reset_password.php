<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

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
    .password-field {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.password-field input {
    width: 100%;
    padding-right: 40px; /* Space for the icon */
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}

</style>

<div class="container">
    <h2>Reset Your Password</h2>
    <form id="resetForm" method="POST" action="reset_password.php">
        <!-- <label for="username">Enter your email:</label>
        <input type="text" name="username" required placeholder="example@gmail.com"> -->
        
        <!-- <label for="new_password">Enter your new password:</label>
        <input type="password" name="new_password" required placeholder="New Password">
         -->

         <label for="new_password">Enter your new password:</label>
        <input type="password" id="new_password" name="new_password" required placeholder="New Password">
        <span class="toggle-password" onclick="togglePasswordVisibility('new_password')">
        <span class="material-icons-outlined">visibility</span>
    </span>
        
        <label for="confirm_password">Confirm your new password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
        <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
        <span class="material-icons-outlined">visibility</span>
    </span>
        <!--<div id="error-message" style="color: red; font-size: 14px; text-align: left; display: none;">Passwords do not match.</div>-->
        <?php if (!empty($error_message)): ?>
    <div id="error-message" style="color: red; font-size: 14px; text-align: left;"><?php echo $error_message; ?></div>
<?php endif; ?>

        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        
        <button type="submit">Reset Password</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $token = $conn->real_escape_string($_POST['token']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Validate the token and expiration
        $result = $conn->query("SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = '$token' AND OTP_EXPIRE_AT >= NOW()");
        if ($result->num_rows === 0) {
            $error_message = "Invalid or expired token.";
        } else {
            // Update the password and clear the token
            $conn->query("UPDATE tblguest SET G_PASS = '$hashed_password', VERIFICATION_TOKEN = NULL, OTP_EXPIRE_AT = NULL WHERE VERIFICATION_TOKEN = '$token'");
            header('Location: http://localhost/HM_HotelReservation/booking/index.php?view=logininfo');
            exit;
        }
    }

    // Update the password and clear the token
    $conn->query("UPDATE tblguest SET G_PASS = '$hashed_password', VERIFICATION_TOKEN = NULL, OTP_EXPIRE_AT = NULL WHERE VERIFICATION_TOKEN = '$token'");
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
?>
<script>
    document.getElementById('resetForm').addEventListener('submit', function (event) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMessage = document.getElementById('error-message');

        if (newPassword !== confirmPassword) {
            event.preventDefault();
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Passwords do not match.';
        } else {
            errorMessage.style.display = 'none';
        }
    });
</script>
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('.material-icons-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>

