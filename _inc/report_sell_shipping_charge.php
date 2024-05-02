<?php 
ob_start();
session_start();
include ("../_init.php");

// Check, if your logged in or not
// If user is not logged in then return an alert message
if (!is_loggedin()) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_login')));
  exit();
}

// Check, if user has reading permission or not
// If user have not reading permission return an alert message
if (user_group_id() != 1 && !has_permission('access', 'read_sell_report')) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_read_permission')));
  exit();
}

$reprot_model = registry()->get('loader')->model('report');
$store_id = store_id();

/**
 *===================
 * START DATATABLE
 *===================
 */
$where_query = "`selling_info`.`store_id` = '{$store_id}'";
$from = from();
$to = to();
$where_query .= date_range_filter($from, $to);
$table = "(SELECT `selling_info`.*, `selling_price`.`shipping_amount` AS `shipping_charge` FROM `selling_info` LEFT JOIN `selling_price` ON (`selling_info`.`invoice_id`=`selling_price`.`invoice_id`) WHERE {$where_query}) as selling_info";

// Table's primary key
$primaryKey = 'info_id';

$columns = array(
    array( 
      'db' => 'created_at',  
      'dt' => 'created_at',
      'formatter' => function( $d, $row ) {
        return $row['created_at'];
      }
    ),
    array( 
      'db' => 'invoice_id',  
      'dt' => 'invoice_id',
      'formatter' => function( $d, $row ) {
        return $row['invoice_id'];
      }
    ),
    array( 
      'db' => 'shipping_charge',  
      'dt' => 'shipping_charge',
      'formatter' => function( $d, $row ) {
        $total = $row['shipping_charge'];
        return currency_format($total);
      }
    ),
);
echo json_encode(
    SSP::simple( $request->get, $sql_details, $table, $primaryKey, $columns )
);