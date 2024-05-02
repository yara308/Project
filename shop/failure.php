<?php

// ابدأ بتضمين الملفات والمكتبات الضرورية
// مثل مكتبة فك التشفير إذا كانت مطلوبة

ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
require_once 'assets/hesabe-php-kit/Libraries/HesabeCrypt.php';
// إذا كنت تستخدم أي ملفات تهيئة أو إعدادات
// include 'path_to_your_config_file.php';

// التحقق من وجود المعامل data في الرابط
if (isset($_GET['data'])) {
    $encryptedData = $_GET['data'];
    
    // هنا، قم بفك تشفير البيانات إذا كانت مشفرة
    // $decryptedData = YourDecryptionFunction($encryptedData);

    // عرض الرسالة للمستخدم
    echo "عذرًا، حدث خطأ أثناء محاولة الدفع. يرجى المحاولة مرة أخرى.";
    
    // يمكنك هنا أيضًا إضافة البيانات المشفرة أو المفككة التشفير إذا أردت عرضها للتحقق
    // echo "<pre>" . print_r($decryptedData, true) . "</pre>";

} else {
    echo "لم يتم توفير بيانات.";
}

?>
