<?php

class ModelProduct extends Model 
{
function generateSlug($arabicText) {
    // You can use a transliteration library to convert Arabic to English, like PHP Intl
    // Here's a simple example using PHP Intl for transliteration:
    if (extension_loaded('intl')) {
        $arabicText = str_replace(["\t", "\n", "\r", "\0", "\x0B", "\xc2\xa0"], '-', $arabicText);

        $englishSlug = transliterator_transliterate('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();', $arabicText);
        
        // Remove specific punctuations
        $englishSlug = str_replace(['.', '":', ';', '}', '{', ')', '(', '\''], '', $englishSlug);
        
        // Replace the Arabic letter 'ʿ' (Ayn) with a dash or remove it as per your requirement
        $englishSlug = str_replace('ʿ', '-', $englishSlug); // Here, I'm replacing it with a dash
        
        // Replace spaces with dashes
        $englishSlug = str_replace(' ', '-', $englishSlug);

        return $englishSlug;
    }

    // If intl extension is not available, you can implement your own transliteration function.
    // Note that a complete transliteration can be quite complex due to various Arabic diacritics.
}
	public function addProduct($data) 
	{
		$has_promotional_price = isset($data['promotional_price']) && isset($data['has_promotional_price']) && $data['has_promotional_price'] ? 1 : 0;

		 // Generate the slug from the product name
	    $slug = $this->generateSlug($data['p_name']);
		 //End Generate the slug from the product name
		$purchase_price = isset($data['purchase_price']) ? (float)$data['purchase_price'] : 0;
		$has_variant = isset($data['variant']) && isset($data['has_variant']) && $data['has_variant'] ? 1 : 0;
		$hsn_code = isset($data['hsn_code']) ? $data['hsn_code'] : NULL;
    	$statement = $this->db->prepare("INSERT INTO `products` (p_type, p_name, p_name_url, p_code, hsn_code, barcode_symbology, category_id, gender_for, unit_id, has_variant, p_image, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    	$statement->execute(array($data['p_type'], $data['p_name'], $slug, $data['p_code'], $hsn_code, $data['barcode_symbology'], $data['category_id'], $data['gender_for'], $data['unit_id'], $has_variant, $data['p_image'], $data['description']));
    	$preference = isset($data['preference']) && !empty($data['preference']) ? serialize($data['preference']) : serialize(array());

    	$product_id = $this->db->lastInsertId();

    	if (isset($data['product_store']) && $product_id) {
			foreach ($data['product_store'] as $store_id) {

			//--- unit to store ---//

				$statement = $this->db->prepare("SELECT * FROM `unit_to_store` WHERE `store_id` = ? AND `uunit_id` = ?");
			    $statement->execute(array($store_id, $data['unit_id']));
			    $unit = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$unit) {
			    	$statement = $this->db->prepare("INSERT INTO `unit_to_store` SET `uunit_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['unit_id'], $store_id));
			    }

			//--- box to store ---//

				$statement = $this->db->prepare("SELECT * FROM `box_to_store` WHERE `store_id` = ? AND `box_id` = ?");
			    $statement->execute(array($store_id, $data['box_id']));
			    $box = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$box) {
			    	$statement = $this->db->prepare("INSERT INTO `box_to_store` SET `box_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['box_id'], $store_id));
			    }

			//--- brand to store ---//

			    $statement = $this->db->prepare("SELECT * FROM `brand_to_store` WHERE `store_id` = ? AND `brand_id` = ?");
			    $statement->execute(array($store_id, $data['brand_id']));
			    $brand = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$brand) {
			    	$statement = $this->db->prepare("INSERT INTO `brand_to_store` SET `brand_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['brand_id'], $store_id));
			    }

			//--- product to store ---//

				$statement = $this->db->prepare("INSERT INTO `product_to_store` SET `product_id` = ?, `store_id` = ?, `purchase_price` = ?, `sell_price` = ?, `brand_id` = ?, `box_id` = ?, `taxrate_id` = ?, `tax_method` = ?, `has_promotional_price` = ?, `preference` = ?, `e_date` = ?, `alert_quantity` = ?, `p_date` = ?");
				$statement->execute(array($product_id, $store_id, $purchase_price, $data['sell_price'], $data['brand_id'], $data['box_id'], $data['taxrate_id'], $data['tax_method'], $has_promotional_price, $preference, $data['e_date'], $data['alert_quantity'], date('Y-m-d')));


			//--- product to supplier ---//

				if (isset($data['supplier']) && $product_id) {
					foreach ($data['supplier'] as $sup_id) {
						$statement = $this->db->prepare("SELECT * FROM `product_to_supplier` WHERE `store_id` = ? AND `product_id` = ? AND `sup_id` = ?");
					    $statement->execute(array($store_id, $product_id, $sup_id));
					    $supplier = $statement->fetch(PDO::FETCH_ASSOC);
					    if (!$supplier) {
					    	$statement = $this->db->prepare("INSERT INTO `product_to_supplier` SET `product_id` = ?, `sup_id` = ?, `store_id` = ?");
							$statement->execute(array($product_id, $sup_id, $store_id));
					    }

					    //--- supplier to store ---//
					    $statement = $this->db->prepare("SELECT * FROM `supplier_to_store` WHERE `store_id` = ? AND `sup_id` = ?");
					    $statement->execute(array($store_id, $sup_id));
					    $supplier = $statement->fetch(PDO::FETCH_ASSOC);
					    if (!$supplier) {
					    	$statement = $this->db->prepare("INSERT INTO `supplier_to_store` SET `sup_id` = ?, `store_id` = ?");
							$statement->execute(array($sup_id, $store_id));
					    }
					}
				}

			}
		}
		
		$this->syncPromotionalPrice($product_id, $data);
		$this->syncVariant($product_id, $data);
		$this->syncImage($product_id, $data);

		$this->updateStatus($product_id, $data['status']);
		$this->updateSortOrder($product_id, $data['sort_order']);

    	return $product_id;
	}

	public function syncPromotionalPrice($product_id, $data, $store_id = null)
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("DELETE FROM `product_promotions` WHERE `product_id` = ? AND `store_id` = ?");
		$statement->execute(array($product_id, $store_id));
		if (isset($data['promotional_price'])) {
			foreach ($data['promotional_price'] as $price) {
				if (is_numeric($price['promotional_price']) && isItValidDate($price['start_date']) && isItValidDate($price['end_date'])) {
					$statement = $this->db->prepare("INSERT INTO `product_promotions` SET `product_id` = ?, `store_id` = ?, `promotional_price` = ?, `start_date` = ?, `end_date` = ?, `sort_order` = ?, `created_at` = ?");
					$statement->execute(array($product_id, $store_id, $price['promotional_price'], $price['start_date'], $price['end_date'], $price['sort_order'], date_time()));
				}
			}
		}
	}

