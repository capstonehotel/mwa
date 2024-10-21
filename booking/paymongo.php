<?php
// paymongo.php

// Replace these with your PayMongo API keys
$paymongo_secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here
$paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu'; // Use your public key here

// Retrieve the selected payment method from the form
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Handle different payment methods (in this case, GCash)
if ($paymentMethod === 'Gcash') {
    try {
        // Step 1: Create a Payment Intent
        $paymentIntentData = [
            'data' => [
                'attributes' => [
                    'amount' => 10000, // Amount in cents (e.g., 10000 = PHP 100)
                    'payment_method_allowed' => ['gcash'],
                    'currency' => 'PHP',
                    'description' => 'Payment for booking', // Add your own description
                    'statement_descriptor' => 'Booking Payment'
                ]
            ]
        ];

        $response = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents', $paymentIntentData, $paymongo_secret_key);

        // Extract the payment intent ID
        $paymentIntentId = $response->data->id;

        // Step 2: Create a Source for GCash
        $sourceData = [
            'data' => [
                'attributes' => [
                    'amount' => 10000, // Amount in cents (e.g., 10000 = PHP 100)
                    'redirect' => [
                        'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment.php', // Return URL after successful payment
                        'failed' => 'https://mcchmhotelreservation.com/booking/payment.php', // Return URL if payment fails
                    ],
                    'type' => 'gcash',
                    'currency' => 'PHP'
                ]
            ]
        ];

        // Create a source for GCash
        $sourceResponse = createPaymongoRequest('https://api.paymongo.com/v1/sources', $sourceData, $paymongo_secret_key);

        // Redirect to GCash payment page
        $gcashCheckoutUrl = $sourceResponse->data->attributes->redirect->checkout_url;
        header('Location: ' . $gcashCheckoutUrl);
        exit();
    } catch (Exception $e) {
        echo 'Error processing payment: ' . $e->getMessage();
    }
}

// Function to make PayMongo API requests
function createPaymongoRequest($url, $data, $secretKey)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($secretKey . ':'), // Basic Auth
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        throw new Exception('Unable to process PayMongo API request.');
    }

    $decodedResponse = json_decode($response);

    if (isset($decodedResponse->errors)) {
        throw new Exception('API Error: ' . $decodedResponse->errors[0]->detail);
    }

    return $decodedResponse;
}
?>
