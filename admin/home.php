<style>
.material-symbols-outlined {
    weight: 200px;
    font-size: 25px;
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
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result->Total) ? $result->Total : 0; ?></div>
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
$query1 = "SELECT count(*) as 'Total' FROM `tblaccomodation` WHERE ACCOMODATION != '' ";
$mydb->setQuery($query1);
$cur1 = $mydb->loadResultList();
foreach ($cur1 as $result1) {
?>
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result1->Total) ? $result1->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Accomodations</div>
                        </div>
                        <div class="col-auto">
                        <span class="material-symbols-outlined">meeting_room</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php
$query2 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS != '' ";
$mydb->setQuery($query2);
$cur2 = $mydb->loadResultList();
foreach ($cur2 as $result2) {
?>
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result2->Total) ? $result2->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Reservations</div>
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
$query3 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE TRANSDATE=DATE(NOW())!=  '' ";
$mydb->setQuery($query3);
$cur3 = $mydb->loadResultList();
foreach ($cur3 as $result3) {
?>
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result3->Total) ? $result3->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Booking Today</div>
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
$query4 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Confirmed'  ";
$mydb->setQuery($query4);
$cur4 = $mydb->loadResultList();
foreach ($cur4 as $result4) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class=" row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result4->Total) ? $result4->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Confirm Booking</div>
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
$query5 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedin' ";
$mydb->setQuery($query5);
$cur5 = $mydb->loadResultList();
foreach ($cur5 as $result5) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result5->Total) ? $result5->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Check-in Guest</div>
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
$query6 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS = 'Checkedout' ";
$mydb->setQuery($query6);
$cur6 = $mydb->loadResultList();
foreach ($cur6 as $result6) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result6->Total) ? $result6->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Check-out Guest</div>
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
$query7 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Cancelled'  ";
$mydb->setQuery($query7);
$cur7 = $mydb->loadResultList();
foreach ($cur7 as $result7) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; "><?php echo isset($result7->Total) ? $result7->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">Cancelled</div>
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
$query7 = "SELECT count(*) as 'Total' FROM `tblreservation` WHERE STATUS= 'Cancelled'  ";
$mydb->setQuery($query7);
$cur7 = $mydb->loadResultList();
foreach ($cur7 as $result7) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; ">
                                ₱<?php echo isset($result8->Total) ? $result8->Total : 0; ?>
                            </div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; ">
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
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
// Database queries to get the count of different room statuses
$select = "SELECT count(*) FROM tblroom where ROOM != '' ";
$result = mysqli_query($connection, $select);
$cnt = mysqli_fetch_array($result);

$select1 = "SELECT count(*) FROM tblaccomodation where ACCOMODATION != '' ";
$result1 = mysqli_query($connection, $select1);
$cnt1 = mysqli_fetch_array($result1);

$select2 = "SELECT count(*) FROM tblreservation where CONFIRMATIONCODE != '' ";
$result2 = mysqli_query($connection, $select2);
$cnt2 = mysqli_fetch_array($result2);

$sql3 = "SELECT count(*) FROM `tblreservation` WHERE TRANSDATE=DATE(NOW()) AND STATUS != 'Booked' ";
$result3 = mysqli_query($connection, $sql3);
$cnt3 = mysqli_fetch_array($result3);

$sql4 = "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Confirmed' ";
$result4 = mysqli_query($connection, $sql4);
$cnt4 = mysqli_fetch_array($result4);

$sql5 = "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Checkedin' ";
$result5 = mysqli_query($connection, $sql5);
$cnt5 = mysqli_fetch_array($result5);

$sql6 = "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Checkedout' ";
$result6 = mysqli_query($connection, $sql6);
$cnt6 = mysqli_fetch_array($result6);

$sql7 = "SELECT count(*) FROM `tblreservation` WHERE STATUS = 'Cancelled' ";
$result7 = mysqli_query($connection, $sql7);
$cnt7 = mysqli_fetch_array($result7);
?>

<script>
    var xValues = ["Confirmed", "Cancelled", "Checked in", "Checked out"];
    var yValues = [<?php echo $cnt4[0]; ?>, <?php echo $cnt7[0]; ?>, <?php echo $cnt5[0]; ?>, <?php echo $cnt6[0]; ?>];
    var barColors = ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0"]; // Colors for the donut sections

    new Chart("myChart", {
        type: "doughnut", // Set the type to doughnut for a donut chart
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: true // Show legend
            },
            title: {
                display: true,
                text: "ROOM STATUS" // Title of the chart
            },
            animation: {
                animateScale: true, // Add scale animation
                animateRotate: true // Add rotation animation
            }
        }
    });
</script>