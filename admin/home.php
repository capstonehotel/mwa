<style>
.material-symbols-outlined {
    weight: 200px;
    font-size: 30px;
}
</style>
<?php
require_once("../includes/initialize.php");
if (!isset($_SESSION['ADMIN_ID'])) {
    redirect('login.php');
    return true;
}

$query = "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != '' ";
$mydb->setQuery($query);
$cur = $mydb->loadResultList();
foreach ($cur as $result) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 20px; "><?php echo isset($result->Total) ? $result->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; " >Rooms</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">hotel</span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php
$querys = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS != '' ";
$mydb->setQuery($querys);
$cury = $mydb->loadResultList();
foreach ($cury as $resulta) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resulta->Total) ? $resulta->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Reservations</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">book</span>
                        </div>
                    </div>
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resultas->Total) ? $resultas->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Booking Today</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">calendar_today</span> 
                        </div>
                    </div>
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class=" row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resultas->Total) ? $resultas->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Confirm Booking</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">check</span> 
                        </div>
                    </div>
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resultas->Total) ? $resultas->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Check-in Guest</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">person</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php
$querysi = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedout' ";
$mydb->setQuery($querysi);
$curya = $mydb->loadResultList();
foreach ($curya as $resultas) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resultas->Total) ? $resultas->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Check-out Guest</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">person</span>
                        </div>
                    </div>
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;"><?php echo isset($resultas->Total) ? $resultas->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cancelled</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">close</span>
                        </div>
                    </div>
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


<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 30px;">
                                ₱<?php echo isset($resultas->Total) ? $resultas->Total : 0; ?>
                            </div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Invoice
                            </div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<br>

<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Graph </h6>
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

$sqli = "SELECT count(*) FROM  `tblreservation` WHERE TRANSDATE=DATE(NOW()) != 'Booked' ";
$resultas = mysqli_query($connection, $sqli);
$cnt5 = mysqli_fetch_array($resultas);

$sli = "SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Cancelled' ";
$resulta = mysqli_query($connection, $sli);
$cnt1 = mysqli_fetch_array($resulta);

$sqla = "SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Confirmed' ";
$res = mysqli_query($connection, $sqla);
$cntaS = mysqli_fetch_array($res);

$sqlaS = "SELECT count(*) FROM  `tblreservation` WHERE STATUS = 'Checkedin' ";
$resT = mysqli_query($connection, $sqlaS);
$cntS = mysqli_fetch_array($resT);

$select = "SELECT count(*) FROM tblroom where ROOM != '' ";
$result = mysqli_query($connection, $select);
$cnt = mysqli_fetch_array($result);

?>

<script>
    var xValues = ["Booked", "Confirmed", "Cancelled", "Checked in", "Rooms"];
    var yValues = [<?php echo $cnt5[0]; ?>, <?php echo $cntaS[0]; ?>, <?php echo $cnt1[0]; ?>, <?php echo $cntS[0]; ?>, <?php echo $cnt[0]; ?>];
    var barColors = ["red", "green", "blue", "orange", "brown"];

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
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "ROOM"
            }
        }
    });
</script>
