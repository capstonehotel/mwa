
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<?php

if (isset($_GET['view']) && $_GET['view'] == 'payment' && isset($_GET['verify'])) {
    var_dump($_GET['view']);
    var_dump($_GET['verify']);

    ?>
  <script>
    console.log('SweetAlert2 script is running');
    
    Swal.fire({
        title: 'Enter OTP',
        input: 'text',
        inputPlaceholder: 'Enter OTP code',
        showCancelButton: true,
        confirmButtonText: 'Verify OTP',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            // Verify OTP
            //console.log('Entered OTP:', result.value);

            $.ajax({
                type: 'POST',
                url: 'otp_verify.php',
                data: {
                    otp: result.value, email: '<?php echo $_SESSION['username'];?>'
                   
                },
                success: function(response) {
    if (response.trim() == 'valid') {
        // OTP is valid, display success message with icon and timer
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
        // OTP is invalid, display error message with icon
        Swal.fire({
            icon: 'error',
            title: 'Invalid OTP!',
            text: response,
            showConfirmButton: true
        }).then(() => {
        window.location.href = 'index.php?view=logininfo';
   
        });
    }
}

            });
        }
    });
</script>

    <?php
} else {
    // Payment page content
}
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  -->


<!-- CSS for Pop-out Animation -->
<style>
 /* Add animation to modals */
@keyframes popout {
    0% {
        transform: scale(0.5); /* Start at 50% size */
        opacity: 0;
    }
    100% {
        transform: scale(1); /* End at full size */
        opacity: 1;
    }
}
/* Square QR Code Frame */
.qrcode {
    width: 60%; /* Adjust size for mobile */
    aspect-ratio: 1 / 1; /* Maintain square aspect ratio */
    border: 1px solid #d3d3d3; /* Add a border line */
    border-radius: 8px; /* Optional: rounded corners for the border */
    margin: 10px auto; /* Center the QR code horizontally */
    display: flex; /* Flexbox for centering image */
    align-items: center; /* Center image vertically */
    justify-content: center; /* Center image horizontally */
    position: relative; /* Positioning context for the image */
}

/* Container to ensure square fit for images */
.qrcode img {
    position: absolute; /* Position image within the square */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Center image within container */
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensure image covers the square without distortion */
}


/* Modal for Larger Screens (Rectangular) */
@media (min-width: 768px) {
    .modal-dialog {
        max-width: 800px; /* Wider modal for larger screens */
        margin: 1.75rem auto;
    }

    .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row; /* Side-by-side layout for large screens */
    }

    .modal-content {
        border-radius: 8px; /* Rounded corners */
        max-height: 75vh; /* Limit height for rectangular shape */
        overflow-y: auto; /* Enable scroll if content exceeds height */
    }

    .qrcode {
        width: 100%; /* Larger QR code for larger screens */
        margin: 20px auto; /* Center horizontally */
    }

    .modal-body img {
        max-width: 100%; /* Ensure image does not exceed modal width */
        max-height: 75vh; /* Limit image height to keep modal size manageable */
        object-fit: contain; /* Preserve image aspect ratio */
        border-radius: 8px; /* Optional: rounded corners for the image */
    }

    /* Payment Details Styling */
    .payment-details {
        margin-left: 20px;
        margin-top: 20px;
        text-align: left; /* Align text to the left */
        width: 100%; /* Full width for left-alignment */
    }

    .payment-details p {
        margin: 5px 0; /* Add margin between lines */
        font-size: 16px; /* Adjust font size as needed */
    }
}

/* Modal for Smaller Screens (Mobile - Shrink and Zoom-out effect) */
@media (max-width: 767.98px) {
    .modal-dialog {
        width: 80%; /* Smaller modal width on mobile */
        max-width: none;
        margin: 1rem auto;
        transform: scale(0.9); /* Zoom-out effect to shrink modal */
    }

    .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column; /* Stack content vertically for mobile */
    }

    .modal-content {
        border-radius: 8px; /* Rounded corners */
        max-height: 75vh; /* Limit height to make it more square-like */
        overflow-y: auto; /* Enable scroll if content exceeds height */
        transform: scale(0.9); /* Shrink content slightly */
    }

    /* Ensure QR Code Frame is centered and maintains aspect ratio */
    .qrcode {
        width: 80%; /* Adjust size for mobile */
        margin: 10px auto; /* Center horizontally */
    }

    /* Payment details aligned to the left */
    .payment-details {
        margin-top: 20px;
        text-align: left; /* Align text to the left */
        width: 100%; /* Full width for left-alignment */
    }

    /* Proof of Payment input comes last */
    .proof-of-payment {
        margin-top: 20px;
        text-align: center; /* Center align */
    }

    /* Optional: Adjust file input */
    .form-control-file {
        display: inline-block;
        width: 100%;
    }
}

