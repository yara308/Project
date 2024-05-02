<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$reference_no = isset($request->get['reference_no']) ? $request->get['reference_no'] : '';
$order_model = registry()->get('loader')->model('quotation');
$order_model = registry()->get('loader')->model('quotation');;
$order_info = $order_model->getQuotationInfo($reference_no);
if (!$order_info) {
  redirect('products.php');
}
$order_items = $order_model->getQuotationItems($reference_no);
$document->setTitle(trans('title_payment'));
include('header_home.php');?>
<style type="text/css">
.your-order-area {
    border: none;
}
.description-review-wrapper {
    border-width: 2px;
}
.pmethod-tab {
    text-align: center;
    background: #F5F6F9;
    padding: 20px!important;
    margin-right: 3px!important;
    min-width: 120px;
}   
.pmethod-tab .icon {
    font-size: 22px;
    color: black;
}
.pmethod-tab.active .icon {
    color: #DCB86C;
}
.pmethod-tab .text {
    margin-top: 20px!important;
}
.faq-accordion, .faq-accordion.actives {
  box-shadow: none;
}
</style>
<div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
  <div class="container-fluid">
    <div class="breadcrumb-content text-center breadcrumb-center">
      <h2>Payment with paypal</h2>
      <ul>
          <li>
              <a href="home.php">Home</a>
          </li>
          <li>
              <a href="products.php">Products</a>
          </li>
          <li>Payment</li>
      </ul>
    </div>
  </div>
