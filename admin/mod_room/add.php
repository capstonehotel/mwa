<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (isset($_POST['save_room'])) {
    $uploadDir = 'rooms/';
    $maxFileSize = 5 * 1024 * 1024; // 5MB limit
    $errors = [];
    $roomExists = false;

    // Sanitize and validate inputs
    $ROOM = htmlspecialchars(trim($_POST['ROOM']), ENT_QUOTES, 'UTF-8');
    $ACCOMID = intval($_POST['ACCOMID']);
    $ROOMDESC = htmlspecialchars(trim($_POST['ROOMDESC']), ENT_QUOTES, 'UTF-8');
    $NUMPERSON = filter_var($_POST['NUMPERSON'], FILTER_VALIDATE_INT);
    $PRICE = filter_var($_POST['PRICE'], FILTER_VALIDATE_FLOAT);
    $ROOMNUM = filter_var($_POST['ROOMNUM'], FILTER_VALIDATE_INT);

    // Validate numeric inputs
    if ($NUMPERSON === false || $NUMPERSON < 2) {
        $errors[] = 'Number of persons must be at least 2.';
    }
    if ($PRICE === false || $PRICE < 1000) {
        $errors[] = 'Price must be at least 1000.';
    }
    if ($ROOMNUM === false) {
        $errors[] = 'Room number is required.';
    }

    if (empty($ROOM) || empty($ROOMDESC)) {
        $errors[] = 'Room name and description are required.';
    }

    // Check if the room name already exists
    $checkSql = "SELECT * FROM tblroom WHERE ROOM = ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->bind_param("s", $ROOM);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $errors[] = 'Room name already exists. Please choose a different name.';
        $roomExists = true;
    }

    $checkStmt->close();

    // Only proceed if there are no errors
    if (empty($errors)) {
        // Check for image file upload
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                if ($file['size'] <= $maxFileSize) {
                    $fileInfo = getimagesize($file['tmp_name']);
                    if ($fileInfo && in_array($fileInfo['mime'], ['image/jpeg', 'image/png', 'image/webp'])) {
                        $filename = uniqid('room_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                        $uploadPath = $uploadDir . $filename;
                        $ROOMIMAGE = "rooms/$filename";

                        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                            $sql = "INSERT INTO tblroom (ROOMIMAGE, ROOM, ACCOMID, ROOMDESC, NUMPERSON, PRICE, ROOMNUM)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $connection->prepare($sql);
                            $stmt->bind_param("ssisidi", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM);

                            if ($stmt->execute()) {
                                echo "<script>
                                        Swal.fire({
                                            title: 'Saved!',
                                            text: 'New room saved successfully!',
                                            icon: 'success'
                                        }).then(() => {
                                            window.location = 'index.php';
                                        });
                                      </script>";
                            } else {
                                $errors[] = 'Error adding new room: ' . htmlspecialchars($stmt->error);
                            }

                            $stmt->close();
                        } else {
                            $errors[] = 'Error uploading file.';
                        }
                    } else {
                        $errors[] = 'Only valid image files (JPG, JPEG, PNG, WEBP) are allowed.';
                    }
                } else {
                    $errors[] = 'File size exceeds the 5MB limit.';
                }
            } else {
                $errors[] = 'Error with file upload.';
            }
        } else {
            $errors[] = 'No file was uploaded.';
        }
    }

    // Handle errors
    if (!empty($errors)) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    html: '" . implode('<br>', $errors) . "',
                    icon: 'error'
                }).then(() => {
                    // If room name exists, clear it in the input field
                    if ($roomExists) {
                        document.getElementById('ROOM').value = '';
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
              <h6 class="m-0 font-weight-bold text-primary">Add New Room</h6>
              <div class="text-right" style="width: 100%; display: flex; justify-content: flex-end;">
                <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Save Room</button>
              </div>
          </div>
          <div class="card-body">
              <!-- Room Name Input -->
              <div class="form-group">
                <label for="ROOM">Name:</label>
                <input required class="form-control" id="ROOM" name="ROOM"  placeholder="Room Name" type="text" value="<?= isset($ROOM) ? htmlspecialchars($ROOM) : ''; ?>">
              </div>
              <!-- Accommodation Selection -->
              <div class="form-group">
                <label for="ACCOMID">Accommodation:</label>
                <select class="form-control" name="ACCOMID" id="ACCOMID"> 
                  <?php
                  $query = "SELECT * FROM tblaccomodation";
                  $result = mysqli_query($connection, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['ACCOMID'] == $ACCOMID) ? 'selected' : '';
                    echo '<option value="'.$row['ACCOMID'].'" '.$selected.'>'.htmlspecialchars($row['ACCOMODATION']).' ('.htmlspecialchars($row['ACCOMDESC']).')</option>';
                  }
                  ?>
                </select>
              </div>
              <!-- Room Description -->
              <div class="form-group">
                <label for="ROOMDESC">Description:</label>
                <input required class="form-control" id="ROOMDESC" name="ROOMDESC"  pattern="^(?!\s*$)[A-Za-z\s.,]+$" placeholder="Description" type="text" value="<?= isset($ROOMDESC) ? htmlspecialchars($ROOMDESC) : ''; ?>">
              </div>
              <!-- Number of Persons -->
              <div class="form-group">
                <label for="NUMPERSON">Number of Persons:</label>
                <input required class="form-control" id="NUMPERSON" name="NUMPERSON" placeholder="Number of Persons" type="number" min="2" value="<?= isset($NUMPERSON) ? $NUMPERSON : ''; ?>">
              </div>
              <!-- Room Price -->
              <div class="form-group">
                <label for="PRICE">Price:</label>
                <input required class="form-control" id="PRICE" name="PRICE" placeholder="Price (minimum 1000)" type="number" min="1000" value="<?= isset($PRICE) ? $PRICE : ''; ?>">
              </div>
              <!-- Room Number -->
              <div class="form-group">
                <label for="ROOMNUM">Room Number:</label>
                <input required class="form-control" id="ROOMNUM" name="ROOMNUM"  placeholder="Room #" type="number" value="<?= isset($ROOMNUM) ? $ROOMNUM : ''; ?>">
              </div>
              <!-- Image Upload -->
              <div class="form-group">
                <label for="image">Upload Image:</label>
                <input required type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .webp">
                <img src="#" alt="Image Preview" id="image-preview" style="display: none; max-width: 100%; max-height: 200px;">
                <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const fileInput = event.target;
            const filePath = fileInput.value;
            const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i; // Allowed file extensions
            const file = fileInput.files[0];

            // Check for double extensions
            const fileName = file ? file.name : '';
            const fileType = file ? file.type : '';
            const validImageTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const imagePreview = document.getElementById('image-preview');

            // Check if there are multiple dots and if the last extension is valid
            if (fileName.split('.').length > 2 || !allowedExtensions.exec(filePath) || !validImageTypes.includes(fileType)) {
                // Show SweetAlert2 error message
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please upload a valid image file (JPG, JPEG, PNG, WEBP).',
                    confirmButtonText: 'OK'
                });
                fileInput.value = ""; // Clear the input
                imagePreview.style.display = 'none'; // Hide the preview
                return false;
            } else {
                // If valid, show the image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Update the image source
                    imagePreview.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });
    </script>
                <!-- <script>
                document.getElementById('image').addEventListener('change', function() {
                    const file = this.files[0];
                    const imagePreview = document.getElementById('image-preview');

                    if (file) {
                        const fileType = file .type;
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

                        // Check if the selected file is a valid image type
                        if (!validImageTypes.includes(fileType)) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Please select a valid image file (JPEG, PNG, WEBP).',
                                icon: 'error'
                            });
                            this.value = ''; // Clear the input
                            imagePreview.style.display = 'none'; // Hide image preview
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
                </script> -->

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