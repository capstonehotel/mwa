<?php
// require_once("../includes/initialize.php");
// load config file first 
require_once("../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../includes/functions.php");
//later here where we are going to put our class session
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php"); 
require_once("../includes/setting.php");
//Load Core objects
require_once("../includes/database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title . ' | HM Hotel Reservation' :  ' HM Hotel Reservation' ; ?></title>
 
    
<link rel="stylesheet" type="text/css" href="../style.css">  
<link rel="stylesheet" type="text/css" href="../css/responsive.css">    

<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">  

<link rel="stylesheet" type="text/css" href="../fonts/css/font-awesome.min.css"> 

<link rel="stylesheet" type="text/css" href="../css/custom-navbar.min.css"> 

<!-- DataTables CSS -->
<!-- <link href="<?php echo WEB_ROOT; ?>css/dataTables.bootstrap.css" rel="stylesheet"> -->
 
 <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="../css/datepicker.css" rel="stylesheet" media="screen">

 <link href="../css/galery.css" rel="stylesheet" media="screen">
 <link href="../css/ekko-lightbox.css" rel="stylesheet">
</head>
<body onload="window.print();">
<div class="wrapper">
  
  <?php 
// load config file first 
require_once("../includes/config.php");
//load basic functions next so that everything after can use them
require_once("../includes/functions.php");
//later here where we are going to put our class session
require_once("../includes/session.php");
require_once("../includes/user.php");
require_once("../includes/pagination.php");
require_once("../includes/paginsubject.php");
require_once("../includes/accomodation.php");
require_once("../includes/guest.php");
require_once("../includes/reserve.php"); 
require_once("../includes/setting.php");
//Load Core objects
require_once("../includes/database.php");
  // require_once("../includes/initialize.php");
 $query ="SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `G_CITY` , `CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE` FROM `tblguest` g ,`tblreservation` r WHERE g.`GUESTID`=r.`GUESTID` and `CONFIRMATIONCODE` ='".$_POST['code']."'";
  $mydb->setQuery($query);
 $res = $mydb->loadsingleResult();


     ?>
    <form action="guest/readprint.php?>" method="POST" target="_blank">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-building"></i>  HM Hotel Reservation
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong> HM Hotel Reservation </strong><br>
            Crossing Bunakan<br>
            Bunakan,Madridejos, Cebu<br>
            Phone: 09317622381<br>
            Email: Hmhotelreservation@gmail.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $res->G_FNAME . ' ' .$res->G_LNAME; ?>
            </strong><br>
            <?php echo $res->G_ADDRESS; ?> 
          </address>
           <City>
            <strong><?php echo $res->G_CITY . ' ' .$res->G_NATIONALITY; ?>
            </strong><br>
            <?php echo $res->ZIP; ?> 
          </City>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <br/>
        <br/>
          <!-- <b>Invoice #007612</b><br>
          <br> -->
            <b> <p style="background-color:white;color:black;">Invoice No.</b>00 <?php echo $row['GUESTID']; ?></p> 
          <b>Confirmation ID:</b> <p style="background-color:white;color:black;"> <?php echo $res->CONFIRMATIONCODE; ?></p> 
          <input type="hidden" name="code" value="<?php echo $res->CONFIRMATIONCODE; ?>">
<br>
          <b>Transaction Date:</b> <?php echo  Date($res->TRANSDATE); ?>
<br>
          <!-- <b>Account:</b> <?php echo $res->GUESTID; ?> -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  <?php 
 
 $query ="SELECT * FROM `tblaccomodation` A,`tblroom`  RM, `tblreservation` RS  WHERE  A.`ACCOMID`=RM.`ACCOMID` AND RM.`ROOMID`=RS.`ROOMID`  and `CONFIRMATIONCODE` ='".$_POST['code']."'";
  $mydb->setQuery($query);
 $res = $mydb->loadResultList(); 


     ?>
      <!-- Table row -->
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
            <?php   foreach ($res as $result) {
          $days =  dateDiff(date($result->ARRIVAL),date($result->DEPARTURE));
             ?>

            <tr> 
              <td><?php echo $result->ACCOMODATION . ' [' .$result->ROOM.']' ;?></td>
              <td><?php echo $result->ROOMDESC . ' <br/> Person: ' .  $result->NUMPERSON;?></td>
              <td> &#8369 <?php echo $result->PRICE;?></td>
              <td><?php echo date_format(date_create($result->ARRIVAL),'m/d/Y');?></td>
              <td><?php echo date_format(date_create($result->DEPARTURE),'m/d/Y');?></td>
              <td><?php echo ($days==0) ? '1' : $days;?></td>
              <td> &#8369 <?php echo $result->RPRICE;?></td>
            </tr>
            
            
            <?php 
              @$tot += $result->RPRICE;
            } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td> &#8369 <?php echo @$tot ; ?></td>
              </tr>
        <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr> 
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a href="<?php echo WEB_ROOT; ?>guest/readprint.php?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          <!-- <button type="submit"  ><i class="fa fa-print"></i> Print</button> -->
  <!--         <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button> -->
        </div>
      </div>
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper -->
</body>
</html>