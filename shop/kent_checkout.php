<?php 

ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
require_once 'assets/hesabe-php-kit/Libraries/HesabeCrypt.php';
$reference_no = $request->get['reference_no'];
if (!isset($reference_no)) {
    $reference_no = '';
}

$order_model = registry()->get('loader')->model('quotation');
$order_info = $order_model->getQuotationInfo($reference_no);
if (!$order_info) {
  redirect('products.php');
}
$order_items = $order_model->getQuotationItems($reference_no);
$document->setTitle(trans('title_payment'));

$total = currency_format($order_info['payable_amount']);
// Load libraries


$merchantCode = "68592022";
$accessCode = "8a6fcd11-64e0-4429-be18-61b76fa2e40a";
$encryptionKey = "XZx9dzjrPM748jPDOBJapOkbVYyBALGR";
$ivKey = "PM748jPDOBJapOkb";

// Set up request data
$requestData = [
    'merchantCode' => $merchantCode,
    'amount' => $total, // المبلغ المقتبس
    'paymentType' => 0,
    'responseUrl' => 'https://Kuw1.com/response',
    'failureUrl' => 'https://Kuw1.com/failure',
    'version' => '2.0'
];

$encryptedData = HesabeCrypt::encrypt(json_encode($requestData), $encryptionKey, $ivKey);

$checkoutApiUrl = 'https://api.hesabe.com/checkout';
$checkoutRequestData = [
    'data' => $encryptedData
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $checkoutApiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($checkoutRequestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-type: application/x-www-form-urlencoded",
    "accessCode: $accessCode",
    "Accept: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

curl_close($ch);

$decryptedResponse = HesabeCrypt::decrypt($result, $encryptionKey, $ivKey);
$responseDataJson = json_decode($decryptedResponse);

if ($responseDataJson->status === true) {
    $paymentUrl = 'https://api.hesabe.com/payment';
    $responseToken = $responseDataJson->response->data;
    header('Location: ' . $paymentUrl . '?data=' . $responseToken);
} else {
    echo $responseDataJson->message;
}
?>
