<?php
header('Content-Type: application/json');

// PayMongo API Configuration
define('PAYMONGO_SECRET_KEY', 'sk_test_8FHikGJxuzFP3ix4itFTcQCv');
define('PAYMONGO_API_URL', 'https://api.paymongo.com/v1');

// Function to make API requests to PayMongo
function makePayMongoRequest($endpoint, $data) {
    $ch = curl_init(PAYMONGO_API_URL . $endpoint);
    
    $headers = [
        'Authorization: Basic ' . base64_encode(PAYMONGO_SECRET_KEY . ':'),
        'Content-Type: application/json'
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        throw new Exception('cURL Error: ' . $error);
    }
    
    return json_decode($response, true);
}

try {
    // Validate payment method
    if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
        throw new Exception('Payment method is required');
    }
    
    // Get customer details from session
    $firstName = $_SESSION['name'];
    $lastName = $_SESSION['last'];
    $phone = $_SESSION['phone'];
    $username = $_SESSION['username'];
    
    // Validate customer details
    if (empty($firstName) || empty($lastName) || empty($phone)) {
        throw new Exception('Customer details are incomplete');
    }
    
    $paymentMethod = $_POST['payment_method'];
    $amount = isset($_SESSION['pay']) ? $_SESSION['pay'] * 100 : 0; // Convert to cents
    
    // Validate amount
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }
    
    // Create payment source based on selected payment method
    $sourceType = strtolower($paymentMethod) === 'gcash' ? 'gcash' : 'grab_pay';
    
    // Prepare customer name
    $fullName = trim($firstName . ' ' . $lastName);
    
    // Create a source with complete billing information
    $sourceData = [
        'data' => [
            'attributes' => [
                'amount' => $amount,
                'currency' => 'PHP',
                'redirect' => [
                    'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment',
                    'failed' => 'https://your-domain.com/failed.php'
                ],
                'type' => $sourceType,
                'billing' => [
                    'name' => $fullName,
                    'phone' => $phone,
                    'email' => $username,
                    'metadata' => [
                        'first_name' => $firstName,
                        'last_name' => $lastName
                    ]
                ],
                'metadata' => [
                    'customer_username' => $username,
                    'payment_method' => $paymentMethod
                ]
            ]
        ]
    ];
    
    // Create the payment source
    $sourceResponse = makePayMongoRequest('/sources', $sourceData);
    
    if (!isset($sourceResponse['data']['attributes']['checkout_url'])) {
        throw new Exception('Failed to create payment source');
    }
    
    // Store important information in session for later verification
    $_SESSION['payment_source_id'] = $sourceResponse['data']['id'];
    $_SESSION['payment_amount'] = $amount;
    $_SESSION['payment_method'] = $paymentMethod;
    
    // Log the payment attempt
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'customer_name' => $fullName,
        'amount' => $amount / 100, // Convert back to PHP for logging
        'payment_method' => $paymentMethod,
        'source_id' => $sourceResponse['data']['id']
    ];
    
    // You might want to implement proper logging here
    error_log("Payment Attempt: " . json_encode($logData));
    
    // Return the checkout URL to the frontend
    echo json_encode([
        'success' => true,
        'checkout_url' => $sourceResponse['data']['attributes']['checkout_url'],
        'source_id' => $sourceResponse['data']['id']
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    error_log("Payment Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>