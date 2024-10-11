<?php
require_once('../paymongo/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// Fetch the PayMongo secret key from environment variables
$secretKey = getenv('PAYMONGO_SECRET_KEY');

if (!$secretKey) {
    die('PAYMONGO_SECRET_KEY is not set in environment variables');
}

// Initialize the Guzzle client
$client = new Client([
    'base_uri' => 'https://api.paymongo.com/v1/',
    'timeout'  => 10.0,
]);
// Your PayMongo secret key (ensure you keep this secure!)
$secretKey = ''; // Replace with your actual secret key

// Prepare the request headers
$headers = [
    'Accept' => 'application/json',
    'Authorization' => 'Basic ' . base64_encode($secretKey . ':'),
    'Content-Type' => 'application/json',
];

// Define the payment link data
$paymentLinkData = [
    'data' => [
        'attributes' => [
            'description' => 'Test Payment',
            'amount' => 100000, // Amount in smallest currency unit (e.g., 100000 = 1,000.00 PHP)
            'currency' => 'PHP',
            'checkout' => [
                'success_url' => 'https://yourdomain.com/success',
                'failed_url' => 'https://yourdomain.com/failed',
            ],
            'redirect' => [
                'success' => 'https://yourdomain.com/success',
                'failed' => 'https://yourdomain.com/failed',
            ],
        ],
    ],
];

try {
    // Send the POST request to create a payment link
    $response = $client->request('POST', 'links', [
        'headers' => $headers,
        'json' => $paymentLinkData,
    ]);

    // Decode the JSON response
    $responseBody = json_decode($response->getBody(), true);

    // Output the payment link details
    echo "Payment Link Created Successfully!\n";
    echo "Link ID: " . $responseBody['data']['id'] . "\n";
    echo "Payment URL: " . $responseBody['data']['attributes']['checkout_url'] . "\n";

} catch (RequestException $e) {
    // Handle errors
    if ($e->hasResponse()) {
        $errorResponse = json_decode($e->getResponse()->getBody(), true);
        echo "Error: " . $errorResponse['error']['message'] . "\n";
    } else {
        echo "Request Error: " . $e->getMessage() . "\n";
    }
}
