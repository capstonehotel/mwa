<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 


<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> Include SweetAlert2 -->
<?php

if (isset($_GET['view']) && $_GET['view'] == 'payment' && isset($_GET['verify']) && $_GET['verify'] == 'true') {
    // var_dump($_GET['view']);
    // var_dump($_GET['verify']);

    ?>
  <script>
        console.log('SweetAlert2 script is running'); // JS log
        

        // Function to show the OTP input prompt
        function showOtpInput() {
            console.log('Showing OTP input prompt'); // Debugging log
            Swal.fire({
                title: 'Enter OTP',
                input: 'text',
                inputPlaceholder: 'Enter OTP code',
                showCancelButton: true,
                confirmButtonText: 'Verify OTP',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                footer: `Didn't receive a code? <a href="#" id="resend-otp-link">Resend</a>`,
            }).then((result) => {
                if (result.value) {
                    console.log('OTP entered:', result.value); // Debugging log for OTP entered

                    $.ajax({
                        type: 'POST',
                        url: 'otp_verify.php',
                        data: {
                            otp: result.value,
                            email: '<?php echo $_SESSION['username']; ?>'
                        },
                        success: function(response) {
                            console.log('OTP verification response:', response); // Debugging log for response
                            if (response.trim() == 'valid') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OTP Verified!',
                                    text: 'You will be redirected to the payment in 3 seconds.',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    willClose: () => {
                                        window.location.href = 'index.php?view=payment';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid OTP!',
                                    text: 'The OTP you entered is incorrect. Please try again or click "Resend" to receive a new code.',
                                    showConfirmButton: true
                                }).then(() => {
                                    // Show the OTP input again if the OTP is invalid
                                    showOtpInput(); // Call the function to show the OTP input again
                                });
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Handle cancel action
                    var referer = document.referrer; // Get the referer URL
                    if (referer.includes('personalinfo.php')) {
                        window.location.href = 'personalinfo.php'; // Redirect to personalinfo.php
                    } else if (referer.includes('login.php')) {
                        window.location.href = '../logout.php'; // Redirect to logout.php
                    } else {
                        window.location.href = 'https://mcchmhotelreservation.com/booking/index.php?view=logininfo'; // Default redirect
                    }
                }
            });
        }

        // Show the OTP input prompt when the page loads
        showOtpInput();

        // Event listener for "Resend OTP" link
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'resend-otp-link') {
                e.preventDefault(); // Prevent default link behavior
                console.log('Resend OTP clicked'); // Debugging log for Resend OTP

                $.ajax({
                    type: 'POST',
                    url: 'resendOTP.php',
                    data: {
                        email: '<?php echo $_SESSION['username']; ?>'
                    },
                    success: function(response) {
                        console.log('OTP resend response:', response); // Debugging log for resend response

                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Resent!',
                            text: 'Please check your email for the new OTP.',
                            showConfirmButton: true
                        }).then(() => {
                            // After the user acknowledges the success message, show the OTP input again
                            showOtpInput(); // Call the function to show the OTP input
                        });
                    }
                });
            }
        });
    </script>

    <?php
}
?>

<?php
if (!isset($_SESSION['monbela_cart'])) {
  # code...
  redirect(WEB_ROOT.'index.php');
}

function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";

    srand((double)microtime()*1000000);

    $i = 0;

    $pass = '' ;
    while ($i <= 7) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;

    }

    return $pass;

}

 $confirmation = createRandomPassword();
$_SESSION['confirmation'] = $confirmation;



// $arival    = $_SESSION['from']; 
// $departure = $_SESSION['to'];
// echo $name      = $_SESSION['name']; 
// echo $last      = $_SESSION['last'];
// echo $nationality   = $_SESSION['nationality'];
// // echo // $city      = $_SESSION['city'] ;
// echo $address   =  $_SESSION['city'] . ' ' . $_SESSION['address'];
// echo $zip       = $_SESSION['zip'] ;
// echo $phone     = $_SESSION['phone'];
// echo $username     = $_SESSION['username'];
// echo $company     = $_SESSION['company'];
// echo $caddress     = $_SESSION['caddress'];
// echo $password  = $_SESSION['pass'];
// echo $dbirth   = $_SESSION['dbirth'];


 $count_cart = count($_SESSION['monbela_cart']);

