<?php
function get_best_sales($data = array())
{
	$start = $data['start'];
	$limit = $data['limit'];
	$statement = db()->prepare("SELECT `SI`.*, `P`.*, `P2S`.*, SUM(`SI`.`item_quantity`) AS `quantity` FROM `selling_item` SI LEFT JOIN `products` P ON (`SI`.`item_id` = `P`.`p_id`) LEFT JOIN `product_to_store` P2S ON (`SI`.`item_id` = `P2S`.`product_id`) WHERE `SI`.`store_id` = ? AND quantity_in_stock > 0 GROUP BY `p_id` ORDER BY `quantity` DESC LIMIT $start, $limit");
	$statement->execute(array(store_id()));
	$items = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $items;
}

function get_new_products($data = array())
{
	$start = $data['start'];
	$limit = $data['limit'];
	$statement = db()->prepare("SELECT `P`.*, `P2S`.* FROM `products` P LEFT JOIN `product_to_store` P2S ON (`P`.`p_id` = `P2S`.`product_id`) WHERE `P2S`.`store_id` = ? AND p_date >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) AND quantity_in_stock > 0 LIMIT $start, $limit");
	$statement->execute(array(store_id()));
	$items = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $items;
}