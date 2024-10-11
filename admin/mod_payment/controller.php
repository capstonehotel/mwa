<?php 
require_once("../../includes/initialize.php");
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
		$paidDate = date('Y-m-d H:i:s'); // Get the current date and time
			$sql = "UPDATE tblpayment SET STATUS = 'Confirmed', PAYMENT_STATUS = 'Fully Paid', PAID_DATE = '$paidDate' WHERE CONFIRMATIONCODE ='$code'";
			if ($connection->query($sql) === TRUE) {
				header('Location: index.php');
				exit;
			} else {
				header('Location: index.php?error=confirm');
				exit;
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
