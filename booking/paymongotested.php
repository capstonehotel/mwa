<?php
// // paymongo.php
// session_start();

// // Assuming the session variable 'pay' is set
// $amount = $_SESSION['pay'] * 100;
// 

// 
// // Replace these with your PayMongo API keys
// $paymongo_secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here
// $paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu'; // Use your public key here

// // Retrieve the selected payment method from the form
// $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// // Handle different payment methods (GCash and PayMaya)
// if ($paymentMethod === 'Gcash' || $paymentMethod === 'Paymaya') {
//     try {
//         // Step 1: Create a Payment Intent
//         $paymentIntentData = [
//             'data' => [
//                 'attributes' => [
//                     'amount' => $amount, // Amount in cents (e.g., 10000 = PHP 100)
//                     'payment_method_allowed' => [$paymentMethod === 'Gcash' ? 'gcash' : 'paymaya'],
//                     'currency' => 'PHP',
//                     'description' => 'Payment for booking', // Add your own description
//                     'statement_descriptor' => 'Booking Payment'
//                 ]
//             ]
//         ];

//         $response = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents', $paymentIntentData, $paymongo_secret_key);

//         // Extract the payment intent ID
//         $paymentIntentId = $response->data->id;

//         // Step 2: Create a Source for the selected payment method
//         $sourceData = [
//             'data' => [
//                 'attributes' => [
//                     'amount' => $amount, // Amount in centavos (e.g., 23400 = PHP 234)
//                     'redirect' => [
//                         'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment', // Success URL
//                         'failed' => 'https://mcchmhotelreservation.com/booking/payment.php', // Failure URL
//                     ],
//                     'type' => $paymentMethod === 'Gcash' ? 'gcash' : 'paymaya',
//                     'currency' => 'PHP',
//                     'billing' => [
//                         'name' => 'Kyebe',
//                         'email' => 'kyebe@gmail.com',
//                         'phone' => '09354353453',
//                     ]
//                 ]
//             ]
//         ];
        

//         // Create a source for the selected payment method
//         $sourceResponse = createPaymongoRequest('https://api.paymongo.com/v1/sources', $sourceData, $paymongo_secret_key);

//         // Get the checkout URL from the source response
//         $checkoutUrl = $sourceResponse->data->attributes->redirect->checkout_url;

//         // Return the checkout URL as JSON
//         header('Content-Type: application/json');
//         echo json_encode(['checkout_url' => $checkoutUrl]);
//         exit();
//     } catch (Exception $e) {
//         // Return error message as JSON
//         header('Content-Type: application/json');
//         echo json_encode(['message' => 'Error processing payment: ' . $e->getMessage()]);
//     }
// }

// // Function to make PayMongo API requests
// function createPaymongoRequest($url, $data, $secretKey)
// {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Authorization: Basic ' . base64_encode($secretKey . ':'), // Basic Auth
//         'Content-Type: application/json',
//     ]);

//     $response = curl_exec($ch);
//     curl_close($ch);

//     if (!$response) {
//         throw new Exception('Unable to process PayMongo API request.');
//     }

//     $decodedResponse = json_decode($response);

//     if (isset($decodedResponse->errors)) {
//         throw new Exception('API Error: ' . $decodedResponse->errors[0]->detail);
//     }

//     return $decodedResponse;
// }
?>
<?php
session_start();

// Assuming the session variable 'pay' is set
$amount = $_SESSION['pay'] * 100; // Convert pesos to centavos

// Replace these with your PayMongo API keys
$paymongo_secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv'; // Use your secret key here
$paymongo_public_key = 'pk_test_WLnVGBjNdZeqPjoSUpyDk7qu'; // Use your public key here

// Retrieve the selected payment method from the form
$paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// Handle different payment methods (GCash and PayMaya)
if ($paymentMethod === 'Gcash' || $paymentMethod === 'Paymaya') {
    try {
        // Step 1: Create a Payment Intent
        $paymentIntentData = [
            'data' => [
                'type' => 'payment_method', // Specify the type of resource
                'attributes' => [
                    'amount' => $amount, // Amount in cents
                    'currency' => 'PHP',
                    'description' => 'Payment for booking',
                    'statement_descriptor' => 'Booking Payment',
                    'payment_method_allowed' => ['gcash', 'paymaya'], // Allowed payment method
                ]
            ]
        ];
        

        // Create payment intent
        $paymentIntentResponse = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents', $paymentIntentData, $paymongo_secret_key);

        // Extract the payment intent ID
        $paymentIntentId = $paymentIntentResponse->data->id;

        // Step 2: Create a Source for the selected payment method
        $sourceData = [
            'data' => [
                'attributes' => [
                    'amount' => $amount, // Amount in centavos
                    'redirect' => [
                        'success' => 'https://mcchmhotelreservation.com/booking/index.php?view=payment', // Success URL
                        'failed' => 'https://mcchmhotelreservation.com/booking/payment.php', // Failure URL
                    ],
                    'type' => $paymentMethod === 'Gcash' ? 'gcash' : 'paymaya',
                    'currency' => 'PHP',
                    'billing' => [
                        'name' => 'Kyebe', // Client's name
                        'email' => 'kyebe@gmail.com', // Client's email
                        'phone' => '09354353453', // Client's phone number
                    ]
                ]
            ]
        ];

        // Create a source for the selected payment method
        $sourceResponse = createPaymongoRequest('https://api.paymongo.com/v1/sources', $sourceData, $paymongo_secret_key);

        // Get the source ID from the response
        $sourceId = $sourceResponse->data->id;

        // Step 3: Attach the source to the payment intent
        $attachSourceData = [
            'data' => [
                'attributes' => [
                    'source' => $sourceId
                ]
            ]
        ];

        // Attach the source to the payment intent
        $attachResponse = createPaymongoRequest('https://api.paymongo.com/v1/payment_intents/' . $paymentIntentId . '/attach', $attachSourceData, $paymongo_secret_key);

        // Check if the payment was successful
        if ($attachResponse->data->attributes->status === 'succeeded') {
            // Return the checkout URL as JSON
            header('Content-Type: application/json');
            echo json_encode(['checkout_url' => $sourceResponse->data->attributes->redirect->checkout_url]);
            exit();
        } else {
            throw new Exception('Payment failed: ' . $attachResponse->data->attributes->status);
        }

    } catch (Exception $e) {
        // Return error message as JSON
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Error processing payment: ' . $e->getMessage()]);
        exit();
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
