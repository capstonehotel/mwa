<?php 
echo '<script src="../sweetalert.js"></script>';
$id = $_GET['id'];
$sql = $query = "SELECT * FROM tbluseraccount WHERE USERID = '$id'";
$result = $connection->query($sql);
$row = $result->fetch_assoc();


if (isset($_POST['save_user'])) {
    $UNAME = $_POST['UNAME'];
    $USERNAME = $_POST['USERNAME'];
    if ($row['UPASS'] == $_POST['UPASS']) {
        $UPASS = $row['UPASS'];
    } else {
        $UPASS = sha1($_POST['UPASS']);
    }
    $ROLE = $_POST['ROLE'];
    $PHONE = $_POST['PHONE'];

    $sql = "UPDATE tbluseraccount SET 
          UNAME = '$UNAME',
          USER_NAME = '$USERNAME',
          UPASS = '$UPASS',
          ROLE = '$ROLE',
          PHONE = '$PHONE' 
          WHERE USERID = '$id'";

    if ($connection->query($sql) === TRUE) {
    // echo "<script>alert('User updated successfully!');</script>";
    //         redirect("index.php");
    echo "<script>
                            swal({
                                title: 'Updated!',
                                text: 'User updated successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location = 'index.php';
                            });
                          </script>";
    } else {
        // echo "<script>alert('Error updating user: " . $connection->error . "');</script>";
        echo "<script>
        swal({
            title: 'Error!',
            text: 'Error updating User',
            icon: 'error'
        });
      </script>";
    }

    // Close the database connection
    $connection->close();

}
?>

<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3"  style="display: flex;align-items: center;">
              <h6 class="m-0 font-weight-bold text-primary">Update User</h6>

              <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
            <button type="submit" name="save_user" class="btn btn-success btn-sm mr-2">Update User</button>
              </div>
          </div>
            <div class="card-body" >
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Name:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="UNAME" name="UNAME" placeholder=
                    "Account Name" type="text" value="<?php echo $row['UNAME'] ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Username:</label>

                    <div class="col-md-12">
                       <input type="email" required class="form-control input-sm" id="USERNAME" name="USERNAME" placeholder=
                    "Username" type="text" value="<?php echo $row['USER_NAME'] ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Password:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="UPASS" name="UPASS" placeholder=
                    "Account Password" type="Password" value="<?php echo $row['UPASS'] ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Role:</label>

                    <div class="col-md-12">
                       <select required class="form-control input-sm" name="ROLE" id="ROLE">
                        <option value="<?php echo $row['ROLE'] ?>"><?php echo $row['ROLE'] ?></option>
                  <option value="Administrator">Administrator</option>
                    <option value="Guest In-charge">Guest In-charge</option>
                  <!-- <option value="Encoder">Encoder</option> -->
                </select> 
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Contact:</label>

                    <div class="col-md-12">
                       <input required type="text" class="form-control input-sm" id="PHONE" name="PHONE" placeholder="Contact #:" 
       pattern="[0-9]{11}" title="Please enter a valid 11-digit phone number" value="<?php echo $row['PHONE'] ?>">
                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </form>
</div>