/* Full Payment Modal Adjustments */
#gcashFullModal .qrcode {
    width: 60%; /* Same size for consistency */
    aspect-ratio: 1 / 1; /* Maintain square aspect ratio */
    margin: 10px auto; /* Center horizontally */
}

#gcashFullModal .qrcode img {
    width: 100%; /* Ensure image covers the QR code container */
    height: auto; /* Maintain aspect ratio */
}

/* Full Payment Modal for Larger Screens */
@media (min-width: 768px) {
    #gcashFullModal .modal-body {
        display: flex;
        flex-direction: row; /* Side-by-side layout for large screens */
    }

    #gcashFullModal .col-md-6 {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center content in each column */
    }

    #gcashFullModal .qrcode {
        width: 100%; /* Larger QR code for larger screens */
        margin: 20px auto; /* Center horizontally */
    }

    #gcashFullModal .payment-details {
        margin-left: 20px;
        text-align: left; /* Align text to the left */
    }
}

/* Full Payment Modal for Smaller Screens */
@media (max-width: 767.98px) {
    #gcashFullModal .modal-dialog {
        width: 80%; /* Smaller modal width on mobile */
        max-width: none;
        margin: 1rem auto;
        transform: scale(0.9); /* Zoom-out effect to shrink modal */
    }

    #gcashFullModal .modal-body {
        display: flex;
        flex-direction: column; /* Stack content vertically for mobile */
        align-items: center;
    }

    #gcashFullModal .qrcode {
        width: 80%; /* Adjust size for mobile */
        margin: 10px auto; /* Center horizontally */
    }

    #gcashFullModal .payment-details {
        margin-top: 20px;
        text-align: left; /* Align text to the left */
        width: 100%; /* Full width for left-alignment */
    }

    #gcashFullModal .proof-of-payment {
        margin-top: 20px;
        text-align: center; /* Center align */
    }
}

.image-preview {
    margin-top: 10px;
    text-align: center; /* Center the preview */
}

.image-preview img {
    max-width: 100%; /* Ensure the image does not exceed container width */
    max-height: 200px; /* Limit the height of the preview */
    border: 1px solid #ddd; /* Optional: border around the preview */
    border-radius: 8px; /* Optional: rounded corners for the preview */
}



    /* Dropdown toggle button */
    .dropdown-toggle.btn-blue {
    background-color: #007bff; /* Primary blue color */
    border-color: #007bff; /* Blue border */
    color: white; /* White text color */
}

/* Dropdown toggle button on hover */
.dropdown-toggle.btn-blue:hover {
    background-color: #0056b3; /* Darker blue for hover */
    border-color: #004085; /* Darker blue border for hover */
}

/* Dropdown toggle button active state */
.dropdown-toggle.btn-blue:active, .dropdown-toggle.btn-blue:focus {
    background-color:#0056b3; /* Lighter blue for active state */
    border-color: #003d80; /* Darker border for active state */
    box-shadow: none; /* Remove box shadow */
}

/* Dropdown menu background color */
.dropdown-menu {
    background-color: #007bff; /* Blue background color */
    border: 1px solid #007bff; /* Blue border color */
}

/* Dropdown item styles */
.dropdown-menu .dropdown-item {
    color: white; /* White text color for items */
    border-bottom: 3px solid rgba(255, 255, 255, 0.2); /* Light white line between items */
}

/* Remove the bottom border of the last item */
.dropdown-menu .dropdown-item:last-child {
    border-bottom: none;
}

/* Dropdown item background color on hover */
.dropdown-menu .dropdown-item:hover {
    background-color: #0056b3; /* Darker blue background on hover */
    color: white; /* White text color on hover */
}

</style>


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

