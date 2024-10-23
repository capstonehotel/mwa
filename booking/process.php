<?php

function processGcashPayment() {
 
    
    $source_id = $_SESSION['paymongo_source_id'] ?? '';
    if (empty($source_id)) {
        error_log("PayMongo source ID not found in session");
        return false;
    }
    
    $secret_key = 'sk_test_8FHikGJxuzFP3ix4itFTcQCv';
    
    // First, verify the source status
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/sources/$source_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode($secret_key)
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($result['data']['attributes']['status'] === 'chargeable') {
        // Source is chargeable, now create a payment
        $payload = json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $result['data']['attributes']['amount'],
                    'source' => [
                        'id' => $source_id,
                        'type' => 'source'
                    ],
                    'currency' => 'PHP',
                    'description' => 'Online Payment'
                ]
            ]
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . base64_encode($secret_key),
            "Content-Type: application/json"
        ]);
        
        $payment_response = curl_exec($ch);
        curl_close($ch);
        
        $payment_result = json_decode($payment_response, true);
        
        if ($payment_result['data']['attributes']['status'] === 'paid') {
            // Payment was successful, create the order
         
            message("Paid", "success");
            redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
            unset($_SESSION['paymongo_source_id']);
      
            
            return true;
        } else {
            error_log("GCash payment failed. Status: " . $payment_result['data']['attributes']['status']);
            return false;
        }
    } else {
        error_log("GCash source not chargeable. Status: " . $result['data']['attributes']['status']);
        return false;
    }
}


  
    if (processGcashPayment()) {
        //message("Your GCash payment was successful and your order has been created!", "success");
        redirect("https://mcchmhotelreservation.com/booking/index.php?view=payment");
    } else {
        //message("GCash payment was not successful. Please try again.", "error");
        redirect("https://mcchmhotelreservation.com/booking/payment.php");
    }

?>