

<?php

// Load SweetAlert2 from the official CDN
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (isset($_POST['save_accomodation'])) {
    // Sanitize and validate inputs
    $ACCOMODATION = trim($_POST['ACCOMODATION']);
    $ACCOMDESC = trim($_POST['ACCOMDESC']);

    // Basic validation (you can expand this based on your requirements)
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

    // Use prepared statements to prevent SQL injection
    $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tblaccomodation WHERE ACCOMODATION = ?");
    $stmt->bind_param("s", $ACCOMODATION);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Accommodation already exists
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Accommodation with this name already exists!',
                  icon: 'error'
                 }).then(() => {
                    // Clear only the accommodation name input
                    document.getElementById('ACCOMODATION').value = '';
                    // Keep the accommodation description intact
                    document.getElementById('ACCOMDESC').value = '" . htmlspecialchars($ACCOMDESC, ENT_QUOTES) . "';
                });
              </script>";
    } else {
        // Insert into database using prepared statements
        $insert_stmt = $connection->prepare("INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $ACCOMODATION, $ACCOMDESC);
        
        if ($insert_stmt->execute()) {
            // Success message using SweetAlert2
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
            // Error message if the query fails
            echo "<script>
                    Swal.fire({
                      title: 'Error!',
                      text: 'Error adding new Accommodation: " . $connection->error . "',
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
                  <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION"  pattern="^(?!\s*$)[A-Za-z\s.,]+$" placeholder="Accommodation" type="text" value="">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMDESC">Description:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC"   pattern="^(?!\s*$)[A-Za-z\s.,]+$" placeholder="Description" type="text" value="">
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
document.querySelector('form').addEventListener('submit', function(event) {
        // Check each required input field for empty or space-only values
        const requiredFields = document.querySelectorAll('input[required], select[required]');
        let isValid = true;
    
    
        requiredFields.forEach(function(field) {
            const value = field.value.trim(); // Remove leading/trailing spaces
            if (value === '') {
                // Show a custom alert or display the error message
                alert(Please fill out the required field: ${field.placeholder || field.name});
                isValid = false;
                field.focus(); // Focus on the first empty required field
            }
        });
    
        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are invalid fields
        }
    });
    </script>