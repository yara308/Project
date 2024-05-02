<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../').'/_init.php';
function validate_request_data($request) 
{
  if (!validateString($request['full_name'])) {
    throw new Exception(trans('error_full_name_is_required'));
  }
  if (!valdateMobilePhone($request['phone_number'])) {
    throw new Exception(trans('error_phone_number_is_required'));
  }
  if (!validateString($request['address'])) {
    throw new Exception(trans('error_address_is_required'));
  }
}
$address = isset($session->data['address']) ? json_decode($session->data['address'], true) : array();
$errors = array();
if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'ADDADDRESS')
{
    try {

        validate_request_data($request->post['address']);
        $session->data['address'] = json_encode($request->post['address']);
        
        redirect('payment_cashier.php');
    } catch (Exception $e) { 

        $errors[] = $e->getMessage();
    }
}
$document->setTitle(trans('title_checkout'));
include('header.php');?>
<form id="checkoutForm" class="form-horizontal" action="checkout.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action_type" value="ADDADDRESS">
    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Checkout</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="cart.php">Cart</a>
                    </li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area checkout-main-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (!empty($errors)):?>
                        <?php foreach ($errors as $err):?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="text-danger"><?php echo $err;?></p>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
                    <?php if (!is_clogged_in()):?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">Returning customer? <a class="text-success" href="account_login.php">Click here to login &rarr;</a></p>
                        </div>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="cart-page-title">Have not an account yet? <a class="text-info" href="account_register.php">Click here to register &rarr;</a></p>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="checkout-wrap mt-20">
                <div ng-show="totalQuantity" class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="billing-info-wrap">
                            <h3>Your Shipping & Billing Address</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>Full Name <abbr class="required" title="required">*</abbr></label>
                                        <input id="full_name" name="address[full_name]" placeholder="Full name" type="text" value="<?php echo isset($address['full_name']) ? $address['full_name'] : '';?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>Phone Number <abbr class="required" title="required">*</abbr></label>
                                        <input id="phone_number" name="address[phone_number]" placeholder="Phone nuber" type="text" value="<?php echo isset($address['phone_number']) ? $address['phone_number'] : '';?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info">
                                        <label>Address <abbr class="required" title="required">*</abbr></label>
                                        <input id="address" name="address[address]" class="billing-address" placeholder="Enter address here" type="text" value="<?php echo isset($address['address']) ? $address['address'] : '';?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 mb-20">
                                    <div class="billing-info mb-20">
                                        <div class="Place-order mt-25 text-center">
                                            <button class="btn btn-info btn-lg btn-block" type="submit">Save &amp; Place Order &rarr;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mx-auto">
                        <div class="your-order-area">
                            <h3>Order Summary</h3>
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
                                                <a href="product_details.php?product_id={{ items.id }}">{{ items.name }}</a> X {{ items.quantity }} <span>${{ items.price | formatDecimal:2 }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li>Subtotal ({{ totalQuantity }} items) <span>${{ totalAmount | formatDecimal:2 }} </span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-subtotal">
                                        <ul>
                                            <li>Shipping Fee <span>&nbsp;-</span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>Total <span>${{ totalAmount | formatDecimal:2 }} </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="Place-order mt-25 text-center">
                                <button class="btn btn-block" type="submit">Place Order</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div ng-show="!totalQuantity" class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="alert alert-danger">Your Cart is Empty!</div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <a class="text-info" href="products.php">Continue Shopping &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include('footer.php');?>