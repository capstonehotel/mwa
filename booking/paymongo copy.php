 <?php
session_start(); // Start the session to access session variables

require_once('../paymentmethod/vendor/autoload.php'); // Include PayMongo's library

$client = new \GuzzleHttp\Client();

// Check if the session variable 'pay' is set and is a positive integer
$amountInCents = isset($_SESSION['pay']) && is_numeric($_SESSION['pay']) ? (int)$_SESSION['pay'] : 0;

if ($amountInCents <= 0) {
    echo "Error: Invalid payment amount.";
    exit;
}

// Define payment data
$paymentMethod = isset($_POST['payment_method']) ? strtolower(trim($_POST['payment_method'])) : 'gcash'; // Ensure it's lowercase and trimmed

// Prepare the payment data
$paymentData = [
    'data' => [
        'attributes' => [
            'amount' => $amountInCents, // Amount in cents
            'currency' => 'PHP',
            'description' => 'Payment for booking', // Description of the payment
            'payment_method' => [
                'type' => $paymentMethod, // Payment method type
            ],
        ],
    ],
];

try {
    // Make a request to PayMongo API
    $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'Authorization' => 'sk_test_8FHikGJxuzFP3ix4itFTcQCv', // Replace with your actual PayMongo secret key
        ],
        'json' => $paymentData,
    ]);

    // Decode the response
    $responseData = json_decode($response->getBody(), true);

    // Check if the response contains the payment link
    if (isset($responseData['data']['attributes']['url'])) {
        $paymentLink = $responseData['data']['attributes']['url']; // Get the payment link
        // Redirect the user to the payment link
        header("Location: $paymentLink");
        exit;
    } else {
        echo "Error: Payment link not found.";
        exit;
    }

} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Handle errors and display an appropriate message
    echo "Error: " . $e->getMessage();
    exit;
}
?>
