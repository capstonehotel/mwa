<?php
require_once("../../includes/initialize.php");


$query = "SELECT g.`G_FNAME`, g.`G_LNAME`, g.`G_UNAME`, r.`ROOMID`, r.`ARRIVAL`, r.`DEPARTURE`, r.`PRORPOSE`, p.`PQTY`, p.`SPRICE`, p.`STATUS`
          FROM `tblpayment` p
          JOIN `tblguest` g ON p.`GUESTID` = g.`GUESTID`
          JOIN `tblreservation` r ON r.`RESERVEID` = p.`SUMMARYID`
          WHERE p.`STATUS` = 'Checkedout'
          ORDER BY p.`TRANSDATE` DESC";

$result = mysqli_query($connection, $query);   
$number = 0;
$rooms = [];
$total_amount = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $number++;
    $checkin_date = $row['ARRIVAL']; // Fetch from database
    $checkout_date = $row['DEPARTURE']; // Fetch from database
    $guest_name = $_POST['guest_name'];
    // $guest_name = $row['G_FNAME'] . ' ' . $row['G_LNAME'];
    $total_rooms = $row['PQTY'];
    
    // Sample room details (fetch dynamically)
    $rooms[] = ['name' => 'Room ' . $row['ROOMID'], 'nights' => 5, 'total' => $row['SPRICE']];
    
    // Calculate total amount based on room details
    $total_amount += $row['SPRICE'];
}
?>

<?php
// Sample data (fetch from POST request)
$logo = '../../logo2.jpg';
$logo2 = '../../MCClogo.png';
$hotel_name = 'Hospitality Management Hotel';
$contact_details = 'Contact Details Here';
date_default_timezone_set('Asia/Manila'); // Set the time zone to Manila, Philippines
$receipt_date = date('Y-m-d'); // Generate the receipt date and time
$admin_name = 'Admin Name';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt-container {
            width: 80%;
            margin: 0 auto;
            padding: 10px;
            /* border: 1px solid #000; */
        }
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .receipt-header .logo,
        .receipt-header .logo2 {
            height: 80px;
        }
        .receipt-header h1 {
            margin-left: 60px ;
        }
        .contact-details {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .booking-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .booking-details .left, .booking-details .right {
            width: 45%;
        }
        .room-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .room-details table, .room-details th, .room-details td {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
        }
        .total-amount {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .receipt-footer {
            text-align: right;
            font-size: 1em;
            font-weight: bold;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="receipt-container">
    <header class="receipt-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <img src="<?php echo $logo;?>" alt="Hotel Logo" class="logo">
        <div style="text-align: center;">
            <h1><?php echo $hotel_name;?></h1>
            <p><?php echo $contact_details;?></p>
        </div>
        <img src="<?php echo $logo2;?>" alt="Hotel Logo 2" class="logo2" >
    </div>
</header>
        <section class="booking-details">
            <div class="left">
                <p>Paid By</p>
                <p>Guest Name: <?php echo $guest_name; ?></p>
                <p>Check-in Date: <?php echo $checkin_date; ?></p>
                <p>Check-out Date: <?php echo $checkout_date; ?></p>
            </div>
            <div class="right">
                <p>Receipt Date: <?php echo $receipt_date; ?></p>
            </div>
        </section>
        <section class="room-details">
            <table>
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Number of Nights</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room) { ?>
                    <tr>
                        <td><?php echo $room['name']; ?></td>
                        <td><?php echo $room['nights']; ?></td>
                        <td><?php echo $room['total']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="total-amount">
            <p>Total Amount: ₱<?php echo $total_amount; ?></p>
        </section>
        <footer class="receipt-footer">
            <p>Admin Name: <?php echo $admin_name; ?></p>
        </footer>
    </div>
</body>
</html>

