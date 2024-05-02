<?php
$host = "localhost";
$db = "admin_onz";//products
$charset = "utf8mb4";//p_name_url
$user = "admin_onz0";
$pass = "admin_onz0";


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Execute the SQL query
    $sql = "UPDATE products SET p_name_url = REPLACE(REPLACE(p_name_url, ' ', '-'), '''', '-')";

    $pdo->exec($sql);

    echo "Data updated successfully!";
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

?>

