
<?php
require_once("../includes/initialize.php");
 if (!isset($_SESSION['ADMIN_ID'])){
    redirect('login.php');
    return true;
 }


$query = "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != '' ";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();  
                foreach ($cur as $result) { 


 ?>
<div class="col-xl-4 col-md-6 mb-4" >
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Rooms</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($result->Total) ? $result->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-bed fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
   <?php } ?>

   <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }
        .card {
            background-color: white;
            border-radius: 0px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 10px;
            flex: 1;
            min-width: 200px;
            position: relative;
        }
        .card i {
            font-size: 24px;
            color: #00bfa5;
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }
        .card h2 {
            margin: 10px 0;
            font-size: 24px;
            color: #00bfa5;
            text-align: left;
            font-weight: 500;
        }
        .card p {
            margin: 0;
            font-size: 14px;
            color: #888;
            text-align: left;
            font-weight: 400;
        }
        .chart-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }
        .chart {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            flex: 1;
            min-width: 300px;
        }
        .chart h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            color: #333;
            font-weight: 500;
        }
        .chart img {
            width: 100%;
        }
    </style>
<?php
$query = "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != '' ";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();  
                foreach ($cur as $result) { 


 ?>
    <div class="container">
        <div class="card">
            <h2><?php  echo  isset($result->Total) ? $result->Total  : 0;?></h2>
            <p>Rooms</p>
            <i class="fas fa-book"></i>
        </div>
        <?php } ?>
<?php 
    $querys = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS != '' ";
                $mydb->setQuery($querys);
                $cury = $mydb->loadResultList();  
                foreach ($cury as $resulta) { 
   ?>
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Reservations</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resulta->Total) ? $resulta->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php 
    $querysi = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Cancelled'  ";
                $mydb->setQuery($querysi);
                $curya = $mydb->loadResultList();  
                foreach ($curya as $resultas) { 
   ?>


<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Cancelled</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-times fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php 
    $querysi = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE TRANSDATE=DATE(NOW())!=  '' ";
                $mydb->setQuery($querysi);
                $curya = $mydb->loadResultList();  
                foreach ($curya as $resultas) { 
   ?>
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Booking Today</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-calendar fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php 
    $querysi = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Confirmed'  ";
                $mydb->setQuery($querysi);
                $curya = $mydb->loadResultList();  
                foreach ($curya as $resultas) { 
   ?>
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Confirm Booking</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php 
    $querysi = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedin' ";
                $mydb->setQuery($querysi);
                $curya = $mydb->loadResultList();  
                foreach ($curya as $resultas) { 
   ?>
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Check-in Guest</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo  isset($resultas->Total) ? $resultas->Total  : 0;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-black-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>





<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Graph</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myChart" style="width:auto; max-width: 650px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="bar.js"></script>
<?php 








$sqli="SELECT count(*) FROM  `tblreservation` WHERE TRANSDATE=DATE(NOW()) != 'Booked' ";
    $resultas=mysqli_query($connection,$sqli);
    $cnt5=mysqli_fetch_array($resultas);

    $sli="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Cancelled' ";
    $resulta=mysqli_query($connection,$sli);
    $cnt1=mysqli_fetch_array($resulta);

$sqla="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Confirmed' ";
    $res=mysqli_query($connection,$sqla);
    $cntaS=mysqli_fetch_array($res);
$sqlaS="SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Checkedin' ";
    $resT=mysqli_query($connection,$sqlaS);
    $cntS=mysqli_fetch_array($resT);

$select="SELECT count(*) FROM tblroom where ROOM != '' ";
    $result=mysqli_query($connection,$select);
    $cnt=mysqli_fetch_array($result);


// $query=" SELECT COUNT(*) FROM `tblreservation` WHERE TRANSDATE=DATE(NOW())!= 'Booked' ";
//      $resultas=mysqli_query($connection,$query);
//     $cnt5=mysqli_fetch_array($resultas);

 ?>
<script>
var xValues = ["Booked", "Confirmed", "Cancelled", "Checked in", "Rooms"];
var yValues = [<?php echo $cnt5[0]; ?>, <?php echo $cntaS[0]; ?>, <?php echo $cnt1[0]; ?>, <?php echo $cntS[0]; ?>,<?php echo $cnt[0]; ?>];
var barColors = ["red","green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "ROOM"
    }
  }
});
</script>
