<?php
// session_start();
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
    
    $paymentMethod = $_POST['payment_method'];
    $amount = isset($_SESSION['pay']) ? $_SESSION['pay'] * 100 : 0; // Convert to cents
    
    // Validate amount
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }
    
    // Create payment source based on selected payment method
    $sourceType = strtolower($paymentMethod) === 'gcash' ? 'gcash' : 'grab_pay';
    
    // Create a source
    $sourceData = [
        'data' => [
            'attributes' => [
                'amount' => $amount,
                'currency' => 'PHP',
                'redirect' => [
                    'success' => 'https://your-domain.com/success.php',
                    'failed' => 'https://your-domain.com/failed.php'
                ],
                'type' => $sourceType,
                'billing' => [
                    'name' => $_SESSION['customer_name'] ?? 'Customer Name',
                    'email' => $_SESSION['customer_email'] ?? 'customer@email.com'
                ]
            ]
        ]
    ];
    
    // Create the payment source
    $sourceResponse = makePayMongoRequest('/sources', $sourceData);
    
    if (!isset($sourceResponse['data']['attributes']['checkout_url'])) {
        throw new Exception('Failed to create payment source');
    }
    
    // Store the source ID in session for later verification
    $_SESSION['payment_source_id'] = $sourceResponse['data']['id'];
    
    // Return the checkout URL to the frontend
    echo json_encode([
        'success' => true,
        'checkout_url' => $sourceResponse['data']['attributes']['checkout_url']
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>