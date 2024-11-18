<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Add Accommodation</title>
</head>
<body>
<?php
if (isset($_POST['save_accomodation'])) {
    // Sanitize and validate inputs
    $ACCOMODATION = trim($_POST['ACCOMODATION']);
    $ACCOMDESC = trim($_POST['ACCOMDESC']);

    // Basic validation
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

    // Example database connection, replace with your own
    $conn = new mysqli("localhost", "root", "", "your_database_name");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tblaccomodation WHERE ACCOMODATION = ?");
    $stmt->bind_param("s", $ACCOMODATION);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<script>
                Swal.fire({
                  title: 'Error!',
                  text: 'Accommodation with this name already exists!',
                  icon: 'error'
                }).then(() => {
                    document.getElementById('ACCOMODATION').value = '';
                });
              </script>";
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $ACCOMODATION, $ACCOMDESC);
        
        if ($insert_stmt->execute()) {
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
                      text: 'Error adding new Accommodation: " . $conn->error . "',
                      icon: 'error'
                    });
                  </script>";
        }
        $insert_stmt->close();
    }
    $stmt->close();
    $conn->close();
}
?>
<div class="container-fluid">
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Accommodation</h6>
            <button type="submit" name="save_accomodation" class="btn btn-success btn-sm">Save Accommodation</button>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="ACCOMODATION">Name:</label>
              <input required class="form-control" id="ACCOMODATION" name="ACCOMODATION" placeholder="Accommodation" type="text">
            </div>
            <div class="form-group">
              <label for="ACCOMDESC">Description:</label>
              <input required class="form-control" id="ACCOMDESC" name="ACCOMDESC" placeholder="Description" type="text">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>
