<?php
 //$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");
echo '<script src="../sweetalert2.all.min.js"></script>';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$code = $_GET['code'];

switch ($action) {
    

    case 'cancel':
        $sql = "UPDATE tblpayment SET STATUS = 'Cancelled', PAYMENT_STATUS = 'Cancelled' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql) === TRUE) {
            header('Location: index.php');
            exit;
        } else {
            header('Location: index.php?error=cancel');
            exit;
        }
        break;
        case 'confirm':
            // Retrieve the current amount paid and the previous balance
            $query = "SELECT AMOUNT_PAID FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";
            $result = $connection->query($query);
        
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $currentAmountPaid = $row['AMOUNT_PAID'];
                $currentBalance =  $row['AMOUNT_PAID'];
        
                // Add the current payment amount to the existing amount paid
                $newAmountPaid = $currentAmountPaid + $currentBalance;
        
                // Update the AMOUNT_PAID and set PAYMENT_STATUS to 'Fully Paid' in tblpayment
                $paidDate = date('Y-m-d H:i:s'); // Get the current date and time
                $updatePaymentSql = "UPDATE tblpayment 
                                     SET AMOUNT_PAID = '$newAmountPaid', 
                                         PAYMENT_STATUS = 'Fully Paid', 
                                         PAID_DATE = '$paidDate' 
                                     WHERE CONFIRMATIONCODE = '$code'";
        
                if ($connection->query($updatePaymentSql) === TRUE) {
                    // Update the PAYMENT_STATUS in tblreservation
                    $updateReservationSql = "UPDATE tblreservation 
                                             SET PAYMENT_STATUS = 'Fully Paid' 
                                             WHERE CONFIRMATIONCODE = '$code'";
        
                    if ($connection->query($updateReservationSql) === TRUE) {
                        header('Location: index.php');
                        exit;
                    } else {
                        header('Location: index.php?error=updateReservation');
                        exit;
                    }
                } else {
                    header('Location: index.php?error=confirm');
                    exit;
                }
            } else {
                // Handle the case where no record is found
                echo "Error: Payment record not found.";
            }
            break;
        
    case 'pay_balance':
        if (isset($_POST['payment_amount'])) {
            $paymentAmount = $_POST['payment_amount'];

            // Fetch current balance
            $query = "SELECT `BALANCE` FROM `tblpayment` WHERE `CONFIRMATIONCODE` = '$code'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $currentBalance = $row['BALANCE'];

            // Calculate new balance
            $newBalance = $currentBalance - $paymentAmount;

            // Determine new payment status
            if ($newBalance <= 0) {
                $paymentStatus = 'Fully Paid';
                $newBalance = 0;  // Set balance to 0 if fully paid
            } else {
                $paymentStatus = 'Partial';
            }

            // Update payment and balance in the database
            $updateQuery = "UPDATE `tblpayment` 
                            SET `BALANCE` = '$newBalance', `PAYMENT_STATUS` = '$paymentStatus' 
                            WHERE `CONFIRMATIONCODE` = '$code'";
            mysqli_query($connection, $updateQuery);

            // Redirect or show confirmation
            header('Location: payment_confirmation.php?code=' . $code);
            exit;
        }
        break;

    case 'unpaid':
        $sql = "UPDATE tblpayment SET PAYMENT_STATUS = 'Unpaid' WHERE CONFIRMATIONCODE ='$code'";

        if ($connection->query($sql) === TRUE) {
            header('Location: index.php');
            exit;
        } else {
            header('Location: index.php?error=unpaid');
            exit;
        }
        break;
}
?>