// if(isset($_POST['btnsubmitbooking'])){

if (isset($_POST['btnsubmitbooking']) || isset($_SESSION['payment_successful'])) { 
    if (isset($_SESSION['payment_successful'])) {
        // If payment was successful, submit the form
        echo "<script>
            document.getElementById('bookingForm').submit();
        </script>";
        unset($_SESSION['payment_successful']); // Clear the session variable
    }


//    $count_cart = count($_SESSION['monbela_cart']);

//   for ($i=0; $i < $count_cart  ; $i++) {     
//   $mydb->setQuery("SELECT * FROM room where roomNo=". $_SESSION['monbela_cart'][$i]['monbelaroomid']);
//   $rmprice = $mydb->executeQuery();
//   while($row = mysql_fetch_assoc($rmprice)){
//     $rate = $row['price']; 
//   }  
// }
//   $payable= $rate*$days;
//   $_SESSION['pay']= $payable;

if(!isset($_SESSION['GUESTID'])){

  // var_dump($_SESSION);exit;

$guest = New Guest();
$guest->G_AVATAR          = $_SESSION['image'];
$guest->G_FNAME          = $_SESSION['name'];    
$guest->G_LNAME          = $_SESSION['last'];
$guest->G_GENDER         = $_SESSION['gender'];    
$guest->G_CITY           = $_SESSION['city'];
$guest->G_ADDRESS        = $_SESSION['address'] ;        
$guest->DBIRTH           = date_format(date_create($_SESSION['dbirth']), 'Y-m-d');   
$guest->G_PHONE          = $_SESSION['phone'];    
$guest->G_NATIONALITY    = $_SESSION['nationality'];          
$guest->G_COMPANY        = $_SESSION['company'];      
$guest->G_CADDRESS       = $_SESSION['caddress'];        
$guest->G_TERMS          = 1;    
$guest->G_UNAME          = $_SESSION['username'];    
$guest->G_PASS           = sha1($_SESSION['pass']);    
$guest->ZIP              = $_SESSION['zip'];

   
$guest->create(); 
  $lastguest=$guest->id; 
   
$_SESSION['GUESTID'] =   $lastguest;

}
 
    $count_cart = count($_SESSION['monbela_cart']);
  

    for ($i=0; $i < $count_cart  ; $i++) { 

            // $rm = new Room();
            // $result = $rm->single_room($_SESSION['monbela_cart'][$i]['monbelaroomid']);

            // if($result->ROOMNUM>0){

            //   $room = new Room(); 
            //   $room->ROOMNUM    = $room->ROOMNUM - 1; 
            //   $room->update($_SESSION['monbela_cart'][$i]['monbelaroomid']); 
      
            // }
            

            $reservation = new Reservation();
            $reservation->CONFIRMATIONCODE  = $_POST['realconfirmation'];
            $reservation->TRANSDATE         = date('Y-m-d h:i:s'); 
            $reservation->ROOMID            = $_SESSION['monbela_cart'][$i]['monbelaroomid'];
            $reservation->ARRIVAL           = date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckin']), 'Y-m-d');  
            $reservation->DEPARTURE         = date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckout']), 'Y-m-d'); 
            $reservation->RPRICE            = $_SESSION['monbela_cart'][$i]['monbelaroomprice'];  
            $reservation->GUESTID           = $_SESSION['GUESTID']; 
            $reservation->PRORPOSE          = 'Travel';
            $reservation->STATUS            = 'Pending';
            $reservation->create(); 

            
            @$tot += $_SESSION['monbela_cart'][$i]['monbelaroomprice'];
            }

           $item = count($_SESSION['monbela_cart']);
           

      $sql = "INSERT INTO `tblpayment` (`TRANSDATE`,`CONFIRMATIONCODE`,`PQTY`, `GUESTID`, `SPRICE`,`MSGVIEW`,`STATUS`  )
       VALUES ('" .date('Y-m-d h:i:s')."','" . $_POST['realconfirmation'] ."',".$item."," . $_SESSION['GUESTID'] . ",".$tot.",0,'Pending' )" ;
        // mysql_query($sql);





     $mydb->setQuery($sql);
     $msg = $mydb->executeQuery();

     

    //   $lastreserv=mysql_insert_id(); 
    //   $mydb->setQuery("INSERT INTO `comments` (`firstname`, `lastname`, `email`, `comment`) VALUES('$name','$last','$email','$message')");
    //   $msg = $mydb->executeQuery();
    //   message("New [". $name ."] created successfully!", "success");

  //  unsetSessions();

            unset($_SESSION['monbela_cart']);
            // unset($_SESSION['confirmation']);
            unset($_SESSION['pay']);
            unset($_SESSION['from']);
            unset($_SESSION['to']);
            $_SESSION['activity'] = 1;


            
            ?> 
           
<script type="text/javascript">
    Swal.fire({
        title: 'Success!',
        text: 'Booking is successfully submitted!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect after confirmation
            window.location.href = "index.php";
        }
    });