	public function syncVariant($product_id, $data)
	{
		$statement = $this->db->prepare("DELETE FROM `product_variants` WHERE `product_id` = ?");
		$statement->execute(array($product_id));
		if (isset($data['variant'])) {
			foreach ($data['variant'] as $variant) {
				$variant_slug = strtolower(str_replace(array('-',' '), '_', $variant['name']));
				if ($variant['name'] && is_numeric($variant['purchase_price_addition']) && is_numeric($variant['sell_price_addition'])) {
					$statement = $this->db->prepare("INSERT INTO `product_variants` SET `product_id` = ?, `variant_name` = ?, `variant_slug` = ?, `purchase_price_addition` = ?, `sell_price_addition` = ?, `sort_order` = ?, `created_at` = ?");
					$statement->execute(array($product_id, $variant['name'], $variant_slug, $variant['purchase_price_addition'], $variant['sell_price_addition'], $variant['sort_order'], date_time()));
				}
			}
		}
	}

	public function syncImage($product_id, $data)
	{
		$statement = $this->db->prepare("DELETE FROM `product_images` WHERE `product_id` = ?");
		$statement->execute(array($product_id));
		if (isset($data['image'])) {
			foreach ($data['image'] as $img) {
				if ($img['url']) {
					$statement = $this->db->prepare("INSERT INTO `product_images` SET `product_id` = ?, `url` = ?, `sort_order` = ?");
					$statement->execute(array($product_id, $img['url'], $img['sort_order']));
				}
			}
		}
	}

	public function updateStatus($product_id, $status, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("UPDATE `product_to_store` SET `status` = ? WHERE `store_id` = ? AND `product_id` = ?");
		$statement->execute(array((int)$status, $store_id, $product_id));
	}

	public function updateSortOrder($product_id, $sort_order, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("UPDATE `product_to_store` SET `sort_order` = ? WHERE `store_id` = ? AND `product_id` = ?");
		$statement->execute(array((int)$sort_order, $store_id, $product_id));
	}

