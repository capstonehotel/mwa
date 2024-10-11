<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Sender</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tblcontact";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['CONT_CREATED_AT'];?></td>
                            <td><?php echo $row['CONT_NAME'];?></td>
                            <td><?php echo $row['CONT_EMAIL'];?></td>
                            <td><?php echo $row['CONT_MESSAGE'];?></td>
                            <td style="display: flex;">
                                <button class="btn-sm btn btn-danger mr-2 delete-btn" data-id="<?php echo $row['CONTID']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
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
                    data: { id: id, confirm: true },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The message has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to reflect changes
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the message.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
