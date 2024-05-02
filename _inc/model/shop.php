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
class ModelShop extends Model 
{
	public function get($field = null) 
	{
		$statement = $this->db->prepare("SELECT * FROM `shop` WHERE `id` = ?");
	  	$statement->execute(array(1));
	  	$shop = $statement->fetch(PDO::FETCH_ASSOC);
	  	if ($field) {
	  		return isset($shop[$field]) ? $shop[$field] : '';
	  	}
	  	return $shop;
	}
}