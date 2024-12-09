<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
$id = $_GET['id'];

// Validate and sanitize the ID
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    // Invalid ID, handle the error accordingly
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text: 'Invalid accommodation ID!',
        icon: 'error'
    }).then(() => {
        window.location = 'index.php';
    });
    </script>";
    exit;
}

// Use prepared statements to fetch the accommodation details
$stmt = $connection->prepare("SELECT * FROM tblaccomodation WHERE ACCOMID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['save_accomodation'])) {
    // Sanitize and validate the input
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
    } else {
        // Check for duplicate accommodation names using prepared statements
        $checkStmt = $connection->prepare("SELECT * FROM tblaccomodation WHERE ACCOMODATION = ? AND ACCOMID != ?");
        $checkStmt->bind_param("si", $ACCOMODATION, $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Duplicate found
            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Accommodation name already exists!',
                icon: 'error'
            });
            </script>";
        } else {
            // No duplicate found, proceed with update using prepared statements
            $updateStmt = $connection->prepare("UPDATE tblaccomodation SET ACCOMODATION = ?, ACCOMDESC = ? WHERE ACCOMID = ?");
            $updateStmt->bind_param("ssi", $ACCOMODATION, $ACCOMDESC, $id);
            if ($updateStmt->execute()) {
                echo "<script>
                Swal.fire({
                    title: 'Updated!',
                    text: 'Accommodation updated successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location = 'index.php';
                });
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error updating Accommodation',
                    icon: 'error'
                });
                </script>";
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    }
}
?>

<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3" style="display: flex;align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Update Accommodation</h6>

            <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
              <button type="submit" name="save_accomodation" class="btn btn-success btn-sm mr-2">Update Accommodation</button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Name:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION"  pattern="^(?!\s*$)[A-Za-z\s.,]+$" placeholder="Accommodation" type="text" value="<?php echo htmlspecialchars($row["ACCOMODATION"], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Description:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC" pattern="^(?!\s*$)[A-Za-z\s.,]+$" placeholder="Description" type="text" value="<?php echo htmlspecialchars($row["ACCOMDESC"], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
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