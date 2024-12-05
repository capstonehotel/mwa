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
        .container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .container input:focus {
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
        .button-row {
    display: flex;
    justify-content: space-between; /* Space out buttons */
    align-items: center; /* Align buttons vertically */
    margin: 20px 0; /* Add spacing around the buttons */
}

.option-button {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #fd2323; /* Button color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    white-space: nowrap; /* Prevent text from wrapping */
}

.option-button:hover {
    background-color: #45a049; /* Change color on hover */
    transform: translateY(-2px);
}

.option-button:active {
    transform: translateY(0);
}

.button-row button {
    margin: 0 10px; /* Add horizontal spacing between buttons */
}


    </style>

    <div class="container">
        <h2>Forgot password?</h2><br>
        <!-- <form method="POST" action="forgot_password.php">
            <label for="username">Enter your email:</label>
            <input type="email" id="username" name="username" required placeholder="example@gmail.com" aria-required="true" aria-describedby="emailHelp">
            <button type="submit">Send</button>
        </form> -->
        <div class="button-row" id="buttonContainer">
            <button id="sendGmailButton" class="option-button">Send via Gmail</button>
            <button id="sendNumberButton" class="option-button">Send via Number</button>
        </div>
        <form id="gmailForm" method="POST" action="forgot_password.php" style="display: none;">
            <label for="username">Enter your email:</label>
            <input type="email" id="username" name="username" required placeholder="example@gmail.com" aria-required="true">
            <button type="submit" name="submit_email">Send</button>
        </form>
        <form id="numberForm" method="POST" action="forgot_password.php" style="display: none;">
            <label for="phonenumber">Enter your phone number:</label>
            <input type="text" id="phonenumber" name="phonenumber" required placeholder="09XXXXXXXXX" aria-required="true" pattern="09[0-9]{9}">
            <button type="submit" name="submit_phone">Send</button>
        </form>
        <div class="footer">
        <p>Remember your password? <a href="https://mcchmhotelreservation.com/booking/index.php?view=logininfo">Login here</a></p>
        </div>
    </div>

    <script>
        const buttonContainer = document.getElementById('buttonContainer');
        const sendGmailButton = document.getElementById('sendGmailButton');
        const sendNumberButton = document.getElementById('sendNumberButton');
        const gmailForm = document.getElementById('gmailForm');
        const numberForm = document.getElementById('numberForm');

        sendGmailButton.addEventListener('click', function () {
            buttonContainer.style.display = 'none';
            gmailForm.style.display = 'block';
        });

        sendNumberButton.addEventListener('click', function () {
            buttonContainer.style.display = 'none';
            numberForm.style.display = 'block';
        });
    </script>
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
                          <a href='https://mcchmhotelreservation.com/booking/reset_password.php?token=$token'>Reset Password</a><br><br>
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
                window.location.href = 'https://mcchmhotelreservation.com/booking/index.php?view=logininfo'; // Redirect to login page or any other page
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
<?php
class SMSGateway {
    private $apiUrl;
    private $apiKey;


    public function __construct() {
        $this->apiUrl = 'https://69nv3z.api.infobip.com/sms/2/text/advanced';
        $this->apiKey = '987224f704dd65a242869526dd497514-f72703e6-670e-41ba-bd92-15dd09a948af';
    }

    public function sendSMS($phone, $message) {
        try {
            $data = [
                "messages" => [
                    [
                        "destinations" => [
                            ["to" => $phone]
                        ],
                        "text" => $message
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Authorization: App ' . $this->apiKey,
                    'Content-Type: application/json'
                ]
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                error_log('Infobip SMS Error: ' . curl_error($ch));
                return false;
            }

            curl_close($ch);

            $result = json_decode($response, true);
            if (isset($result['messages'][0]['status']['groupName']) &&
                $result['messages'][0]['status']['groupName'] === "PENDING") {
                return true;
            }

            error_log('Infobip SMS Error: ' . $response);
            return false;
        } catch (Exception $e) {
            error_log('Infobip SMS Exception: ' . $e->getMessage());
            return false;
        }
    }
}

function sendSMS($phone, $message) {
    $smsGateway = new SMSGateway();

    // Ensure correct format: +63XXXXXXXXX
    if (substr($phone, 0, 1) === '0') {
        $phone = '+63' . substr($phone, 1);
    }

    return $smsGateway->sendSMS($phone, $message);
}





// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to standardize phone number format for comparison
function standardizePhoneNumber($phone) {
    // Remove any non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // If it starts with 63, remove it
    if (substr($phone, 0, 2) === '63') {
        $phone = '0' . substr($phone, 2);
    }
    
    return $phone;
}

// Function to format phone for SMS sending
function formatPhoneForSMS($phone) {
    // Remove any non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // If it starts with 0, replace with +63
    if (substr($phone, 0, 1) === '0') {
        return '+63' . substr($phone, 1);
    }
    
    // If it starts with 63, add +
    if (substr($phone, 0, 2) === '63') {
        return '+' . $phone;
    }
    
    // If no prefix, assume it needs 63
    return '+63' . $phone;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $phone = $_POST['phone'];
        
        // Standardize phone number for database lookup
        $standardizedPhone = standardizePhoneNumber($phone);
        
        // Debug log
        error_log("Looking up standardized phone: " . $standardizedPhone);
        
        // Check if phone exists in database
        $stmt = $conn->prepare("SELECT * FROM tblguest WHERE G_PHONE = ?");
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }
        
        $stmt->bind_param("s", $standardizedPhone);
        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Generate OTP
            $otp = sprintf("%06d", mt_rand(0, 999999));
            $_SESSION['reset_phone'] = $standardizedPhone;
            $_SESSION['OTP_TIMESTAMP'] = time();
            
            // Update OTP in database
            $update_stmt = $conn->prepare("UPDATE tblguest SET OTP = ?, OTP_EXPIRY_AT = CURRENT_TIMESTAMP WHERE G_PHONE = ?");
            if (!$update_stmt) {
                throw new Exception("Database prepare error: " . $conn->error);
            }
            
            $update_stmt->bind_param("ss", $otp, $standardizedPhone);
            
            if (!$update_stmt->execute()) {
                throw new Exception("Failed to update OTP: " . $update_stmt->error);
            }
            
            // Format phone number for SMS sending
            $smsPhone = formatPhoneForSMS($standardizedPhone);
            
            // Send OTP via SMS
            $message = "Your OTP for password reset is: " . $otp;
            
            // Log before sending SMS
            error_log("Attempting to send SMS to: " . $smsPhone);
            error_log("Message content: " . $message);
            
            if (!sendSMS($smsPhone, $message)) {
                throw new Exception("Failed to send SMS. Please try again later.");
            }
            
            // If we got here, everything worked
            $_SESSION['success_message'] = "OTP sent successfully! Please check your phone.";
            header("Location:send_otp.php");
            exit();
            
        } else {
            throw new Exception("Phone number not found in our records");
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        error_log("Forgot Password Error: " . $error);
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($update_stmt)) $update_stmt->close();
    }
}

?>

