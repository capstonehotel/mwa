<?php
// Load SweetAlert2 from the official CDN
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Start processing if the form is submitted
if (isset($_POST['save_accomodation'])) {
    // Sanitize inputs
    $ACCOMODATION = trim($_POST['ACCOMODATION']);
    $ACCOMDESC = trim($_POST['ACCOMDESC']);

    if (empty($ACCOMODATION) || empty($ACCOMDESC)) {
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Accommodation name and description cannot be empty!',
                  icon: 'error'
                });
              </script>";
        exit;
    }

    // Validate database connection
    if (!$conn) {
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Database connection failed!',
                  icon: 'error'
                });
              </script>";
        exit;
    }

    // Use prepared statements
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tblaccomodation WHERE ACCOMODATION = ?");
    $stmt->bind_param("s", $ACCOMODATION);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Accommodation already exists!',
                  icon: 'error'
                });
              </script>";
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $ACCOMODATION, $ACCOMDESC);
        
        if ($insert_stmt->execute()) {
            echo "<script>
                    Swal.fire({
                      title: 'Success!',
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
                      text: 'Error saving accommodation: " . $conn->error . "',
                      icon: 'error'
                    });
                  </script>";
        }
        $insert_stmt->close();
    }
    $stmt->close();
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