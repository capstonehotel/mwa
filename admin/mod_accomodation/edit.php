<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
$id = $_GET['id'];
$sql = "SELECT * FROM tblaccomodation WHERE ACCOMID = $id";
$result = $connection->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['save_accomodation'])) {

  $ACCOMODATION = $_POST['ACCOMODATION'];
  $ACCOMDESC = $_POST['ACCOMDESC'];

    $sql = "UPDATE tblaccomodation SET ACCOMODATION = '$ACCOMODATION', ACCOMDESC = '$ACCOMDESC' WHERE ACCOMID = '$id' ";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        Swal.fire({
            title: 'Updated!',
            text: 'Accomodation updated successfully!',
            icon: 'success'
        }).then(() => {
            window.location = 'index.php';
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Error updating Accomodation',
            icon: 'error'
        });
        </script>";
    }

}
?>

<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3" style="display: flex;align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Update Accomodation</h6>

            <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
              <button type="submit" name="save_accomodation" class="btn btn-success btn-sm mr-2">Update Accomodation</button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Name:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION" placeholder="Accomodation" type="text" value="<?php echo $row["ACCOMODATION"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Description:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC" placeholder="Description" type="text" value="<?php echo $row["ACCOMDESC"]; ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