</div>
<div class="main-area cart-main-area pt-20 pb-20">
  <div class="container">
    <div class="checkout-wrap">
      <div class="row mb-20">
        <div class="col-lg-7 mx-auto">
          <div class="description-review-wrapper">
            <div id="paypal" class="tab-pane">
              <div class="product-description-wrapper pt-20">
                <?php
                $test_mode = 1;
                $transaction_method = 'sale'; // Authorization
                $order_id = $reference_no;
                $discount_amount_cart = 0;
                $business = 'bdbuzz360@gmail.com';
                if (!$test_mode) {
                    $action = 'https://www.paypal.com/cgi-bin/webscr&pal=V4T754QB63XXL';
                } else {
                    $action = 'https://www.sandbox.paypal.com/cgi-bin/webscr&pal=V4T754QB63XXL';
                }
                $currency_code  = 'USD';
                $first_name     = 'Najmul';
                $last_name      = 'Hossain';
                $address1       = 'Cantonment Road, Rajshahi';
                $address2       = '';
                $city           = 'Rajshahi';
                $zip            = 6250;
                $country        = 'BD'; // iso_code
                $email          = 'bdbuzz360@gmail.com';
                $invoice        = $order_id . ' - ' . 'Najmul' . ' ' . 'Hossain';
                $lc             = 'en-us';
                $return         = root_url().'/xxx/pp_success.php';
                $notify_url     = root_url().'/xxx/pp_callback.php';
                $cancel_return  = root_url().'/xxx/payment_cashier.php';
                if (!$transaction_method) {
                    $paymentaction = 'authorization';
                } else {
                    $paymentaction = 'sale';
                }
                ?>
                <?php if ($test_mode):?>
                <div class="alert alert-danger">
                    Warning: The payment gateway is in 'Sandbox Mode'. Your account will not be charged.
                </div>
                <br>
                <?php endif;?>
                <form action="<?php echo $action;?>" method="post">
                  <input type="hidden" name="cmd" value="_cart" />
                  <input type="hidden" name="upload" value="1" />
                  <input type="hidden" name="business" value="<?php echo $business;?>" />
                  <?php $inc=1;foreach ($order_items as $item):?>
                    <input id="item_id" type="hidden" name="item_name_<?php echo $inc;?>" value="{{<?php echo $item['item_name'];?>">
                    <input id="item_name" type="hidden" name="item_number_<?php echo $inc;?>" value="<?php echo $item['item_name'];?>">
                    <input id="quantity" type="hidden" name="amount_<?php echo $inc;?>" value="<?php echo $item['item_total'];?>">
                    <input id="price" type="hidden" name="quantity_<?php echo $inc;?>" value="<?php echo $item['item_quantity'];?>">
                  <?php $inc++;endforeach;?>
                  <input type="hidden" name="currency_code" value="<?php echo $currency_code;?>" />
                  <input type="hidden" name="first_name" value="<?php echo $first_name;?>" />
                  <input type="hidden" name="last_name" value="<?php echo $last_name;?>" />
                  <input type="hidden" name="address1" value="<?php echo $address1;?>" />
                  <input type="hidden" name="address2" value="<?php echo $address2;?>" />
                  <input type="hidden" name="city" value="<?php echo $city;?>" />
                  <input type="hidden" name="zip" value="<?php echo $zip;?>" />
                  <input type="hidden" name="country" value="<?php echo $country;?>" />
                  <input type="hidden" name="address_override" value="0" />
                  <input type="hidden" name="email" value="<?php echo $email;?>" />
                  <input type="hidden" name="invoice" value="<?php echo $invoice;?>" />
                  <input type="hidden" name="lc" value="<?php echo $lc;?>" />
                  <input type="hidden" name="rm" value="2" />
                  <input type="hidden" name="no_note" value="1" />
                  <input type="hidden" name="no_shipping" value="1" />
                  <input type="hidden" name="charset" value="utf-8" />
                  <input type="hidden" name="return" value="<?php echo $return;?>" />
                  <input type="hidden" name="notify_url" value="<?php echo $notify_url;?>" />
                  <input type="hidden" name="cancel_return" value="<?php echo $cancel_return;?>" />
                  <input type="hidden" name="paymentaction" value="<?php echo $paymentaction;?>" />
                  <input type="hidden" name="custom" value="<?php echo $order_id;?>" />
                  <input type="hidden" name="bn" value="ModernPOS_3.0" />
                  <button class="btn btn-info" type="submit"/>Coonfirm Order
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="panel faq-accordion mb-20" style="border-radius:0">
            <div class="panel-heading">
              <h4 class="panel-title bg-light">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#summary">
                      <i class="fa fa-fw fa-eye"></i> Order Summary : <span class="text-info" style="font-size: 22px;"><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?></span>
                  </a>
              </h4>
            </div>  
            <div id="summary" class="panel-collapse collapse">
              <div class="panel-body">
                  <div class="your-order-area">
                    <div class="your-order-wrap gray-bg-4">
                      <div class="your-order-info-wrap">
                          <div class="your-order-info">
                              <ul>
                                  <li>Product <span>Total</span></li>
                              </ul>
                          </div>
                          <div class="your-order-middle">
                              <ul>
                                <?php $inc=1;foreach ($order_items as $item):?>
                                  <li class="single-product-cart">
                                      <input id="item_id" type="hidden" name="items[<?php echo $item['item_id'];?>][item_id]" value="<?php echo $item['item_id'];?>">
                                      <input id="item_name" type="hidden" name="items[<?php echo $item['item_id'];?>][item_name]" value="<?php echo $item['item_name'];?>">
                                      <input id="quantity" type="hidden" name="items[<?php echo $item['item_id'];?>][quantity]" value="<?php echo $item['item_quantity'];?>">
                                      <input id="price" type="hidden" name="items[<?php echo $item['item_id'];?>][price]" value="<?php echo $item['item_total'];?>">
                                      <?php echo $item['item_name'];?> X <?php echo $item['item_quantity'];?> <span><?php echo get_currency_symbol();?><?php echo currency_format($item['item_total']);?></span>
                                  </li>
                                <?php endforeach;?>
                              </ul>
                          </div>
                          <div class="your-order-info order-subtotal">                                        
                              <ul>
                                  <li>
                                      <a href="cart.php" title="View Cart">Subtotal (<?php echo $order_info['total_items'];?> items)</a> <span><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?></span>
                                  </li>
                              </ul>
                          </div>
                          <div class="your-order-info order-shipping">
                              <ul>
                                  <li>Shipping Fee <span>-</span></li>
                              </ul>
                          </div>
                          <div class="your-order-info order-total">
                              <ul>
                                  <li>Total <span><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?></span></li>
                              </ul>
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
</div>
<?php include('footer.php');?>