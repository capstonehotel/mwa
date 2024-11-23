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
        .container p a {
            color: #007bff;
            text-decoration: none;
        }
        .container p a:hover {
            text-decoration: underline;
        }
        .container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .container input[type="email"]:focus {
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
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
            color: #666;
        }
        .footer a {
            color: #666;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .footer i {
            margin-right: 5px;
        }
    </style>

    <div class="container">
        <h2>Forgot password?</h2><br>
        <form method="POST" action="forgot_password.php">
            <label for="username">Enter your email:</label>
            <input type="email" id="username" name="username" required placeholder="example@gmail.com" aria-required="true" aria-describedby="emailHelp">
            <button type="submit">Send</button>
        </form>
        <div class="footer">
        <p>Remember your password? <a href="https://mcchmhotelreservation.com/booking/index.php?view=logininfo">Login here</a></p>
        </div>
    </div>


<?php
require_once("../includes/initialize.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);

    // Check if the user exists
    $result = $conn->query("SELECT * FROM tblguest WHERE G_UNAME = '$username'");
    if ($result->num_rows === 0) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Account Not Found',
            text: 'No account found with that email.',
            confirmButtonText: 'OK'
        });
    </script>";
    exit;
}

    // Generate a unique reset token and expiration time
    $token = bin2hex(random_bytes(50));
    $expires = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    // Store the token in the database
    $conn->query("UPDATE tblguest SET VERIFICATION_TOKEN = '$token', OTP_EXPIRE_AT = '$expires' WHERE G_UNAME = '$username'");

    // Get user's email for sending reset link
    $user = $result->fetch_assoc();
    $email = $user['G_UNAME'];

    // Send the reset email with PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mcchmhotelreservation@gmail.com';
        $mail->Password   = 'bkdb giql jcxw mmcc';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link below to reset your password:<br><br>
                          <a href='http://localhost/HM_HotelReservation/booking/reset_password.php?token=$token'>Reset Password</a><br><br>
                          If you did not request a password reset, please ignore this email.";

        $mail->send();
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Email Sent',
            text: 'Please check your email for changing your password.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'http://localhost/HM_HotelReservation/booking/index.php?view=logininfo'; // Redirect to login page or any other page
            }
        });
    </script>";
    } catch (Exception $e) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Email Not Sent',
            text: 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}',
            confirmButtonText: 'OK'
        });
    </script>";

    }
}
?>
