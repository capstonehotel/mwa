<?php
include '../check_login.php'; 
?>    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Rooms List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New Rooms</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Room</th>
                            <th>Accomodation</th>
                            <th>Person</th>
                            <th>Price</th>
                            <th># of Rooms</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT *,ACCOMODATION FROM tblroom r, tblaccomodation a WHERE r.ACCOMID = a.ACCOMID ORDER BY  ROOMID ASC ";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            $number = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $number ++;
                    ?>
                        <tr>
                            <td align="center"><?php echo $number; ?> </td>
                            <td align="center"><img  width="80" height="80" src="<?php echo $row['ROOMIMAGE'];?>" /></td>
                            <td align="center"><?php echo $row['ROOM'];?> <?php echo $row['ROOMDESC'];?></td>
                            <td align="center"><?php echo $row['ACCOMODATION'];?></td>
                            <td align="center"><?php echo $row['NUMPERSON'];?></td>
                            <td align="center"> &#8369 <?php echo $row['PRICE'];?></td>
                            <td align="center"><?php echo $row['ROOMNUM'];?></td>
                            <td style="display: flex;">
				            	<a class="btn-sm btn btn-primary mr-2" href="index.php?view=edit&id=<?php echo $row['ROOMID']; ?>">View/Edit</a>
				            	<a class="btn-sm btn btn-danger mr-2" href="" onclick="confirmDelete(event,<?php echo $row['ROOMID']; ?>)">Delete</a>
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
function confirmDelete(event, id) {
    event.preventDefault(); // Prevent the default action of the link
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
            window.location.href = 'delete.php?id=' + id + '&confirm=true';
        }
    });
}
</script>