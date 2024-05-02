<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
//$store = get_stores(true);
// $email_model = registry()->get('loader')->model('email');
// $email_model->send();
//$storess = store('store_id');

// Get the store ID from the query string
//$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : null;

// Now, you can use the $store_id variable in your PHP code as needed.

$document->setTitle(trans('title_home'));
include('headerst.php');
$storess = store('store_id');

// تأكد من وجود مصفوفة السلة في الجلسة
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$buttonFunction = "defaultFunction()";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedZone = $_POST["zone"];
    switch ($selectedZone) {
        case 'zone1':
            $buttonFunction = "addItemToInvoice(1684,1)";
            break;
        case 'zone2':
            $buttonFunction = "addItemToInvoice(1685,1)";
            break;
        default:
            break;
    }
}

?>
			  <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only"></div>
      </div>
    </div>
    <div class="intro-wrapper d-flex align-items-center justify-content-center text-center">
      <div class="container"><img class="big-logo" src="https://control.elmattger.com/assets/itsolution24/img/logo-favicons/1_logo.png" alt=""></div>
   </div>
<script>
function handleZoneChange() {
    var zone = document.getElementById("zone").value;
    var button = document.getElementById("submitButton");
    switch (zone) {
        case 'zone1':
            button.setAttribute("onclick", "addItemToInvoice(1684,1)");
            break;
        case 'zone2':
            button.setAttribute("onclick", "addItemToInvoice(1685,1)");
            break;
        default:
            button.removeAttribute("onclick");
            break;
    }
}
</script>

<div class="get-started-form">
    <form action="start.php" method="post" id="zoneForm">

        <select name="zone" id="zone" required onchange="handleZoneChange()">
            <option value="" selected disabled>اختر المنطقة</option>
            <option value="zone1">المنطقة 1</option>
            <option value="zone2">المنطقة 2</option>
        </select>

        <br>
    
        <div class="get-started-btn">
            <button id="submitButton" class="btn btn-warning btn-lg w-100" type="submit">الدخول الي الموقع</button>
        </div>
    </form>
</div>


    <!-- All JavaScript Files-->								
						
     
    
<?php include('footerst.php');?>