</script>
<?php }?>

 
<!-- Add this in your HTML head section -->

<div class="card rounded" style="padding: 10px;">
    <div class="pagetitle">
        <h1>Billing Details</h1>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 10px;">
            <li class="breadcrumb-item"><a href="<?php echo WEB_ROOT; ?>index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo WEB_ROOT; ?>booking/">Booking Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Billing Details</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <form action="index.php?view=payment" method="post" name="personal" enctype="multipart/form-data" id="bookingForm">
                <div class="col-md-8 col-sm-4">
                    <div class="col-md-12">
                        <label>Name:</label>
                        <?php echo $_SESSION['name'] . ' ' . $_SESSION['last']; echo $count_cart; ?>
                    </div>
                    <div class="col-md-12">
                        <label>Address:</label>
                        <?php echo isset($_SESSION['city']) ? $_SESSION['city'] : ' ' . ' ' . (isset($_SESSION['address']) ? $_SESSION['address'] : ' '); ?> 
                    </div>
                    <div class="col-md-12">
                        <label>Phone #:</label>
                        <?php echo $_SESSION['phone']; ?>
                    </div>
                </div>
                
                    <div class="col-md-12">
                        <label>Transaction Date:</label>
                        <?php echo date("m/d/Y"); ?>
                    </div>
                    
                    <div class="col-md-12">
    <label style="display: none;" >Transaction Id:</label>
    <span style="display: none;"><?php echo $_SESSION['confirmation']; ?></span>
    <input type="hidden" name="realconfirmation" value="<?php echo $_SESSION['confirmation']; ?>" />
    <input type="hidden" id="payment_status_input"  name="txtstatus">
</div>
<div class="col-md-12 col-sm-2">
    <label for="paymentAmount" id="paymentLabel">Select Payment Option:</label>
    <div>
        <select id="paymentAmount" name="payment_amount" required>
            <option value="full">Full Payment</option>
            <option value="partial">Partial Payment</option>
        </select>
    </div>
</div>

<div class="col-md-12 col-sm-2">
        <label id="paymentLabel">Payment Method:</label>
        <div>
            <input type="radio" id="gcash" name="payment_method" value="gcash" required>
            <label for="gcash">
                <img src="../gcash.png" alt="Pay with GCash" style="height: 20px; margin-right: 5px;">
                Pay with GCash
            </label>
        </div>
        <input type="hidden" name="realconfirmation" value="<?php echo $confirmationCode; ?>" />
        </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Room</td>
                                <td>Checked in</td>
                                <td>Checked out</td>
                                <td>Price</td>
                                <td>Night(s)</td>
                                <td>Subtotal</td>
                            </tr>
                        </thead>
                      
