<?php 
// session_start(); // Start session management
require_once("sendOTP.php");
if (!isset($_SESSION['monbela_cart'])) {
    redirect('https://mcchmhotelreservation.com/index.php');
}
?>

<div class="card rounded" style="padding: 10px;">
    <div class="pagetitle">   
        <h1>Your Booking Cart</h1> 
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-top: 10px;">
            <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="https://mcchmhotelreservation.com/booking/">Booking Cart</a></li>
            <li class="breadcrumb-item active">Verify Accounts</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Login</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Register</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="col-md-12">
                            <h4>Service Two</h4> 
                            <?php echo logintab(); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <?php require_once 'personalinfo.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function logintab() {
    ?>  
    <div class="col-md-12">
        <form id="loginForm" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback" style="margin-top: 10px;">
                <input type="password" class="form-control" name="pass" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" name="gsubmit" class="btn btn-primary btn-block btn-flat" onclick=" showOtpInput();">Sign In</button>
                </div>
            </div>
        </form> 
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    type: 'POST',
                    url: 'login.php', // URL of the login script
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        if (response.trim() === 'success') {
                            // If login is successful, show OTP input prompt
                            showOtpInput();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response, // Display the error message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            });
        });

        function showOtpInput() {
            Swal.fire({
                title: 'Enter OTP',
                input: 'text',
                inputPlaceholder: 'Enter OTP code',
                showCancelButton: true,
                confirmButtonText: 'Verify OTP',
                footer: `Didn't receive a code? <a href="#" id="resend-otp-link">Resend</a>`,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: 'otp_verify.php',
                        data: {
                            otp: result.value,
                            email: '<?php echo $_SESSION['username']; ?>' // Use stored username
                        },
                        success: function(response) {
                            if (response.trim() == 'valid') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'OTP Verified!',
                                    text: 'Redirecting to payment...',
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
                                    text: 'Please try again.',
                                }).then(() => {
                                    showOtpInput(); // Show OTP input again if invalid
                                });
                            }
                        }
                    });
                }
            });
        }

        // Event listener for "Resend OTP" link
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'resend-otp-link') {
                e.preventDefault(); // Prevent default link behavior
                $.ajax({
                    type: 'POST',
                    url: 'resendOTP.php',
                    data: {
                        email: '<?php echo $_SESSION['username']; ?>'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Resent!',
                            text: 'Please check your email for the new OTP.',
                        }).then(() => {
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
