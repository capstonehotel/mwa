<!-- Contact Section -->
<?php  
  if (isset($_POST['submit'])){

    $name   = $_POST['name']; 
    $email   = $_POST['email']; 
    $message   = $_POST['message']; 

    $sql = "INSERT INTO `tblcontact` (`CONT_NAME`,`CONT_EMAIL`,`CONT_MESSAGE`,`CONT_CREATED_AT`)
       VALUES ('" . $name  ."','" . $email ."','" . $message ."','" .date('Y-m-d h:i:s')."')" ;
        // mysql_query($sql);

     $mydb->setQuery($sql);
     $msg = $mydb->executeQuery();

     if($msg){
      $alertMessage = "Thank you, $name! Your message has been sent to administrator.";
      echo '<script>alert("' . $alertMessage . '");</script>';
     }

  }
?>
<div class="card rounded" style="padding: 10px;">
    <div class="container">
        <div class="row">
          <div class="modal-header">
            <h3><strong>Contact</strong> us</h3>
          </div>
          <div class="col-md-4 col-sm-12 py-2">
             <h5>Contact Info</h5>
             <div class="space"></div>
              <p><i class="fa fa-building-o fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://web.facebook.com/madridejoscollege';">Madridejos Community College</span></p>
              <div class="space"></div>
              <div class="space"></div>
              <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://www.google.com/maps/place/Madridejos+Community+College/@11.2636504,123.7209869,17z/data=!3m1!4b1!4m6!3m5!1s0x33a88140310a21a9:0xc5b9b94e9c2702db!8m2!3d11.2636451!4d123.7235618!16s%2Fg%2F1hc28c7s2?entry=ttu';">Crossing Bunakan Madridejos Cebu</span></p>
              <div class="space"></div>
              <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='mailto:Hmhotel@gmail.com';">Hmhotel@gmail.com</span></p>
              <div class="space"></div>
              <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='tel:+1234567890';">09317622381</p>
              <p><i class="fa fa-facebook fa-fw pull-left fa-2x"></i><span class="link-text" onclick="window.location.href='https://web.facebook.com/p/Madridejos-Community-College-Hospitality-Management-Department-100054453806197/?paipv=0&eav=AfYUS3bOnNWDmiBS86XIEqDgKwonPli4DFEY8cjKFQSxZq-ZEAJASAViws-aNONi-rM&_rdc=1&_rdr';">Hospitality Management Department</span></p>
              <div class="space"></div>
              <div class="container">
    
  </div>
          </div>
          <div class="col-md-8 col-sm-12 py-2">
            <h5>Leave us a message!</h5>
            <form method="POST">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <input type="text"  id="name" name="name" class="form-control" placeholder="Name" required="required">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <input type="email"   id="email" name="email" class="form-control" placeholder="Email" required="required">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                    <textarea name="message"  id="message" class="form-control" rows="4" placeholder="Message" required></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <button type="submit" name="submit"  class="btn btn-success">Send Message</button>
                </div>
              </div>
            </form>
          </div>

        </div>
    </div>
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
        
        const firstInput = document.getElementById('name');
        const lastInput = document.getElementById('email');
        const phoneInput = document.getElementById('message');
        
        detectXSS(firstInput, 'Name');
        detectXSS(lastInput, 'Email');
        detectXSS(phoneInput, 'Message');
        
    });
</script>

<script type="text/javascript">
  
function displayCustomAlert(message) {
    document.getElementById("customAlertMessage").textContent = message;
    document.getElementById("customAlert").style.display = "flex";
}

// Close the custom alert
document.getElementById("customAlertClose").addEventListener("click", function() {
    document.getElementById("customAlert").style.display = "none";
});

</script>

<!-- <?php
if(isset($_POST['submit'])){
// Check for empty fields
if(empty($_POST['name'])        ||
   empty($_POST['email'])       ||
   empty($_POST['message']) ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
    echo "No arguments Provided!";
    return false;
   }
    
$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
    
// Create the email and send the message
$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address"; 
mail($to,$email_subject,$email_body,$headers);
return true;
}           
?> -->