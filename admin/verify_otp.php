<?php
require_once '../includes/initialize.php';
// OTP verification logic in a separate file (verify_otp.php)
  if (isset($_POST['otp'])) {
      session_start();
      $entered_otp = $_POST['otp'];
      if (isset($_SESSION['OTP']) && $entered_otp == $_SESSION['OTP'] && time() < $_SESSION['OTP_EXPIRY']) {
          echo 'success';
      } else {
          echo 'fail';
      }
      exit;
  }
  ?>