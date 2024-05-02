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
if (user_group_id() != 1 && !has_permission('access', 'read_profit_loss_report')) {
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

$where_query = "selling_info.inv_type != 'due_paid' AND selling_info.store_id = '{$store_id}'";
if (isset($request->get['type']) && $request->get['type'] && $request->get['type'] != 'null') {
  $type = $request->get['type'];
} else {
  $type = 'itemwise';
}
$from = from();
$to = to();
$where_query .= date_range_filter($from, $to);

switch ($type) {
  case 'itemwise':
      $where_query .= " AND selling_item.item_id != '' AND selling_item.item_id IS NOT NULL";
      $table = "(SELECT @sl:=@sl+1 AS sl, selling_item.id, selling_item.item_variant_slug, selling_item.item_id as content_id, SUM(selling_item.item_quantity) as quantity, SUM(selling_item.profit) as profit FROM selling_item LEFT JOIN selling_info ON (selling_item.invoice_id = selling_info.invoice_id)
      WHERE {$where_query}
      GROUP BY selling_item.item_id, selling_item.item_variant_slug
      ORDER BY selling_item.profit DESC) as selling_item";
    break;
  case 'categorywise':
      $where_query .= " AND selling_item.category_id != '' AND selling_item.category_id IS NOT NULL";
      $table = "(SELECT @sl:=@sl+1 AS sl, selling_item.id, selling_item.category_id as content_id, SUM(selling_item.item_quantity) as quantity, SUM(selling_item.profit) as profit FROM selling_item LEFT JOIN selling_info ON (selling_item.invoice_id = selling_info.invoice_id)
      WHERE {$where_query}
      GROUP BY selling_item.category_id
      ORDER BY selling_item.profit DESC) as selling_item";
    break;
  case 'supplierwise':
    $where_query .= " AND selling_item.sup_id != '' AND selling_item.sup_id IS NOT NULL";
    $table = "(SELECT @sl:=@sl+1 AS sl, selling_item.id, selling_item.sup_id  as content_id, SUM(selling_item.item_quantity) as quantity, SUM(selling_item.profit) as profit FROM selling_item LEFT JOIN selling_info ON (selling_item.invoice_id = selling_info.invoice_id)
      WHERE {$where_query}
      GROUP BY selling_item.sup_id
      ORDER BY selling_item.profit DESC) as selling_item";
    break;
  case 'brandwise':
      $where_query .= " AND selling_item.brand_id != '' AND selling_item.brand_id IS NOT NULL";
      $table = "(SELECT @sl:=@sl+1 AS sl, selling_item.id, selling_item.brand_id as content_id, SUM(selling_item.item_quantity) as quantity, SUM(selling_item.profit) as profit FROM selling_item LEFT JOIN selling_info ON (selling_item.invoice_id = selling_info.invoice_id)
      WHERE {$where_query}
      GROUP BY selling_item.brand_id
      ORDER BY selling_item.profit DESC) as selling_item";
    break;
  case 'genderwise':
      $where_query .= " AND selling_item.gender_for != '' AND selling_item.gender_for IS NOT NULL";
      $table = "(SELECT @sl:=@sl+1 AS sl, selling_item.id, selling_item.gender_for as content_id, SUM(selling_item.item_quantity) as quantity, SUM(selling_item.profit) as profit FROM selling_item LEFT JOIN selling_info ON (selling_item.invoice_id = selling_info.invoice_id)
      WHERE {$where_query}
      GROUP BY selling_item.gender_for
      ORDER BY selling_item.profit DESC) as selling_item";
    break;
  default:
    //....
    break;
}

// Table's primary key
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'sl', 'dt' => 'sl' ),
    array( 'db' => 'item_variant_slug', 'dt' => 'item_variant_slug' ),
    array( 
      'db' => 'content_id',  
      'dt' => 'name',
      'formatter' => function( $d, $row ) use($type) {
        switch ($type) {
          case 'itemwise':
            return get_the_product($row['content_id'],'p_name') . ' ['.$row['item_variant_slug'].']';
            break;
          case 'categorywise':
            return get_the_category($row['content_id'],'category_name');
            break;
          case 'supplierwise':
            return get_the_supplier($row['content_id'],'sup_name');
            break;
          case 'brandwise':
            return get_the_brand($row['content_id'],'brand_name');
            break;
          case 'genderwise':
            return $row['content_id'];
            break;
          default:
            return $row['content_id'];
            break;
        }
        return $row['content_id'];
      }
    ),
    array( 
      'db' => 'profit',  
      'dt' => 'profit',
      'formatter' => function( $d, $row ) {
        return currency_format($row['profit']);
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