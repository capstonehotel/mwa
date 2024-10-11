<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title . ' | HM Hotel Reservation' :  ' HM Hotel Reservation' ; ?></title>

<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/style.css">  
<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/css/responsive.css">    
<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/css/bootstrap.css">  
<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/fonts/css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="https://mcchmhotelreservation.com/css/custom-navbar.min.css"> 
<link href="https://mcchmhotelreservation.com/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="https://mcchmhotelreservation.com/css/datepicker.css" rel="stylesheet" media="screen">
<link href="https://mcchmhotelreservation.com/css/galery.css" rel="stylesheet" media="screen">
<link href="https://mcchmhotelreservation.com/css/ekko-lightbox.css" rel="stylesheet">
<style>
    /* Add scrollable container */
    .scrollable-content {
        max-height: 80vh; /* You can adjust the height as needed */
        overflow-y: auto;
    }
</style>
</head>
<body>
<div class="wrapper">

  <?php 
  require_once("../includes/initialize.php");
  $query ="SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `G_CITY` , `ZIP`, `G_NATIONALITY`,`CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE` 
           FROM `tblguest` g ,`tblreservation` r 
           WHERE g.`GUESTID`=r.`GUESTID` 
           AND `CONFIRMATIONCODE` ='".$_GET['code']."'";
  $result = mysqli_query($connection, $query);

  if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
     ?>
    <form action="<?php echo 'https://mcchmhotelreservation.com/guest/readprint.php'?>" method="POST" target="_blank">
    
    <!-- Scrollable content wrapper -->
    <div class="scrollable-content">
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
            <strong><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></strong><br>
            <?php echo $row['G_ADDRESS']; ?><br>
            <?php echo $row['G_CITY']; ?><br>
            <?php echo $row['G_NATIONALITY']; ?><br>
            <?php echo $row['ZIP']; ?>
          </address>
        </div>

        <div class="col-sm-4 invoice-col">
          <b>Invoice No.</b> 00<?php echo $row['GUESTID']; ?><br>
          <b>Confirmation ID:</b> <?php echo $row['CONFIRMATIONCODE']; ?><br>
          <b>Transaction Date:</b> <?php echo $row['TRANSDATE']; ?><br>
        </div>
      </div>

      <?php 
      }
  }
  
  $query1 ="SELECT * FROM `tblaccomodation` A,`tblroom` RM, `tblreservation` RS  
           WHERE  A.`ACCOMID`=RM.`ACCOMID` 
           AND RM.`ROOMID`=RS.`ROOMID` 
           AND `CONFIRMATIONCODE` ='".$_GET['code']."'";
  $result1 = mysqli_query($connection, $query1);

  if ($result1) {
      while ($row1 = mysqli_fetch_assoc($result1)) {
     ?>
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
              $days =  dateDiff(date($row1['ARRIVAL']), date($row1['DEPARTURE']));
             ?>
            <tr> 
              <td> <?php echo $row1['ACCOMODATION']; ?> <?php echo $row1['ROOM']; ?></td>
              <td> <?php echo $row1['ROOMDESC']; ?> <br> <?php echo $row1['NUMPERSON']; ?> </td>
              <td> &#8369;<?php echo $row1['PRICE']; ?></td>
              <td><?php echo date_format(date_create($row1['ARRIVAL']), 'm/d/Y'); ?> </td>
              <td><?php echo date_format(date_create($row1['DEPARTURE']), 'm/d/Y'); ?> </td>
              <td><?php echo ($days == 0) ? '1' : $days; ?> </td>
              <td> &#8369;<?php echo $row1['RPRICE']; ?></td>
            </tr>
            <?php 
              @$tot += $row1['RPRICE'];
            } } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-6">
        </div>
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td> &#8369;<?php echo @$tot; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="row no-print">
        <div class="col-xs-12">
          <a href="index.php" class="btn btn-primary" style="margin-left: 10px;">
            <i class="fa fa-arrow-left"></i> Back
          </a>
        </div>
      </div>
    </section>
    </div> <!-- End of scrollable content -->
    </form>

    <div class="clearfix"></div>

</div>
<!-- ./wrapper -->
</body>
</html>
