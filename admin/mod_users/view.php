<?php 
if (isset($_POST['save_user'])) {
    $UNAME = $_POST['UNAME'];
    $USERNAME = $_POST['USERNAME'];
    $UPASS = $_POST['UPASS'];
    $ROLE = $_POST['ROLE'];
    $PHONE = $_POST['PHONE'];
    echo $PHONE;
    $sql = "INSERT INTO tbluseraccount (UNAME, USER_NAME, UPASS, ROLE, PHONE)
    VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    
    // Check if the prepare statement succeeded
    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("ssiss", $UNAME, $USERNAME, $UPASS, $ROLE, $PHONE);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('New user saved successfully!');</script>";
            redirect("index.php");
        } else {
            echo "<script>alert('Error adding new user: ". $stmt->error . "');</script>";
        }
        
        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the statement: ". $connection->error . "');</script>";
    }
}
?>

<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3"  style="display: flex;align-items: center;">
              <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>

              <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
            <button type="submit" name="save_user" class="btn btn-success btn-sm mr-2">Save User</button>
              </div>
          </div>
            <div class="card-body" >
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Name:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="UNAME" name="UNAME" placeholder=
                    "Account Name" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Username:</label>

                    <div class="col-md-12">
                       <input type="email" required class="form-control input-sm" id="USERNAME" name="USERNAME" placeholder=
                    "Username" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Password:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="UPASS" name="UPASS" placeholder=
                    "Account Password" type="Password" value="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Role:</label>

                    <div class="col-md-12">
                       <select required class="form-control input-sm" name="ROLE" id="ROLE">
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
       pattern="[0-9]{11}" title="Please enter a valid 11-digit phone number" value="">
                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </form>
</div>