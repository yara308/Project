<?php 
ob_start();
session_start();
include ("../_init.php");

// Check, if user logged in or not
// If user is not logged in then return an alert message
if (!is_loggedin()) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_login')));
  exit();
}

// Check, if user has reading permission or not
// If user have not reading permission return an alert message
if (user_group_id() != 1 && !has_permission('access', 'create_sell_invoice')) {
  header('HTTP/1.1 422 Unprocessable Entity');
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode(array('errorMsg' => trans('error_read_permission')));
  exit();
}

$product_model = registry()->get('loader')->model('product');
$store_id = store_id();

// Fetch customer by id
if ($request->server['REQUEST_METHOD'] == 'GET' && isset($request->get['action_type']) && $request->get['action_type'] == 'CUSTOMER') {
	try {
		// validte customer id
		if (!validateInteger($request->get['customer_id'])) {
			throw new Exception(trans('error_customer_id'));
		}
		$id = $request->get['customer_id'];
		$statement = db()->prepare("SELECT * FROM `customers`  
			LEFT JOIN `customer_to_store` c2s ON (`customers`.`customer_id` = `c2s`.`customer_id`)
			WHERE `c2s`.`store_id` = ? AND `customers`.`customer_id` = ? AND `c2s`.`status` = ?");
		$statement->execute(array($store_id, $id, 1));
		$the_customer = $statement->fetch(PDO::FETCH_ASSOC);
		$customer = $the_customer ? $the_customer : array();

	    header('Content-Type: application/json');
	    echo json_encode($customer); 
	    exit();

	} catch (Exception $e) {

	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	}
}

// Fetch customer list
if ($request->server['REQUEST_METHOD'] == 'GET' && isset($request->get['action_type']) && $request->get['action_type'] == 'CUSTOMERLIST') {
	try {

		$limit = isset($request->get['limit']) ? (int)$request->get['limit'] : 20;
		$field = $request->get['field'];
		$query_string = $request->get['query_string'];
		$statement = db()->prepare("SELECT * FROM `customers` 
			LEFT JOIN `customer_to_store` c2s ON (`customers`.`customer_id` = `c2s`.`customer_id`)
			WHERE UPPER($field) LIKE '" . strtoupper($query_string) . "%' AND `c2s`.`store_id` = ? AND `c2s`.`status` = ? GROUP BY `customers`.`customer_id` ORDER BY `customers`.`customer_id` DESC LIMIT $limit");
		$statement->execute(array($store_id, 1));
		$customers = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$customer_array = array();
		if ($statement->rowCount() > 0) {
		    $customer_array = $customers;
		}

	    header('Content-Type: application/json');
	    echo json_encode($customer_array); 
	    exit();

	} catch (Exception $e) {

	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	}
}

// Fetch a product item
if ($request->server['REQUEST_METHOD'] == 'GET' && isset($request->get['action_type']) && $request->get['action_type'] == 'PRODUCTITEM')
{
	try {

		$is_edit_mode = isset($request->get["is_edit_mode"]) && $request->get["is_edit_mode"];
		if ($is_edit_mode)	 {
		    if (user_group_id() != 1 && !has_permission('access', 'add_item_to_invoice')) {
		      throw new Exception(trans('error_item_add_permission'));
		    }
		}

		// Validate product id
		if (!isset($request->get['p_id'])) {
			throw new Exception(trans('error_product_id'));
		}

		$p_id = $request->get['p_id'];
		$variant_slug = isset($request->get['variant_slug']) ? trim($request->get['variant_slug']) : '';
		$where_query = "`p2s`.`store_id` = ? AND (`p_id` = ? OR `p_code` = ?) AND `p2s`.`status` = ?";
		if (get_preference('expiry_yes')) {
			$where_query .= " AND `p2s`.`e_date` > NOW()";
		}
		if (!$is_edit_mode) {
			$where_query .= " AND (`p2s`.`quantity_in_stock` > 0 OR `products`.`p_type` = 'service')";
		}
		$statement = db()->prepare("SELECT * FROM `products` LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) WHERE {$where_query}");
		$statement->execute(array($store_id, $p_id, $p_id, 1));
		$product = $statement->fetch(PDO::FETCH_ASSOC);
		if (!$product) {
			throw new Exception(trans('error_out_of_stock'));
		}

		$pquery = "`store_id` = {$store_id} AND `item_id` = {$p_id} AND `status` = ?";
		if ($variant_slug AND $variant_slug != 'undefined') {
			$pquery .= " AND `item_variant_slug` = '{$variant_slug}'";
		}
		$statement = db()->prepare("SELECT * FROM `purchase_item` WHERE {$pquery}");
		$statement->execute(array('active'));
		$pitem = $statement->fetch(PDO::FETCH_ASSOC);
		if (isset($pitem['sup_id'])) {
			unset($product['sup_id']);
			$product['sup_id'] = $pitem['sup_id'];
		}

		if ($product['has_promotional_price']) {
			$from = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '23:59:59'));
			$statement = db()->prepare("SELECT * FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ? AND `start_date` <= '{$from}' AND `end_date` >= '{$to}'");
			$statement->execute(array($p_id, $store_id));
			$promotional_price = $statement->fetch(PDO::FETCH_ASSOC);
			if ($promotional_price) {
				unset($product['sell_price']);
				$product['sell_price'] = $promotional_price['promotional_price'];
			}
		}
		$product = array_replace($product, array('p_name' => html_entity_decode($product['p_name'])));
		if ($product['taxrate_id']) {
			$product['tax_amount'] = (get_the_taxrate($product['taxrate_id'],'taxrate') / 100) * $product['sell_price'];
		}
		$product['unit_name'] = get_the_unit($product['unit_id'],'unit_name');
		$product['variant_name'] = '';
		$product['sell_price_addition'] = 0;
		$variants = get_product_variants($p_id);
		if ($variants) {
			foreach ($variants as $var) {
				if ($variant_slug && $variant_slug == $var['variant_slug'] && $var['quantity'] <= 0) {
					throw new Exception(trans('error_out_of_stock'));
				}
				if (($variant_slug && $variant_slug == $var['variant_slug'] && $var['quantity'] > 0) || $var['quantity'] > 0) {
					$product['variant_id'] = $var['variant_id'];
					$product['variant_slug'] = $var['variant_slug'];
					$product['variant_name'] = $var['variant_name'];
					$product['purchase_price_addition'] = $var['purchase_price_addition'];
					$product['sell_price_addition'] = $var['sell_price_addition'];
					break;
				}
			}
		}
		if (!isset($product['purchase_price_addition'])) {
			$product['purchase_price_addition'] = 0;
			$product['sell_price_addition'] = 0;
		}
		$product['variants'] = $variants;

		echo json_encode($product); 
		exit();

	} catch (Exception $e) { 

	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	}
}

