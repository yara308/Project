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
class ModelSellreturn extends Model 
{
	public function getInvoices($store_id = null, $limit = 100000) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT `returns`.* FROM `returns` 
			WHERE `returns`.`store_id` = ? ORDER BY `returns`.`created_at` DESC LIMIT $limit");
		$statement->execute(array($store_id));
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getInvoiceInfo($invoice_id, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `returns` 
			WHERE `store_id` = ? AND `invoice_id` = ?");
		$statement->execute(array($store_id, $invoice_id));
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	public function getInvoiceItems($invoice_id, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `return_items` WHERE `store_id` = ? AND `invoice_id` = ?");
		$statement->execute(array($store_id, $invoice_id));
		$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
		$array = array();
        $i = 0;
        foreach ($rows as $row) {
            $array[$i] = $row;
            $array[$i]['variant_name'] = $row['item_variant_name'] ? '('.$row['item_variant_name'].')' : null;
            $array[$i]['variant_slug'] = $row['item_variant_slug'] ? '('.$row['item_variant_slug'].')' : null;
            $array[$i]['unitName'] = get_the_unit(get_the_product($row['item_id'])['unit_id'], 'unit_name');
            $i++;
        }
        return $array;
	}
}