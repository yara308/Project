<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../../').'/_init.php';

if ($request->server['REQUEST_METHOD'] == 'POST' && $request->post['action_type'] == 'DELETE')
{
  try {

  	// Validate quotation id
    if (empty($request->post['reference_no'])) {
        throw new Exception(trans('error_reference_no'));
    }

    $reference_no = $request->post['reference_no'];
    $quotation_model = registry()->get('loader')->model('quotation');
    $store_id = store_id();

    // Check, if quotation exist or not
    $quotation_info = $quotation_model->getQuotationInfo($reference_no);
    if (!$quotation_info) {
        throw new Exception(trans('error_quotation_not_found'));
    }

    // Fetch selling quotation item
    $statement = db()->prepare("SELECT * FROM `quotation_item` WHERE `store_id` = ? AND `reference_no` = ?");
    $statement->execute(array($store_id, $reference_no));
    $quotation_items = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check, if quotation item exist or not
    if (!$statement->rowCount()) {
        throw new Exception(trans('error_quotation_item'));
    }

    // Delete items
    $statement = db()->prepare("DELETE FROM `quotation_item` WHERE `store_id` = ? AND `reference_no` = ?");
    $statement->execute(array($store_id, $reference_no));

    // Delete quotation price info
    $statement = db()->prepare("DELETE FROM  `quotation_price` WHERE `store_id` = ? AND `reference_no` = ? LIMIT 1");
    $statement->execute(array($store_id, $reference_no));

    // Delete quotation info
    $statement = db()->prepare("DELETE FROM  `quotation_info` WHERE `store_id` = ? AND `reference_no` = ? LIMIT 1");
    $statement->execute(array($store_id, $reference_no));

  	header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_order_deleted'), 'status' => 'ok'));
    exit();
  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}