if(isset($_POST['btnsubmitbooking'])){
  // $message = $_POST['message'];

 


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
if (verifyOTP($_SESSION['otp'])) {
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
$guest->ZIP              = $_SESSION['zip'];  
$guest->G_NATIONALITY    = $_SESSION['nationality'];          
$guest->G_COMPANY        = $_SESSION['company'];      
$guest->G_CADDRESS       = $_SESSION['caddress'];        
$guest->G_TERMS          = 1;    
$guest->G_UNAME          = $_SESSION['username'];    
$guest->G_PASS           = sha1($_SESSION['pass']);
$guest->OTPCODE          = $_SESSION['otp'];
$guest->OTP_EXPIRE_AT   = date('Y-m-d H:i:s', strtotime('+5 minutes')); 
   

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
           $paymentstatus = $_POST['txtstatus'];

            $target_dir = "../uploads/";
            $target_file = $target_dir . $_POST['realconfirmation'] ."_". basename($_FILES["proofOfPayment"]["name"]);
            $file_name = $_POST['realconfirmation'] ."_". basename($_FILES["proofOfPayment"]["name"]);

      $sql = "INSERT INTO `tblpayment` (`TRANSDATE`,`CONFIRMATIONCODE`,`PQTY`, `GUESTID`, `SPRICE`,`MSGVIEW`,`STATUS`,`PAYMENT_STATUS`, `PROOF_OF_PAYMENT`  )
       VALUES ('" .date('Y-m-d h:i:s')."','" . $_POST['realconfirmation'] ."',".$item."," . $_SESSION['GUESTID'] . ",".$tot.",0,'Pending', '".$paymentstatus."', '".$file_name."' )" ;
        // mysql_query($sql);





     $mydb->setQuery($sql);
     $msg = $mydb->executeQuery();

     move_uploaded_file($_FILES["proofOfPayment"]["tmp_name"], $target_file);

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
    <?php
} else {
    // Display error message
    ?>
    <script type="text/javascript">
        Swal.fire({
            title: 'Error!',
            text: 'Invalid OTP code !',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    <?php
}?>
<!-- <script type="text/javascript">
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
<?php }?> -->

 
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
            <form action="index.php?view=payment" method="post" name="personal" enctype="multipart/form-data">
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
    <label>Transaction Id:</label>
    <span><?php echo $_SESSION['confirmation']; ?></span>
    <input type="hidden" name="realconfirmation" value="<?php echo $_SESSION['confirmation']; ?>" />
    <input type="hidden" id="payment_status_input"  name="txtstatus">
</div>
                    <div class="col-md-12 col-sm-2">
    <label id="paymentLabel">Payment Options:</label>

    <!-- Payment buttons for larger screens -->
    <div class="d-none d-md-block">
        <button type="button" class="btn btn-primary" onclick="showPaymentModal('partial')">
            <img src="../gcash.png" alt="GCash Icon" style="width: 20px; margin-right: 5px;"> Partial Payment
        </button>
        <button type="button" class="btn btn-primary" onclick="showPaymentModal('full')">
            <img src="../gcash.png" alt="GCash Icon" style="width: 20px; margin-right: 5px;"> Full Payment
        </button>
        <!-- <button type="button" class="btn btn-primary" onclick="showCashPaymentModal('cash')">
            <i class="fas fa-money-bill-wave"></i> Cash Payment
        </button> -->
    </div>

   <!-- Dropdown for smaller screens -->
<div class="d-block d-md-none">
    <div class="dropdown">
        <button class="btn btn-blue dropdown-toggle" type="button" id="paymentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Select Payment Option
        </button>
        <div class="dropdown-menu" aria-labelledby="paymentDropdown">
            <a class="dropdown-item" href="javascript:void(0);" onclick="showPaymentModal('partial')">
                <img src="../gcash.png" alt="GCash Icon" style="width: 20px; margin-right: 5px;"> Partial Payment
            </a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="showPaymentModal('full')">
                <img src="../gcash.png" alt="GCash Icon" style="width: 20px; margin-right: 5px;"> Full Payment
            </a>
            <!-- <a class="dropdown-item" href="javascript:void(0);" onclick="showCashPaymentModal('cash')">
                <i class="fas fa-money-bill-wave"></i> Cash Payment
            </a> -->
        </div>
    </div>
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

<!-- GCash Payment Modal (for both Partial and Full) -->
<div class="modal fade" id="gcashPaymentModal" tabindex="-1" role="dialog" aria-labelledby="gcashPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcashPaymentLabel"></h5> <!-- Dynamic title -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- QR Code (Centered on Mobile) -->
                <div class="qrcode-container">
                    <img src="../qrcode.png" alt="GCash QR Code" class="qrcode">
                </div>

                <!-- GCash Payment Details (Left Aligned on Mobile) -->
                <div class="payment-details">
                    <h6>Payment Details</h6>
                    <p><strong>Name:</strong><br>GCash Merchant Name</p>
                    <p><strong>Number:</strong><br>09XXXXXXXXX</p>
                    <p><strong>Total Amount Due:</strong><br>₱<span id="paymentAmount"></span></p> <!-- Dynamic amount -->
                </div>

                <!-- Proof of Payment (Centered on Mobile) -->
                <div class="proof-of-payment">
                    <label for="proofOfPayment">Upload Proof of Payment:</label>
                    <input type="file" class="form-control-file" name="proofOfPayment" id="proofOfPayment" accept="image/*">
                    
                    <div id="proofOfPaymentPreview" class="image-preview"></div> <!-- Preview Container -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" id="submitPayment">Submit Payment</button> -->
            </div>
        </div>
    </div>
</div>


<!-- Cash Payment Modal -->
<div class="modal fade" id="cashPaymentModal" tabindex="-1" role="dialog" aria-labelledby="cashPaymentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cashPaymentLabel">Cash Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please visit our office to complete the payment.</p>
                <p><strong>Total Amount Due:</strong> ₱<?php echo number_format($_SESSION['pay'], 2); ?></p>
                <!-- You could add a barcode or reference number for internal processing if needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Confirm Cash Payment</button> -->
            </div>
        </div>
    </div>
</div>

                <div id="confirmModal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" >
            <div class="modal-body">
                <p>Are you sure you want to submit the booking?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary" align="right" name="btnsubmitbooking">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- <script>
function submitBooking() {
  Swal.fire({
    title: 'Are you sure?',
    text: 'You want to submit the booking?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // Submit the booking form
      var button = document.querySelector('[name="btnsubmitbooking"]');
      var event = new MouseEvent('click', {
        view: window,
        bubbles: true,
        cancelable: true
      });
      button.dispatchEvent(event);
    }
  });
}
</script> -->

<div class="row"> 
  <h3 align="right">Total: &#8369 <?php echo   $_SESSION['pay'] ;?></h3>
</div>

    <div class="pull-right flex-end" align="right">
    <button  type="button" id="submitBookingButton" class="btn btn-primary" align="right" data-toggle="modal" data-target="#confirmModal">Submit Booking</button>
       <!-- <button  type="button"  id="submitBookingButton" class="btn btn-primary" align="right" onclick="submitBooking()" >Submit Booking</button> -->
    </div>
</form>
  </div>  
  

  
        </div>
      </div>
</div>
<script>
// Get the proof of payment input field and the submit booking button
const proofOfPaymentInput = document.getElementById('proofOfPayment');
const submitBookingButton = document.getElementById('submitBookingButton');

// Disable the submit booking button by default
submitBookingButton.disabled = true;

// Add an event listener to the proof of payment input field
proofOfPaymentInput.addEventListener('change', function() {
  // If a file has been selected, enable the submit booking button
  if (this.files.length > 0) {
    submitBookingButton.disabled = false;
  } else {
    submitBookingButton.disabled = true;
  }
});
</script>
<!-- <script>// Get the file input and submit button elements
const fileInput = document.getElementById('proofOfPayment');
const submitButton = document.querySelector('button[name="btnsubmitbooking"]');

// Function to check if the file input is empty
function checkFileInput() {
    if (fileInput.files.length === 0) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

// Add event listener to the file input
fileInput.addEventListener('change', checkFileInput);

// Initialize the button state
checkFileInput();</script> -->
<script>
    function showPaymentModal(paymentType) {
        let modalTitle = '';
        let paymentAmount = '';

        // Set modal title and amount based on the payment type
        if (paymentType === 'partial') {
            modalTitle = 'Partial Payment - GCash';
            paymentAmount = '<?php echo number_format($_SESSION["pay"] / 2, 2); ?>';
            $('#payment_status_input').val('Partial');
        } else if (paymentType === 'full') {
            modalTitle = 'Full Payment - GCash';
            paymentAmount = '<?php echo number_format($_SESSION["pay"], 2); ?>';
            $('#payment_status_input').val('Full');
        }


        // Update the modal title and payment amount dynamically
        $('#gcashPaymentLabel').text(modalTitle);
        $('#paymentAmount').text(paymentAmount);

        // Show the modal
        $('#gcashPaymentModal').modal('show');
    }
    function showCashPaymentModal() {
    // Show the cash payment modal
    $('#cashPaymentModal').modal('show');
    $('#payment_status_input').val('Cash');
}
</script>
<script>
    // Function to close the modal
    function closeModal(modalId) {
        $('#' + modalId).modal('hide');
    }

    // Event listener for the close buttons
    document.addEventListener('DOMContentLoaded', function () {
        // Close modal when the "X" icon or Close button is clicked
        const closeButtons = document.querySelectorAll('.modal .close, .modal-footer .btn-secondary');
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Find the closest modal to the button and hide it
                const modal = button.closest('.modal');
                if (modal) {
                    $(modal).modal('hide');
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Handle partial payment proof of payment preview
        document.getElementById('proofOfPayment').addEventListener('change', function(event) {
            var input = event.target;
            var previewContainer = document.getElementById('proofOfPaymentPreview');
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Proof of Payment Preview">';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.innerHTML = '';
            }
        });

        // Handle full payment proof of payment preview
        document.getElementById('proofOfPaymentFull').addEventListener('change', function(event) {
            var input = event.target;
            var previewContainer = document.getElementById('proofOfPaymentFullPreview');
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Proof of Payment Preview">';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.innerHTML = '';
            }
        });
    });

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle submission and show SweetAlert
    function handleSubmission(modalId, submitButtonId) {
        var submitButton = document.getElementById(submitButtonId);

        submitButton.addEventListener('click', function() {
            // Show SweetAlert success message
            Swal.fire({
                title: 'Success!',
                text: 'Your payment has been submitted successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Close the modal
                    $('#' + modalId).modal('hide');
                }
            });
        });
    }

    // Handle submission for partial payment
    handleSubmission('gcashPartialModal', 'submitPartialPayment');

    // Handle submission for full payment
    handleSubmission('gcashFullModal', 'submitFullPayment');
});
</script>


