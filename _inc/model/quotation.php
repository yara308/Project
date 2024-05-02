<?php
/*
| ------------------------------------------
*/
class ModelQuotation extends Model 
{
    public function createQuotation($request, $store_id = null)
    {
        $store_id = $store_id ? $store_id : store_id();
        $user_id = 1 ;
        $created_at   = date_time();
        $reference_no = generate_order_reference_no();
// تحقق من وجود $reference_no في جدول quotation_info
$checkStatement = $this->db->prepare("SELECT COUNT(*) as count FROM `quotation_info` WHERE `reference_no` = ?");
$checkStatement->execute(array($reference_no));
$result = $checkStatement->fetch(PDO::FETCH_ASSOC);

// إذا كان موجودًا، أضف رقمًا عشوائيًا إليه
while($result['count'] > 0) {
    $randomNumber = rand(1, 99); // رقم عشوائي بين 1000 و 9999
    $reference_no .= $randomNumber;
    
    // إعادة التحقق من القيمة المحدثة
    $checkStatement->execute(array($reference_no));
    $result = $checkStatement->fetch(PDO::FETCH_ASSOC);
}
        $product_items  = $request->post['products'];
        $total_items  = count($product_items);
        $quotation_note   = $request->post['quotation-note'];
        $customer_id    = $request->post['customer_id'] ? $request->post['customer_id'] : 1;
        $customer_mobile  = isset($request->post['customer-mobile']) ? $request->post['customer-mobile'] : '';
        $subtotal      = $request->post['total-amount'];
        $discount_type  = isset($request->post['discount-type']) ? $request->post['discount-type'] : 'plain';
        $discount_amount= $request->post['discount-amount'] ? $request->post['discount-amount'] : 0;
        $shipping_type  = isset($request->post['shipping-type']) ? $request->post['shipping-type'] : 'plain';
        $shipping_amount= $request->post['shipping-amount'] ? $request->post['shipping-amount'] : 0;
        $others_charge = $request->post['others-charge'] ? $request->post['others-charge'] : 0;
        $order_tax     = $request->post['order-tax-amount'] ? $request->post['order-tax-amount'] : 0; 
        $item_tax     = $request->post['total-tax-amount'] ? $request->post['total-tax-amount'] : 0;
        $payable_amount = $request->post['payable-amount'];
        $is_order = isset($request->post['is_order']) ? (int)$request->post['is_order'] : 0;
        $status = $request->post['status'];
        $product_discount = $discount_amount / $total_items;
        $payment_status = 'due';

        $subtotal = 0;
        $igst = 0;
        $cgst = 0;
        $sgst = 0;

        $tgst = 0;
        $tigst = 0;
        $tcgst = 0;
        $tsgst = 0;
        $total_purchase_price = 0;

        foreach ($product_items as $product) 
        {
            $product_id         = $product['item_id'];
            $item_variant_name  = $product['variant_name'] ? $product['variant_name'] : 'NULL';
            $item_variant_slug  = $product['variant_slug'] ? $product['variant_slug'] : 'NULL';
            $product_info       = get_the_product($product_id);
            $product_name       = $product['item_name'];
            $category_id        = $product_info['category_id'];
            $brand_id           = $product_info['brand_id'];
            $sup_id             = $product['sup_id'];
            $product_quantity   = $product['quantity'];
            $product_price      = $product['sell_price'];
            $taxrate            = get_the_taxrate($product_info['taxrate_id'],'taxrate');
            $tax                = $product['tax_amount'];
            $product_total      = ($product['sell_price']*$product_quantity)+$tax;
            $purchase_invoice_id  = NULL;
            $item_purchase_price = 0;

            $subtotal += $product['sell_price']*$product_quantity;
            $taxrate_id = $product_info['taxrate_id'];
            
            $quantity_exist = $product_quantity;
            $sell_quantity = $product_quantity;

            if (get_the_customer($customer_id, 'customer_state') == get_preference('business_state')) 
            {
              $cgst = $tax / 2;
              $sgst = $tax / 2;
              $tcgst += $tax / 2;
              $tsgst += $tax / 2;
            } else {
              $igst = $tax;
              $tigst += $tax;
            }


            $statement = $this->db->prepare("INSERT INTO `quotation_item` (reference_no, store_id, sup_id, category_id, brand_id, item_id, item_name, item_variant_slug, item_variant_name, item_purchase_price, item_price, item_discount, item_tax, taxrate_id, tax, gst, cgst, sgst, igst, item_quantity, item_total, purchase_invoice_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($reference_no, $store_id, $sup_id, $category_id, $brand_id,  $product_id, $product_name, $item_variant_slug, $item_variant_name, $item_purchase_price, $product_price, $product_discount, $tax, $taxrate_id, $taxrate, $taxrate, $cgst, $sgst, $igst, $product_quantity, $product_total, $purchase_invoice_id));
        }

        $statement = $this->db->prepare("INSERT INTO `quotation_info` (reference_no, store_id, customer_id, customer_mobile, quotation_note, total_items, is_order, status, payment_status, is_installment, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($reference_no, $store_id, $customer_id, $customer_mobile, $quotation_note, $total_items, $is_order, $status, $payment_status, 0, $user_id, $created_at));

        $statement = $this->db->prepare("INSERT INTO `quotation_price` (reference_no, store_id, subtotal, discount_type, discount_amount, interest_amount, interest_percentage, item_tax, order_tax, cgst, sgst, igst, total_purchase_price, shipping_type, shipping_amount, others_charge, payable_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($reference_no, $store_id, $subtotal, $discount_type, $discount_amount, 0, 0, $item_tax, $order_tax, $tcgst, $tsgst, $tigst, $total_purchase_price, $shipping_type, $shipping_amount, $others_charge, $payable_amount
        ));

        return $reference_no;
    }

    public function updateQuotation($reference_no, $request, $store_id = null)
    {
        $store_id = $store_id ? $store_id : store_id();
        $user_id = user_id();
        $created_at   = date_time();

        $product_items  = $request->post['products'];
        $total_items    = count($product_items);
        $quotation_note = $request->post['quotation-note'];
        $customer_id    = $request->post['customer_id'];
        $customer_mobile= isset($request->post['customer-mobile']) ? $request->post['customer-mobile'] : '';
        $subtotal       = $request->post['total-amount'];
        $discount_type  = isset($request->post['discount-type']) ? $request->post['discount-type'] : 'plain';;
        $discount_amount= $request->post['discount-amount'] ? $request->post['discount-amount'] : 0;
        $shipping_type  = isset($request->post['shipping-type']) ? $request->post['shipping-type'] : 'plain';
        $shipping_amount= $request->post['shipping-amount'] ? $request->post['shipping-amount'] : 0;
        $others_charge  = $request->post['others-charge'] ? $request->post['others-charge'] : 0;
        $order_tax      = $request->post['order-tax-amount'] ? $request->post['order-tax-amount'] : 0; 
        $item_tax       = $request->post['total-tax-amount'] ? $request->post['total-tax-amount'] : 0;
        $payable_amount = $request->post['payable-amount'];
        $status         = $request->post['status'];

        $product_discount = $discount_amount / $total_items;
        $payment_status = 'due';

        $subtotal = 0;
        $igst = 0;
        $cgst = 0;
        $sgst = 0;

        $tgst = 0;
        $tigst = 0;
        $tcgst = 0;
        $tsgst = 0;
        $total_purchase_price = 0;

        $statement = $this->db->prepare("DELETE FROM `quotation_item` WHERE `reference_no` = ? AND `store_id` = ?");
        $statement->execute(array($reference_no, $store_id));

        foreach ($product_items as $product) 
        {
            $product_id         = $product['item_id'];
            $item_variant_name  = $product['variant_name'] ? $product['variant_name'] : 'NULL';
            $item_variant_slug  = $product['variant_slug'] ? $product['variant_slug'] : 'NULL';
            $product_info       = get_the_product($product_id);
            $product_name       = $product['item_name'];
            $category_id        = $product['category_id'];
            $brand_id           = $product_info['brand_id'];
            $sup_id             = $product['sup_id'];
            $product_quantity   = $product['quantity'];
            $product_price      = $product['sell_price'];
            $taxrate            = $product['taxrate'];
            $tax                = $product['tax_amount'];
            $product_total      = ($product['sell_price']*$product_quantity)+$tax;
            $purchase_invoice_id  = NULL;
            $item_purchase_price = 0;

            $subtotal += $product['sell_price']*$product_quantity;
            $taxrate_id = $product_info['taxrate_id'];
            $quantity_exist = $product_quantity;
            $sell_quantity = $product_quantity;

            if (get_the_customer($customer_id, 'customer_state') == get_preference('business_state')) 
            {
              $cgst = $tax / 2;
              $sgst = $tax / 2;
              $tcgst += $tax / 2;
              $tsgst += $tax / 2;
            } else {
              $igst = $tax;
              $tigst += $tax;
            }
            $statement = $this->db->prepare("INSERT INTO `quotation_item` (reference_no, store_id, sup_id, category_id, brand_id, item_id, item_name, item_variant_slug, item_variant_name, item_purchase_price, item_price, item_discount, item_tax, taxrate_id, tax, gst, cgst, sgst, igst, item_quantity, item_total, purchase_invoice_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($reference_no, $store_id, $sup_id, $category_id, $brand_id, $product_id, $product_name, $item_variant_slug, $item_variant_name, $item_purchase_price, $product_price, $product_discount, $tax, $taxrate_id, $taxrate, $taxrate, $cgst, $sgst, $igst, $product_quantity, $product_total, $purchase_invoice_id));
        }
        $statement = $this->db->prepare("UPDATE `quotation_info` SET `customer_id` = ?, `customer_mobile` = ?, `quotation_note` = ?, `total_items` = ?, `status` = ?, `payment_status` = ?, `is_installment` = ? WHERE `reference_no` = ? AND `store_id` = ?");
        $statement->execute(array($customer_id, $customer_mobile, $quotation_note, $total_items, $status, $payment_status, 0, $reference_no, $store_id));

        $statement = $this->db->prepare("UPDATE `quotation_price` SET `subtotal` = ?, `discount_type` = ?, `discount_amount` = ?, `interest_amount` = ?, `interest_percentage` = ?, `item_tax` = ?, `order_tax` = ?, `cgst` = ?, `sgst` = ?, `igst` = ?, `total_purchase_price` = ?, `shipping_type` = ?, `shipping_amount` = ?, `others_charge` = ?, `payable_amount` = ? WHERE `reference_no` = ? AND `store_id` = ?");
        $statement->execute(array($subtotal, $discount_type, $discount_amount, 0, 0, $item_tax, $order_tax, $tcgst, $tsgst, $tigst, $total_purchase_price, $shipping_type, $shipping_amount, $others_charge, $payable_amount, $reference_no, $store_id));
        return $reference_no;
    }

    public function getQuotations($store_id = null, $limit = 100000, $customer_id = null) 
    {
        $store_id = $store_id ? $store_id : store_id();
        $where_query = "`quotation_info`.`store_id` = {$store_id}";
        if ($customer_id) {
            $where_query .= " AND `quotation_info`.`customer_id` = {$customer_id}";
        }
        $statement = $this->db->prepare("SELECT `quotation_info`.*, `quotation_price`.*, `customers`.`customer_id`, `customers`.`customer_name`, `customers`.`customer_mobile`, `customers`.`customer_email` FROM `quotation_info` 
            LEFT JOIN `quotation_price` ON `quotation_info`.`reference_no` = `quotation_price`.`reference_no` 
            LEFT JOIN `customers` ON `quotation_info`.`customer_id` = `customers`.`customer_id` 
            WHERE {$where_query} ORDER BY `quotation_info`.`created_at` DESC LIMIT $limit");
        $statement->execute(array());
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuotationInfo($reference_no, $store_id = null) 
    {
        $store_id = $store_id ? $store_id : store_id();
        $statement = $this->db->prepare("SELECT `quotation_info`.*, `quotation_price`.*, `customers`.`customer_id`, `customers`.`customer_name`, `customers`.`customer_mobile` AS `mobile_number`, `customers`.`customer_email` FROM `quotation_info` 
            LEFT JOIN `quotation_price` ON `quotation_info`.`reference_no` = `quotation_price`.`reference_no` 
            LEFT JOIN `customers` ON `quotation_info`.`customer_id` = `customers`.`customer_id` 
            WHERE `quotation_info`.`store_id` = ? AND (`quotation_info`.`reference_no` = ? OR `quotation_info`.`customer_id` = ?) ORDER BY `quotation_info`.`reference_no` DESC");
        $statement->execute(array($store_id, $reference_no, $reference_no));
        $quotation = $statement->fetch(PDO::FETCH_ASSOC);
        if ($quotation) {
            $quotation['by'] = get_the_user($quotation['created_by'], 'username');
            $quotation['date'] = date('Y-m-d', strtotime($quotation['created_at']));
        }
        return $quotation;
    }

    public function getQuotationItems($reference_no, $store_id = null) 
    {        
        $store_id = $store_id ? $store_id : store_id();
        $statement = $this->db->prepare("SELECT *, q.sup_id AS sup_id FROM `quotation_item` q LEFT JOIN `products` p ON (`q`.`item_id` = `p`.`p_id`) LEFT JOIN `product_to_store` p2s ON (`q`.`item_id` = `p2s`.`product_id`) WHERE `q`.`store_id` = ? AND `q`.`reference_no` = ? GROUP BY `p_id`");
        $statement->execute(array($store_id, $reference_no));
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $the_products = array();
        $i = 0;
        foreach ($rows as $row) {
            $the_product = get_the_product($row['item_id']);
            $the_products[$i] = $row;
            $the_products[$i]['sup_id'] = $row['sup_id'];
            $the_products[$i]['quantity'] = $row['item_quantity'];
            $the_products[$i]['p_name'] = $the_product['p_name'];
            $the_products[$i]['p_code'] = $the_product['p_code'];
            $the_products[$i]['p_type'] = $the_product['p_type'];
            $the_products[$i]['p_type'] = $the_product['p_type'];
            $the_products[$i]['unitName'] = get_the_unit(get_the_product($row['item_id'])['unit_id'],'unit_name');
            $taxrate = 0;
            $tax_amount = 0;
            $taxrate = 0;
            if ($the_product && $the_product['taxrate']) {
                $the_products[$i]['taxrate'] = $the_product['taxrate']['taxrate'];
                $the_products[$i]['tax_amount'] = ($the_product['taxrate']['taxrate'] / 100 ) * $the_product['sell_price'];
            }
            $the_products[$i]['variant_slug'] = '';
            $the_products[$i]['variant_name'] = '';
            $the_products[$i]['sell_price_addition'] = 0;
            $the_variant = get_the_variant($row['item_id'], $row['item_variant_slug']);
            if ($the_variant) {
                $the_products[$i]['variant_id'] = $the_variant['variant_id'];
                $the_products[$i]['variant_slug'] = $the_variant['variant_slug'];
                $the_products[$i]['variant_name'] = $the_variant['variant_name'];
                $the_products[$i]['purchase_price_addition'] = $the_variant['purchase_price_addition'];
                $the_products[$i]['sell_price_addition'] = $the_variant['sell_price_addition'];
            }
            if (!isset($the_products[$i]['sell_price_addition'])) {
                $the_products[$i]['purchase_price_addition'] = 0;
                $the_products[$i]['sell_price_addition'] = 0;
            }
            $the_products[$i]['variant'] = $the_variant;
            $i++;
        }
        return $the_products;
    }
}