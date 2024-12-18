<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendOTPEmail($toEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to use
        $mail->SMTPAuth = true;
        $mail->Username = 'mcchmhotelreservation@gmail.com'; // SMTP username
        $mail->Password = 'bkdb giql jcxw mmcc'; // SMTP password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
        $mail->addAddress($toEmail); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Hello, <br><br>Your OTP code is: <b>$otp</b>.<br><br>This code will expire in 5 minutes.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
<?php
require_once("../includes/initialize.php");

if (isset($_POST['btnVerify'])) {
    $inputOTP = sanitize_input($_POST['otp']);

    if ($inputOTP == $_SESSION['OTP']) {
        // OTP is correct, proceed with login
        unset($_SESSION['OTP']); // Clear OTP from session
        header("Location: index");
        exit();
    } else {
        echo "<script>Swal.fire({icon: 'error', title: 'Invalid OTP', text: 'The OTP you entered is incorrect.'});</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="wave.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <title>Verify OTP</title>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form method="POST" action="verifyOTP.php">
            <div class="input-group">
                <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" name="btnVerify">Verify</button>
        </form>
    </div>
</body>
</html>