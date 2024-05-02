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
if (user_group_id() != 1 && !has_permission('access', 'read_stock_report')) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_read_permission')));
  exit();
}

//===========================
// Datatable start
//===========================

$store_id = store_id();
$user_id = user_id();
$report_model = registry()->get('loader')->model('report');
$where_query = "item_quantity > 0 AND is_visible = 1";
if ((user_group_id() != 1 && !has_permission('access', 'read_global_stock_report')) || store_filter()) {
  $where_query .= " AND purchase_item.store_id = '{$store_id}'";
}

$table = "(SELECT purchase_item.id, purchase_item.store_id, purchase_item.item_variant_slug, purchase_item.item_variant_name, purchase_item.item_id as p_id, purchase_item.item_name as p_name, SUM(item_quantity) as quantity_in_stock, SUM(total_sell) as total_sell, SUM(item_selling_price) as sell_price, SUM(item_purchase_price) as purchase_price FROM purchase_item
  WHERE $where_query
  GROUP BY purchase_item.item_variant_slug, purchase_item.store_id
  ORDER BY purchase_item.store_id ASC) as purchase_item";

// Table's primary key
$primaryKey = 'id';

// indexes
$columns = array(
    array(
        'db' => 'p_id',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'p_id',  'dt' => 'p_id'),
    array( 'db' => 'p_id',  'dt' => 'sl'),
    array( 'db' => 'item_variant_name',  'dt' => 'item_variant_name'),
    array( 
      'db' => 'p_name',  
      'dt' => 'product_name',
      'formatter' => function( $d, $row ) {
        $variant_name = $row['item_variant_name'] ? ' ('.$row['item_variant_name'].')' : null;
        return '<a href="product_details.php?p_id='.$row['p_id'].'">'.$row['p_name'].$variant_name.'</a>';
      }
    ),
    array( 
      'db' => 'store_id',  
      'dt' => 'store',
      'formatter' => function( $d, $row ) {
        return store_field('name', $row['store_id']);
      }
    ),
    array( 'db' => 'total_sell',  'dt' => 'total_sell'),
    array( 
      'db' => 'quantity_in_stock',  
      'dt' => 'stock',
      'formatter' => function( $d, $row ) {
        // return currency_format($row['quantity_in_stock']) . '  ' . get_the_unit(get_the_product($row['p_id'],'unit_id'),'unit_name');
        return currency_format($row['quantity_in_stock'] - $row['total_sell']);
      }
    ),
    array( 
      'db' => 'sell_price',  
      'dt' => 'sell_price',
      'formatter' => function( $d, $row ) {
        return currency_format($row['sell_price'] * $row['quantity_in_stock']);
      }
    ),
    array( 
      'db' => 'purchase_price',  
      'dt' => 'purchase_price',
      'formatter' => function( $d, $row ) {
        return currency_format($row['purchase_price'] * $row['quantity_in_stock']);
      }
    ),
);

echo json_encode(
    SSP::simple( $request->get, $sql_details, $table, $primaryKey, $columns )
);

/**
 *===================
 * END DATATABLE
 *===================
 */