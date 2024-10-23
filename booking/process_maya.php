<?php
session_start();

function processMayaPayment() {
    // Check if PayMongo source ID exists in the session
    $source_id = $_SESSION['paymongo_source_id'] ?? '';
    if (empty($source_id)) {
        return "PayMongo source ID not found in session.";
    }
    
    // PayMongo secret key
    $secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here
    
    // Step 1: Verify the source status using the PayMongo API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/sources/$source_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode($secret_key)
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    // Step 2: Check if the PayMaya source is chargeable
    if (isset($result['data']['attributes']['status']) && $result['data']['attributes']['status'] === 'chargeable') {
        // Source is chargeable, proceed to create a payment
        $amount = $result['data']['attributes']['amount']; // Amount should already be in the smallest unit (cents)
        
        $payload = json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'source' => [
                        'id' => $source_id,
                        'type' => 'source'
                    ],
                    'currency' => 'PHP',
                    'description' => 'PayMaya Online Payment'
                ]
            ]
        ]);
        
        // Step 3: Create the payment using the PayMongo API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . base64_encode($secret_key),
            "Content-Type: application/json"
        ]);
        
        $payment_response = curl_exec($ch);
        curl_close($ch);
        
        $payment_result = json_decode($payment_response, true);
        
        // Step 4: Check the payment status
        if (isset($payment_result['data']['attributes']['status']) && $payment_result['data']['attributes']['status'] === 'paid') {
            // Payment successful, clear the session source ID
            unset($_SESSION['paymongo_source_id']);
            return true; // Return true to indicate success
        } else {
            // Log the payment failure and return the failure message
            $status = $payment_result['data']['attributes']['status'] ?? 'unknown';
            return "Maya payment failed. Status: " . $status;
        }
    } else {
        // Log the source not being chargeable
        $status = $result['data']['attributes']['status'] ?? 'unknown';
        return "Maya source not chargeable. Status: " . $status;
    }
}

// Process the PayMaya payment
$error_message = processMayaPayment();
if ($error_message === true) {
    // Payment was successful, redirect to the confirmation page
    $_SESSION['status'] = 'success';
    header("Location: https://mcchmhotelreservation.com/booking/index.php?view=payment");
    exit();
} else {
    // Payment failed, redirect back to the payment page with an error message
    $_SESSION['status'] = 'failed';
    error_log($error_message); // Log the error for debugging
    header("Location: https://mcchmhotelreservation.com/booking/payment.php");
    exit();
}

?>
