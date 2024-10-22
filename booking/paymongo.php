<?php
// paymongo.php

// PayMongo API keys
$paymongo_secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; 
$paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu'; 

// Retrieve the selected payment method
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Retrieve the amount from session and convert it to centavos (PayMongo requires amount in cents)
$amountInCents = isset($_SESSION['pay']) ? (int)($_SESSION['pay'] * 100) : 0; // Ensure integer conversion

// Validate that the amount is over the minimum and within PayMongo limits
if ($amountInCents < 2000) { // Minimum 20 PHP
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Error: Payment amount must be at least PHP 20.00.']);
    exit();
}

// PayMongo maximum limit is 100,000 PHP (10,000,000 centavos)
if ($amountInCents > 10000000) {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Error: Payment amount cannot exceed PHP 100,000.00.']);
    exit();
}

// Validate payment method
if (!in_array($paymentMethod, ['Gcash', 'Paymaya'])) {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Invalid payment method selected.']);
    exit();
}

try {
    // Step 1: Create a Payment Intent
    $paymentIntentData = [
        'data' => [
            'attributes' => [
                'amount' => $amountInCents,
                'payment_method_allowed' => [$paymentMethod === 'Gcash' ? 'gcash' : 'paymaya'],
                'currency' => 'PHP',
                'description' => 'Payment for booking',
                'statement_descriptor' => 'Booking Payment',
                'payment_method_options' => [
                    'card' => [
                        'request_three_d_secure' => 'any'
                    ]
                ]
            ]
        ]
    ];

    $response = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents', $paymentIntentData, $paymongo_secret_key);

    // Step 2: Create a Source
    $sourceData = [
        'data' => [
            'attributes' => [
                'amount' => $amountInCents,
                'redirect' => [
                    'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment',
                    'failed' => 'https://mcchmhotelreservation.com/booking/payment.php'
                ],
                'type' => strtolower($paymentMethod),
                'currency' => 'PHP',
                'billing' => [
                    'address' => [
                        'country' => 'PH'
                    ]
                ]
            ]
        ]
    ];

    $sourceResponse = createPaymongoRequest('https://api.paymongo.com/v1/sources', $sourceData, $paymongo_secret_key);
    
    if (!isset($sourceResponse->data->attributes->redirect->checkout_url)) {
        throw new Exception('Invalid response from PayMongo: Missing checkout URL');
    }

    $checkoutUrl = $sourceResponse->data->attributes->redirect->checkout_url;
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'checkout_url' => $checkoutUrl
    ]);
    exit();

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error processing payment: ' . $e->getMessage()
    ]);
    exit();
}

function createPaymongoRequest($url, $data, $secretKey) {
    $ch = curl_init($url);
    
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Authorization: Basic ' . base64_encode($secretKey . ':'),
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true
    ];
    
    curl_setopt_array($ch, $options);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if ($error) {
        throw new Exception('cURL Error: ' . $error);
    }
    
    if ($httpCode >= 400) {
        $errorData = json_decode($response);
        throw new Exception(isset($errorData->errors[0]->detail) ? 
            $errorData->errors[0]->detail : 
            'HTTP Error: ' . $httpCode
        );
    }
    
    $decodedResponse = json_decode($response);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from PayMongo');
    }
    
    return $decodedResponse;
}
?>