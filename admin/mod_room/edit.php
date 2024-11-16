<?php
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id = intval($_GET['id']); // Sanitize ID

// Fetch room data
$sql = "SELECT * FROM tblroom INNER JOIN tblaccomodation ON tblroom.ACCOMID = tblaccomodation.ACCOMID WHERE ROOMID = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['save_room'])) {
    // Validate CSRF Token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    $errors = []; // Initialize error array
    $uploadDir = 'rooms/';
    $maxFileSize = 5 * 1024 * 1024;
    $ROOMIMAGE = $row["ROOMIMAGE"]; // Default to existing image path

    // Validate inputs
    $ROOM = htmlspecialchars(trim($_POST['ROOM']), ENT_QUOTES, 'UTF-8');
    $ACCOMID = intval($_POST['ACCOMID']);
    $ROOMDESC = htmlspecialchars(trim($_POST['ROOMDESC']), ENT_QUOTES, 'UTF-8');
    $NUMPERSON = filter_var($_POST['NUMPERSON'], FILTER_VALIDATE_INT);
    $PRICE = filter_var($_POST['PRICE'], FILTER_VALIDATE_FLOAT);
    $ROOMNUM = filter_var($_POST['ROOMNUM'], FILTER_VALIDATE_INT);

    if ($NUMPERSON === false || $NUMPERSON < 2) $errors[] = 'Number of persons must be at least 2.';
    if ($PRICE === false || $PRICE < 1000) $errors[] = 'Price must be at least 1000.';
    if ($ROOMNUM === false) $errors[] = 'Room number is required.';
    if (empty($ROOM) || empty($ROOMDESC)) $errors[] = 'Room name and description are required.';

    // Check if the room name already exists
    $checkSql = "SELECT * FROM tblroom WHERE ROOM = ? AND ROOMID != ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->bind_param("si", $ROOM, $id);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        $errors[] = 'Room name already exists. Please choose a different name.';
    }
    $checkStmt->close();

    // Handle file upload if a new file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        if ($_FILES['image']['size'] <= $maxFileSize) {
            $fileInfo = getimagesize($_FILES['image']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if ($fileInfo && in_array($fileInfo['mime'], $allowedTypes)) {
                $filename = uniqid('room_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $uploadPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $ROOMIMAGE = "rooms/$filename";
                } else {
                    $errors[] = 'Error uploading file.';
                }
            } else {
                $errors[] = 'Only valid image files (JPG, JPEG, PNG, WEBP) are allowed.';
            }
        } else {
            $errors[] = 'File size exceeds the 5MB limit.';
        }
    }

    // If no errors, update the database
    if (empty($errors)) {
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
        $stmt->bind_param("ssissdii", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM, $id);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Saved!',
                        text: 'Room updated successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location = 'index.php';
                    });
                  </script>";
        } else {
            $errors[] = 'Error updating room: ' . $stmt->error;
        }
        $stmt->close();
    }

    // Display errors if any
    if (!empty($errors)) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    html: '" . implode('<br>', $errors) . "',
                    icon: 'error'
                });
              </script>";
    }
}
?>



<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3" style="display: flex;align-items: center;">
              <a class="btn btn-primary btn-sm mr-2" href="index.php">Back</a>
              <h6 class="m-0 font-weight-bold text-primary">Update Room</h6>
              <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
                <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Update Room</button>
              </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Name:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ROOM" name="ROOM" placeholder="Room Name" type="text" value="<?php echo htmlspecialchars($row["ROOM"], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMID">Accommodation:</label>
                <div class="col-md-12">
                  <select class="form-control input-sm" name="ACCOMID" id="ACCOMID">
                    <option value="<?php echo $row["ACCOMID"]; ?>"><?php echo htmlspecialchars($row["ACCOMODATION"], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($row["ACCOMDESC"], ENT_QUOTES, 'UTF-8'); ?>)</option>
                    <?php
                    $query = "SELECT * FROM tblaccomodation";
                    $result = mysqli_query($connection, $query);
                    while ($rows = mysqli_fetch_assoc($result)) {
                      echo '<option value='.$rows['ACCOMID'].'>'.htmlspecialchars($rows['ACCOMODATION'], ENT_QUOTES, 'UTF-8').' (' .htmlspecialchars($rows['ACCOMDESC'], ENT_QUOTES, 'UTF-8').')</OPTION>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOMDESC">Description:</label>
                <div class ="col-md-12">
                  <input required class="form-control input-sm" id="ROOMDESC" name="ROOMDESC" placeholder="Description" type="text" value="<?php echo htmlspecialchars($row["ROOMDESC"], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="NUMPERSON">Number of Person:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="NUMPERSON" name="NUMPERSON" placeholder="Number of Person" type="text" value="<?php echo htmlspecialchars($row["NUMPERSON"], ENT_QUOTES, 'UTF-8'); ?>" onkeyup="javascript:checkNumber(this);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="PRICE">Price:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="PRICE" name="PRICE" placeholder="Price" type="text" value="<?php echo htmlspecialchars($row["PRICE"], ENT_QUOTES, 'UTF-8'); ?>" onkeyup="javascript:checkNumber(this);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOMNUM">No. of Rooms:</label>
                <div class="col-md-12">
                  <input required class="form-control input-sm" id="ROOMNUM" name="ROOMNUM" placeholder="Room #" type="text" value="<?php echo htmlspecialchars($row["ROOMNUM"], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
    <div class="col-md-12 col-sm-12">
        <label class="col-md-4 control-label" for="image">Upload Image:</label>
        <div class="col-md-12">
            <input type="file" name="image" id="image" accept="image/*">
            <?php if ($row["ROOMIMAGE"]) { ?>
                <img src="<?php echo htmlspecialchars($row["ROOMIMAGE"], ENT_QUOTES, 'UTF-8'); ?>" alt="Image Preview" id="image-preview" style="display: flex; max-width: 100%; max-height: 200px;">
            <?php } else { ?>
                <img src="#" alt="Image Preview" id="image-preview" style="display: none; max-width: 100%; max-height: 200px;">
            <?php } ?>
            <script>
                document.getElementById('image').addEventListener('change', function() {
                    const file = this.files[0];
                    const imagePreview = document.getElementById('image-preview');

                    if (file) {
                        const fileType = file.type;
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

                        // Check if the selected file is a valid image type
                        if (!validImageTypes.includes(fileType)) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Please select a valid image file (JPEG, PNG, WEBP).',
                                icon: 'error'
                            });
                            this.value = ''; // Clear the input
                        } else {
                            // Create a URL for the selected file and set it as the src for the image preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.src = e.target.result; // Update the image source
                                imagePreview.style.display = 'flex'; // Show the image preview
                            };
                            reader.readAsDataURL(file); // Read the file as a data URL

                            // If there's an existing image, hide it
                            if (imagePreview.src !== "#") {
                                imagePreview.src = "#"; // Clear previous image
                            }
                        }
                    }
                });
            </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>