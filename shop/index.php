
<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
session_start();

// Get the store ID from the query string
$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : null;

// Now, you can use the $store_id variable in your PHP code as needed.

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
     header("Location: /welcome?store_id=$id");
        //echo "Found ID: $id";
    } else {
        echo "Link not found in the database.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
//header("Location:home.php?store_id= echo $ths_store['store_id'];);
?>
<html>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1027066651831151');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1027066651831151&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</html>