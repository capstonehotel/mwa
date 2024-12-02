<style>
     .keypad {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .keypad button {
            padding: 20px;
            font-size: 18px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f5f5f5;
        }
        .payment-amount-display {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        text-align: center;
        width: 100%; /* Make it full width */
        box-sizing: border-box; /* Include padding in width */
        grid-column: span 4; /* Span across all columns */
    }
    .payment-info, .calculator-section {
        padding: 20px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fafafa;
    }
    .payment-info h3, .calculator-section h3 {
        margin-bottom: 15px;
    }
    .box-body ul.nav li.active a {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        margin: 5px 0;
        border-bottom: 1px solid #e0e0e0;
    }
</style>
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

                $query = "SELECT  `TRANSDATE`, `CONFIRMATIONCODE`, `PAYMENT_STATUS`, `PAYMENT_METHOD`, `STATUS`,`SPRICE`,`AMOUNT_PAID`, `BALANCE`  
                          FROM `tblpayment` p, `tblguest` g
                          WHERE p.`GUESTID` = g.`GUESTID` AND `CONFIRMATIONCODE`='" . $code . "'";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $paymentmethod = $row['PAYMENT_METHOD'];
                        $paymentStatus = $row['PAYMENT_STATUS'];
                        $amount = $row['AMOUNT_PAID'];
                        $ccode = $row['CONFIRMATIONCODE'];
                        $isFullyPaid = ($row['PAYMENT_STATUS'] == "Fully Paid");
                
                        if ($paymentStatus == 'Partially Paid') {
                            $paymentName = 'Partial Payment';
                            $amount = $row['AMOUNT_PAID'];
                        } elseif ($paymentStatus == 'Fully Paid') {
                            $paymentName = 'Full Payment';
                            $amount = $row['AMOUNT_PAID'];
                            
                        } else {
                            $paymentName = 'Payment Pending';
                            $amountToPay = $totalPrice;
                        }
                        
                        ?>

<?php if ($_SESSION['ADMIN_UROLE'] == "Administrator") { ?>
    <?php if ($row['PAYMENT_STATUS'] == "Partially Paid") { ?>
        <a href="controller.php?action=confirm&code=<?php echo $row['CONFIRMATIONCODE']; ?>" class="btn btn-success btn-sm ml-2" onclick="confirmConfirmation('<?php echo $row['CONFIRMATIONCODE']; ?>'); return false;"><i class="icon-edit">Paid</i></a>
    <?php } else if ($row['PAYMENT_STATUS'] == "Fully Paid") { ?>
        <a href="javascript:void(0);" class="btn btn-success btn-sm ml-2" disabled><i class="icon-edit">Paid</i></a>
    <?php } ?>
<?php } ?>

            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Left Column: Payment Info and Invoice -->
                <div class="col-md-6">
                    <div class="box box-solid mb-4"  style="padding: 20px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fafafa;">
                        <h3>Payment Information</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Payment Name: <span class="float-right"><?php echo $paymentName; ?></span></li>
                            <li class="list-group-item">Payment Method: <span class="float-right"><?php echo $paymentmethod; ?></span></li>
                            <li class="list-group-item">Initial Amount Paid: <span class="float-right"><?php echo $amount; ?></span></li>
                            <li class="list-group-item">Amount to Pay: <span class="float-right"><?php echo $amount; ?></span></li>
                        </ul>
                    </div>
                    <div class="box box-solid"  style="padding: 20px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fafafa;">
                        <h3>Payment Invoice</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Amount Paid:  <span id="amount-paid" class="float-right"><?php echo isset($_SESSION['amount_paid']) ? $_SESSION['amount_paid'] : '0'; ?></span></li>                     
                            <li class="list-group-item">Change: <span id="change-display"  class="float-right"><?php echo isset($_SESSION['change']) ? $_SESSION['change'] : '0'; ?></span></li>
                        </ul>
                    </div>
                </div>

    <!-- Right Column: Pay Balance and Calculator -->
    <div class="col-md-6">
                    <!-- <?php if ($paymentStatus != 'Fully Paid') { ?>
                        <h3 id="payBalanceTitle"><?php echo $paymentStatus == 'Unpaid' ? 'Pay the Amount' : 'Pay Balance'; ?></h3>
                        <form action="controller.php?action=pay_balance&code=<?php echo $code; ?>" method="POST" class="form-inline mb-4">
                            <div class="form-group mr-2">
                                <label for="payment_amount" class="sr-only">Amount</label>
                                <input type="number" class="form-control" name="payment_amount" id="payment_amount" placeholder="Amount" required <?php echo $paymentStatus == 'Full' ? 'disabled' : ''; ?>>
                            </div>
                            <button type="submit" class="btn btn-primary" <?php echo $paymentStatus == 'Full' ? 'disabled' : ''; ?>>Pay</button>
                        </form>
                    <?php } ?> -->

                    <div class="box box-solid" style="padding: 20px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fafafa;">
                        <h3>Calculator</h3>
                        <div class="payment-amount-display" id="display"><?php echo $amount; ?></div>
                        <div class="keypad" <?php echo $isFullyPaid ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
                            <button onclick="appendToDisplay('1')" >1</button>
                            <button onclick="appendToDisplay('2')">2</button>
                            <button onclick="appendToDisplay('3')">3</button>
                            <button onclick="backspace()"><i class="fas fa-backspace"></i></button>
                            <button onclick="appendToDisplay('4')">4</button>
                            <button onclick="appendToDisplay('5')">5</button>
                            <button onclick="appendToDisplay('6')">6</button>
                            <button onclick="appendToDisplay('+')">+</button>
                            <button onclick="appendToDisplay('7')">7</button>
                            <button onclick="appendToDisplay('8')">8</button>
                            <button onclick="appendToDisplay('9')">9</button>
                            <button onclick="appendToDisplay('-')">-</button>
                            <button onclick="appendToDisplay('00')">00</button>
                            <button onclick="appendToDisplay('0')">0</button>
                            <button onclick="appendToDisplay('.')">.</button>
                            <button onclick="calculateResult()">=</button>
                            <button onclick="clearDisplay()" style="grid-column: span 4;">C</button>
                        </div>
                    </div>
                </div>

                <?php 
                    }
                }
                ?>
           
    </div>
