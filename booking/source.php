<?php
session_start();

// Ensure the session variable 'pay' is set and is a valid amount
if (!isset($_SESSION['pay']) || !is_numeric($_SESSION['pay'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid total amount']);
    exit;
}

// Calculate the amount based on the payment type
// Use the provided payment amount from POST or default to the session amount
$amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] * 100 : $_SESSION['pay'] * 100;

// Check if the amount is valid (not zero or negative)
if ($amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment amount']);
    exit;
}

// PayMongo Secret Key
$secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here

// Retrieve the selected payment method from the form
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

if ($paymentMethod === 'gcash') {
    // Get order details from the session
    $customerName = $_SESSION['name'] . ' ' . $_SESSION['last'];
    $customerEmail = $_SESSION['username'];
    $customerPhone = $_SESSION['phone'];

    // Construct absolute URLs for success and failed redirects
    $successUrl = 'https://mcchmhotelreservation.com/booking/process_gcash.php';
    $failedUrl = 'https://mcchmhotelreservation.com/booking/payment.php';

    try {
        // Prepare the payload
        $payload = json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $amount, // amount is in cents
                    'redirect' => [
                        'success' => $successUrl,
                        'failed' => $failedUrl
                    ],
                    'payment_method_allowed' => ["gcash"],
                    'billing' => [
                        'name' => $customerName,
                        'email' => $customerEmail,
                        'phone' => $customerPhone
                    ],
                    'type'  => 'gcash',
                    'currency' => 'PHP'
                ]
            ]
        ]);

        // Create a PayMongo source for GCash
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/sources");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($secret_key)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data']['id'])) {
            $_SESSION['paymongo_source_id'] = $result['data']['id'];

            if (isset($result['data']['attributes']['redirect']['checkout_url'])) {
                echo json_encode([
                    'success' => true,
                    'checkoutUrl' => $result['data']['attributes']['redirect']['checkout_url']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Checkout URL not found']);
            }
        } else {
            $errorMessage = isset($result['errors'][0]['detail']) ? $result['errors'][0]['detail'] : 'Unknown error';
            echo json_encode(['success' => false, 'message' => 'Failed to create GCash source: ' . $errorMessage]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid payment method']);
}
?>
