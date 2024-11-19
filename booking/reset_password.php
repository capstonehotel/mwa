<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</style>

<div class="container">
    <h2>Reset Your Password</h2>
    <form method="POST" action="reset_password.php">
        <label for="username">Enter your email:</label>
        <input type="text" name="username" required placeholder="example@gmail.com">
        
        <label for="new_password">Enter your new password:</label>
        <input type="password" name="new_password" required placeholder="New Password">
        
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        
        <button type="submit">Reset Password</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'hmsystemdb');
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $token = $conn->real_escape_string($_POST['token']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Validate the token and expiration
    $result = $conn->query("SELECT * FROM tblguest WHERE VERIFICATION_TOKEN = '$token' AND OTP_EXPIRE_AT >= NOW()");
    if ($result->num_rows === 0) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Invalid or Expired Token',
            text: 'The token is invalid or has expired.',
            confirmButtonText: 'OK'
        });
        </script>";
        exit;
    }

    // Update the password and clear the token
    $conn->query("UPDATE tblguest SET G_PASS = '$new_password', VERIFICATION_TOKEN = NULL, OTP_EXPIRE_AT = NULL WHERE VERIFICATION_TOKEN = '$token'");
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Password Reset Successfully',
        text: 'Your password has been reset successfully.',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'http://localhost/HM_HotelReservation/booking/index.php?view=logininfo'; // Redirect to login page or any other page
        }
    });
    </script>";
}
?>