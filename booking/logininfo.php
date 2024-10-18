<?php 

// session_start(); // Start the session at the beginning
require_once 'sendOTP.php';
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        // Handle form submission for login
        $('form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Check if the response indicates a successful login
                    if (response.trim() === 'success') {
                        // Show the OTP input prompt
                        showOtpInput();
                    } else {
                        // Handle error response (e.g., invalid credentials)
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid Username or Password! Please try again.',
                        });
                    }
                }
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
                    // Handle OTP verification
                    $.ajax({
                        type: 'POST',
                        url: 'otp_verify.php',
                        data: {
                            otp: result.value,
                            email: '<?php echo $_SESSION['username']; ?>'
                        },
                        success: function(response) {
                            if (response.trim() === 'valid') {
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
                                }).then(() => {
                                    showOtpInput(); // Show OTP input again
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
                        });
                    }
                });
            }
        });
    });
</script>
