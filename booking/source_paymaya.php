<?php
// source_paymaya.php
session_start();

// Assuming the session variable 'pay' is set
$amount = $_SESSION['pay'] * 100;

// PayMongo Secret Key
$secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';
$paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu';

// Retrieve the selected payment method from the form
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Handle different payment methods (GCash and PayMaya)
if ($paymentMethod === 'gcash' || $paymentMethod === 'paymaya') {
    // Get order details from the form
    $customerName = 'Kyebe';
    $customerEmail = 'kyebe@gmail.com';
    $customerno = '09123456789';

    // Construct absolute URLs for success and failed redirects
    $successUrl = 'https://mcchmhotelreservation.com/booking/process_maya.php';
    $failedUrl = 'https://mcchmhotelreservation.com/booking/payment.php';

    try {
        // Prepare the payload
        $payload = json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'redirect' => [
                        'success' => $successUrl,
                        'failed' => $failedUrl
                    ],
                    'billing' => [
                        'name' => $customerName,
                        'email' => $customerEmail,
                        'phone' => $customerno
                    ],
                    // Fix: Set the correct type for PayMaya
                    'type' => 'paymaya',  // Always set to 'paymaya' for this file
                    'currency' => 'PHP'
                ]
            ]
        ]);

        error_log("PayMongo API Request Payload: " . $payload);

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
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if(curl_errno($ch)){
            error_log('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        error_log("PayMongo API Response: " . $response);
        error_log("HTTP Code: " . $httpCode);

        $result = json_decode($response, true);

        if ($httpCode == 200 && isset($result['data']['id'])) {
            $_SESSION['paymongo_source_id'] = $result['data']['id'];

            if (isset($result['data']['attributes']['redirect']['checkout_url'])) {
                $checkoutUrl = $result['data']['attributes']['redirect']['checkout_url'];
                echo json_encode([
                    'success' => true,
                    'checkoutUrl' => $checkoutUrl
                ]);
            } else {
                error_log("Checkout URL not found in the response");
                echo json_encode([
                    'success' => false,
                    'message' => 'Checkout URL not found in the response'
                ]);
            }
        } else {
            $errorMessage = isset($result['errors'][0]['detail']) ? $result['errors'][0]['detail'] : 'Unknown error occurred';
            $errorCode = isset($result['errors'][0]['code']) ? $result['errors'][0]['code'] : 'Unknown';
            error_log("PayMongo Error: Code - " . $errorCode . ", Message - " . $errorMessage);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create PayMaya source: ' . $errorMessage,
                'errorCode' => $errorCode
            ]);
        }
    } catch (Exception $e) {
        error_log("PayMongo Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>