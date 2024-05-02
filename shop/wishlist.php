<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_wishlist'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Your Wishlist</h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li class="active">Wishlist</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area cart-main-area pt-70 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="head-img"></th>
                                        <th class="product-name">Product</th>
                                        <th class="head-price">Price</th>
                                        <th class="head-quality">Quantity</th>
                                        <th class="head-total">Total</th>
                                        <th class="wish-cart">Add To Wishlist</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="product-cart-img">
                                            <a href="#"><img src="assets/img/cart/cart-3.jpg" alt=""></a>
                                        </td>
                                        <td class="product-cart-name"><a href="#">Ruffled cotton top</a></td>
                                        <td class="product-price-cart"><span class="amount">$260.00</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
                                            </div>
                                        </td>
                                        <td class="product-total"><span>$110.00</span></td>
                                        <td class="product-wish-cart">
                                            <a href="#">add to cart</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="product-cart-img">
                                            <a href="#"><img src="assets/img/cart/cart-4.jpg" alt=""></a>
                                        </td>
                                        <td class="product-cart-name"><a href="#">Bow polka-dot blouse</a></td>
                                        <td class="product-price-cart"><span class="amount">$260.00</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
                                            </div>
                                        </td>
                                        <td class="product-total"><span>$110.00</span></td>
                                        <td class="product-wish-cart">
                                            <a href="#">add to cart</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="product-cart-img">
                                            <a href="#"><img src="assets/img/cart/cart-3.jpg" alt=""></a>
                                        </td>
                                        <td class="product-cart-name"><a href="#">Ruffled cotton top</a></td>
                                        <td class="product-price-cart"><span class="amount">$260.00</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
                                            </div>
                                        </td>
                                        <td class="product-total"><span>$110.00</span></td>
                                        <td class="product-wish-cart">
                                            <a href="#">add to cart</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php include('footer.php');?>