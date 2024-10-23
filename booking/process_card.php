<?php
session_start();

function processCardPayment() {
    $source_id = $_SESSION['paymongo_source_id'] ?? '';
    if (empty($source_id)) {
        return "PayMongo source ID not found in session.";
    }
    
    $secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here

    // Verify the source status
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/sources/$source_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode($secret_key)
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $result = json_decode($response, true);

    if ($httpCode == 200 && isset($result['data']['attributes']['status'])) {
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
            $payment_httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $payment_result = json_decode($payment_response, true);
            
            if ($payment_httpCode == 200 && $payment_result['data']['attributes']['status'] === 'paid') {
                // Payment was successful
                unset($_SESSION['paymongo_source_id']);
                return true; // Indicates successful payment
            } else {
                return "Card payment failed. Status: " . $payment_result['data']['attributes']['status'];
            }
        } else {
            return "Card source not chargeable. Status: " . $result['data']['attributes']['status'];
        }
    } else {
        return "Error verifying source status. HTTP Code: " . $httpCode;
    }
}

// Process the payment
$error_message = processCardPayment();
if ($error_message === true) {
    // Payment successful, redirect to confirmation page
    header("Location: https://mcchmhotelreservation.com/booking/index.php?view=payment");
    $_SESSION['status'] = 'success';
    exit();
} else {
    // Payment failed, redirect back to payment page with error message
    $_SESSION['error_message'] = $error_message; // Store the error message in session
    header("Location: https://mcchmhotelreservation.com/booking/payment.php");
    exit();
}
?>
