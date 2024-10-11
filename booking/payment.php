
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
}
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  -->




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
// if (verifyOTP($_SESSION['otp'])) {
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
</script>-->
<?php }?> 
<style>
 .btn-group .btn {
    padding: 5px 10px; /* Reduce padding for smaller button size */
}

.payment-icon {
    width: 25px; /* Set a smaller width for the icons */
    height: 25px; /* Set a smaller height for the icons */
    margin-right: 5px; /* Space between the icon and text */
    vertical-align: middle; /* Align image vertically in the middle of the button */
}


</style>
 
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
    <label style="display: none;">Transaction Id:</label>
    <span style="display: none;"><?php echo $_SESSION['confirmation']; ?></span>
    <input type="hidden" name="realconfirmation" value="<?php echo $_SESSION['confirmation']; ?>" />
    <input type="hidden" id="payment_status_input"  name="txtstatus">
</div>
                    <div class="col-md-12 col-sm-2">
    <label id="paymentLabel">Payment Method:</label>

    <form method="POST" action="paymongo.php" id="paymentForm">
    <input type="hidden" name="payment_method" id="payment_method" value="">
    
    <button type="button" class="btn btn-primary" onclick="selectPaymentMethod('Gcash')">
        <img src="../gcash.png" alt="Pay with GCash" style="height: 20px; margin-right: 5px;">
        Pay with GCash
    </button>
    
    <button type="button" class="btn btn-primary" onclick="selectPaymentMethod('Paymaya')">
        <img src="../paymaya.png" alt="Pay with PayMaya" style="height: 20px; margin-right: 5px;">
        Pay with PayMaya
    </button>
</form>

<script>
        function selectPaymentMethod(method) {
            document.getElementById('payment_method').value = method;

            // Automatically submit the form to trigger the payment process
            document.getElementById('paymentForm').submit();
        }
    </script>

        <!-- <button type="button" class="btn btn-primary" id="gcash-btn">
            <img src="../gcash.png" alt="GCash Icon" class="payment-icon" onclick="payWithGcash()"> GCash
        </button>
        <button type="button" class="btn btn-primary" id="paymaya-btn" onclick="payWithPaymaya()">
            <img src="../paymaya.png" alt="PayMaya Icon" class="payment-icon"> PayMaya
        </button>
        </div> -->
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

