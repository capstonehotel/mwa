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
    
    // Get and validate customer details
    $customerName = isset($_SESSION['name']) && isset($_SESSION['last']) 
        ? trim($_SESSION['name'] . ' ' . $_SESSION['last'])
        : '';
    $customerPhone = $_SESSION['phone'] ?? '';
    $customerUsername = $_SESSION['username'] ?? '';
    
    if (empty($customerName)) {
        throw new Exception('Customer name is required');
    }
    
    $paymentMethod = $_POST['payment_method'];
    $amount = isset($_SESSION['pay']) ? $_SESSION['pay'] * 100 : 0; // Convert to cents
    
    // Validate amount
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }
    
    // Create reference number for tracking
    $referenceNumber = 'BOOK-' . time() . '-' . substr(uniqid(), -4);
    $_SESSION['reference_number'] = $referenceNumber;
    
    // Create payment source based on selected payment method
    $sourceType = strtolower($paymentMethod) === 'gcash' ? 'gcash' : 'paymaya';
    
    // Create a source with complete customer details
    $sourceData = [
        'data' => [
            'attributes' => [
                'amount' => $amount,
                'currency' => 'PHP',
                'redirect' => [
                    'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment',
                    'failed' => 'https://mcchmhotelreservation.com/booking/index.php?'
                ],
                'type' => $sourceType,
                'billing' => [
                    'name' => $customerName,
                    'phone' => $customerPhone,
                    'email' => $customerUsername . '@example.com', // Add proper email field if available
                ],
                'metadata' => [
                    'reference_number' => $referenceNumber,
                    'username' => $customerUsername,
                    'phone' => $customerPhone
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
        'reference_number' => $referenceNumber,
        'customer_name' => $customerName,
        'customer_phone' => $customerPhone,
        'username' => $customerUsername,
        'amount' => $amount / 100, // Convert back to PHP for logging
        'payment_method' => $paymentMethod,
        'source_id' => $sourceResponse['data']['id']
    ];
    
    // Log to file (you may want to use a database instead)
    file_put_contents(
        'payment_logs.txt', 
        json_encode($logData) . "\n", 
        FILE_APPEND
    );
    
    // Return the checkout URL and reference number to the frontend
    echo json_encode([
        'success' => true,
        'checkout_url' => $sourceResponse['data']['attributes']['checkout_url'],
        'reference_number' => $referenceNumber
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>