	public function editProduct($product_id, $data) 
	{
 $slug = $this->generateSlug($data['p_name']);
		$has_promotional_price = isset($data['promotional_price']) && isset($data['has_promotional_price']) && $data['has_promotional_price'] ? 1 : 0;
		$has_variant = isset($data['variant']) && isset($data['has_variant']) && $data['has_variant'] ? 1 : 0;
		$hsn_code = isset($data['hsn_code']) ? $data['hsn_code'] : NULL;
    	$statement = $this->db->prepare("UPDATE `products` SET `p_type` = ?, `p_name` = ?, `p_name_url` = ?, `p_code` = ?, `hsn_code` = ?, `barcode_symbology` = ?, `category_id` = ?, `gender_for` = ?, `unit_id` = ?, `has_variant` = ?, `p_image` = ?, `description` = ?  WHERE `p_id` = ?");
    	$statement->execute(array($data['p_type'], $data['p_name'],$slug, $data['p_code'], $hsn_code, $data['barcode_symbology'], $data['category_id'], $data['gender_for'], $data['unit_id'], $has_variant, $data['p_image'], $data['description'], $product_id));
    	$preference = isset($data['preference']) && !empty($data['preference']) ? serialize($data['preference']) : serialize(array());
		
		// Insert product into store
    	if (isset($data['product_store'])) {

    		$store_ids = array();

			foreach ($data['product_store'] as $store_id) {

			//--- category to store ---//

				$statement = $this->db->prepare("SELECT * FROM `category_to_store` WHERE `store_id` = ? AND `ccategory_id` = ?");
			    $statement->execute(array($store_id, $data['category_id']));
			    $category = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$category) {
			    	$statement = $this->db->prepare("INSERT INTO `category_to_store` SET `ccategory_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['category_id'], $store_id));
			    } 

			//--- unit to store ---//

				$statement = $this->db->prepare("SELECT * FROM `unit_to_store` WHERE `store_id` = ? AND `uunit_id` = ?");
			    $statement->execute(array($store_id, $data['unit_id']));
			    $unit = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$unit) {
			    	$statement = $this->db->prepare("INSERT INTO `unit_to_store` SET `uunit_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['unit_id'], $store_id));
			    }

			//--- box to store ---//

				$statement = $this->db->prepare("SELECT * FROM `box_to_store` WHERE `store_id` = ? AND `box_id` = ?");
			    $statement->execute(array($store_id, $data['box_id']));
			    $box = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$box) {
			    	$statement = $this->db->prepare("INSERT INTO `box_to_store` SET `box_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['box_id'], $store_id));
			    } 

			//--- brand to store ---//

			    $statement = $this->db->prepare("SELECT * FROM `brand_to_store` WHERE `store_id` = ? AND `brand_id` = ?");
			    $statement->execute(array($store_id, $data['brand_id']));
			    $brand = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$brand) {
			    	$statement = $this->db->prepare("INSERT INTO `brand_to_store` SET `brand_id` = ?, `store_id` = ?");
					$statement->execute(array((int)$data['brand_id'], $store_id));
			    } 

			//--- product to store ---//

				$statement = $this->db->prepare("SELECT * FROM `product_to_store` WHERE `store_id` = ? AND `product_id` = ?");
			    $statement->execute(array($store_id, $product_id));
			    $product = $statement->fetch(PDO::FETCH_ASSOC);
			    if (!$product) {
			    	$statement = $this->db->prepare("INSERT INTO `product_to_store` SET `product_id` = ?, `store_id` = ?, `brand_id` = ?, `box_id` = ?, `taxrate_id` = ?, `tax_method` = ?, `has_promotional_price` = ?, `preference` = ?, `sell_price` = ?, `e_date` = ?, `alert_quantity` = ?, `p_date` = ?");
					$statement->execute(array($product_id, $store_id, $data['brand_id'], $data['box_id'], $data['taxrate_id'], $data['tax_method'], $has_promotional_price, $preference, $data['sell_price'], $data['e_date'], $data['alert_quantity'], date('Y-m-d')));
			    
			    } else {

			    	$statement = $this->db->prepare("UPDATE `product_to_store` SET `brand_id` = ?, `box_id` = ?, `taxrate_id` = ?, `tax_method` = ?, `has_promotional_price` = ?, `preference` = ?, `purchase_price` = ?, `sell_price` = ?, `e_date` = ?, `alert_quantity` = ? WHERE `store_id` = ? AND `product_id` = ?");
					$statement->execute(array($data['brand_id'], $data['box_id'], $data['taxrate_id'], $data['tax_method'], $has_promotional_price, $preference, $data['purchase_price'], $data['sell_price'], $data['e_date'], $data['alert_quantity'], $store_id, $product_id));
			    }

			    $store_ids[] = $store_id;
			}

			// Delete unwanted store
			if (!empty($store_ids)) {

				$unremoved_store_ids = array();

				// get unwanted stores
				$statement = $this->db->prepare("SELECT * FROM `product_to_store` WHERE `store_id` NOT IN (" . implode(',', $store_ids) . ")");
				$statement->execute();
				$unwanted_stores = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($unwanted_stores as $store) {

					$store_id = $store['store_id'];
					
					// Fetch purchase invoice id
				    $statement = $this->db->prepare("SELECT * FROM `purchase_item` WHERE `store_id` = ? AND `item_id` = ?  AND `status` IN ('stock', 'active') AND `item_quantity` != `total_sell`");
				    $statement->execute(array($store_id, $product_id));
				    $item_available = $statement->fetch(PDO::FETCH_ASSOC);

				     // If item available then store in variable
				    if ($item_available) {
				      $unremoved_store_ids[$item_available['store_id']] = store_field('name', $item_available['store_id']);
				      continue;
				    }

				    // Delete unwanted store link
					$statement = $this->db->prepare("DELETE FROM `product_to_store` WHERE `store_id` = ? AND `product_id` = ?");
					$statement->execute(array($store_id, $product_id));
				}

				if (!empty($unremoved_store_ids)) {
					throw new Exception('The product "' . $item_available['item_name'] . '" can not be removed. Because stock amount available in store ' . implode(', ', $unremoved_store_ids));
				}				
			}

			
			//--- supplier to store ---//

			foreach ($data['product_store'] as $store_id) {
				if (isset($data['supplier'])) {
					$sup_ids = array();
					foreach ($data['supplier'] as $sup_id) {
						$statement = $this->db->prepare("SELECT * FROM `product_to_supplier` WHERE `store_id` = ? AND `sup_id` = ? AND `product_id` = ?");
					    $statement->execute(array($store_id, $sup_id, $product_id));
					    $supplier = $statement->fetch(PDO::FETCH_ASSOC);
					    if (!$supplier) {
					    	$statement = $this->db->prepare("INSERT INTO `product_to_supplier` SET `sup_id` = ?, `product_id` = ?, `store_id` = ?");
							$statement->execute(array($sup_id, $product_id, $store_id));
					    }

					    //--- supplier to store ---//
					    $statement = $this->db->prepare("SELECT * FROM `supplier_to_store` WHERE `store_id` = ? AND `sup_id` = ?");
					    $statement->execute(array($store_id, $sup_id));
					    $supplier = $statement->fetch(PDO::FETCH_ASSOC);
					    if (!$supplier) {
					    	$statement = $this->db->prepare("INSERT INTO `supplier_to_store` SET `sup_id` = ?, `store_id` = ?");
							$statement->execute(array($sup_id, $store_id));
					    }
					    $sup_ids[] = $sup_id;
					}
				}

				// Delete unwanted supplier
				if (!empty($sup_ids)) {

					$unremoved_sup_ids = array();

					// get unwanted stores
					$statement = $this->db->prepare("SELECT * FROM `product_to_supplier` WHERE `store_id` = ? AND `product_id` = ? AND `sup_id` NOT IN (" . implode(',', $sup_ids) . ")");
					$statement->execute(array($store_id, $product_id));
					$unwanted_suppliers = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($unwanted_suppliers as $supplier) {

						$sup_id = $supplier['sup_id'];
						
						// Fetch purchase invoice id
					    $statement = $this->db->prepare("SELECT `purchase_info`.`sup_id`, `purchase_item`.* FROM `purchase_info` LEFT JOIN `purchase_item` ON (`purchase_info`.`invoice_id` = `purchase_item`.`invoice_id`) WHERE `purchase_info`.`sup_id` = ? AND `purchase_item`.`item_id` = ?  AND `purchase_item`.`status` IN ('stock', 'active') AND `purchase_item`.`item_quantity` != `purchase_item`.`total_sell`");
					    $statement->execute(array($sup_id, $product_id));
					    $item_available = $statement->fetch(PDO::FETCH_ASSOC);

					     // If item available then supplier in variable
					    if ($item_available) {
					      $unremoved_sup_ids[$item_available['sup_id']] = supplier_field('name', $item_available['sup_id']);
					      continue;
					    }

					    // Delete unwanted supplier link
						$statement = $this->db->prepare("DELETE FROM `product_to_supplier` WHERE `sup_id` = ? AND `product_id` = ?");
						$statement->execute(array($sup_id, $product_id));
					}

					if (!empty($unremoved_sup_ids)) {
						throw new Exception('The product "' . $item_available['item_name'] . '" can not be removed. Because stock amount available in supplier ' . implode(', ', $unremoved_sup_ids));
					}				
				}
			}
		}
		$this->syncPromotionalPrice($product_id, $data);
		$this->syncVariant($product_id, $data);
		$this->syncImage($product_id, $data);

