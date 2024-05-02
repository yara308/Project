<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
$address = isset($session->data['address']) ? json_decode($session->data['address'], true) : array();
$document->setTitle(trans('title_payment'));
include('header.php');?>
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
<form id="orderForm" class="form-horizontal" action="place_order.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="address[full_name]" value="<?php echo isset($address['full_name']) ? $address['full_name'] : '';?>">
    <input type="hidden" name="address[phone_number]" value="<?php echo isset($address['phone_number']) ? $address['phone_number'] : '';?>">
    <input type="hidden" name="address[address]" value="<?php echo isset($address['address']) ? $address['address'] : '';?>">
    <input type="hidden" id="pmethod_name" name="pmethod[name]" value="cod">

    <input type="hidden" id="order-tax-amount" name="order-tax-amount" value="0">
    <input type="hidden" id="total-tax-amount" name="total-tax-amount" value="0">

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-50 pb-50">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Select Payment Method</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="cart.php">Cart</a>
                    </li>
                    <li>
                        <a href="checkout.php">Checkout</a>
                    </li>
                    <li class="active">Payment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area cart-main-area pt-20 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto">
                    <?php if (!empty($address)):?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">
                                <span style="font-size:18px;">Shipping and Biling Address :</span> <br>
                                Full name: <b><?php echo $address['full_name'];?></b> <br>
                                Phone number: <b><?php echo $address['phone_number'];?></b> <br>
                                Address: <b><?php echo $address['address'];?></b>

                                <br>
                                <a class="text-info" href="checkout.php">Change Address</a>
                            </p>
                        </div>
                    <?php else:?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">Returning customer? <a class="text-success" href="account_login.php">Click here to login &rarr;</a></p>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
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
            <div ng-show="totalQuantity" class="checkout-wrap">
                <div class="row mb-20">
                    <div class="col-lg-7 mx-auto">
                        <div class="description-review-wrapper">
                            <div class="description-review-topbar nav">
                                <a class="pmethod-tab bg-info text-white active" data-code="cod" href="#cod">
                                    <i class="icon fa fa-dollar"></i>
                                    <div class="text">Cash on Delivery</div>
                                </a>
                                <a class="pmethod-tab bg-info text-white" data-code="bank_transfer" href="#bank_transfer">
                                    <i class="icon fa fa-paper-plane"></i>
                                    <div class="text">Bank Transfer</div>
                                </a>
                                <a class="pmethod-tab bg-info text-white" data-code="bkash" href="#bKash">
                                    <i class="icon fa fa-star-o"></i>
                                    <div class="text">bKash</div>
                                </a>
                                <a class="pmethod-tab bg-info text-white" data-code="paypal" href="#paypal">
                                    <i class="icon fa fa-paypal"></i>
                                    <div class="text">Paypal</div>
                                </a>
                            </div>
                            <div class="tab-content description-review-bottom">
                                <div id="cod" class="tab-pane active">
                                    <div class="product-description-wrapper pt-20">
                                        <p>You can pay in cash to our courier when you receive the goods at your doorstep.</p>
                                        <h4>*Please have this amount ready on delivery day.</h4>
                                        <br>
                                        <button ng-click="placeOrder();" onClick="return false;" class="btn btn-info" name="submit" data-loading-text="Processing...">
                                          <i class="fa fa-fw fa-check"></i>
                                          <?php echo trans('button_conform_order'); ?>
                                        </button>
                                    </div>
                                </div>
                                <div id="bank_transfer" class="tab-pane">
                                    <div class="product-description-wrapper pt-20">
                                        <h5 class="font-weight-bold">Bank Account Details</h5>
                                            <address>
                                                Bank account detals goes here...
                                            </address>
                                        <h5 class="font-weight-bold">How to make a bank transfer</h5>
                                        <ol>
                                            <li>Online bank transfers. Log in to your online account and select the option for making a payment. ...</li>
                                            <li>Telephone transfers. Call your bank's telephone banking service. ...</li>
                                            <li>In-branch bank transfers. If you have the money in cash, you can pay it into the account of the person you owe it to in-branch.</li>
                                        </ol>
                                        <button ng-click="placeOrder();" onClick="return false;" class="btn btn-info mt-20" data-form="#orderForm" name="submit" data-loading-text="Processing...">
                                          <i class="fa fa-fw fa-check"></i>
                                          <?php echo trans('button_conform_order'); ?>
                                        </button>
                                    </div>
                                </div>
                                <div id="bKash" class="tab-pane">
                                    <div class="product-description-wrapper pt-20">
                                        <div class="mb-30">
                                            You can make payments from your bKash Account to any “Merchant” who accepts “bKash Payment”. Now you can bKash your Payment at more than 47,000 outlets nationwide. To bKash your Payment follow the steps below.
                                        </div>
                                        <ol>
                                            <li>Go to your bKash Mobile Menu by dialing *247#</li>
                                            <li>Choose “Payment”</li>
                                            <li>Enter the Merchant bKash Account Number <b>(<?php echo store('mobile') ? store('mobile') : '+8801737346122';?>)</b></li>
                                            <li>Enter the amount you want to pay</li>
                                            <li>Enter a reference* against your payment (you can mention the purpose of the transaction in one word. e.g. Bill)</li>
                                            <li>Enter the Counter Number* (the salesperson at the counter will tell you the number)</li>
                                            <li>Now enter your bKash Mobile Menu PIN to confirm</li>
                                        </ol>
                                        <div class="mb-10">
                                            Done! You will receive a confirmation message from bKash.
                                        </div>
                                        <div class="mb-30">
                                            *If Reference or Counter No. or both are not applicable, you can skip them by entering 0
                                        </div>
                                        <button ng-click="placeOrder();" onClick="return false;" class="btn btn-info" data-form="#orderForm" name="submit" data-loading-text="Processing...">
                                          <i class="fa fa-fw fa-check"></i>
                                          <?php echo trans('button_conform_order'); ?>
                                        </button>
                                    </div>
                                </div>
                                <div id="paypal" class="tab-pane">
                                    <div class="product-description-wrapper pt-20">
                                        <div class="mb-30">
                                            Payment with paypal.
                                            More descript goes here..
                                        </div>
                                        <button ng-click="placeOrder();" onClick="return false;" class="btn btn-info" data-form="#orderForm" name="submit" data-loading-text="Processing...">
                                          <i class="fa fa-fw fa-check"></i>
                                          <?php echo trans('button_pay_now'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-show="!totalQuantity" class="row mb-20">
                <div class="col-lg-7 mx-auto">
                    <div class="card bg-danger text-center">
                        <div class="card-body">
                            <h4 class="text-white">Shopping card is empty!</h4>
                        </div>
                        <div class="card-footer">
                            <a class="text-white" href="products.php">Continue Shopping &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
<!-- </form> -->

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