<?php
$payable = 0;
if (isset( $_SESSION['monbela_cart'])){ 
$count_cart = count($_SESSION['monbela_cart']);


for ($i=0; $i < $count_cart  ; $i++) {  

  $query = "SELECT * FROM `tblroom` r ,`tblaccomodation` a WHERE r.`ACCOMID`=a.`ACCOMID` AND ROOMID=" . $_SESSION['monbela_cart'][$i]['monbelaroomid'];
   $mydb->setQuery($query);
   $cur = $mydb->loadResultList(); 
    foreach ($cur as $result) { 


?>

      
        <tr>
          <td><?php echo  $result->ROOM.' '. $result->ROOMDESC; ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckin']),"m/d/Y"); ?></td>
          <td><?php echo  date_format(date_create( $_SESSION['monbela_cart'][$i]['monbelacheckout']),"m/d/Y"); ?></td>
          <td><?php echo  ' &#8369 '. $result->PRICE; ?></td>
          <td><?php echo   $_SESSION['monbela_cart'][$i]['monbeladay']; ?></td>
          <td><?php echo ' &#8369 '.   $_SESSION['monbela_cart'][$i]['monbelaroomprice']; ?></td>
        </tr>
<?php
       $payable += $_SESSION['monbela_cart'][$i]['monbelaroomprice'] ;
      }

    } 
     $_SESSION['pay'] = $payable;
 } 
 ?> 
      </tbody>
                 </table>
            </div>

                <div id="confirmModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" >
            <div class="modal-body">
                <p>Are you sure you want to submit the booking?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="confirmBookingButton" class="btn btn-primary">Yes</button>
                <!-- <button type="submit" class="btn btn-primary" align="right" name="btnsubmitbooking">Yes</button> -->
            </div>
        </div>
    </div>
</div>


<div class="row"> 
  <h3 align="right">Total: &#8369 <?php echo   $_SESSION['pay'] ;?></h3>
</div>

    <div class="pull-right flex-end" align="right">
    <button  type="button" id="submitBookingButton" class="btn btn-primary" align="right" data-toggle="modal" data-target="#confirmModal">Pay and Submit Booking</button>
       <!-- <button  type="button"  id="submitBookingButton" class="btn btn-primary" align="right" onclick="submitBooking()" >Submit Booking</button> -->
    </div>
</form>
  </div>  
  

  
        </div>
      </div>
</div>

<!-- <script>
    // Event listener for the "Yes" button in the modal
    document.getElementById('confirmBookingButton').addEventListener('click', function() {
    });
</script> -->
    <script>
document.getElementById('confirmBookingButton').addEventListener('click', function() {
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    const selectedPayment = document.getElementById('paymentAmount').value;
    
    if (selectedMethod) {
        // Adjust payment amount based on selected option
        let paymentAmount = <?php echo $_SESSION['pay']; ?>; // Full amount
        if (selectedPayment === 'partial') {
            paymentAmount /= 2; // Half for partial payment
        }

        // Prepare form data with payment method and adjusted amount
        const formData = new FormData();
        formData.append('payment_method', selectedMethod.value);
        formData.append('payment_amount', paymentAmount);

        // Send the form data via fetch to source.php
        fetch('source.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Expecting a JSON response
        .then(data => {
            if (data.checkoutUrl) {
                // Redirect to the GCash checkout URL
                window.location.href = data.checkoutUrl;
            } else {
                alert('Error: ' + data.message); // Handle error response
            }
        })
        .catch(error => {
            console.error('Error:', error); // Handle error
        });
    } else {
        alert('Please select a payment method.'); // Ensure a payment method is selected
    }
});
</script>

