<?php //die('delete...everything***********');

error_reporting(-1);
ini_set('display_errors', 1);

if (isset($request->get['store_id']) && $request->get['store_id']) {
    $store->openTheStore($request->get['store_id']);
}
if(isset($request->get['action']) && $request->get['action'] == 'logout')
{
    $session->data['is_clogged_in'] = 0;
    $session->data['cid'] = '';
    $session->data['cname'] = '';
    redirect('home.php');
}
$body_class = $document->getBodyClass();
$title = $document->getTitle();
$description = $document->getDescription();
$keywords = $document->getKeywords();
$styles = $document->getStyles();
$scripts = $document->getScripts(); 
$query_string = '';
if (!empty($request->get)) {
    $inc=1;foreach ($request->get as $key => $value) {
      if (!in_array($key, array('from', 'to', 'filter','ftype', 'type'))) {
        if ($inc==1) {
            $query_string .= '?'.$key.'='.$value;
        } else {
            $query_string .= '&'.$key.'='.$value;
        }
      }
    $inc++;}
} else {
    $query_string = '?filter=yes';
}
$query_string = str_replace(array('&'), '?', $query_string);
?>
<!doctype html>
<html class="no-js" lang="en-us" ng-app="angularApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title ? $title . ' &raquo; ' : null; ?><?php echo store('name'); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Bootstrap Timepicker CSS -->
    <link type="text/css" href="../assets/timepicker/bootstrap-timepicker.min.css" type="text/css">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/icons.min.css">
    <!-- Select2 CSS -->
    <link type="text/css" href="../assets/select2/select2.min.css" type="text/css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="../assets/toastr/toastr.min.css" type="text/css" rel="stylesheet">
    <!-- Revolution Slider CSS -->
    <link href="assets/revolution/css/settings.css" rel="stylesheet">
    <link href="assets/revolution/css/navigation.css" rel="stylesheet">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <style type="text/css">
        body {
            font-size: 16px;
            color: #000;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
            background-color: #fff
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: rgba(0,0,0,.5)
        }
        input {
            font-size: 22px;
        }
        .select2-search__field {
            height: 30px;
        }
        p {
            color: #000;
            font-size: 14px!important;
            font-family: arial, "sans-serif";
        }
        .btn {
            font-size: 14px;
        }
        .active {
            color: #b68724;
        }
        .search-close {
            color: rgb(119, 119, 119)!important;
        }
        .login-register-wrapper .login-form-container .login-register-form form .sin-login-register input {
            border: 1px solid #000;
        }
        .your-order-area .your-order-wrap .your-order-info ul li {
            font-size: 14px;
        }
        .billing-info-wrap .billing-info input {
            background-color: transparent;
            padding: 2px 10px;
            color: #090909;
            font-size: 14px;
        }
        .your-order-area {
            background: #f8f9fa;
        }
        .header-right-wrap .same-style.account-satting ul {
            right: -50%;
            left: auto!important;
        }
        .site-topbar {
            background: rgba(158,158,158,.2);
        }
        .site-topbar ul {
            list-style: none;
            text-align: right;
        }
        .site-topbar ul li {
            display: inline-block;
        }
        .site-topbar ul li a {
            font-size: 10px;
            font-weight: 600;
            padding: 0 10px;
        }
        .breadcrumb-area {
            background: #e5f1fe;
        }
        .product-wrap, .shop-list-wrap {
            position: relative;
        }
        .prod-inner-loader {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            z-index: 1050;
            background: #ffffffc9;
            display: none;
        }
        .prod-inner-loader .loader-inner {}
        .prod-inner-loader img {
            position: relative;
            width: 80px;
            height: 80px;
        }
        .footer-widget .footer-list ul li {
            margin-bottom: 5px;
        }
        .footer-bottom {
            text-align: center;
            background: #e9ecef;
            padding: 10px;
        }
        .footer-widget .footer-list ul li {
            margin-bottom: 5px;
        }
        .grand-totall ul li {
            font-size: 16px;
        }
        .billing-info-wrap .checkout-account input {
            height: 20px;
            width: 20px;
            top: 3px;
        }
        .category-wrap-2 .category-btn-2 a {
            font-size: 14px;
            color: #dc3545;
            text-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff0cfba;
            padding: 10px 30px;
            text-align: center;
            border: 2px solid #dc3545;
            border-radius: 50px;
        }
        .your-order-area .Place-order a {
            font-size: 14px;
        }
        .contact-info-area {
            padding: 40px 40px 40px 40px;
        }
        .pagination {
            display: block;
        }
        .pagination li {
            font-weight: 700;
        }
        .pagination .active span {
            color: red;
        }
        .easyzoom  img {
            display: inline-block;
        }
        .product-wrap .product-img > span {
            top: 10px;
            left: 10px;
            padding: 3px 5px;
        }
        .product-wrap .product-img > span.red {
            background-color: red;
        }
        .category-wrap-2 {
            background-image: linear-gradient(270deg,#fcfcfc,#fcfcff);
            padding: 15px;
        }
        @media only screen and (max-width: 767px) {
            .header-small-mobile {
                background-image: linear-gradient(270deg,#b8baf6,#fea8e8);
            }
            .pro-details-cart {
                width: 100%;
            }
            .pro-details-cart a {
                width: 100%;
                text-align: center;
            }
            .description-review-wrapper .description-review-topbar a {
                width: 100%;
                border-bottom: 2px solid #ddd;
            }
            .site-topbar ul {
                text-align: center;
            }
            .your-order-area {
                margin-top: 0;
            }
            .copyright p {
                color: #000;
                font-size: 10px!important;
            }
            .copyright p a {
                color: blue;
            }
        }
        @media only screen and (min-width: 1200px) and (max-width: 1365px) {}
        @media only screen and (min-width: 992px) and (max-width: 1199px) {}
        @media only screen and (min-width: 768px) and (max-width: 991px) {}
        @media only screen and (min-width: 768px) and (max-width: 991px) {}
        @media only screen and (min-width: 992px) and (max-width: 1199px) {}
    </style>


    <!-- JS
    ============================================ -->

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script type="text/javascript">
        var lang = "en-us";
        var baseUrl = "<?php echo root_url().'/shop';?>";
    </script>

    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Popper JS -->
    <script src="assets/js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Bootstrap Timepicker JS-->
    <script src="../assets/timepicker/bootstrap-timepicker.min.js" type="text/javascript" ></script>
    <!-- Angular JS -->
    <script src="../assets/itsolution24/angularmin/angular.js" type="text/javascript"></script> 
    <!-- AngularApp JS -->
    <script src="../assets/itsolution24/angular/angularApp.js" type="text/javascript"></script>
    <!-- Filemanager JS -->
    <script src="../assets/itsolution24/angularmin/filemanager.js" type="text/javascript"></script>
    <!-- Angular JS Modal -->
    <script src="../assets/itsolution24/angularmin/modal.js" type="text/javascript"></script>
    <!-- Select2 JS -->
    <script src="../assets/select2/select2.min.js" type="text/javascript"></script>
    <!-- Perfect Scroolbar JS -->
    <script src="../assets/perfectScroll/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!-- Sweet ALert JS -->
    <script src="../assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- Toastr JS -->
    <script src="../assets/toastr/toastr.min.js" type="text/javascript"></script>
    <!-- Accounting JS -->
    <script src="../assets/accounting/accounting.min.js" type="text/javascript"></script>
    <!-- Underscore JS -->
    <script src="../assets/underscore/underscore.min.js" type="text/javascript"></script>
    <!-- Plugins JS -->
    <script src="assets/js/plugins.js"></script>
    <!-- Common JS -->
    <script src="../assets/itsolution24/js/common.js"></script>
    <!-- Main JS -->
    <script src="../assets/itsolution24/js/main.js"></script>
</head>
<body class="<?php echo $body_class; ?>" ng-controller="PosController">
<div class="site-topbar">
    <div class="container-fluid">
        <div class="col-sm-12">
            <ul>
                <li><a href="support.php"><?php echo trans('menu_support');?></a></li>
                <?php if(!is_clogged_in()):?>
                    <li><a href="account_login.php"><?php echo trans('menu_login');?></a></li>
                    <li><a href="account_register.php"><?php echo trans('menu_register');?></a></li>
                <?php else:?>
                    <li><a href="account.php?action=logout"><?php echo trans('menu_logout');?></a></li>
                <?php endif;?>
            </ul>
        </div>   
    </div>
</div>
<div class="wrapper wrapper-2 wrapper-3">
    <header class="header-area header-padding-1 section-padding-1 sticky-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-1 col-lg-1 col-md-6 col-4">
                    <div class="logo">
                        <a href="home.php">
                            <img alt="" src="assets/img/logo/logo.png"> <span class="text-info"><?php echo store('name');?></span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-10 d-none d-lg-block">
                    <div class="main-menu main-menu-center">
                        <nav>
                            <ul>
                                <li class="<?php echo current_nav() == 'shop' ? 'active' : '';?>"><a href="stores.php">Stores</a></li>
                                <li class="<?php echo current_nav() == 'products' && isset($request->get['best_sales']) ? 'active' : '';?>"><a href="products.php?best_sales=yes"> Best Sales <span class="tip">Hot</span></a></li>
                                <li class="<?php echo current_nav() == 'products' && isset($request->get['new_products']) ? 'active' : '';?>"><a href="products.php?new_products=yes"> New Products</a></li>
                                <li class="<?php echo current_nav() == 'products' && !isset($request->get['new_products']) && !isset($request->get['best_sales']) ? 'active' : '';?>"><a href="products.php">All Products</a></li>
                                <li class="<?php echo current_nav() == 'categories' ? 'active' : '';?>"><a href="categories.php">Categories</a></li>
                                <li class="<?php echo current_nav() == 'brands' ? 'active' : '';?>"><a href="brands.php">Brands</a></li>
                                <li class="<?php echo current_nav() == 'cart' ? 'active' : '';?>"><a href="cart.php">Shopping Cart <span ng-show="totalItem" class="tip ng-cloak" style="font-size:18px;">{{ totalItem }}</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-1 col-lg-1 col-md-6 col-9">
                       <div class="header-right-wrap">
                        <?php if(is_clogged_in()):?>
                            <div class="same-style account-satting">
                                <a class="account-satting-active" href="account.php?tab=orders"><i class="negan-icon-users-circle-2"></i></a>
                                <ul>
                                    <li><a href="account.php?tab=orders"><?php echo trans('menu_my_orders');?></a></li>
                                    <li><a href="account.php?tab=profile"><?php echo trans('menu_my_account');?></a></li>
                                    <li><a href="account.php?tab=profile_edit"><?php echo trans('menu_edit_my_account');?></a></li>
                                    <li><a href="account.php?tab=change_password"><?php echo trans('menu_change_password');?></a></li>
                                </ul>
                            </div>
                        <?php endif;?>
                        <!-- <div class="same-style header-wishlist">
                            <a href="wishlist.php"><i class="negan-icon-favourite-28"></i></a>
                        </div> -->
                        <div class="same-style cart-wrap">
                            <a href="#" class="cart-active">
                                <i class="negan-icon-bag"></i>
                                <span ng-show="totalItem" class="count-style ng-cloak">{{ totalItem }}</span>
                            </a>
                        </div>
                        <div class="same-style header-search">
                            <a class="search-active" href="#"><i class="negan-icon-zoom"></i></a>
                        </div>
                        <!-- <div class="same-style mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="negan-icon-menu-left"></i></a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="header-small-mobile sticky-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="logo">
                        <a href="home.php">
                            <img alt="" src="assets/img/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <?php if(is_clogged_in()):?>
                            <div class="same-style account-satting">
                                <a class="account-satting-active" href="account.php?tab=orders" onClick="return false;"><i class="negan-icon-users-circle-2"></i></a>
                                <ul>
                                    <li><a href="account.php?tab=orders"><?php echo trans('menu_my_orders');?></a></li>
                                    <li><a href="account.php?tab=profile"><?php echo trans('menu_my_account');?></a></li>
                                    <li><a href="account.php?tab=profile_edit"><?php echo trans('menu_edit_my_account');?></a></li>
                                    <li><a href="account.php?tab=change_password"><?php echo trans('menu_change_password');?></a></li>
                                </ul>
                            </div>
                        <?php endif;?>
                        <div class="same-style cart-wrap">
                            <a href="#" class="cart-active">
                                <i class="negan-icon-bag"></i>
                                <span class="count-style">{{ totalItem }}</span>
                            </a>
                        </div>
                        <div class="same-style header-search">
                            <a class="search-active" href="#"><i class="negan-icon-zoom"></i></a>
                        </div>
                        <div class="same-style mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="negan-icon-menu-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-off-canvas-active">
        <a class="mobile-aside-close"><i class="negan-icon-simple-close"></i></a>
        <div class="header-mobile-aside-wrap">
            <h4>Menubar</h4>
            <hr>
            <div class="mobile-menu-wrap">
                <div id="mobile-menu" class="slinky-mobile-menu text-left">
                    <ul>
                        <li><a href="stores.php"> <?php echo trans('menu_stores');?> </a></li>
                        <li><a href="products.php?best_sales=yes"> <?php echo trans('menu_best_sales');?> <span class="tip">Hot</span></a></li>
                        <li><a href="products.php?new_products=yes"> <?php echo trans('menu_new_products');?></a></li>
                        <li><a href="products.php"> <?php echo trans('menu_all_products');?> </a></li>
                        <li><a href="categories.php"><?php echo trans('menu_categories');?></a>
                        <li><a href="brands.php"><?php echo trans('menu_brands');?></a>
                        <li><a href="cart.php"> <?php echo trans('menu_shopping_cart');?> <span ng-show="totalItem" class="tip ng-cloak" style="font-size:18px;">{{ totalItem }}</span></a></li>
                        <li><a href="support.php"> <?php echo trans('menu_support');?> </a></li>
                    </ul>
                </div>
            </div>
            <small>&copy; <?php echo store('name');?>, <?php echo date('Y');?></small>
            <!-- <div class="mobile-curr-lang-wrap">
                <div class="single-mobile-curr-lang">
                    <div class="lang-curr-dropdown lang-dropdown-active">
                        <ul>
                            <li><a href="#">English</a></li>
                            <li><a href="#">France</a></li>
                            <li><a href="#">German</a></li>
                        </ul>
                    </div>
                </div>
                <div class="single-mobile-curr-lang">
                    <span>CURRENCY : <a class="mobile-currency-active" href="#">USD</a></span>
                    <div class="lang-curr-dropdown curr-dropdown-active">
                        <ul>
                            <li><a href="#">USD</a></li>
                            <li><a href="#">EUR</a></li>
                            <li><a href="#">USD</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- <div class="mobile-social-wrap">
                <a href="twitter"><i class="fa fa-twitter"></i></a>
                <a href="facebook"><i class="fa fa-facebook"></i></a>
                <a href="instagram"><i class="fa fa-instagram"></i></a>
            </div> -->
        </div>
    </div>
    <!-- search start -->
    <div class="search-content-wrap main-search-active">
        <a class="search-close"><i class="negan-icon-simple-close"></i></a>
        <div class="search-content">
            <p>Search entire store</p>
            <form class="search-form" action="products.php" method="GET">
                <input id="main-search-input" type="text" name="s" placeholder="Type here...">
                <button class="button-search" type="submit"><i class="negan-icon-zoom2"></i></button>
            </form>
        </div>
    </div>
    <!-- mini cart start -->
    <div class="sidebar-cart-active">
        <div class="sidebar-cart-all">
            <a class="cart-close" href="#"><i class="negan-icon-simple-close"></i></a>
            <div class="cart-content">
                <h3 class="text-center"><?php echo trans('title_shopping_cart');?></h3>
                <ul>
                    <li ng-repeat="items in itemArray" class="single-product-cart">
                        <div class="cart-img">
                            <a ng-show="!items.img" href="#"><img style="width:60px;height:70px;" ng-src="assets/img/cart/cart-3.jpg" alt=""></a>
                            <a ng-show="items.img" href="#"><img style="width:60px;height:70px;" ng-src="<?php echo FILEMANAGERURL;?>/{{items.img}}" alt=""></a>
                        </div>
                        <div class="cart-title">
                            <h4><a href="#"> {{ items.name }} </a></h4>
                            <span>{{ items.quantity }} {{ items.unitName }} × {{ items.price }}</span>
                        </div>
                        <div class="cart-delete">
                            <a ng-click="removeItemFromInvoice($index, items.id)" onClick="return false;" href="#">×</a>
                        </div>
                    </li>
                </ul>
                <div ng-show="totalQuantity" class="cart-total">
                    <h4><?php echo trans('text_subtotal:');?> <span><?php echo get_currency_symbol();?>{{ totalAmount | formatDecimal:2 }}</span></h4>
                </div>
                <div ng-hide="totalQuantity" class="cart-total">
                    <h4 class="text-center text-danger"><?php echo trans('text_empty');?></h4>
                </div>
                <div ng-show="totalQuantity" class="cart-checkout-btn">
                    <a class="btn-hover cart-btn-style" href="cart.php"><?php echo trans('text_viee_cart');?></a>
                    <a class="no-mrg btn-hover cart-btn-style" href="checkout.php"><?php echo trans('button_checkout');?></a>
                </div>
                <div class="mt-20 text-center">
                    <a class="text-info" href="products.php">&larr; <?php echo trans('button_continue_shopping');?></a>
                </div>
            </div>
        </div>
    </div>