<?php
include ("../_init.php");

// Product Images
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'PRODUCTIMAGES') 
{
	try {
		$p_id = $request->get['p_id'];
		$images = get_product_images($p_id);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_success'), 'images' => $images));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Quotation Product Options
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'QUOTATIONPRODUCTOPTIONS') 
	{
	try {
		$id = $request->get['id'];
		$name = get_the_product($id, 'p_name');
		$variants = get_product_variants($id);
		// $price = get_the_product($id, 'sell_price');
		$product = get_the_product($id);
		$price = $product['sell_price'];
		if ($product['has_promotional_price']) {
			$from = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '23:59:59'));
			$statement = db()->prepare("SELECT * FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ? AND `start_date` <= '{$from}' AND `end_date` >= '{$to}'");
			$statement->execute(array($id, store_id()));
			$promotional_price = $statement->fetch(PDO::FETCH_ASSOC);
			if ($promotional_price) {
				unset($product['sell_price']);
				$price = $promotional_price['promotional_price'];
			}
		}
		include 'template/quotation_option_form.php';
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
		exit();
	}
}

// Sell Product Options
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'SELLPRODUCTOPTIONS') 
{
	try {
		$id = $request->get['id'];
		$name = get_the_product($id, 'p_name');
		$variants = get_product_variants($id);
		$product = get_the_product($id);
		$price = $product['sell_price'];
		if ($product['has_promotional_price']) {
			$from = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '23:59:59'));
			$statement = db()->prepare("SELECT * FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ? AND `start_date` <= '{$from}' AND `end_date` >= '{$to}'");
			$statement->execute(array($id, store_id()));
			$promotional_price = $statement->fetch(PDO::FETCH_ASSOC);
			if ($promotional_price) {
				unset($product['sell_price']);
				$price = $promotional_price['promotional_price'];
			}
		}
	    include 'template/sell_option_form.php';
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Purchase Product Options
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'PURCHASEPRODUCTOPTIONS') 
{
	try {
		$id = $request->get['id'];
		$name = get_the_product($id, 'p_name');
		$variants = get_product_variants($id);
		$purchase_price = get_the_product($id, 'purchase_price');
		$sell_price = get_the_product($id, 'sell_price');
	    include 'template/purchase_option_form.php';
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Product Promotional Price
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'PRODUCTPROMOTIONALPRICES') 
{
	try {
		$p_id = $request->get['p_id'];
		$promotional_prices = get_product_promotional_prices($p_id);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_success'), 'promotional_prices' => $promotional_prices));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Product Variants
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'PRODUCTVARIANTS') 
{
	try {
		$p_id = $request->get['p_id'];
		$variants = get_product_variants($p_id);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_success'), 'variants' => $variants));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Banner Images
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'BANNERIMAGES') 
{
	try {
		include DIR_HELPER.'banner.php';
		$id = $request->get['id'];
		$images = get_banner_images($id);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_banner_images'), 'images' => $images));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Banner Images
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'BANNERIMAGES') 
{
	try {
		$id = $request->get['id'];
		$images = get_banner_images($id);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_banner_images'), 'images' => $images));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// Quotation info
if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'QUOTATIONINFO') 
{
	try {
		$ref_no = $request->post['ref_no'];
		$quotation_model = registry()->get('loader')->model('quotation');
		$quotation = $quotation_model->getQuotationInfo($ref_no);
		$quotation_items = $quotation_model->getQuotationItems($ref_no);
		$quotation['items'] = $quotation_items;
		header('Content-Type: application/json');
		echo json_encode(array('msg' => trans('text_success'), 'quotation' => $quotation));
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
		exit();
	}
}

// Update POS tempalte content
if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'UPDATEPOSTEMPALTECONTENT') 
{
	try {

		if (DEMO || (user_group_id() != 1 && !has_permission('access', 'receipt_template'))) {
	      throw new Exception(trans('error_update_permission'));
	    }

		$template_id = $request->post['template_id'];
		$content = $request->post['content'];
		$statement = db()->prepare("UPDATE `pos_templates` SET `template_content` = ? WHERE `template_id` = ?");
		$statement->execute(array($content, $template_id));

		header('Content-Type: application/json');
		echo json_encode(array('msg' => trans('text_template_content_update_success')));
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
	exit();
	}
}

// Update POS tempalte CSS
if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'UPDATEPOSTEMPALTECSS') 
{
	try {

		if (DEMO || (user_group_id() != 1 && !has_permission('access', 'receipt_template'))) {
	      throw new Exception(trans('error_update_permission'));
	    }

		$template_id = $request->post['template_id'];
		$content = $request->post['content'];
		$statement = db()->prepare("UPDATE `pos_templates` SET `template_css` = ? WHERE `template_id` = ?");
		$statement->execute(array($content, $template_id));

		header('Content-Type: application/json');
		echo json_encode(array('msg' => trans('text_template_css_update_success')));
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
		exit();
	}
}

// Update opening balance
if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'UPDATEOPENINGBALANCE') 
{
	try {
		$balance = str_replace(',', '', $request->post['balance']);
		if (!is_numeric($balance)) {
			throw new Exception(trans('error_invalid_balance'));
		}

		// UPDATE OPENING BALANCE
		$from = date('Y-m-d');
		$day = date('d', strtotime($from));
		$month = date('m', strtotime($from));
		$year = date('Y', strtotime($from));
		$where_query = " DAY(`pos_register`.`created_at`) = $day";
		$where_query .= " AND MONTH(`pos_register`.`created_at`) = $month";
		$where_query .= " AND YEAR(`pos_register`.`created_at`) = $year";

		// If not exist then insert
		$statement = db()->prepare("SELECT `id` FROM `pos_register` WHERE $where_query AND `store_id` = ?");
		$statement->execute(array(store_id()));
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		if (!$row) {
			$statement = db()->prepare("INSERT INTO `pos_register` SET `store_id` = ?, `created_at` = ?");
			$statement->execute(array(store_id(), date_time()));
		}

		$statement = db()->prepare("UPDATE `pos_register` SET `opening_balance` = ? WHERE $where_query AND `store_id` = ?");
		$statement->execute(array($balance, store_id()));

		// UPDATE CLOSING BALANCE
		$date = date('Y-m-d');
		$from = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
		$day = date('d', strtotime($from));
		$month = date('m', strtotime($from));
		$year = date('Y', strtotime($from));
		$where_query = " DAY(`pos_register`.`created_at`) = $day";
		$where_query .= " AND MONTH(`pos_register`.`created_at`) = $month";
		$where_query .= " AND YEAR(`pos_register`.`created_at`) = $year";
		$statement = db()->prepare("UPDATE `pos_register` SET `opening_balance` = ? WHERE $where_query AND `store_id` = ?");
		$statement->execute(array($balance, store_id()));

		header('Content-Type: application/json');
		echo json_encode(array('msg' => trans('text_opening_balance_update_success')));
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
		exit();
	}
}

if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'PURCHASEITEM') 
{
	$sup_id = isset($request->post['sup_id']) ? $request->post['sup_id'] : null;
	$type = $request->post['type'];
	$name = $request->post['name_starts_with'];
	$query = "SELECT * FROM `products` LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) LEFT JOIN `product_to_supplier` p2sup ON (`products`.`p_id` = `p2sup`.`product_id`) WHERE `p2s`.`store_id` = ? AND `p2s`.`status` = ? AND `p_type` != 'service'";
	if ($sup_id) {
		$query .= " AND `p2sup`.`sup_id` = ?";
	}
	$query .= " AND (UPPER($type) LIKE '" . strtoupper($name) . "%' OR `p_code` = '{$name}') GROUP BY `products`.`p_id` ORDER BY `p_id` DESC LIMIT 10";
	$statement = db()->prepare($query);
	if ($sup_id) {
		$statement->execute(array(store_id(), 1, $sup_id));
	} else {
		$statement->execute(array(store_id(), 1));
	}
	$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	$the_products = array();
	$inc = 0;
    foreach ($products as $product) {
    	$p_id = $product['p_id'];
    	$product_info = get_the_product($p_id);
    	$the_products[$inc] = $product;
    	$the_products[$inc]['unit_name'] = get_the_unit($product_info['unit_id'], 'unit_name');
    	$taxrate = 0;
    	$tax_amount = 0;
    	$taxrate = 0;
    	if ($product_info && $product_info['taxrate']) {
    		$the_products[$inc]['taxrate'] = $product_info['taxrate']['taxrate'];
    		$the_products[$inc]['tax_amount'] = ($product_info['taxrate']['taxrate'] / 100 ) * $product_info['purchase_price'];
    	}
		$variants = get_product_variants($p_id);
		if ($variants) {
			foreach ($variants as $var) {
				$the_products[$inc]['variant_id'] = $var['variant_id'];
				$the_products[$inc]['variant_slug'] = $var['variant_slug'];
				$the_products[$inc]['variant_name'] = $var['variant_name'];
				$the_products[$inc]['purchase_price_addition'] = $var['purchase_price_addition'];
				$the_products[$inc]['sell_price_addition'] = $var['sell_price_addition'];
				break;
			}
		}
		if (!isset($the_products[$inc]['purchase_price_addition'])) {
			$the_products[$inc]['purchase_price_addition'] = 0;
			$the_products[$inc]['sell_price_addition'] = 0;
		}
		$the_products[$inc]['variants'] = $variants;
		$inc++;
    }
	echo json_encode($the_products);
	exit();
}

if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'PURCHASEEDITINFO') 
{
	$invoice_id = $request->post['invoice_id'];
	$statement = db()->prepare("SELECT * FROM `purchase_info` LEFT JOIN `purchase_price` ON (`purchase_info`.`invoice_id` = `purchase_price`.`invoice_id`) WHERE `purchase_info`.`store_id` = ? AND `purchase_info`.`invoice_id` = ?");
    $statement->execute(array(store_id(), $invoice_id));
    $info = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = db()->prepare("SELECT `purchase_item`.*, `purchase_item`.status as `sell_status` FROM `purchase_item` WHERE `store_id` = ? AND `invoice_id` = ?");
    $statement->execute(array(store_id(), $invoice_id));
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
	$the_products = array();
	$inc = 0;
    foreach ($products as $product) {
    	$p_id = $product['item_id'];
    	$product_info = get_the_product($p_id);
    	$the_products[$inc] = array_merge($product, $product_info);
    	$the_products[$inc]['unit_name'] = get_the_unit($product_info['unit_id'], 'unit_name');
    	$taxrate = 0;
    	$tax_amount = 0;
    	$taxrate = 0;
    	if ($product_info && $product_info['taxrate']) {
    		$the_products[$inc]['taxrate'] = $product_info['taxrate']['taxrate'];
    		$the_products[$inc]['tax_amount'] = ($product_info['taxrate']['taxrate'] / 100 ) * $product_info['purchase_price'];
    	}
		$variants = get_product_variants($p_id);
		if ($variants) {
			foreach ($variants as $var) {
				$the_products[$inc]['variant_id'] = $var['variant_id'];
				$the_products[$inc]['variant_slug'] = $var['variant_slug'];
				$the_products[$inc]['variant_name'] = $var['variant_name'];
				$the_products[$inc]['purchase_price_addition'] = $var['purchase_price_addition'];
				$the_products[$inc]['sell_price_addition'] = $var['sell_price_addition'];
				break;
			}
		}
		if (!isset($the_products[$inc]['purchase_price_addition'])) {
			$the_products[$inc]['purchase_price_addition'] = 0;
			$the_products[$inc]['sell_price_addition'] = 0;
		}
		$the_products[$inc]['variants'] = $variants;
		$inc++;
    }
	echo json_encode(array('info'=>$info, 'items' => $the_products));
	exit();
}