		$this->updateStatus($product_id, $data['status']);
		$this->updateSortOrder($product_id, $data['sort_order']);

    	return $product_id;
	}

	public function deleteProduct($product_id) 
	{
		$statement = $this->db->prepare("DELETE FROM `products` WHERE `p_id` = ? LIMIT 1");
        $statement->execute(array($product_id));

        $statement = $this->db->prepare("DELETE FROM `product_to_store` WHERE `product_id` = ?");
        $statement->execute(array($product_id));

        $statement = $this->db->prepare("DELETE FROM `product_images` WHERE `product_id` = ?");
        $statement->execute(array($product_id));

        return $product_id;
	}

	public function deleteWithRelatedContent($product_id)
	{
	    // Fetch sold out purchase invoice id
	    $statement = $this->db->prepare("SELECT * FROM `purchase_item` WHERE `item_id` = ?");
	    $statement->execute(array($product_id));
	    $purchase_items = $statement->fetchAll(PDO::FETCH_ASSOC);

		// Delete purchase history
		 foreach ($purchase_items as $purchase_item) {

	        if (isset($purchase_item['invoice_id'])) {
	          $statement = $this->db->prepare("DELETE FROM `purchase_info` WHERE `invoice_id` = ?");
	          $statement->execute(array($purchase_item['invoice_id']));
	          $statement = $this->db->prepare("DELETE FROM `purchase_price` WHERE `invoice_id` = ?");
	          $statement->execute(array($purchase_item['invoice_id']));
	          $statement = $this->db->prepare("DELETE FROM `purchase_item` WHERE `item_id` = ?");
	          $statement->execute(array($product_id));
	        }
	    }

	    // Fetch selling invoice id
        $statement = $this->db->prepare("SELECT * FROM `selling_item` WHERE `item_id` = ?");
        $statement->execute(array($product_id));
        $selling_items = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Delete selling history
        foreach ($selling_items as $selling_item) {

        	if (isset($selling_item['invoice_id'])) {
	          $statement = $this->db->prepare("DELETE FROM `selling_info` WHERE `invoice_id` = ?");
	          $statement->execute(array($selling_item['invoice_id']));
	          $statement = $this->db->prepare("DELETE FROM `selling_price` WHERE `invoice_id` = ?");
	          $statement->execute(array($selling_item['invoice_id']));
	          $statement = $this->db->prepare("DELETE FROM `selling_item` WHERE `item_id` = ?");
	          $statement->execute(array($product_id));
	        }
        }

        $this->deleteProduct($product_id); 
	}

	public function getBelongsStore($p_id)
	{
		$statement = $this->db->prepare("SELECT * FROM `product_to_store` WHERE `product_id` = ?");
		$statement->execute(array($p_id));

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function isStockAvailable($p_id, $store_id)
	{
		$statement = $this->db->prepare("SELECT * FROM `purchase_item` WHERE `item_id` = ? AND `store_id` = ? AND `status` IN ('active', 'stock')");
		$statement->execute(array($p_id, $store_id));
		return $statement->rowCount();

	}

	public function getProduct($product_id, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `products`
			LEFT JOIN `product_to_store` as p2s ON (`products`.`p_id` = `p2s`.`product_id`) 
			WHERE `p2s`.`store_id` = ? AND `products`.`p_id` = ?");
	    $statement->execute(array($store_id, $product_id));
	    $product = $statement->fetch(PDO::FETCH_ASSOC);
	    if (!$product) {
	    	return array();
	    }

	    // Fetch stores related to products
	    $statement = $this->db->prepare("SELECT * FROM `product_to_store` WHERE `product_id` = ?");
	    $statement->execute(array($product_id));
	    $all_stores = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $stores = array();
	    foreach ($all_stores as $store) {
	    	$stores[] = $store['store_id'];
	    }
	    $product['stores'] = $stores;

	    // Fetch suppliers related to products
	    $statement = $this->db->prepare("SELECT * FROM `product_to_supplier` WHERE `product_id` = ?");
	    $statement->execute(array($product_id));
	    $all_suppliers = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $suppliers = array();
	    foreach ($all_suppliers as $supplier) {
	    	$suppliers[] = $supplier['sup_id'];
	    }
	    $product['suppliers'] = $suppliers;
	    
	    $product['sup_name'] = get_the_supplier($product['sup_id'],'sup_name');
	    $product['brand_name'] = get_the_brand($product['brand_id'],'brand_name');
	    $product['unit'] = get_the_unit($product['unit_id'],'unit_name');
	    $product['taxrate'] = '';
	    $product['purchase_tax_amount'] = '0.00';
	    if ($product['taxrate_id']) {
	    	$taxrate = get_the_taxrate($product['taxrate_id']);
	    	$product['taxrate'] = $taxrate;
	    	$product['purchase_tax_amount'] = ($taxrate['taxrate'] / 100) * $product['purchase_price'];
	    }
	    
	    return $product;
	}

	public function getTheProductPrice($product_id, $store_id = null, $variant_slug = null) 
	{
		$price = get_the_product($product_id, 'sell_price');
		$promotional_price = get_product_promotional_prices($product_id, $store_id);
		if (isset($promotional_price[0])) {
			$price = $promotional_price[0]['promotional_price'];
		}

		$variants = $this->getProductVariants($product_id, $store_id, $variant_slug);
		foreach ($variants as $variant) {
			if ($variant['quantity'] <= 0) continue;
			$price = isset($variant['sell_price_addition']) ? $price + (float)$variant['sell_price_addition'] : $price;
			break;
		}
		return $price;
	}

	public function getTheProductStock($product_id, $store_id = null, $variant_slug = null) 
	{
		$quantity = get_the_product($product_id, 'quantity_in_stock');
		$variants = $this->getProductVariants($product_id, $store_id, $variant_slug);
		foreach ($variants as $variant) {
			if ($variant['quantity'] <= 0) continue;
			$quantity = isset($variant['quantity']) ? $variant['quantity'] : $quantity;
			break;
		}
		return $quantity;
	}

	public function getProducts($data = array(), $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$sql = "SELECT * FROM `products` p 
			LEFT JOIN `product_to_store` p2s ON (`p`.`p_id` = `p2s`.`product_id`) 
			LEFT JOIN `suppliers` s ON (`p2s`.`sup_id` = `s`.`sup_id`) 
			LEFT JOIN `brands` b ON (`p2s`.`brand_id` = `b`.`brand_id`) 
			LEFT JOIN `boxes` bx ON (`p2s`.`box_id` = `bx`.`box_id`) 
			LEFT JOIN `taxrates` tr ON (`p2s`.`taxrate_id` = `tr`.`taxrate_id`) 
			WHERE `p2s`.`store_id` = ? AND `p2s`.`status` = ?";

		if (isset($data['filter_p_type'])) {
			$sql .= " AND `p`.`p_type` = '" . $data['filter_p_type'] . "'";
		}

		if (isset($data['filter_search_key'])) {
			$sql .= " AND `p`.`p_name` LIKE '%" . $data['filter_search_key'] . "%'";
		}	

		if (isset($data['filter_category_id'])) {
			$sql .= " AND `p`.`category_id` = '" . $data['filter_category_id'] . "'";
		}

		if (isset($data['filter_brand_id'])) {
			$sql .= " AND `p2s`.`brand_id` = '" . $data['filter_brand_id'] . "'";
		}

		if (isset($data['filter_gender'])) {
			$sql .= " AND `p`.`gender_for` = '" . $data['filter_gender'] . "'";
		}

		if (isset($data['filter_name'])) {
			$sql .= " AND `p`.`p_name` LIKE '" . $data['filter_name'] . "%'";
		}

		if (isset($data['filter_purchase_price']) && !is_null($data['filter_sell_price'])) {
			$sql .= " AND `p`.`purchase_price` LIKE '" . $data['filter_purchase_price'] . "%'";
		}

		if (isset($data['filter_sell_price']) && !is_null($data['filter_sell_price'])) {
			$sql .= " AND `p`.`sell_price` LIKE '" . $data['filter_sell_price'] . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND `p2s`.`quantity_in_stock` >= '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND `p2s`.`status` = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY p.p_id";

		$sort_data = array(
			'p.p_name',
			'p.purchase_price',
			'p.sell_price',
			'p2s.quantity_in_stock',
			'p2s.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY `p`.`p_name`";
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

	public function getProductPromotionalPrices($product_id, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `product_promotions` WHERE `product_promotions`.`store_id` = ? AND `product_promotions`.`product_id` = ? ORDER BY `sort_order` ASC");
	    $statement->execute(array($store_id, $product_id));
	    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $rows;
	}

	public function getProductVariants($product_id, $store_id = null, $variant_slug = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$where = "`product_variants`.`product_id` = ?";
		if ($variant_slug) {
			$where .= " AND `product_variants`.`variant_slug` = '{$variant_slug}'";
		}
		$statement = $this->db->prepare("SELECT * FROM `product_variants` WHERE $where ORDER BY `sort_order` ASC");
	    $statement->execute(array($product_id));
	    $variants = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $variant_arr = array();
	    $inc = 0;
	    foreach ($variants as $vari) {
	    	$variant_arr[$inc] = $vari;
	    	$statement = $this->db->prepare("SELECT SUM(`item_quantity`) as item_quantity, SUM(`total_sell`) as total_sell FROM `purchase_item` WHERE `store_id` = ? AND `item_id` = ? AND `item_variant_slug` = ? AND `status` IN ('active','stock')");
		    $statement->execute(array($store_id, $product_id, $vari['variant_slug']));
		    $stock = $statement->fetch(PDO::FETCH_ASSOC);
		    $variant_arr[$inc]['quantity'] = isset($stock['item_quantity']) ? $stock['item_quantity'] - $stock['total_sell'] : 0;
	    	$inc++;
	    }
	    return $variant_arr;
	}

	public function getProductImages($product_id) 
	{
		$statement = $this->db->prepare("SELECT * FROM `product_images` WHERE `product_images`.`product_id` = ? ORDER BY `sort_order` ASC");
	    $statement->execute(array($product_id));
	    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $rows;
	}

	public function getPosProducts($data = array(), $store_id = null) 
	{
		extract($data);
		$store_id = $store_id ? $store_id : store_id();
		$products = array();
		$where_query = '';
		if (get_preference('expiry_yes')) {
			$where_query .= " AND `p2s`.`e_date` > NOW()";
		}
		$limit_query = NULL;
		if (isset($data['start']) && isset($data['limit'])) {
			$limit_query =  " LIMIT $start,$limit";
		}
		if (!$query_string) {
			if ($category_id) {
				$statement = $this->db->prepare("SELECT * FROM `products` 
				LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) 
				WHERE `p2s`.`store_id` = ? AND (`p2s`.`quantity_in_stock` > 0 OR `products`.`p_type` = 'service') AND `p2s`.`status` = ? AND `products`.`category_id` = ?{$where_query} GROUP BY `product_id`{$limit_query}");
				$statement->execute(array($store_id, 1, $category_id));
			} else {
				$statement = $this->db->prepare("SELECT `products`.*, `selling_item`.`item_id`, SUM(`selling_item`.`item_total`) as `total` FROM `selling_item` 
				RIGHT JOIN `products` ON (`selling_item`.`item_id` = `products`.`p_id`) 
				RIGHT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) 
				WHERE `p2s`.`store_id` = ? AND (`p2s`.`quantity_in_stock` > 0 OR `products`.`p_type` = 'service') AND `p2s`.`status` = ?{$where_query}
				GROUP BY `product_id` ORDER BY `total` DESC{$limit_query}");
				$statement->execute(array($store_id, 1));
			}
	    	$products = $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		if ($query_string || (!$query_string && empty($products))) {
			if ($category_id) {
				$statement = $this->db->prepare("SELECT * FROM `products` 
				LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) 
				WHERE `p2s`.`store_id` = ? AND (`p2s`.`quantity_in_stock` > 0 OR `products`.`p_type` = 'service') AND (UPPER($field) LIKE '" . strtoupper($query_string) . "%' OR `products`.`p_code` = '{$query_string}') AND `p2s`.`status` = ? AND `products`.`category_id` = ?{$where_query}{$limit_query}");
				$statement->execute(array($store_id, 1, $category_id));
			} else {
				$statement = $this->db->prepare("SELECT * FROM `products` 
				LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) 
				WHERE `p2s`.`store_id` = ? AND (`p2s`.`quantity_in_stock` > 0 OR `products`.`p_type` = 'service') AND (UPPER($field) LIKE '" . strtoupper($query_string) . "%' OR `products`.`p_code` = '{$query_string}') AND `p2s`.`status` = ?{$where_query}{$limit_query}");
				$statement->execute(array($store_id, 1));
			}
			$products = $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		array_walk_recursive($products, 'updateImageValue');
		array_walk_recursive($products, 'updateNameValue');

		return $products;
	}

	public function getExpiredProducts($store_id = null)
	{
		$store_id = $store_id ? $store_id : store_id();
		$current_datetime = date_time();
		$statement = $this->db->prepare("SELECT * FROM `product_to_store` WHERE `store_id` = ? AND `e_date` < '{$current_datetime}'");
		$statement->execute(array($store_id));
		$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function getSellingPrice($item_id, $from, $to, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$where_query = "`selling_info`.`inv_type` != 'due_paid' AND `selling_item`.`item_id` = ? AND `selling_item`.`store_id` = ?";
		$where_query .= date_range_filter($from, $to);

		$statement = $this->db->prepare("SELECT SUM(`selling_price`.`discount_amount`) as discount, SUM(`selling_price`.`subtotal`) as total FROM `selling_info` 
			LEFT JOIN `selling_item` ON (`selling_info`.`invoice_id` = `selling_item`.`invoice_id`) 
			LEFT JOIN `selling_price` ON (`selling_info`.`invoice_id` = `selling_price`.`invoice_id`) 
			WHERE $where_query");

		$statement->execute(array($item_id, $store_id));
		$invoice = $statement->fetch(PDO::FETCH_ASSOC);

		return (int)($invoice['total'] - $invoice['discount']);
	}

	public function getpurchasePrice($item_id, $from, $to, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();

		$where_query = "`purchase_info`.`inv_type` != 'others' AND `purchase_item`.`item_id` = ? AND `purchase_item`.`store_id` = ?";
		$where_query .= date_range_filter2($from, $to);

		$statement = $this->db->prepare("SELECT SUM(`purchase_price`.`paid_amount`) as total FROM `purchase_info` 
			LEFT JOIN `purchase_item` ON (`purchase_info`.`invoice_id` = `purchase_item`.`invoice_id`) 
			LEFT JOIN `purchase_price` ON (`purchase_info`.`invoice_id` = `purchase_price`.`invoice_id`) 
			WHERE $where_query");
		$statement->execute(array($item_id, $store_id));
		$purchase_price = $statement->fetch(PDO::FETCH_ASSOC);

		return (int)$purchase_price['total'];
	}

	public function getQtyInStock($product_id, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();

		$statement = $this->db->prepare("SELECT SUM(`purchase_item`.`item_quantity`) as total, SUM(`purchase_item`.`total_sell`) as total_sell FROM `purchase_item` 
			WHERE `store_id` = ? AND `item_id` = ? AND `status` IN ('stock', 'active')");
		$statement->execute(array($store_id, $product_id));
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result['total'] - $result['total_sell'];
	}

	public function totalToday($store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$where_query = "`p2s`.`store_id` = {$store_id} AND `p2s`.`status` = 1";
		$from = date('Y-m-d');
		$to = date('Y-m-d');
		if (($from && ($to == false)) || ($from == $to)) {
			$day = date('d', strtotime($from));
			$month = date('m', strtotime($from));
			$year = date('Y', strtotime($from));
			$where_query .= " AND DAY(`p2s`.`p_date`) = $day";
			$where_query .= " AND MONTH(`p2s`.`p_date`) = $month";
			$where_query .= " AND YEAR(`p2s`.`p_date`) = $year";
		} else {
			$from = date('Y-m-d H:i:s', strtotime($from.' '. '00:00:00')); 
			$to = date('Y-m-d H:i:s', strtotime($to.' '. '23:59:59'));
			$where_query .= " AND `p2s`.`p_date` >= '{$from}' AND `p2s`.`p_date` <= '{$to}'";
		}
		$statement = $this->db->prepare("SELECT * FROM `products` LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) WHERE {$where_query}");
		$statement->execute(array());
		
		return $statement->rowCount();
	}

	public function total($from, $to, $store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$where_query = "`p2s`.`store_id` = {$store_id} AND `p2s`.`status` = 1";
		if ($from) {
			$from = $from ? $from : date('Y-m-d');
			$to = $to ? $to : date('Y-m-d');
			if (($from && ($to == false)) || ($from == $to)) {
				$day = date('d', strtotime($from));
				$month = date('m', strtotime($from));
				$year = date('Y', strtotime($from));
				$where_query .= " AND DAY(`p2s`.`p_date`) = $day";
				$where_query .= " AND MONTH(`p2s`.`p_date`) = $month";
				$where_query .= " AND YEAR(`p2s`.`p_date`) = $year";
			} else {
				$from = date('Y-m-d H:i:s', strtotime($from.' '. '00:00:00')); 
				$to = date('Y-m-d H:i:s', strtotime($to.' '. '23:59:59'));
				$where_query .= " AND `p2s`.`p_date` >= '{$from}' AND `p2s`.`p_date` <= '{$to}'";
			}
		}
		$statement = $this->db->prepare("SELECT * FROM `products` LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) WHERE {$where_query}");
		$statement->execute(array());
		
		return $statement->rowCount();
	}

	public function totalTrash($store_id = null) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `products` LEFT JOIN `product_to_store` p2s ON (`products`.`p_id` = `p2s`.`product_id`) WHERE `p2s`.`store_id` = ? AND `p2s`.`status` = ?");
		$statement->execute(array($store_id, 0));
		return $statement->rowCount();
	}

	public function getProductFirstSupplierID($product_id, $store_id = null)
	{
		$store_id = $store_id ? $store_id : store_id();
		$where_query = "`p2s`.`store_id` = {$store_id} AND `p2s`.`product_id` = {$product_id}";
		$statement = $this->db->prepare("SELECT * FROM `product_to_supplier` p2s LEFT JOIN `suppliers` s ON (`s`.`sup_id` = `p2s`.`sup_id`) WHERE $where_query");
		$statement->execute(array());
		return $statement->fetch(PDO::FETCH_ASSOC)['sup_id'];
	}

	public function getProductSuppliers($product_id, $store_id = null)
	{
		$store_id = $store_id ? $store_id : store_id();
		$where_query = "`p2s`.`store_id` = {$store_id} AND `p2s`.`product_id` = {$product_id}";
		$statement = $this->db->prepare("SELECT * FROM `product_to_supplier` p2s LEFT JOIN `suppliers` s ON (`s`.`sup_id` = `p2s`.`sup_id`) WHERE $where_query");
		$statement->execute(array());
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getProductSupplierHTML($product_id, $store_id = null)
	{
		$suppliers = $this->getProductSuppliers($product_id, $store_id);
		$s = '';
		if (count($suppliers) <= 1) {
			foreach ($suppliers as $supplier) {
				$s .= $supplier['sup_name'];
			}
		} else {
			$s = '<div class="suppleirs">';
			$s .= '<ol class="supplier-list">';
			foreach ($suppliers as $supplier) {
				$s .= '<li id="'.$supplier['sup_id'].'">'.$supplier['sup_name'].'</li>';
			}
			$s .= '</ol>';
			$s .= '</div>';
			
		}
		return $s;
		
	}
	public function getProductSupplierText($product_id, $store_id = null)
	{
		$inc = 0;
		$s = '';
		foreach ($this->getProductSuppliers($product_id, $store_id) as $supplier) {
			if ($inc != 0) {
				$s .= ', ';
			}
			$s .= $supplier['sup_name'];
			$inc++;
		}
		return $s;
	}
}