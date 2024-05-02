<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_cart'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Shopping Cart</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li>Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area cart-main-area pt-30 pb-30">
        <div class="container">
            <?php if (!is_clogged_in()):?>
                <div class="customer-zone mb-20">
                    <p style="font-size:16px;" class="cart-page-title">Returning customer? <a class="text-success" href="account_login.php">Click here to login &rarr;</a></p>
                </div>
                <div class="customer-zone mb-20">
                    <p style="font-size:16px;" class="cart-page-title">Does not have account yet? <a class="text-info" href="account_register.php">Click here to register &rarr;</a></p>
                </div>
            <?php endif;?>
            <div ng-show="totalQuantity" class="row">
                <div class="col-lg-8 col-md-8">
                    <form action="#">
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="head-remove font-weight-bold"></th>
                                        <th class="head-img font-weight-bold"></th>
                                        <th class="product-name font-weight-bold">Product</th>
                                        <th class="head-price font-weight-bold">Price</th>
                                        <th class="head-quality font-weight-bold">Quantity</th>
                                        <th class="head-total font-weight-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="items in itemArray" class="single-product-cart">
                                        <td class="product-remove">
                                            <a ng-click="removeItemFromInvoice($index, items.id)" onClick="return false;" class="text-danger" href="#"><i class="negan-icon-simple-close"></i></a>
                                        </td>
                                        <td class="product-cart-img">
                                            <a ng-show="!items.img" href="#"><img style="width:60px;height:70px;" ng-src="assets/img/cart/cart-3.jpg" alt=""></a>
                                            <a ng-show="items.img" href="#"><img style="width:60px;height:70px;" ng-src="<?php echo FILEMANAGERURL;?>/{{items.img}}" alt=""></a>

                                        <td class="product-cart-name"><a href="product_details.php?product_id={{ items.id }}">{{ items.name }}</a></td>
                                        <td class="product-price-cart"><span class="amount">${{ items.price | formatDecimal:2 }}</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <div ng-click="DecreaseItemFromInvoice(items.id,1)" class="dec qtybutton">-</div>
                                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ items.quantity }}">
                                                <div ng-click="addItemToInvoice(items.id,1)" class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="product-total"><span>${{ items.subTotal | formatDecimal:2 }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper text-center">
                                    <div ng-show="totalQuantity" class="cart-clear">
                                        <button ng-click="clearTheCart()" onClick="return false;"><span class="fa fa-fw fa-close"></span>Clear Cart</button>
                                    </div>
                                    <div class="cart-clear d-none d-md-block">
                                        <a class="btn" href="products.php">&larr; Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="grand-totall mt-20">
                        <div class="title-wrap bg-gray pt-20 pb-20 mb-0" style="border-bottom:2px solid #ddd;">
                            <h4 class="cart-bottom-title text-center">Order Summary</h4>
                        </div>
                        <ul class="mt-0">
                            <li>Subtotal (1 Items) <span>${{ totalAmount | formatDecimal:2 }}</span></li>
                            <li>Shipping Fee <span>0.00</span></li>
                            <li>Total <span>${{ totalAmount | formatDecimal:2 }}</span></li>
                        </ul>
                        <a ng-show="totalQuantity" class="btn-success" href="checkout.php">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
            <div ng-show="!totalQuantity" class="cart-empty-content text-center pt-50 pb-50">
                <i class="negan-icon-cart-modern"></i>
                <p>Your cart is currently empty.</p>
                <div class="empty-btn">
                    <a href="products.php">&larr; Return to shop</a>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>