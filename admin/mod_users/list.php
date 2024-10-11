<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Account Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbluseraccount";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            $number = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $number++;
                    ?>
                        <tr>
                            <td align="center"><?php echo $number; ?></td>
                            <td align="center"><?php echo $row['UNAME'];?></td>
                            <td align="center"><?php echo $row['USER_NAME'];?></td>
                            <td align="center"><?php echo $row['ROLE'];?></td>
                            <td align="center"><?php echo $row['PHONE'];?></td>
                            <td style="display: flex;">
                                <a class="btn-sm btn btn-primary mr-2" href="index.php?view=edit&id=<?php echo $row['USERID']; ?>">View/Edit</a>
                                <button class="btn-sm btn btn-danger mr-2" onclick="deleteUser(<?php echo $row['USERID']; ?>)">Delete</button>
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
<script>
function deleteUser(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('delete.php?id=' + id, {
                method: 'GET',
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire(
                          'Deleted!',
                          'The user has been deleted.',
                          'success'
                      ).then(() => {
                          location.reload(); // Refresh the page to reflect changes
                      });
                  } else {
                      Swal.fire(
                          'Error!',
                          'An error occurred while deleting the user.',
                          'error'
                      );
                  }
              });
        }
    });
}
</script>
