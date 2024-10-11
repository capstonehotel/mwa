<?php
require_once('../paymentmethod/vendor/autoload.php');



// Set content type to application/json to ensure the response is valid JSON
header('Content-Type: application/json');

// Retrieve the POST data
$input = json_decode(file_get_contents('php://input'), true);
$payment_method = $input['payment_method'] ?? '';

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
                        'amount' => 10000, // Example amount in centavos (100 PHP)
                        'description' => 'Test Payment',
                        'payment_method_types' => [$payment_method]
                    ]
                ]
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        $paymentLink = $body['data']['attributes']['checkout_url'];

        // Return the payment link as a JSON response
        echo json_encode(['checkout_url' => $paymentLink]);

    } catch (Exception $e) {
        // Return an error message in JSON format
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Return an error if no payment method is selected
    echo json_encode(['error' => 'No payment method selected']);
}
?>
