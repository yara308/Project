
<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
session_start();
//include realpath(__DIR__).'/_init.php';
//echo root_url();
//$getstore= root_url();
//echo $getstore ;
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$hostname = $_SERVER['HTTP_HOST'];
$root_url = $protocol . $hostname;

//echo $root_url;
$linkToSearch = $root_url;
//$linkToSearch = $getstore;
//https://shop.elmattger.com/
$host = 'localhost';
$dbname = 'admin_onz';
$username = 'admin_onz0';
$password = 'admin_onz0';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

try {
    $stmt = $pdo->prepare("SELECT store_id FROM stores WHERE store_link = :linkToSearch");
    $stmt->bindParam(':linkToSearch', $linkToSearch, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

   // var_dump($result); // Debugging

    if ($result) {
        $id = $result['store_id'];
     header("Location: home.php?store_id=$id");
        //echo "Found ID: $id";
    } else {
        echo "Link not found in the database.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
//header("Location:home.php?store_id= echo $ths_store['store_id'];);