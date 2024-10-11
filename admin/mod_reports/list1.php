<div class="container-fluid">
    <form id="deleteForm">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="display: flex; align-items: center;">
                <h6 class="m-0 font-weight-bold text-primary">List of Checked-out Reservations</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Guest</th>
                                <th>Transaction Date</th>
                                <th>Confirmation Code</th>
                                <th>Total Rooms</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `CONFIRMATIONCODE`, `PQTY`, `STATUS`
                                          FROM `tblpayment` p, `tblguest` g
                                          WHERE p.`GUESTID` = g.`GUESTID` AND p.`STATUS` = 'Checkedout'
                                          ORDER BY p.`TRANSDATE` DESC";
                                $result = mysqli_query($connection, $query);
                                $number = 0;
                                while ($row = mysqli_fetch_assoc($result)) { $number++; ?>
                                    <tr>
                                        <td align="center"><?php echo $number; ?></td>
                                        <td align="center"><?php echo $row['G_FNAME']; ?> <?php echo $row['G_LNAME']; ?></td>
                                        <td align="center"><?php echo $row['TRANSDATE']; ?></td>
                                        <td align="center"><?php echo $row['CONFIRMATIONCODE']; ?></td>
                                        <td align="center"><?php echo $row['PQTY']; ?></td>
                                        <td align="center"><?php echo $row['STATUS']; ?></td>
                                        <td align="center">
                                            <div class="btn-group" role="group">
                                                <form action="printreport.php" method="GET" target="_blank">
                                                    <input type="hidden" name="code" value="<?php echo $row['CONFIRMATIONCODE']; ?>">
                                                    <button class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</button>
                                                </form>
                                                <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $row['CONFIRMATIONCODE']; ?>"><i class="icon-edit"></i> Delete</button>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- SweetAlert and AJAX script for deletion -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
       

        // Handle delete button click
        $('.deleteBtn').on('click', function() {
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
                        data: { confirm: 'true', id: confirmationCode },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'The reservation has been deleted.',
                                    'success'
                                );
                                // Reload the table or remove the row
                                location.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the reservation.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