// Product list
if($request->server['REQUEST_METHOD'] == 'POST' AND $request->get['type'] == 'SELLINGITEM') 
{
	$sup_id = isset($request->post['sup_id']) ? $request->post['sup_id'] : null;
	$type = $request->post['type'];
	$name = $request->post['name_starts_with'];
	$query = "SELECT * FROM `products` 
		LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`)
		LEFT JOIN `product_to_supplier` p2sup ON (`products`.`p_id` = `p2sup`.`product_id`)
		WHERE `p2s`.`store_id` = ? AND `p2s`.`status` = ?";
	if ($sup_id) {
		$query .= " AND `p2sup`.`sup_id` = ?";
	}
	$query .= " AND (UPPER($type) LIKE '" . strtoupper($name) . "%' OR `p_code` = '{$name}') GROUP BY `products`.`p_id` ORDER BY `p_id` DESC LIMIT 10";
	$statement = db()->prepare($query);
	if ($sup_id) {
		$statement->execute(array(store_id(), 1, $sup_id));
	} else {
		$statement->execute(array(store_id(), 1));
	}
	$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	$the_products = array();
	$inc = 0;
    foreach ($products as $product) {
    	$p_id = $product['p_id'];
    	if ($product['has_promotional_price']) {
			$from = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '23:59:59'));
			$statement = db()->prepare("SELECT * FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ? AND `start_date` <= '{$from}' AND `end_date` >= '{$to}'");
			$statement->execute(array($p_id, store_id()));
			$promotional_price = $statement->fetch(PDO::FETCH_ASSOC);
			if ($promotional_price) {
				unset($product['sell_price']);
				$product['sell_price'] = $promotional_price['promotional_price'];
			}
		}
		$the_products[$inc] = $product;
    	$the_products[$inc]['unit_name'] = get_the_unit($p_id, 'unit_name');
    	$taxrate = 0;
    	$tax_amount = 0;
    	$taxrate = 0;
    	$product_info = get_the_product($p_id);
    	if ($product_info && $product_info['taxrate']) {
    		$the_products[$inc]['taxrate'] = $product_info['taxrate']['taxrate'];
    		$the_products[$inc]['tax_amount'] = ($product_info['taxrate']['taxrate'] / 100 ) * $product_info['purchase_price'];
    	}
		$variants = get_product_variants($p_id);
		if ($variants) {
			foreach ($variants as $var) {
				$the_products[$inc]['variant_id'] = $var['variant_id'];
				$the_products[$inc]['variant_slug'] = $var['variant_slug'];
				$the_products[$inc]['variant_name'] = $var['variant_name'];
				$the_products[$inc]['purchase_price_addition'] = $var['purchase_price_addition'];
				$the_products[$inc]['sell_price_addition'] = $var['sell_price_addition'];
				break;
			}
		}
		if (!isset($the_products[$inc]['purchase_price_addition'])) {
			$the_products[$inc]['purchase_price_addition'] = 0;
			$the_products[$inc]['sell_price_addition'] = 0;
		}
		$the_products[$inc]['variants'] = $variants;
		$inc++;
    }
	echo json_encode($the_products);
	exit();
}

// StockItems
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'STOCKITEMS') 
{
	try {
		$store_id = $request->get['store_id'] ? $request->get['store_id'] : store_id();
		$statement = db()->prepare("SELECT `purchase_item`.*, `purchase_info`.`inv_type` FROM `purchase_item` LEFT JOIN `purchase_info` ON (`purchase_item`.`invoice_id` = `purchase_info`.`invoice_id`) WHERE `purchase_item`.`store_id` = ? AND `purchase_item`.`item_quantity` > `purchase_item`.`total_sell` AND `purchase_item`.`status` IN ('stock','active') AND `purchase_info`.`inv_type` = ?");
	    $statement->execute(array($store_id, 'purchase'));
	    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
	    header('Content-Type: application/json');
	    echo json_encode(array('msg' => trans('text_success'), 'products' => $products));
	    exit();

	  } catch (Exception $e) { 
	    
	    header('HTTP/1.1 422 Unprocessable Entity');
	    header('Content-Type: application/json; charset=UTF-8');
	    echo json_encode(array('errorMsg' => $e->getMessage()));
	    exit();
	  }
}

// StockItem
if($request->server['REQUEST_METHOD'] == 'GET' AND $request->get['type'] == 'STOCKITEM') 
{
	try {
		$id = $request->get['id'];
		$quantity = $request->get['quantity'];
		$statement = db()->prepare("SELECT * FROM `purchase_item` WHERE `purchase_item`.`id` = ? AND `purchase_item`.`item_quantity` > `purchase_item`.`total_sell` AND `purchase_item`.`status` IN ('stock','active')");
		$statement->execute(array($id));
		$product = $statement->fetch(PDO::FETCH_ASSOC);
		$p_id = $product['item_id'];
		$pro_info = get_the_product($p_id);
		if ($pro_info['has_promotional_price']) {
			$from = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '. '23:59:59'));
			$statement = db()->prepare("SELECT * FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ? AND `start_date` <= '{$from}' AND `end_date` >= '{$to}'");
			$statement->execute(array($p_id, store_id()));
			$promotional_price = $statement->fetch(PDO::FETCH_ASSOC);
			if ($promotional_price) {
				unset($product['sell_price']);
				$product['sell_price'] = $promotional_price['promotional_price'];
			}
		}
		$pro_info = get_the_product($p_id);
		$product['id'] = $pro_info['p_id'];
		$product['name'] = $pro_info['p_name'];
		$product['p_code'] = $pro_info['p_code'];
		$product['has_variant'] = $pro_info['has_variant'];
    	$product['unit_name'] = get_the_unit($p_id, 'unit_name');
    	$taxrate = 0;
    	$tax_amount = 0;
    	$taxrate = 0;
    	if ($pro_info['taxrate']) {
    		$product['taxrate'] = $pro_info['taxrate']['taxrate'];
    		$product['tax_amount'] = ($pro_info['taxrate']['taxrate'] / 100 ) * $pro_info['purchase_price'];
    	}
		$variants = get_product_variants($p_id);
		if ($variants) {
			foreach ($variants as $var) {
				$product['variantID'] = $var['variant_id'];
				$product['variant_id'] = $var['variant_id'];
				$product['variantSlug'] = $var['variant_slug'];
				$product['variant_slug'] = $var['variant_slug'];
				$product['variantName'] = $var['variant_name'];
				$product['variant_name'] = $var['variant_name'];
				$product['purchase_price_addition'] = $var['purchase_price_addition'];
				$product['sell_price_addition'] = $var['sell_price_addition'];
				break;
			}
		}
		if (!isset($product['purchase_price_addition'])) {
			$product['purchase_price_addition'] = 0;
			$product['sell_price_addition'] = 0;
		}
		$product['variants'] = $variants;
		header('Content-Type: application/json');
		echo json_encode(array('msg' => trans('text_success'), 'product' => $product));
		exit();

	} catch (Exception $e) { 

		header('HTTP/1.1 422 Unprocessable Entity');
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode(array('errorMsg' => $e->getMessage()));
		exit();
	}
}