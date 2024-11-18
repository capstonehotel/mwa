<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (isset($_POST['save_accomodation'])) {
    $errors = [];
    $accommodationExists = false;

    // Sanitize inputs
    $ACCOMODATION = htmlspecialchars(trim($_POST['ACCOMODATION']), ENT_QUOTES, 'UTF-8');
    $ACCOMDESC = htmlspecialchars(trim($_POST['ACCOMDESC']), ENT_QUOTES, 'UTF-8');

    // Validate inputs
    if (empty($ACCOMODATION) || empty($ACCOMDESC)) {
        $errors[] = 'Accommodation name and description cannot be empty.';
    }

    // Check for existing accommodation
    $checkSql = "SELECT * FROM tblaccomodation WHERE ACCOMODATION = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $ACCOMODATION);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $errors[] = 'Accommodation already exists.';
        $accommodationExists = true;
    }
    $checkStmt->close();

    // If no errors, proceed
    if (empty($errors)) {
        $insertSql = "INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ss", $ACCOMODATION, $ACCOMDESC);

        if ($insertStmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Saved!',
                        text: 'Accommodation saved successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location = 'index.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error saving accommodation: " . htmlspecialchars($insertStmt->error) . "',
                        icon: 'error'
                    });
                  </script>";
        }
        $insertStmt->close();
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    html: '" . implode('<br>', $errors) . "',
                    icon: 'error'
                }).then(() => {
                    if ($accommodationExists) {
                        document.getElementById('ACCOMODATION').value = '';
                    }
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
          <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Add New Accommodation</h6>
            <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
              <button type="submit" name="save_accomodation" class="btn btn-success btn-sm mr-2">Save Accommodation</button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMODATION">Name:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION" placeholder="Accommodation" type="text" value="">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMDESC">Description:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC" placeholder="Description" type="text" value="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js-->