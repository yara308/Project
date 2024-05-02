<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../../').'/_init.php';

$order_model = registry()->get('loader')->model('quotation');
function validate_request_data($request) 
{
  // Validate product
  if (!isset($request->post['items']) || empty($request->post['items'])) {
      throw new Exception(trans('error_items'));
  }

  // Validate payadble amount
  if (!is_numeric($request->post['total_amount'])) {
    throw new Exception(trans('error_total_amount'));
  }

  // Validate address
  if (empty($request->post['address'])) {
    throw new Exception(trans('error_address'));
  }
}

// Validate Items
function validate_order_items($items)
{
  foreach ($items as $item) 
  {
    // Validate product id
    if (!validateInteger($item['item_id'])) {
      throw new Exception(trans('error_invalid_item_id'));
    }

    // Fetch product item
    $the_product = get_the_product($item['item_id'], null, store_id());

    // Check, product item exist or not
    if (!$the_product) {
      throw new Exception(trans('error_product_not_found'));
    }

    // Validate product name
    if (!validateString($item['item_name'])) {
      throw new Exception(trans('error_item_name'));
    }

    // Validate product quantity
    if (!validateFloat($item['quantity'])) {
      throw new Exception(trans('error_item_quantity'));
    }

    // Validate product price
    if (!validateFloat($item['price'])) {
      throw new Exception(trans('error_price'));
    }

    // Validate payment method
    if (isset($item['pmethod']['name']) && !validateString($item['pmethod']['name'])) {
      throw new Exception(trans('error_payment_method'));
    }
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' && $request->get['action_type'] == 'CREATE')
{
  try {

    validate_request_data($request);

    if (!isset($request->post['items']) || empty($request->post['items'])) {
      throw new Exception(trans('error_product_item'));
    }

    $reference_no = unique_id();
    $items = $request->post['items'];
    $pmethod_details = json_encode($request->post['pmethod']);
    $address = json_encode($request->post['address']);
 // تحقق من وجود $reference_no في جدول quotation_info
    $checkStatement = db()->prepare("SELECT COUNT(*) as count FROM `quotation_info` WHERE `reference_no` = ?");
    $checkStatement->execute(array($reference_no));
    $result = $checkStatement->fetch(PDO::FETCH_ASSOC);

    // إذا كان موجودًا، أضف رقمًا عشوائيًا إليه
    if($result['count'] > 0) {
    $randomNumber = rand(1000, 9999); // رقم عشوائي بين 1000 و 9999
    $reference_no .= $randomNumber;
    }
    validate_order_items($items);

    $products = array();
    foreach ($items as $item) {
        $products[] = array(
            'item_id' => $item['item_id'],
            'sup_id' => $item['sup_id'],
            'item_name' => $item['item_name'],
            'variant_slug' => $item['variant_slug'],
            'variant_name' => $item['variant_name'],
            'quantity' => $item['quantity'],
            'sell_price' => $item['price'],
            'taxrate' => 1,
            'tax_amount' => 0,
        );
    };
//$customer_id = $session->data['cid'];
    $customer_id = isset($session->data['cid']) ? (int)$session->data['cid'] : 0;

   
    $request->post = array(
        'reference_no' => $reference_no,
        'quotation-note' => '',
        'customer_id' => 1,
        'discount-amount' => 0,
        'shipping-amount' =>  $request->post['shipping-amount'],
        'others-charge' => $request->post['others-charge'],
        'order-tax-amount' => $request->post['order-tax-amount'],
        'total-tax-amount' => $request->post['total-tax-amount'],
        'total-amount' => $request->post['total_amount'],
        'payable-amount' => $request->post['total_amount'],
        'status' => 'pending',
        'products' => $products,
        'is_order' => 1,
    );

  

     // الآن استخدم الـ $reference_no المحدث عند إدراج البيانات في الجدول
    $reference_no = $order_model->createQuotation($request, store_id());

    $statement = db()->prepare("UPDATE `quotation_info` SET `pmethod_details` = ?, `address` = ? WHERE `reference_no` = ?");
	 
    $statement->execute(array($pmethod_details, $address, $reference_no));

	  
	  
    $statement = db()->prepare("UPDATE `customers` SET `pmethod_details` = ?, `address` = ? WHERE `reference_no` = ?");
    $statement->execute(array($pmethod_details, $address, $reference_no));
	  
    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_order_placed'), 'status' => 'ok', 'reference_no' => $reference_no));
    exit();
  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}