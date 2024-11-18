<?php
// Load SweetAlert2
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Database connection
$conn = new mysqli('127.0.0.1', 'u510162695_hmsystemdb', '1Hmsystemdb', 'u510162695_hmsystemdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['save_accomodation'])) {
    $ACCOMODATION = $conn->real_escape_string($_POST['ACCOMODATION']);
    $ACCOMDESC = $conn->real_escape_string($_POST['ACCOMDESC']);

    $stmt = $conn->prepare("INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES (?, ?)");
    $stmt->bind_param("ss", $ACCOMODATION, $ACCOMDESC);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                  title: 'Saved!',
                  text: 'New Accommodation saved successfully!',
                  icon: 'success'
                }).then(() => {
                  window.location = 'index.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Error adding new Accommodation: " . $stmt->error . "',
                  icon: 'error'
                });
              </script>";
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
            <h6 class="m-0 font-weight-bold text-primary">Add New Accomodation</h6>
            <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
              <button type="submit" name="save_accomodation" class="btn btn-success btn-sm mr-2">Save Accomodation</button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMODATION">Name:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION" placeholder="Accomodation" type="text" value="">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
                 <script>
    document.addEventListener('DOMContentLoaded', function() {
        function detectXSS(inputField, fieldName) {
            const xssPattern =  /[<>:\/\$\;\,\?\!]/;
            inputField.addEventListener('input', function() {
                if (xssPattern.test(this.value)) {
                  Swal.fire("XSS Detected", `Please avoid using invalid characters in your ${fieldName}.`, "error");
                    this.value = "";
                }
            });
        }
        
        const ACCOMODATIONInput = document.getElementById('ACCOMODATION');
        const ACCOMDESCInput = document.getElementById('ACCOMDESC');
        
        detectXSS(ACCOMODATIONInput, 'ACCOMODATION');
        detectXSS(ACCOMDESCInput, 'ACCOMDESC');
        
    });
</script>
