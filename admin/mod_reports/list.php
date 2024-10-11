<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Additional styling and scripts -->
<style>
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }
    .table thead th {
        text-align: center;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    .table-responsive {
        display: none; /* Hide table initially */
    }
    #printthis {
        display: none;
    }
    @media print {
        #printthis {
            display: block;
        }
    }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Checked-Out Reservations</h6>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <div class="card-body">
                    <div class="table-responsive" style="width: 100%;">
                        <table class="table table-striped" id="dataTableCheckout" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest</th>
                                    <th>Transaction Date</th>
                                    <th>Confirmation Code</th>
                                    <th>Total Rooms</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `SPRICE`, `STATUS` 
                                          FROM `tblpayment` p, `tblguest` g 
                                          WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'checkedout' 
                                          ORDER BY p.`TRANSDATE` DESC";
                                $result = mysqli_query($connection, $query);
                                if (!$result) {
                                    echo "<tr><td colspan='8'>Query failed: " . mysqli_error($connection) . "</td></tr>";
                                } else {
                                    $number = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
                                            <td align="center"><?php echo $row['TRANSDATE']; ?></td>
                                            <td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
                                            <td align="center"><?php echo $row['PQTY']; ?></td>
                                            <td align="center"><?php echo $row['SPRICE']; ?></td>
                                            <td align="center"><?php echo $row['STATUS']; ?></td>
                                            <td align="center">
                                            <a href="?code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-sm btn-primary"><i class="icon-print"></i> Print</a>
                                                <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['CONFIRMATIONCODE']; ?>"><i class="icon-edit"></i> Delete</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } 
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once("../../includes/initialize.php");
// Ensure the 'code' parameter is provided
if (isset($_GET['code'])) {
    //die('Confirmation code not provided.');

$code = mysqli_real_escape_string($connection, $_GET['code']);

$queryp = "SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`, `G_CITY`, `ZIP`, `G_NATIONALITY`, `CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE`
          FROM `tblguest` g
          JOIN `tblreservation` r ON g.`GUESTID` = r.`GUESTID`
          WHERE `CONFIRMATIONCODE` = '$code'";

$result = mysqli_query($connection, $queryp);
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

<section class="invoice" id="printthis">
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
<?php } else { ?>
<?php echo 'none'; } ?>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script> 

<!-- Initialize DataTables -->
<script>

<?php if (isset($_GET['code'])) { ?> 
    printJS({
        printable: 'printthis',
        type: 'html',
		header: '<h3 class="custom-h3">HM Hotel Reservation</h3>',
		style: 'thead th { background-color: #f2f2f2; color: #333; } .lead { font-weight: bold; } .table th, .table td { border: 1px solid #ddd; }',
	});

<?php } ?>


$(document).ready(function() {
    // Initialize DataTables for check-out tab
    $('#dataTableCheckout').DataTable({
        "paging": true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10
    });

    // Show table after initialization
    $('.table-responsive').show();

    // Event listener for deleting a reservation
    $(document).on('click', '.delete-btn', function() {
        var confirmationCode = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete.php',
                    type: 'GET',
                    data: { id: confirmationCode, confirm: 'true' },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The check-out reservation has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after deletion
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the reservation.',
                            'error'
                        );
                    }
                });
            }
        });
    });



// print

});
</script>