if ($request->server['REQUEST_METHOD'] == 'GET' && isset($request->get['action_type']) && $request->get['action_type'] == 'SELLEDITINFO')
{
	try {

		if (isset($request->get["is_edit_mode"]) && $request->get["is_edit_mode"])	 {
		    if (user_group_id() != 1 && !has_permission('access', 'add_item_to_invoice')) {
		      throw new Exception(trans('error_item_add_permission'));
		    }
		}

		$invoice_id = $request->get['invoice_id'];
		$statement = db()->prepare("SELECT * FROM `selling_info` LEFT JOIN `selling_price` ON (`selling_info`.`invoice_id` = `selling_price`.`invoice_id`) WHERE `selling_info`.`store_id` = ? AND `selling_info`.`invoice_id` = ?");
	    $statement->execute(array(store_id(), $invoice_id));
	    $info = $statement->fetch(PDO::FETCH_ASSOC);

	    $statement = db()->prepare("SELECT * FROM `selling_item` WHERE `store_id` = ? AND `invoice_id` = ?");
	    $statement->execute(array(store_id(), $invoice_id));
	    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode(array('info'=>$info, 'items'=>$products)); 
		exit();

	} catch (Exception $e) { 

	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	}
}

// Fetch product list
if ($request->server['REQUEST_METHOD'] == 'GET' && isset($request->get['action_type']) && $request->get['action_type'] == 'PRODUCTLIST')
{
	try {

		if (isset($request->get['query_string'])) {
			$query_string = $request->get['query_string'];
		} else {
			$query_string = '';
		}

		if (isset($request->get['category_id'])) {
			$category_id = $request->get['category_id'];
		} else {
			$category_id = '';
		}

		if (isset($request->get['field'])) {
			$field = $request->get['field'];
		} else {
			$field = 'p_name';
		}

		if (isset($request->get['page'])) {
			$page = $request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($request->get['limit'])) {
			$limit = (int)$request->get['limit'];
		} else {
			$limit = get_preference('pos_product_display_limit') ? (int)get_preference('pos_product_display_limit') : 20;
		}

		$start = ($page - 1) * $limit;

		$data = array(
			'query_string' => $query_string,
			'field' => $field,
			'category_id' => $category_id,
			'start' => $start,
			'limit' => $limit,
		);
		$products = $product_model->getPosProducts($data, $store_id);
		$product_total = count($products);

		// Pagination
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = root_url().'/_inc/pos.php?query_string='.$query_string.'&category_id='.$category_id.'&field='.$field.'&action_type=PRODUCTLIST&page={page}&limit='.$limit;
		$pagination = $pagination->render();

	    header('Content-Type: application/json');
	    echo json_encode(array('products' => array_values($products), 'pagination' => $pagination, 'page' => $page+1)); 
	    exit();
		
	} catch (Exception $e) {

	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	}
}