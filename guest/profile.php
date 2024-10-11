<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    .form-control {
      width: 100%;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .card {
      height: 700px; /* Set your desired fixed height */
      overflow: hidden; /* Hide any overflow content */
    }
    .card-body {
      overflow-y: auto; /* Allow vertical scrolling inside the card-body if needed */
    }
    .form-section {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
<?php 
require_once("../includes/initialize.php");
// load config file first 
// require_once("../includes/config.php");
// //load basic functions next so that everything after can use them
// require_once("../includes/functions.php");
// //later here where we are going to put our class session
// require_once("../includes/session.php");
// require_once("../includes/user.php");
// require_once("../includes/pagination.php");
// require_once("../includes/paginsubject.php");
// require_once("../includes/accomodation.php");
// require_once("../includes/guest.php");
// require_once("../includes/reserve.php"); 
// require_once("../includes/setting.php");
// //Load Core objects
// require_once("../includes/database.php");
  
$guest = New Guest();
$res = $guest->single_guest($_SESSION['GUESTID']);

?>
<div class="container" style="max-width: 1200px; padding: 20px; margin-top: 20px;">
  <form class="form-horizontal" action="https://mcchmhotelreservation.com/guest/update.php" method="post" onsubmit="return personalInfo()" name="personal">
    <div class="card">
      <div class="card-body">
        <h1>My Account</h1>
        <div class="row">
          <!-- Left Side (6 fields) -->
          <div class="col-md-6 form-section">
            <div class="form-group">
              <label for="firstName" class="form-label">First Name:</label>
              <input name="name" type="text" value="<?php echo $res->G_FNAME; ?>" class="form-control" id="firstName" placeholder="First Name">
            </div>
            <div class="form-group">
              <label for="lastName" class="form-label">Last Name:</label>
              <input name="last" type="text" value="<?php echo $res->G_LNAME; ?>" class="form-control" id="lastName" placeholder="Last Name">
            </div>
            <div class="form-group">
              <label for="genderSelect" class="form-label">Gender:</label>
              <select name="gender" class="form-control" id="genderSelect">
                <option value="" disabled selected>Select Gender</option>
                <option value="Male" <?php echo ($res->G_GENDER == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($res->G_GENDER == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($res->G_GENDER == 'Other') ? 'selected' : ''; ?>>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label for="city" class="form-label">City:</label>
              <input name="city" type="text" value="<?php echo $res->G_CITY; ?>" class="form-control" id="city" placeholder="City">
            </div>
            <div class="form-group">
              <label for="address" class="form-label">Address:</label>
              <input name="address" type="text" value="<?php echo $res->G_ADDRESS; ?>" class="form-control" id="address" placeholder="Address">
            </div>
            <div class="form-group">
              <label for="dbirth" class="form-label">Date of Birth:</label>
              <input type="text" name="dbirth" value="<?php echo date($res->DBIRTH); ?>" class="form-control" id="dbirth" placeholder="Date of Birth">
            </div>
          </div>

          <!-- Right Side (5 fields) -->
          <div class="col-md-6 form-section">
            <div class="form-group">
              <label for="phone" class="form-label">Phone:</label>
              <input name="phone" type="text" value="<?php echo $res->G_PHONE; ?>" class="form-control" id="phone" placeholder="Phone">
            </div>
            <div class="form-group">
              <label for="nationality" class="form-label">Nationality:</label>
              <input name="nationality" type="text" value="<?php echo $res->G_NATIONALITY; ?>" class="form-control" id="nationality" placeholder="Nationality">
            </div>
            <div class="form-group">
              <label for="company" class="form-label">Company:</label>
              <input name="company" type="text" value="<?php echo $res->G_COMPANY; ?>" class="form-control" id="company" placeholder="Company">
            </div>
            <div class="form-group">
              <label for="caddress" class="form-label">Company Address:</label>
              <input name="caddress" type="text" value="<?php echo $res->G_CADDRESS; ?>" class="form-control" id="caddress" placeholder="Company Address">
            </div>
            <div class="form-group">
              <label for="zip" class="form-label">Zip Code:</label>
              <input name="zip" type="text" value="<?php echo $res->ZIP; ?>" class="form-control" id="zip" placeholder="Zip Code">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-end">
            <input name="submit" type="submit" value="Save" class="btn btn-primary" onclick="return personalInfo();"/>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
<script type="text/javascript">
  // Validates Personal Info
  function personalInfo(){
    var a = document.forms["personal"]["name"].value;
    var b = document.forms["personal"]["last"].value;
    var b1 = document.forms["personal"]["gender"].value;
    var c = document.forms["personal"]["city"].value;
    var d = document.forms["personal"]["address"].value;
    var e = document.forms["personal"]["dbirth"].value;  
    var f = document.forms["personal"]["zip"].value; 
    var g = document.forms["personal"]["phone"].value;
    var h = document.forms["personal"]["username"].value;
    var i = document.forms["personal"]["password"].value;

    if (document.personal.condition.checked == false) {
      Swal.fire({
    icon: 'error',
    title: 'Terms and Conditions',
    text: 'Please agree to the terms and conditions of this hotel',
  });
  return false;
}
    if ((a == "Firstname" || a == "") || (b == "lastname" || b == "") || (b1 == "gender" || b1 == "") || (c == "City" || c == "") || (d == "address" || d == "") || (e == "dateofbirth" || e == "") || (f == "Zip" || f == "") || (g == "Phone" || g == "") || (h == "username" || h == "") || (i == "password" || i == "")) {
      alert("All fields are required!");
      return false;
    }
  }
</script>
</body>
</html>
