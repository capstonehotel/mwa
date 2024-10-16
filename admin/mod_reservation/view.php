<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;" >Back</a>
                <h6 class="m-0 font-weight-bold text-primary ml-10">View Booking</h6>
            </div>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
if (!defined('WEB_ROOT')) {
    exit;
}

$code=$_GET['code'];


 
        $query="SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS` ,  `TRANSDATE` , `G_GENDER`, `CONFIRMATIONCODE` ,  `PQTY` ,  `SPRICE` ,`STATUS`
                FROM  `tblpayment` p,  `tblguest` g
                WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='".$code."'";
        $result = mysqli_query($connection, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) { ?>
 <?php if($_SESSION['ADMIN_UROLE']=="Administrator"){ ?>
                                    <?php if ($row['STATUS'] == "Confirmed" ) { ?>
                                        <a href="controller.php?action=cancel&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm ml-2" ><i class="icon-edit">Cancel</a>
                                        <a href="controller.php?action=checkin&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2" ><i class="icon-edit">Check in</a>
                                    <?php } elseif($row['STATUS'] == 'Checkedin') {?>
                                        <a href="controller.php?action=checkout&code=<?php echo $row['CONFIRMATIONCODE'];?>" class="btn btn-warning btn-sm ml-2" ><i class="icon-edit">Check out</a>
                                    <?php } elseif($row['STATUS'] == 'Checkedout') {?>
                                <a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm ml-2    " ><i class="icon-edit">Delete</a>
                                    <?php } else {?>
                                        <a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2"  ><i class="icon-edit">Confirm</a>


                                            <?php } ?>
                                 <?php } ?>

                                 <!-- <a href="controller.php?action=delete&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm " style="margin-left: 3px!important;"><i class="icon-edit">Delete</a>  -->
            
            </div>

        </div>

        <div class="card-body">
            <div class="row" style="width: 100%;">
                <div class="col-md-12 col-sm-12" style="margin-top: 10px;">  
          <div class="box box-solid">
            <div class="">
              <h3 >Guest Information</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav " style="display: block;">
                <li class="active"><a>Firstname:
                  <span class="pull-right"><?php echo $row['G_FNAME'] ; ?></span></a></li>
                <li class="active"><a>Lastname:
                <span class="pull-right"><?php echo $row['G_LNAME'] ; ?></span></a></li>
                <li class="active"><a>Address:
                <?php echo $row['G_ADDRESS'] ; ?> </a></li>
               <li class="active"><a>Gender:
                <?php echo $row['G_GENDER'] ; ?> </a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>

 </div> <br> <hr>
  <?php } 
            }
        



?>
                <?php 
                $query="SELECT * 
                FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
                WHERE r.`ROOMID` = rm.`ROOMID` 
                AND a.`ACCOMID` = rm.`ACCOMID` 
                AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
                AND  `CONFIRMATIONCODE` = '".$code."'";
                $result = mysqli_query($connection, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image = '../mod_room/'.$row['ROOMIMAGE'];  
                $day=dateDiff(date($row['ARRIVAL']),date($row['DEPARTURE']));
                 ?>
                 <div class="col-md-6 col-sm-12 " style="margin-top: 10px; text-align: center;"> 
                    <img class="img-responsive img-hover" height="200px" width="250px" src="<?php echo $image ; ?>" alt=""> 
                </div>
                <div class="col-md-6 col-sm-12" style="margin-top: 10px;">
                    <div class="box box-solid">
                        <ul class="nav nav-pills nav-stacked">
                <li><h3>
                    <?php echo $row['ROOM']; ?> [ <small><?php echo $row['ACCOMODATION']; ?></small> ]
                </h3>
                </li>
            </ul>
                 
                <p><strong>Check-in: </strong><?php echo date_format(date_create( $row['ARRIVAL'] ),'m/d/Y');?></p>
                <p><strong>Check-out: </strong><?php echo date_format(date_create( $row['DEPARTURE'] ),'m/d/Y'); ?></p>
                <p><strong>Night(s): </strong><?php echo ($day==0) ? '1' : $day; ?></p>
                <p><strong>Price: &#8369</strong><?php echo $row['RPRICE' ]; ?></p>
                </div>
                </div>
                <br><hr>
             <?php } } ?>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    $(document).ready(function() {
        $('.action-btn').on('click', function(e) {
            e.preventDefault();
            var action = $(this).data('action');
            var code = $(this).data('code');
            var actionText = ''; // Declare a variable to hold the dynamic action text

            // Set the action text based on the action performed
            if(action === 'confirm') {
                actionText = 'confirmed';
            } else if(action === 'checkin') {
                actionText = 'checked in';
            } else if(action === 'checkout') {
                actionText = 'checked out';
            } else if(action === 'cancel') {
                actionText = 'cancelled';
            } else if(action === 'delete') {
                actionText = 'deleted';
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller.php',
                        type: 'GET',
                        data: {
                            action: action,
                            code: code
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: `Booking has been ${actionText} successfully.`,
                                icon: 'success'
                            }).then(() => {
                                // Redirect to index.php directly
                                window.location.href = 'index.php';
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Confirm Booking
function confirmBooking(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the redirect only after the user has confirmed the action
            window.location.href = "controller.php?action=confirm&code=<?php echo $code; ?>";
        } else {
            // Do nothing if the user clicks "Cancel"
            return false;
        }
    });
}

    // Cancel Booking
function cancelBooking(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "controller.php?action=cancel&code=<?php echo $code; ?>";
        } else {
            return false;
        }
    })
}

// Check in Booking
function checkinBooking(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, check in!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "controller.php?action=checkin&code=<?php echo $code; ?>";
        } else {
            return false;
        }
    })
}

// Check out Booking
function checkoutBooking(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, check out!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "controller.php?action=checkout&code=<?php echo $code; ?>";
        } else {
            return false;
        }
    })
}

// Delete Booking
function deleteBooking(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "controller.php?action=delete&code=<?php echo $code; ?>";
        } else {
            return false;
        }
    })
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
 -->
