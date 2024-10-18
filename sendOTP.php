<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendOTP($email,$name, $lastname) {
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp_email'] = $email;
    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';       
        $mail->SMTPAuth = true;
        $mail->Username = 'mcchmhotelreservation@gmail.com';  
        $mail->Password = 'bkdb giql jcxw mmcc'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('mcchmhotelreservation@gmail.com', 'Hotel Reservation');
        $mail->addAddress($email); 

        // Content
        $mail->isHTML(true);                                
        $mail->Subject = 'Your OTP for Hotel Reservation';
        $mail->Body    = "Hello, $name $lastname <br><br>Your OTP is: <b>{$otp}</b><br><br>Please enter this OTP to proceed.";

        $mail->send();
        return $otp;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";  
        return null;
    }
}
?>