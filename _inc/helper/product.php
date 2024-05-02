<?php
function get_products($data = array()) 
{
	$model = registry()->get('loader')->model('product');
	return $model->getProducts($data);
}


function get_product_promotional_prices($p_id, $store_id = null) 
{	
	$model = registry()->get('loader')->model('product');
	return $model->getProductPromotionalPrices($p_id, $store_id);
}

function get_product_variants($p_id) 
{	
	$model = registry()->get('loader')->model('product');
	return $model->getProductVariants($p_id);
}

function get_product_images($p_id) 
{	
	$model = registry()->get('loader')->model('product');
	return $model->getProductImages($p_id);
}

function get_the_product($id, $field = null, $store_id = null) 
{	
	$model = registry()->get('loader')->model('product');
	$product = $model->getProduct($id, $store_id);
	if ($field && isset($product[$field])) {
		return $product[$field];
	} elseif ($field) {
		return;
	}
	return $product;
}

function get_the_product_price($p_id, $store_id = null, $variant_slug = null)
{
	$model = registry()->get('loader')->model('product');
	return $model->getTheProductPrice($p_id, $store_id, $variant_slug);
}

function get_the_product_stock($p_id, $store_id = null, $variant_slug = null)
{
	$model = registry()->get('loader')->model('product');
	return $model->getTheProductStock($p_id, $store_id, $variant_slug);
}

function product_selling_price($p_id, $from, $to)
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getSellingPrice($p_id, $from, $to);
}

function product_purchase_price($p_id, $from, $to)
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getpurchasePrice($p_id, $from, $to);
}

function total_product_today($store_id = null)
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->totalToday($store_id);

}

function total_product($from = null, $to = null, $store_id = null)
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->total($from, $to, $store_id);
}

function total_trash_product()
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->totalTrash();
}

function get_variants() 
{
	$model = registry()->get('loader')->model('variant');
	return $model->getVariants();
}

function get_the_variant($product_id, $variant_slug, $field = null) 
{
	$model = registry()->get('loader')->model('variant');
	$variant = $model->getVariant($product_id, $variant_slug);
	if ($field && isset($variant[$field])) {
		return $variant[$field];
	} elseif ($field) {
		return;
	}
	return $variant;
}

function get_expired_products()
{	
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getExpiredProducts();
}

function get_product_first_supplier_id($product_id, $store_id = null)
{
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getProductFirstSupplierID($product_id, $store_id);
}

function get_product_suppliers($product_id, $store_id = null)
{
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getProductSuppliers($product_id, $store_id);
}

function get_product_supplier_html($product_id, $store_id = null)
{
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getProductSupplierHTML($product_id, $store_id);
}

function get_product_supplier_text($product_id, $store_id = null)
{
	$product_model = registry()->get('loader')->model('product');
	return $product_model->getProductSupplierText($product_id, $store_id);
}