</div>
<script>

    function confirmConfirmation(code) {
        // Check if the "Amount Paid" is 0 (indicating no payment has been made)
        var amountPaid = document.getElementById("amount-paid").textContent;

        if (amountPaid == "0") {
            // Show a SweetAlert warning if no payment is made
            Swal.fire({
                icon: 'warning',
                title: 'No Payment Made',
                text: 'You have not made any payment yet. Please verify the payment before confirming.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        } else {
            // Proceed with confirming the payment if payment is made
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
    }
</script>
<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.13/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let displayValue = '<?php echo $amount; ?>'; // Set initial display to PHP amount
    let currentExpression = ''; // Stores the current expression
    const initialAmount = parseFloat('<?php echo $amount; ?>'); // Store the initial PHP amount
    let amount1 = initialAmount; // Initialize amount1 to PHP amount for first calculation
    let canInputAmount2 = false; // Track if numbers can be entered for amount2
    let isFirstCalculation = true; // Track if this is the first calculation

    // Display the initial amount
    document.querySelector('.payment-amount-display').textContent = displayValue;

    function appendToDisplay(value) {
        // Allow only '+' and '-' operators
        if (value === '+' || value === '-') {
            if (currentExpression.length === 0) {
                currentExpression = displayValue + value; // Start new calculation with current display value
            } else {
                currentExpression = displayValue + value; // Reset currentExpression to use the last total
            }
            displayValue = currentExpression; // Update display
            updateDisplay();
            canInputAmount2 = true; // Enable input for amount2
        }
        // Allow numeric input and decimal point for amount2
        else if (canInputAmount2 && (!isNaN(value) || value === '.')) {
            // Handle decimal point input for amount2
            if (value === '.') {
                // Prevent multiple decimal points
                let lastOperatorIndex = currentExpression.lastIndexOf('+') !== -1 ? currentExpression.lastIndexOf('+') : currentExpression.lastIndexOf('-');
                let amount2Part = currentExpression.slice(lastOperatorIndex + 1); // Extract amount2 part
                if (amount2Part.includes('.')) {
                    return; // Prevent additional decimals
                }
            }
            displayValue += value; // Append value to display
            currentExpression += value; // Update the current expression
            updateDisplay();

            // Sync Amount Paid with amount2 during initial calculation
            if (isFirstCalculation) {
                syncAmountPaid();
            }
        }
    }

    function syncAmountPaid() {
        let operatorIndex = currentExpression.indexOf('+') !== -1 ? currentExpression.indexOf('+') : currentExpression.indexOf('-');
        let amount2 = parseFloat(currentExpression.slice(operatorIndex + 1)) || 0;
        document.getElementById('amount-paid').textContent = amount2.toFixed(2);
        calculateChange(amount2);
        
        // Store the values in sessionStorage
        sessionStorage.setItem('amount_paid', amount2.toFixed(2));
    }


function calculateChange(amountPaid) {
    let change = amountPaid - initialAmount;
    document.getElementById('change-display').textContent = change > 0 ? change.toFixed(2) : '0.00';
    
    // Store the change in sessionStorage
    sessionStorage.setItem('change', change > 0 ? change.toFixed(2) : '0.00');
}
    function calculateResult() {
        // Separate amount1 and amount2 based on the expression
        let operatorIndex = currentExpression.indexOf('+') !== -1 ? currentExpression.indexOf('+') : currentExpression.indexOf('-');
        let amount2 = parseFloat(currentExpression.slice(operatorIndex + 1));

        // Apply restriction for amount2 only on the first calculation
        if (isFirstCalculation && amount2 < amount1) {
            Swal.fire({
            title: 'Error!',
            text: 'The amount cannot be less than the initial amount paid.',
            icon: 'error',
            confirmButtonText: 'OK',
        }).then(() => {
            resetCalculator();
        });
            return;
        }

        try {
            // Evaluate the expression and calculate the result
            let result = eval(currentExpression);
            displayValue = result.toString();
            amount1 = result; // Update amount1 to be the new result for continuous calculations
            currentExpression = ''; // Reset expression for new operations
            canInputAmount2 = false; // Reset flag

            // After first calculation, stop syncing Amount Paid
            if (isFirstCalculation) {
                isFirstCalculation = false; // Allow unrestricted calculations after first one
            }

            updateDisplay();
        } catch (error) {
            alert('Invalid expression');
            resetCalculator();
        }
    }

    function resetCalculator() {
        displayValue = '<?php echo $amount; ?>'; // Reset to initial PHP amount
        currentExpression = '';
        amount1 = initialAmount; // Reset amount1
        canInputAmount2 = false; // Reset flag
        isFirstCalculation = true; // Reset to allow limit in the very first calculation again
        document.getElementById('amount-paid').textContent = ''; // Clear Amount Paid field
        document.getElementById('change-display').textContent = ''; // Clear Change field
        updateDisplay();
    }

    function clearDisplay() {
        displayValue = '0';
        currentExpression = '';
        canInputAmount2 = false; // Reset flag
        updateDisplay();
    }

    function backspace() {
        // Remove last character from displayValue and currentExpression
        if (displayValue.length > 1) {
            displayValue = displayValue.slice(0, -1);
            currentExpression = currentExpression.slice(0, -1);
        } else {
            displayValue = '0'; // Reset if nothing left to backspace
            currentExpression = '';
        }
        updateDisplay();

        // Re-sync the Amount Paid after backspacing
        syncAmountPaid();
    }

    function updateDisplay() {
        document.querySelector('.payment-amount-display').textContent = displayValue;
    }
</script>
<script>
  // Pass the confirmation code from PHP to JavaScript
  const confirmationCode = "<?php echo $ccode; ?>"; // PHP variable passed to JS

// Load Amount Paid and Change from sessionStorage on page load
window.onload = function() {
    const savedAmountPaid = sessionStorage.getItem('amount_paid_' + confirmationCode);
    const savedChange = sessionStorage.getItem('change_' + confirmationCode);

    // If values exist in sessionStorage, update the display
    if (savedAmountPaid !== null) {
        document.getElementById('amount-paid').textContent = savedAmountPaid;
    }
    if (savedChange !== null) {
        document.getElementById('change-display').textContent = savedChange;
    }
};

// Clear sessionStorage after confirming the payment
function clearPaymentData() {
    sessionStorage.removeItem('amount_paid_' + confirmationCode);
    sessionStorage.removeItem('change_' + confirmationCode);
}
</script>
