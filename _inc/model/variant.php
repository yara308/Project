<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	Onzwo
| -----------------------------------------------------
| AUTHOR:			ONZWO.COM
| -----------------------------------------------------
| EMAIL:			info@ONZWO.COM
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY ONZWO.COM
| -----------------------------------------------------
| WEBSITE:			http://ONZWO.COM
| -----------------------------------------------------
*/
class ModelVariant extends Model 
{
	public function getVariant($product_id, $variant_slug) 
	{
		$statement = $this->db->prepare("SELECT * FROM `product_variants` WHERE `product_id` = ? AND `variant_slug` = ?");
	  	$statement->execute(array($product_id, $variant_slug));
	    return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function getVariants($data = array(), $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$sql = "SELECT * FROM `product_variants` WHERE 1=1";
		if (isset($data['filter_name'])) {
			$sql .= " AND `variant_name` LIKE '" . $data['filter_name'] . "%'";
		}
		$sort_data = array(
			'variant_name'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY variant_name";
		}
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$statement = $this->db->prepare($sql);
		$statement->execute(array($store_id, 1));
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}