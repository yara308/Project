<?php

$host = "localhost";
$db = "admin_onz";
$charset = "utf8mb4";
$user = "admin_onz0";
$pass = "admin_onz0";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

function generateSlug($arabicText) {
    // You can use a transliteration library to convert Arabic to English, like PHP Intl
    // Here's a simple example using PHP Intl for transliteration:
    if (extension_loaded('intl')) {

		$arabicText = str_replace(["\t", "\n", "\r", "\0", "\x0B", "\xc2\xa0"], '-', $arabicText);

        $englishSlug = transliterator_transliterate('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();', $arabicText);
        
        // Remove specific punctuations
        $englishSlug = str_replace(['.', '":', ';', '}', '{', ')', '(', '\''], '', $englishSlug);
        
        // Replace the Arabic letter 'ʿ' (Ayn) with a dash or remove it as per your requirement
        $englishSlug = str_replace('ʿ', '-', $englishSlug); // Here, I'm replacing it with a dash
        
        // Replace spaces with dashes
        $englishSlug = str_replace(' ', '-', $englishSlug);
        return $englishSlug;
    }

    // If intl extension is not available, you can implement your own transliteration function.
    // Note that a complete transliteration can be quite complex due to various Arabic diacritics.
    return null; // Add this line to explicitly return null if intl isn't available
}

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Fetch all products
    $stmt = $pdo->query('SELECT p_id, p_name FROM products');
    $products = $stmt->fetchAll();

    // Prepare an UPDATE statement
    $updateStmt = $pdo->prepare('UPDATE products SET p_name_url = :p_name_url WHERE p_id = :p_id');

    // Loop through each product and update the p_name_url
    foreach ($products as $product) {
        $slug = generateSlug($product['p_name']);

        if ($slug) { // Ensure slug is generated before updating
            $updateStmt->execute([
                ':p_name_url' => $slug,
                ':p_id' => $product['p_id']
            ]);
        }
    }

    echo "All products updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Output the error for debugging
}

?>

