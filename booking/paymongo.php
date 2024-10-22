<?php
// paymongo.php

// Start the session if not already started
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// PayMongo API keys
$paymongo_secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; 
$paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu'; 

// Log the incoming session data
error_log('Raw session pay value: ' . print_r($_SESSION['pay'], true));

// Retrieve the selected payment method
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Properly handle the amount from session
if (!isset($_SESSION['pay'])) {
    error_log('Session pay value is not set');
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error: Payment amount is not set']);
    exit();
}

// Clean and convert the amount
$amount = str_replace(['₱', ' ', ','], '', $_SESSION['pay']); // Remove peso sign, spaces, and commas
$amount = (float) $amount;
$amountInCents = (int) round($amount * 100); // Round to avoid floating point issues

// Log the processed amounts
error_log('Cleaned amount in PHP: ' . $amount);
error_log('Amount in cents: ' . $amountInCents);

// Validate amount is greater than zero
if ($amountInCents <= 0) {
    error_log('Invalid amount: ' . $amountInCents);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error: Invalid payment amount']);
    exit();
}

// Process the payment
if ($paymentMethod === 'Gcash' || $paymentMethod === 'Paymaya') {
    try {
        error_log('Creating payment intent for amount: ' . $amountInCents);
        
        // Step 1: Create a Payment Intent
        $paymentIntentData = [
            'data' => [
                'attributes' => [
                    'amount' => $amountInCents,
                    'payment_method_allowed' => [$paymentMethod === 'Gcash' ? 'gcash' : 'paymaya'],
                    'currency' => 'PHP',
                    'description' => 'Payment for booking - ' . number_format($amount, 2) . ' PHP',
                    'statement_descriptor' => 'Booking Payment'
                ]
            ]
        ];

        error_log('Payment Intent Data: ' . print_r($paymentIntentData, true));
        
        $response = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents', $paymentIntentData, $paymongo_secret_key);
        error_log('Payment Intent Response: ' . print_r($response, true));

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
                    'currency' => 'PHP'
                ]
            ]
        ];

        error_log('Source Data: ' . print_r($sourceData, true));
        
        $sourceResponse = createPaymongoRequest('https://api.paymongo.com/v1/sources', $sourceData, $paymongo_secret_key);
        error_log('Source Response: ' . print_r($sourceResponse, true));

        if (!isset($sourceResponse->data->attributes->redirect->checkout_url)) {
            throw new Exception('Missing checkout URL in PayMongo response');
        }

        $checkoutUrl = $sourceResponse->data->attributes->redirect->checkout_url;
        
        // Return success response with checkout URL
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'checkout_url' => $checkoutUrl,
            'amount' => $amount,
            'amount_in_cents' => $amountInCents
        ]);
        exit();

    } catch (Exception $e) {
        error_log('Payment Processing Error: ' . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Error processing payment: ' . $e->getMessage(),
            'amount' => $amount,
            'amount_in_cents' => $amountInCents
        ]);
        exit();
    }
} else {
    error_log('Invalid payment method: ' . $paymentMethod);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid payment method selected']);
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
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_VERBOSE => true
    ];
    
    curl_setopt_array($ch, $options);
    
    // Log the request
    error_log('PayMongo Request URL: ' . $url);
    error_log('PayMongo Request Data: ' . print_r($data, true));
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
        throw new Exception('Failed to connect to PayMongo: ' . curl_error($ch));
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    error_log('PayMongo Response Code: ' . $httpCode);
    error_log('PayMongo Response: ' . $response);
    
    curl_close($ch);

    $decodedResponse = json_decode($response);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from PayMongo');
    }

    if (isset($decodedResponse->errors)) {
        $errorMessage = isset($decodedResponse->errors[0]->detail) 
            ? $decodedResponse->errors[0]->detail 
            : 'Unknown PayMongo API error';
        error_log('PayMongo Error: ' . $errorMessage);
        throw new Exception($errorMessage);
    }

    return $decodedResponse;
}
?>