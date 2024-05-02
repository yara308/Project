<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
$address = isset($session->data['address']) ? json_decode($session->data['address'], true) : array();
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
<form id="orderForm" class="form-horizontal" action="place_order.php"  method="post" enctype="multipart/form-data">
    <input type="hidden" name="address[full_name]" value="<?php echo isset($address['full_name']) ? $address['full_name'] : '';?>">
    <input type="hidden" name="address[phone_number]" value="<?php echo isset($address['phone_number']) ? $address['phone_number'] : '';?>">
    <input type="hidden" name="address[address]" value="<?php echo isset($address['address']) ? $address['address'] : '';?>">
    <input type="hidden" id="pmethod_name" name="pmethod[name]" value="cod">

    <input type="hidden" id="order-tax-amount" name="order-tax-amount" value="0">
    <input type="hidden" id="total-tax-amount" name="total-tax-amount" value="0">

   
    
           <div class="card user-data-card">
            <div class="card-body">
                    <?php if (!empty($address)):?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">
<div class="title mb-2"><i class="fa-solid fa-user"></i><span>أسم العميل</span></div>
   <input class="form-control" id="full_name" name="address[full_name]" placeholder="Full name" value="<?php echo isset($address['full_name']) ? $address['full_name'] : '';?>" disabled>
                </div>
<div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-phone"></i><span>رقم الهاتف</span></div>
               
 </div>
<div class="mb-3">
                   <input class="form-select" id="phone_number" name="address[phone_number]" placeholder="Phone nuber" type="text" value="<?php echo isset($address['phone_number']) ? $address['phone_number'] : '';?>" disabled>
                </div>
<div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-location-arrow"></i><span>العنوان</span></div>
                  <input class="form-control" id="address" name="address[address]" class="billing-address" placeholder="Enter address here" type="text" value="<?php echo isset($address['address']) ? $address['address'] : '';?>" disabled>
                </div>

                               
                                <a class="btn btn-success w-100" href="checkout.php">Change Address</a>
                            </p>
                        </div>
                    <?php else:?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">Returning customer? <a class="text-success" href="account_login.php">Click here to login &rarr;</a></p>
                        </div>
                    <?php endif;?>
                </div>
            </div>



           
           <div class="card user-data-card">
            
                    <div class="col-lg-7 mx-auto">
                        <div class="panel faq-accordion mb-20" style="border-radius:0">
                            <div class="panel-heading">
                                <h4 class="panel-title bg-light">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#summary">
                                        <i class="fa fa-fw fa-file"></i> Order Summary : Amount <?php echo get_currency_symbol();?>{{ totalAmount | formatDecimal:2 }}
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
                                                        <li ng-repeat="items in itemArray" class="single-product-cart">
                                                            <input id="item_id" type="hidden" name="items[{{ items.id}}][item_id]" value="{{ items.id }}">
                                                            <input id="sup_id" type="hidden" name="items[{{ items.id}}][sup_id]" value="{{ items.supId }}">
                                                            <input id="item_name" type="hidden" name="items[{{ items.id}}][item_name]" value="{{ items.name }}">
                                                            <input id="variant_slug" type="hidden" name="items[{{ items.id}}][variant_slug]" value="{{ items.variant_slug }}">
                                                            <input id="variant_name" type="hidden" name="items[{{ items.id}}][variant_name]" value="{{ items.variant_name }}">
                                                            <input id="quantity" type="hidden" name="items[{{ items.id}}][quantity]" value="{{ items.quantity }}">
                                                            <input id="price" type="hidden" name="items[{{ items.id}}][price]" value="{{ items.price }}">
                                                            {{ items.name }} X {{ items.quantity }} <span>${{ items.price | formatDecimal:2 }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-subtotal">                                        
                                                    <ul>
                                                        <li>
                                                            <a href="cart.php" title="View Cart">Subtotal ({{ totalQuantity }} items)</a> <span>${{ totalAmount | formatDecimal:2 }} </span>
                                                            <input id="total_quantity" type="hidden" name="total_quantity" value="{{ totalQuantity }}">
                                                            <input id="total_amount" type="hidden" name="total_amount" value="{{ totalAmount }}">
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-shipping">

                                                    <ul>
                                                        <li>
                                                            <input type="hidden" name="shipping-amount">
                                                            Shipping Fee <span>-</span>
                                                        </li>
                                                        <li>
                                                            <input type="hidden" name="others-charge">
                                                            Others Charge <span>-</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="your-order-info order-total">
                                                    <ul>
                                                        <li>Total <span>${{ totalAmount | formatDecimal:2 }}</span></li>
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
<div class="page-content-wrapper" >
    <div class="container">
        <!-- Checkout Wrapper-->
        <div class="checkout-wrapper-area py-3">
            <!-- Choose Payment Method-->
            <ul class="nav nav-tabs">
                <li class="nav-item col-6 col-md-5 single-payment-method">
                    <a data-toggle="tab" href="#kent" class="nav-link active credit-card"><i class="fas fa-credit-card"></i><h6>كي نت</h6></a>
                </li>
                <li class="nav-item col-6 col-md-5 single-payment-method">
                    <a data-toggle="tab" href="#cash" class="nav-link bank"><i class="fas fa-hand-holding-usd"></i><h6>الدفع عند الاستلام</h6></a>
                </li>
                <li class="nav-item col-6 col-md-5 single-payment-method">
                    <a data-toggle="tab" href="#apple" class="nav-link paypal"><i class="fa-brands fa-apple-pay"></i><h6>ابل باي</h6></a>
                </li>
               
            </ul>

            <!-- Payment Method Content-->
   <div class="tab-content description-review-bottom">
    <div id="cod" class="tab-pane fade show active">
        <div class="pay-credit-card-form">
            <p>You can pay using your credit card.</p>
            <!-- Wrapper for Credit Card Info -->
            <div class="credit-card-info-wrapper">
                 
                        <button ng-click="placeOrder();" class="btn btn-warning btn-lg w-100" name="submit" data-loading-text="Processing..."><i class="fas fa-check"></i>ادفع الان</button>
                   
            </div>
        </div>
    </div>
 <div id="cash" class="tab-pane fade show">
        <div class="pay-credit-card-form">
            <p>You using your cash.</p>
            <!-- Wrapper for Credit Card Info -->
            <div class="credit-card-info-wrapper">
                 
                        <button ng-click="placeOrder();" class="btn btn-warning btn-lg w-100" name="submit" data-loading-text="Processing..."><i class="fas fa-check"></i>ادفع الان</button>
                   
            </div>
        </div>
    </div>
	   <div id="apple" class="tab-pane fade show">
        <div class="pay-credit-card-form">
            <p>You using your apple pay.</p>
            <!-- Wrapper for Credit Card Info -->
            <div class="credit-card-info-wrapper">
                 
                        <button ng-click="placeOrder();" class="btn btn-warning btn-lg w-100" name="submit" data-loading-text="Processing..."><i class="fas fa-check"></i> ادفع الان</button>
                   
            </div>
        </div>
    </div>
    <!-- ... other tab panes ... -->
</div>


        </div>
    </div>
</div>


 </form>

<script type="text/javascript">
$(document).ready(function() {
    var code;
    $(".pmethod-tab").click(function(e){
        e.preventDefault();
        $(this).tab("show");
        if (!$(this).data("code") || $(this).data("code") == undefined || $(this).data("code") == null) {
            window.location.reload();;
        }
        $("#pmethod_name").val($(this).data("code"));
    });
});
</script>
<?php include('footer.php');?>