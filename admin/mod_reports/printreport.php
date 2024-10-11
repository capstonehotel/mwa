<?php
require_once("../../includes/initialize.php");

// Ensure the 'code' parameter is provided
if (!isset($_GET['code']) || empty($_GET['code'])) {
    die('Confirmation code not provided.');
}

$code = mysqli_real_escape_string($connection, $_GET['code']);

$query = "SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `G_CITY`, `ZIP`, `G_NATIONALITY`, `CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE`
          FROM `tblguest` g
          JOIN `tblreservation` r ON g.`GUESTID` = r.`GUESTID`
          WHERE `CONFIRMATIONCODE` = '$code'";

$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    die('No records found for the provided confirmation code.');
}

$query1 = "SELECT A.ACCOMID, A.ACCOMODATION, RM.ROOM, RM.ROOMDESC, RM.NUMPERSON, RM.PRICE, RM.ROOMID, RS.ARRIVAL, RS.DEPARTURE 
           FROM tblaccomodation A
           JOIN tblroom RM ON A.ACCOMID = RM.ACCOMID
           JOIN tblreservation RS ON RM.ROOMID = RS.ROOMID 
           WHERE RS.CONFIRMATIONCODE = '".$_GET['code']."'";

$result1 = mysqli_query($connection, $query1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HM Hotel Reservation</title>
    <link rel="stylesheet" type="text/css" href="../../style.css">  
    <link rel="stylesheet" type="text/css" href="../../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../fonts/css/font-awesome.min.css"> 
    <link rel="stylesheet" type="text/css" href="../../css/custom-navbar.min.css"> 
    <link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="../../css/datepicker.css" rel="stylesheet" media="screen">
    <link href="../../css/galery.css" rel="stylesheet" media="screen">
    <link href="../../css/ekko-lightbox.css" rel="stylesheet">
    <style>
       @media print {
    body {
        margin: 0.5in;
    }
    
    thead th {
        background-color: #f2f2f2; /* Change this to your desired background color */
        color: #333; /* Change this to your desired text color */
    }

    .lead {
        font-weight: bold;
    }

    .table th, .table td {
        border: 1px solid #ddd; /* Ensure borders are visible in print */
    }
}

    </style>
     <script>
        // Function to check if the user has canceled the print dialog
        function checkPrintStatus() {
            if (window.print) {
                // Listen for print completion
                window.onafterprint = function() {
                    window.location.href = "index.php"; // Replace with the URL you want to redirect to
                };

                // Trigger the print dialog
                window.print();
            } else {
                // If the print function is not supported, redirect immediately
                window.location.href = "index.php"; // Replace with the URL you want to redirect to
            }
        }

        // Call the function when the document is loaded
        window.onload = checkPrintStatus;
    </script>
</head>
<body >
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-building"></i> HM Hotel Reservation
                    </h2>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>HM Hotel Reservation</strong><br>
                        Crossing Bunakan<br>
                        Bunakan, Madridejos, Cebu<br>
                        Phone: 09317622381<br>
                        Email: Hmhotelreservation@gmail.com
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong><?php echo $row['G_FNAME'] . ' ' . $row['G_LNAME']; ?></strong><br>
                        <?php echo $row['G_ADDRESS']; ?><br>
                        <?php echo $row['G_CITY']; ?><br>
                        <?php echo $row['G_NATIONALITY']; ?><br>
                        <?php echo $row['ZIP']; ?>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <b>Invoice No.</b> 00<?php echo $row['GUESTID']; ?><br>
                    <b>Confirmation ID:</b> <?php echo $row['CONFIRMATIONCODE']; ?><br>
                    <b>Transaction Date:</b> <?php echo $row['TRANSDATE']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Checked in</th>
                                <th>Checked out</th>
                                <th>Night(s)</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $tot = 0;
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                $days = dateDiff(date($row1['ARRIVAL']), date($row1['DEPARTURE']));
                                $subtotal = $row1['PRICE'] * ($days == 0 ? 1 : $days);
                                $tot += $subtotal;
                                ?>
                                <tr> 
                                    <td><?php echo $row1['ACCOMODATION'] . ' ' . $row1['ROOM']; ?></td>
                                    <td><?php echo $row1['ROOMDESC']; ?><br><?php echo $row1['NUMPERSON']; ?></td>
                                    <td>&#8369; <?php echo $row1['PRICE']; ?></td>
                                    <td><?php echo date_format(date_create($row1['ARRIVAL']), 'm/d/Y'); ?></td>
                                    <td><?php echo date_format(date_create($row1['DEPARTURE']), 'm/d/Y'); ?></td>
                                    <td><?php echo ($days == 0) ? '1' : $days; ?></td>
                                    <td>&#8369; <?php echo $subtotal; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <p class="lead">Total Amount</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td>&#8369; <?php echo $tot; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
