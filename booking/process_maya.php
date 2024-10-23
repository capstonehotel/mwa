<?php
session_start();
function processMayaPayment() {
    $source_id = $_SESSION['paymongo_source_id'] ?? '';
    if (empty($source_id)) {
        return "PayMongo source ID not found in session";
    }
    
    $secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';
    
    // Verify the source status
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/sources/$source_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode($secret_key)
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($result['data']['attributes']['status'] === 'chargeable') {
        // Source is chargeable, create a payment
        $payload = json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $result['data']['attributes']['amount'],
                    'source' => [
                        'id' => $source_id,
                        'type' => 'source'
                    ],
                    'currency' => 'PHP',
                    'description' => 'Online Payment'
                ]
            ]
        ]);
        
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
        
        if ($payment_result['data']['attributes']['status'] === 'paid') {
            // Payment was successful
            unset($_SESSION['paymongo_source_id']);
            return true;
        } else {
            return "Maya payment failed. Status: " . $payment_result['data']['attributes']['status'];
        }
    } else {
        return "Maya source not chargeable. Status: " . $result['data']['attributes']['status'];
    }
}

// Process the payment
$error_message = processMayaPayment();
if ($error_message === true) {
    // Payment successful, redirect to confirmation page
    header("Location: https://mcchmhotelreservation.com/booking/index.php?view=payment");
    $_SESSION['status'] = 'success';
    exit();
} else {
    // Payment failed, redirect back to payment page with error message
    header("Location: https://mcchmhotelreservation.com/booking/payment.php");
    exit();
}

?>
