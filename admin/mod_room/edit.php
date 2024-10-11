<?php
echo '<script src="../sweetalert.js"></script>';

$id = $_GET['id'];

// Fetch room details from the database
$sql = "SELECT * FROM tblroom INNER JOIN tblaccomodation ON tblroom.ACCOMID = tblaccomodation.ACCOMID WHERE ROOMID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_POST['save_room'])) {
    $ROOM = $_POST['ROOM'];

    // Check for duplicate room names
    $checkDuplicateSql = "SELECT ROOMID FROM tblroom WHERE ROOM = ? AND ROOMID != ?";
    $stmt = $connection->prepare($checkDuplicateSql);
    $stmt->bind_param("si", $ROOM, $id);
    $stmt->execute();
    $duplicateResult = $stmt->get_result();

    if ($duplicateResult->num_rows > 0) {
        // Duplicate room name found
        echo "<script>
            swal({
                title: 'Error!',
                text: 'A room with this name already exists.',
                icon: 'error'
            });
          </script>";
    } else {
        $uploadDir = 'rooms/'; // Set the directory where you want to save uploaded files

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $filename = basename($file['name']);
            $uploadPath = $uploadDir . $filename;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $ROOMIMAGE = $uploadDir . $filename;
            } else {
                // Handle file upload error
                $ROOMIMAGE = $row["ROOMIMAGE"];
                echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'Error uploading file',
                        icon: 'error'
                    });
                  </script>";
                exit(); // Stop further execution
            }
        } else {
            // No new file uploaded
            $ROOMIMAGE = $row["ROOMIMAGE"];
        }

        $ACCOMID = $_POST['ACCOMID'];
        $ROOMDESC = $_POST['ROOMDESC'];
        $NUMPERSON = $_POST['NUMPERSON'];
        $PRICE = $_POST['PRICE'];
        $ROOMNUM = $_POST['ROOMNUM'];

        $sql = "UPDATE tblroom SET 
            ROOMIMAGE = ?,
            ROOM = ?,
            ACCOMID = ?,
            ROOMDESC = ?,
            NUMPERSON = ?,
            PRICE = ?,
            ROOMNUM = ?
            WHERE ROOMID = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssisidii", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM, $id);

        if ($stmt->execute()) {
            echo "<script>
                swal({
                    title: 'Saved!',
                    text: 'Room updated successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location = 'index.php';
                });
              </script>";
        } else {
            echo "<script>
                swal({
                    title: 'Error!',
                    text: 'Error updating room: ". $stmt->error . "',
                    icon: 'error'
                });
              </script>";
        }

        $stmt->close();
        $connection->close();
    }
}
?>

<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3" style="display: flex; align-items: center;">
              <a class="btn btn-primary btn-sm mr-2" href="index.php">Back</a>
              <h6 class="m-0 font-weight-bold text-primary">Update Room</h6>
              <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
                <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Update Room</button>
              </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label class="col-md-4 control-label" for="ROOM">Name:</label>
              <input required class="form-control input-sm" id="ROOM" name="ROOM" placeholder="Room Name" type="text" value="<?php echo htmlspecialchars($row["ROOM"], ENT_QUOTES); ?>">
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="ACCOMID">Accommodation:</label>
              <select class="form-control input-sm" name="ACCOMID" id="ACCOMID"> 
                <option value="<?php echo htmlspecialchars($row["ACCOMID"], ENT_QUOTES); ?>"><?php echo htmlspecialchars($row["ACCOMODATION"], ENT_QUOTES); ?> (<?php echo htmlspecialchars($row["ACCOMDESC"], ENT_QUOTES); ?>)</option>
                <?php
                $query = "SELECT * FROM tblaccomodation";
                $result = mysqli_query($connection, $query);
                while ($rows = mysqli_fetch_assoc($result)) {
                  echo '<option value="'.htmlspecialchars($rows['ACCOMID'], ENT_QUOTES).'">'.htmlspecialchars($rows['ACCOMODATION'], ENT_QUOTES).' (' .htmlspecialchars($rows['ACCOMDESC'], ENT_QUOTES).')</option>';
                }
                ?>
              </select> 
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="ROOMDESC">Description:</label>
              <input required class="form-control input-sm" id="ROOMDESC" name="ROOMDESC" placeholder="Description" type="text" value="<?php echo htmlspecialchars($row["ROOMDESC"], ENT_QUOTES); ?>">
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="NUMPERSON">Number of Persons:</label>
              <input required class="form-control input-sm" id="NUMPERSON" name="NUMPERSON" placeholder="Number of Persons" type="text" value="<?php echo htmlspecialchars($row["NUMPERSON"], ENT_QUOTES); ?>" onkeyup="javascript:checkNumber(this);">
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="PRICE">Price:</label>
              <input required class="form-control input-sm" id="PRICE" name="PRICE" placeholder="Price" type="text" value="<?php echo htmlspecialchars($row["PRICE"], ENT_QUOTES); ?>" onkeyup="javascript:checkNumber(this);">
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="ROOMNUM">No. of Rooms:</label>
              <input required class="form-control input-sm" id="ROOMNUM" name="ROOMNUM" placeholder="Room #" type="text" value="<?php echo htmlspecialchars($row["ROOMNUM"], ENT_QUOTES); ?>">
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="image">Upload Image:</label>
              <input type="file" name="image" id="image" accept="image/*">
              <?php if ($row["ROOMIMAGE"]) { ?>
                <img src="<?php echo htmlspecialchars($row["ROOMIMAGE"], ENT_QUOTES); ?>" alt="Image Preview" id="image-preview" style="display: flex; max-width: 100%; max-height: 200px;">
              <?php } else { ?>
                <img src="#" alt="Image Preview" id="image-preview" style="display: none; max-width: 100%; max-height: 200px;">
              <?php } ?>
              <script>
                const fileInput = document.getElementById('image');
                const imagePreview = document.getElementById('image-preview');

                fileInput.addEventListener('change', function () {
                  const file = fileInput.files[0];

                  if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                      imagePreview.src = e.target.result;
                      imagePreview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                  } else {
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                  }
                });
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