<!-- <script>
    function showPaymentModal(paymentType) {
    // Hide all modals first
    $('#partialPaymentModal').modal('hide');
    $('#fullPaymentModal').modal('hide');
    $('#cashPaymentModal').modal('hide');

    // Determine which modal to show based on payment type
    if (paymentType === 'partial') {
        $('#partialPaymentModal').modal('show');
    } else if (paymentType === 'full') {
        $('#fullPaymentModal').modal('show');
    } else if (paymentType === 'cash') {
        $('#cashPaymentModal').modal('show');
    }
}
    // Function to handle image preview
    function handleImagePreview(inputElement, previewElement) {
        const file = inputElement.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block'; // Show the preview
            };
            reader.readAsDataURL(file);
        } else {
            previewElement.style.display = 'none'; // Hide preview if not an image
        }
    }

    // Event listeners for file inputs
    document.addEventListener('DOMContentLoaded', function () {
        const fileInputs = document.querySelectorAll('input[type="file"]'); // Get all file inputs
        fileInputs.forEach(inputElement => {
            const previewElement = document.getElementById(inputElement.getAttribute('data-preview-id')); // Get corresponding preview element using data attribute
            if (previewElement) {
                inputElement.addEventListener('change', function () {
                    handleImagePreview(inputElement, previewElement);
                });
            }
        });
    });

    // Function to close the modal with animation
    function closeModal(modalId) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            $(modalElement).modal('hide');
            setTimeout(() => {
                // Reset transform after closing animation
                modalElement.querySelector('.modal-dialog').style.transform = 'scale(1)';
            }, 300); // Match the duration with CSS transition
        }
    }

    // Event listeners for modal close buttons
    document.addEventListener('DOMContentLoaded', function () {
        const closeButtons = document.querySelectorAll('.modal .close, .modal .btn-secondary');
        closeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const modalId = this.closest('.modal').id;
                closeModal(modalId);
            });
        });
    });
    function confirmPayment(paymentType) {
    var formId = '';
    var data = new FormData();

    // Determine form ID based on payment type
    if (paymentType === 'partial') {
        formId = '#partialPaymentForm';
        data.append('paymentType', 'partial');
    } else if (paymentType === 'full') {
        formId = '#fullPaymentForm';
        data.append('paymentType', 'full');
    } else if (paymentType === 'cash') {
        formId = '#cashPaymentForm';
        data.append('paymentType', 'cash');
    }

    // Append form data
    $(formId).find('input, select, textarea').each(function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        if (name) {
            data.append(name, value);
        }
    });

    // Handle file input
    var fileInput = $(formId).find('input[type="file"]');
    if (fileInput.length) {
        var files = fileInput[0].files;
        if (files.length > 0) {
            for (var i = 0; i < files.length; i++) {
                data.append('proofOfPayment', files[i]);
            }
        }
    }

    // Send AJAX request
    $.ajax({
        url: 'processpayment.php',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: res.message,
                    icon: 'success'
                }).then(function() {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: res.message,
                    icon: 'error'
                });
            }
        }
    });
}
 
   // Run on initial load and whenever the window is resized
   window.addEventListener('resize', updatePaymentLabel);
    window.addEventListener('load', updatePaymentLabel);

</script> -->