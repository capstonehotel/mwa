<?php
require_once('../paymongo/vendor/autoload.php');

// Set content type to application/json
header('Content-Type: application/json');

// Retrieve the POST data
$payment_method = $_POST['payment_method'] ?? '';

// Ensure that session is started and session value is set
session_start();
if (!isset($_SESSION['pay']) || empty($_SESSION['pay'])) {
    echo json_encode(['error' => 'Payment amount is missing']);
    exit;
}

$amount = $_SESSION['pay']; // Amount in PHP centavos

if ($payment_method) {
    // PayMongo API Key (replace with your actual test key)
    $apiKey = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';

    try {
        $client = new \GuzzleHttp\Client();

        // Create the payment link request
        $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                'content-type' => 'application/json',
            ],
            'json' => [
                'data' => [
                    'attributes' => [
                        'amount' => $amount, // Amount from session in centavos
                        'description' => 'Test Payment',
                        'payment_method_types' => [$payment_method]
                    ]
                ]
            ]
        ]);

        // Decode the JSON response body
        $body = json_decode($response->getBody(), true);

        // Extract the payment link from the response
        if (isset($body['data']['attributes']['checkout_url'])) {
            $paymentLink = $body['data']['attributes']['checkout_url'];
            // Return the payment link as a JSON response
            echo json_encode(['checkout_url' => $paymentLink]);
        } else {
            // Handle case where checkout_url is not present
            echo json_encode(['error' => 'Payment link could not be generated']);
        }

    } catch (Exception $e) {
        // Return an error message in JSON format
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Return an error if no payment method is selected
    echo json_encode(['error' => 'No payment method selected']);
}
?>
