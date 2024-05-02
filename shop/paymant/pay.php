<?php

// تحميل المكتبات
require_once 'hesabe-php-kit/Libraries/HesabeCrypt.php';




// احصل على بيانات اعتماد API الخاصة بك من Hesabe
$merchantCode = "68592022";
$accessCode = "8a6fcd11-64e0-4429-be18-61b76fa2e40a";
$encryptionKey = "XZx9dzjrPM748jPDOBJapOkbVYyBALGR";
$ivKey = "PM748jPDOBJapOkb";

// احصل على بيانات الدفع من المستخدم
$amount = 100.00;
$paymentType = 1; // 0 = Indirect, 1 = Knet, 2 = MPGS
$responseUrl = "https://kuw1.com/response";
$failureUrl = "https://kuw1.com/failure";

// قم بإنشاء كائن طلب
$requestData = [
    "merchantCode" => $merchantCode,
    "amount" => $amount,
    "paymentType" => $paymentType,
    "responseUrl" => $responseUrl,
    "failureUrl" => $failureUrl,
];

// قم بتشفير بيانات الطلب
$encryptedData = HesabeCrypt::encrypt(json_encode($requestData), $encryptionKey, $ivKey);
//echo $encryptedData ;
 
// أرسل طلب الدفع إلى Hesabe
$url = "https://api.hesabe.com/checkout";
$headers = [
    "accessCode" => $accessCode,
];
$response = file_get_contents($url, false, stream_context_create([
    "http" => [
        "header" => $headers,
    ],
]));

//echo '<pre>'; print_r($headers); echo '</pre>';

// فك تشفير استجابة Hesabe
$decryptedResponse = HesabeCrypt::decrypt($response, $encryptionKey, $ivKey);
$responseData = json_decode($decryptedResponse);


// تحقق من حالة استجابة Hesabe
if ($responseData->status == "SUCCESS") {
    // يتم قبول الدفع
    // قم بإعادة توجيه المستخدم إلى صفحة الدفع
    header("Location: " . $responseData->data);
} else {
    // فشل الدفع
    // عرض رسالة خطأ للمستخدم
    echo $responseData->message;
}


?>
