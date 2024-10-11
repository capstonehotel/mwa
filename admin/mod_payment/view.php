<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <div style="display: flex; justify-content: flex-end;">
                <a href="./index.php" class="btn btn-primary btn-sm" style="margin-right: 10px;">Back</a>
                <h6 class="m-0 font-weight-bold text-primary">View Proof of Payment</h6>
            </div>
            <div style="display: flex; width: 90%; justify-content: flex-end;">
                <?php
                if (!defined('WEB_ROOT')) {
                    exit;
                }

                $code = $_GET['code'];

                $query = "SELECT `G_FNAME`, `G_LNAME`, `TRANSDATE`, `G_GENDER`, `G_UNAME`, `G_PHONE`, `CONFIRMATIONCODE`, `PAYMENT_STATUS`, `PROOF_OF_PAYMENT`, `STATUS`,`SPRICE` 
                          FROM `tblpayment` p, `tblguest` g
                          WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='" . $code . "'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $paymentStatus = $row['PAYMENT_STATUS'];
                        $totalPrice = $row['SPRICE'];
                
                        if ($paymentStatus == 'Partial') {
                            $paymentName = 'Partial Payment';
                            $priceToPay = $totalPrice / 2;
                            $amountToPay = $priceToPay;
                        } elseif ($paymentStatus == 'Full') {
                            $paymentName = 'Full Payment';
                            $amountToPay = '';
                        } else {
                            $paymentName = 'Payment Pending';
                            $amountToPay = $totalPrice;
                        }
                        
                        ?>

                        <?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
                            <?php if ($row['PAYMENT_STATUS'] == "Partial" || $row['PAYMENT_STATUS'] == "Full") { ?>
                                <a href="controller.php?action=unpaid&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-warning btn-sm ml-2" onclick="markAsUnpaid('<?php echo $row['CONFIRMATIONCODE']; ?>'); return false;"><i class="icon-edit">Mark as Unpaid</i></a>
                                
            <a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2" onclick="confirmConfirmation('<?php echo $row['CONFIRMATIONCODE']; ?>'); return false;"><i class="icon-edit">Confirm</i></a>
       
                                <!-- <a href="controller.php?action=cancel&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-danger btn-sm ml-2" onclick="cancelConfirmation ('<?php echo $row['CONFIRMATIONCODE']; ?>'); return false;"><i class="icon-edit">Cancel</i></a> -->
                                <?php } else if ($row['PAYMENT_STATUS'] == "Unpaid") { ?>
        <a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2" onclick="confirmConfirmation('<?php echo $row['CONFIRMATIONCODE']; ?>'); return false;"><i class="icon-edit">Confirm</i></a>
    <?php } ?>
                                <?php } ?>
            </div>
        </div>

        <div class="card-body">
        <div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="box box-solid">
            <div class="">
                <h3>Guest Information</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav" style="display: block;">
                    <li class="active"><a>Firstname: <span class="pull-right"><?php echo $row['G_FNAME']; ?></span></a></li>
                    <li class="active"><a>Lastname: <span class="pull-right"><?php echo $row['G_LNAME']; ?></span></a></li>
                    <li class="active"><a>Gender: <?php echo $row['G_GENDER']; ?> </a></li>
                    <li class="active"><a>Email: <?php echo $row['G_UNAME']; ?> </a></li>
                    <li class="active"><a>Phone Number: <?php echo $row['G_PHONE']; ?> </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="box box-solid">
            <div class="">
                <h3>Payment Information</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav" style="display: block;">
                    <li class="active"><a>Payment Name: <span class="pull-right"><?php echo $paymentName; ?></span></a></li>
                    <li class="active"><a>Amount to Pay: <span class="pull-right"><?php echo $amountToPay; ?></span></a></li>
                </ul>
            </div>
        </div>
    </div>

                            
                
                <br><hr>

                <?php
                    }
                }

                $query = "SELECT `CONFIRMATIONCODE`, `PROOF_OF_PAYMENT`, `SPRICE`, `PAYMENT_STATUS`
                          FROM `tblpayment`
                          WHERE `CONFIRMATIONCODE` = '" . $code . "'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
    
                ?>
<div class="row" style="width: 100%;">
    <!-- Proof of Payment Section -->
    <div class="col-md-6 col-sm-12 offset-md-3" style="margin-top: 10px; text-align: center;"> 
        <img class="img-responsive img-hover" height="300px" width="350px" src="<?php echo WEB_ROOT .'/uploads/'. $row['PROOF_OF_PAYMENT']; ?>" alt="Proof of Payment">
    </div>

    <!-- Pay Balance Form Section -->
<div class="col-md-3 col-sm-12" style="margin-top: 10px;">
    <div class="box box-solid">
        <ul class="nav nav-pills nav-stacked">
        <?php if ($paymentStatus != 'Fully Paid') { ?>
            <li><h3 id="payBalanceTitle"><?php echo $paymentStatus == 'Unpaid' ? 'Pay the Amount' : 'Pay Balance'; ?></h3></li>
        <?php } ?>
        </ul>
    </div>
        <?php if ($paymentStatus == 'Partial' || $paymentStatus == 'Full' || $paymentStatus == 'Unpaid') { ?>

        <!-- Form to pay the balance -->
        <form action="controller.php?action=pay_balance&code=<?php echo $code; ?>" method="POST" class="form-inline">
            <div class="form-group" style="margin-right: 10px;">
                <label for="payment_amount" class="sr-only">Amount</label>
                <input type="number" class="form-control" name="payment_amount" id="payment_amount" placeholder="Amount" style="width: 150px;" required <?php echo $paymentStatus == 'Full' ? 'disabled' : ''; ?>>
            </div>
            <button type="submit" class="btn btn-primary" <?php echo $paymentStatus == 'Full' ? 'disabled' : ''; ?>>Pay</button>
        </form>
        <?php } ?>
    </div>
</div>
                <br><hr>

                <?php 
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
function markAsUnpaid(code) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to mark this payment as unpaid!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mark it as unpaid!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: 'controller.php?action=unpaid&code=' + code,
                success: function(data) {
                    // Update the payment status text
                    $('#payBalanceTitle').text('Pay the Amount');
                    // Update the amount to pay
                    var totalPrice = '<?php echo $totalPrice; ?>';
                    $('#amountToPay').text(totalPrice);
                    // Update the form fields and buttons
                    $('#payment_amount').prop('disabled', false);
                    $('button[type="submit"]').prop('disabled', false);
                    // Remove any other buttons or links that should not be shown for unpaid status
                    $('#markAsUnpaidButton').remove();
                    $('#confirmButton').remove();
                    $('#cancelButton').remove();
                }
            });
        }
    });
}

function confirmConfirmation(code) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to confirm this payment!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'controller.php?action=confirm&code=' + code;
        }
    });
}

function cancelConfirmation(code) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to cancel this confirmation!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'controller.php?action=cancel&code=' + code;
        }
    });
}
</script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
