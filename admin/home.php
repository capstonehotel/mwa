<style>
.material-symbols-outlined {
    weight: 200px;
    font-size: 25px;
}
.card-body {
    padding: 10px; /* Adjust padding */
}

</style>
<?php
require_once("../includes/initialize.php");
if (!isset($_SESSION['ADMIN_ID'])) {
    redirect('login.php');
    return true;
}
echo '<div class="row"  style="padding: 10px;">';

$query = "SELECT count(*) as 'Total' FROM `tblroom` WHERE ROOM != '' ";
$mydb->setQuery($query);
$cur = $mydb->loadResultList();
foreach ($cur as $result) {
?>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill ">
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result->Total) ? $result->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px;  padding-left: 5px; " >Rooms</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result1->Total) ? $result1->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px; ">Accomodations</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px;"><?php echo isset($result2->Total) ? $result2->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px; ">Reservations</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card board1 fill">
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result3->Total) ? $result3->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px;  padding-left: 5px;">Booking Today</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class=" row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result4->Total) ? $result4->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px; ">Confirm Booking</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px;"><?php echo isset($result5->Total) ? $result5->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px;">Check-in Guest</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result6->Total) ? $result6->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px;  padding-left: 5px;">Check-out Guest</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; "><?php echo isset($result7->Total) ? $result7->Total : 0; ?></div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px; ">Cancelled</div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
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
        <div class="card shadow h-100 py-2" style="border-radius: 0;">
            <div class="card-body">
                <div class="dash-widget-header">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 25px; padding-left: 5px; ">
                                ₱<?php echo isset($result8->Total) ? $result8->Total : 0; ?>
                            </div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"  style="font-size: 10px; padding-left: 5px;">
                                Total Invoice
                            </div>
                        </div>
                        <div class="col-auto" style="padding-left: 5px;">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</div>

<?php
// Database queries to get the count of different room statuses
$select = "SELECT count(*) FROM tblroom where ROOM != 'Rooms' ";
$result = mysqli_query($connection, $select);
$cnt = mysqli_fetch_array($result);

$select1 = "SELECT count(*) FROM tblaccomodation where ACCOMODATION != 'Accomodation' ";
$result1 = mysqli_query($connection, $select1);
$cnt1 = mysqli_fetch_array($result1);

$select2 = "SELECT count(*) FROM tblreservation where CONFIRMATIONCODE != 'Reservations' ";
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
// Prepare data only up to the current year
$lineData = [];
$startYear = 2024;
$currentYear = date("Y"); // dynamically get the current year

$roomCount = (int)$cnt[0];
for ($year = $startYear; $year <= $currentYear; $year++) {
    for ($month = 1; $month <= 12; $month++) {
        $date = sprintf('%04d-%02d', $year, $month); // Format as YYYY-MM
        $sql = "SELECT COUNT(*) AS count FROM `tblreservation` WHERE DATE_FORMAT(TRANSDATE, '%Y-%m') = '$date'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        $reservationCount = (int)$row['count'];
        $lineData[] = ['y' => $date, 'a' => $roomCount, 'b' => $reservationCount];
    }
}
?>


<div class="col-md-12 col-lg-6">
    <div class="card shadow mb-4">
        <div class="card card-chart" style="height: 400px;"> <!-- Ensure consistent height -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="card-title m-0 font-weight-bold text-primary">LINE CHART</h6>
            </div>
            <div class="card-body">
                <div id="line-chart" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-lg-6">
    <div class="card shadow mb-4">
        <div class="card card-chart" style="height: 400px;"> <!-- Ensure consistent height -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="card-title m-0 font-weight-bold text-primary">DONUT CHART</h6>
            </div>
            <div class="card-body">
                <div id="donut-chart" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    donutChart();
    lineChart();
    $(window).resize(function() {
        window.donutChart.redraw();
        window.lineChart.redraw();
    });
});

function donutChart() {
    window.donutChart = Morris.Donut({
        element: 'donut-chart',
        data: [
            { label: "Rooms", value: <?php echo $cnt[0]; ?> },
            { label: "Confirmed", value: <?php echo $cnt4[0]; ?> },
            { label: "Cancelled", value: <?php echo $cnt7[0]; ?> },
            { label: "Checked In", value: <?php echo $cnt5[0]; ?> },
            { label: "Checked Out", value: <?php echo $cnt6[0]; ?> },
        ],
        backgroundColor: '#f2f5fa',
        labelColor: '#009688',
        colors: ['#0BA462', '#39B580', '#FF6384', '#FFCE56', '#4BC0C0'],
        resize: true,
    });
}

function lineChart() {
    window.lineChart = Morris.Line({
        element: 'line-chart',
        data: <?php echo json_encode($lineData); ?>,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Rooms', 'Reservations'],
        xLabels: 'month', // Display only months
        xLabelFormat: function (x) {
            // Format months as Jan, Feb, etc.
            return x.toLocaleString('en-US', { month: 'short' });
        },
        lineColors: ['#009688', '#FF6384'],
        lineWidth: '3px',
        resize: true,
        redraw: true
    });

    // Add the current year below the chart
    let chartElement = document.getElementById('line-chart');
    let currentYearLabel = document.createElement('div');
    currentYearLabel.innerHTML = `<span style="font-size: 14px; color: #666; display: block; text-align: center; margin-top: -10px;">${new Date().getFullYear()}</span>`;
    chartElement.parentNode.insertBefore(currentYearLabel, chartElement.nextSibling);
}
</script>
    <!-- Include jQuery and Morris.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<!-- <script>
$(document).ready(function() {
    donutChart();
});

function donutChart() {
    window.donutChart = Morris.Donut({
        element: 'donut-chart',
        data: [
            { label: "Rooms", value: <?php echo $cnt[0]; ?> },
            { label: "Confirmed", value: <?php echo $cnt4[0]; ?> },
            {label: "Cancelled", value: <?php echo $cnt7[0]; ?> },
            { label: "Checked In", value: <?php echo $cnt5[0]; ?> },
            { label: "Checked Out", value: <?php echo $cnt6[0]; ?> },
            
        ],
        backgroundColor: '#f2f5fa',
        labelColor: '#009688',
        colors: ['#0BA462','#39B580','#67C69D','#95D7BB','#67C69D'],
        resize: true,
    });
}
</script> -->