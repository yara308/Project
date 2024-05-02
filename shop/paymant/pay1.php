<?php
// Load libraries
require_once 'hesabe-php-kit/Libraries/HesabeCrypt.php';
// Load encryption keys from configuration


$merchantCode = "68592022";
$accessCode = "8a6fcd11-64e0-4429-be18-61b76fa2e40a";
$encryptionKey = "XZx9dzjrPM748jPDOBJapOkbVYyBALGR";
$ivKey = "PM748jPDOBJapOkb";
// Set up request data
$requestData = [
    'merchantCode' => $merchantCode,
    'amount' => 10.00,  // Update the value based on user input
    'paymentType' => 0,
    'responseUrl' => 'https://Kuw1.com/response',
    'failureUrl' => 'https://Kuw1.com/failure',
    'version' => '2.0'
];
//echo '<pre>'; print_r($requestData); echo '</pre>';
// Encrypt request data
$requestDataJson = json_encode($requestData);
$encryptedData = HesabeCrypt::encrypt($requestDataJson, $encryptionKey, $ivKey);

// Set up the request
$checkoutApiUrl = 'https://api.hesabe.com/checkout';
$checkoutRequestData = [
    'data' => $encryptedData
];

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $checkoutApiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($checkoutRequestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-type: application/x-www-form-urlencoded",
    "accessCode: $accessCode",
    "Accept: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Send the request
$result = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

// Close cURL
curl_close($ch);

// Decrypt the response
$decryptedResponse = HesabeCrypt::decrypt($result, $encryptionKey, $ivKey);
$responseDataJson = json_decode($decryptedResponse);

// Check for a successful response
if ($responseDataJson->status === true) {
    // Redirect to the payment page
    $paymentUrl = 'https://api.hesabe.com/payment';
    $responseToken = $responseDataJson->response->data;
    header('Location: ' . $paymentUrl . '?data=' . $responseToken);
} else {
    // Handle the error
    echo $responseDataJson->message;
}
?>
