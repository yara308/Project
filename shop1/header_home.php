<?php //die('delete...everything***********');

error_reporting(-1);
ini_set('display_errors', 0);

if (isset($request->get['store_id']) && $request->get['store_id']) {
    $store->openTheStore($request->get['store_id']);
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
    <link type="text/css" href="<?php echo store('apilink'); ?>/assets/timepicker/bootstrap-timepicker.min.css" type="text/css">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/icons.min.css">
    <!-- Toastr CSS -->
    <link href="<?php echo store('apilink'); ?>/assets/toastr/toastr.min.css" type="text/css" rel="stylesheet">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">
    <!-- Revolution Slider CSS -->
    <link href="assets/revolution/css/settings.css" rel="stylesheet">
    <link href="assets/revolution/css/navigation.css" rel="stylesheet">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <style type="text/css">
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
        p {
            color: #000;
            font-size: 14px!important;
            font-family: arial, "sans-serif";
        }
        .header-area .header-right-wrap .same-style.account-satting ul {
            right: -50%;
            left: auto!important;
        }
        .home-sidebar-left-2 p {
            font-family: cursive;
            font-style: normal;
        }
        @media only screen and (max-width: 1600px) and (min-width: 1366px) {
            .sidebar-menu > nav > ul > li {
                margin-bottom: 3px;
                border-bottom: 1px solid #ddd;
            }
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
        .single-banner-6 {
            border: none;
        }
        .single-banner-6 .banner-content-10 span {
            font-size: 14px;
            color: #000;
            font-family: arial; 
            font-style: normal; 
        }
        .single-banner-6 .banner-content-10 {
            z-index: 11;
        }
        .single-banner-6 .banner-content-10 h3 {
            font-size: 24px;
        }
        .single-banner-6 .banner-content-10 h3,
        .single-banner-6 .banner-content-10 span {
            color: #fff;
        }
        .product-wrap {
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
        .footer-bottom {
            text-align: center;
            background: #e9ecef;
            padding: 3px;
        }
        .footer-widget .footer-list ul li {
            margin-bottom: 5px;
        }
        .cat-quicklinks__item-background {
            width: 37.3rem;
            height: 38rem;
            border-radius: 50%;
            background-color: #1b1f61;
            transform: rotate(93deg);
            box-shadow: 3px -7px 28px 0 rgba(38,38,38,.4);
            position: absolute;
            left: -20.6rem;
            bottom: -22.5rem;
            border: 134px solid #f50;
            z-index: 30;
            transition: transform .25s ease;
        }
        .cat-quicklinks__item-background-container {
            width: 100%;
            height: 100%;
            display: block;
            overflow: hidden;
            border-radius: 10px;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
        }
        /*.cat-quicklinks__item .cat-quicklinks__item-background {
            border-color: #<?php echo random_color();?>;
        }*/
        .cat-quicklinks__item-background--middle {
            z-index: 20;
            bottom: -21.1rem;
            left: -13.6rem;
            background-color: transparent;
        }
        .cat-quicklinks__item-background--end {
            z-index: 10;
            bottom: 3.2rem;
            left: 10.2rem;
            width: 49.5rem;
            background-color: transparent;
        }
        .product-wrap .product-img > span {
            top: 10px;
            left: 10px;
            padding: 3px 5px;
        }
        .product-wrap .product-img > span.red {
            background-color: red;
        }
        @media only screen and (max-width: 767px) {
            .header-small-mobile {
                background-image: linear-gradient(270deg,#b8baf6,#fea8e8);
            }
            .description-review-wrapper .description-review-topbar a {
                width: 100%;
                border-bottom: 2px solid #ddd;
            }
            .site-topbar ul {
                text-align: center;
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
    </script>

    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Popper JS -->
    <script src="assets/js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Bootstrap Timepicker JS-->
    <script src="<?php echo store('apilink'); ?>/assets/timepicker/bootstrap-timepicker.min.js" type="text/javascript" ></script>
    <!-- Angular JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angularmin/angular.js" type="text/javascript"></script> 
    <!-- AngularApp JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angular/angularApp.js" type="text/javascript"></script>
    <!-- Filemanager JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angularmin/filemanager.js" type="text/javascript"></script>
    <!-- Angular JS Modal -->
    <script src="../assets/itsolution24/angularmin/modal.js" type="text/javascript"></script>
    <!-- Select2 JS -->
    <script src="<?php echo store('apilink'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
    <!-- Perfect Scroolbar JS -->
    <script src="<?php echo store('apilink'); ?>/assets/perfectScroll/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!-- Sweet ALert JS -->
    <script src="<?php echo store('apilink'); ?>/assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- Toastr JS -->
    <script src="<?php echo store('apilink'); ?>/assets/toastr/toastr.min.js" type="text/javascript"></script>
    <!-- Accounting JS -->
    <script src="<?php echo store('apilink'); ?>/assets/accounting/accounting.min.js" type="text/javascript"></script>
    <!-- Underscore JS -->
    <script src="<?php echo store('apilink'); ?>/assets/underscore/underscore.min.js" type="text/javascript"></script>
    <!-- Plugins JS -->
    <script src="assets/js/plugins.js"></script>
    <!-- Common JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/js/common.js"></script>
    <!-- Main JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/js/main.js"></script>
</head>
<body class="<?php echo $body_class; ?>" ng-controller="PosController">
<div class="home-sidebar-left-2 xbg-black-2 xsidebar-left-white">
    <div class="logo text-center">
        <a href="home.php">
            <img alt="" src="assets/img/logo/logo-3.png">
        </a>
    </div>
    <h4 class="text-center text-info mt-10"><strong><?php echo store('name');?></strong></h4>
    <p><?php echo trans('shop_slogan');?></p>
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
    </div>
    <div class="sidebar-menu">
        <nav>
            <ul>
                <li><a href="stores.php"> <?php echo trans('menu_stores');?> </a></li>
                <li><a href="products.php?best_sales=yes"> <?php echo trans('menu_best_sales');?> <span class="tip">Hot</span></a></li>
                <li><a href="products.php?new_products=yes"> <?php echo trans('menu_new_products');?></a></li>
                <li><a href="products.php"> <?php echo trans('menu_all_products');?> </a></li>
                <li><a href="categories.php"><?php echo trans('menu_categories');?></a>
                    <div class="dropdown-menu-style dropdown-width-2">
                        <ul>
                            <li>
                                <ul>
                                    <?php foreach (get_categorys() as $the_category) :?>
                                    <li><a href="products.php?category_id=<?php echo $the_category['category_id'];?>"><?php echo $the_category['category_name'];?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href="brands.php"><?php echo trans('menu_brands');?></a>
                    <div class="dropdown-menu-style dropdown-width-2">
                        <ul>
                            <li>
                                <ul>
                                    <?php foreach (get_brands() as $the_brand) :?>
                                    <li><a href="products.php?brand_id=<?php echo $the_brand['brand_id'];?>"><?php echo $the_brand['brand_name'];?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href="cart.php"> <?php echo trans('menu_shopping_cart');?> <span ng-show="totalItem" class="tip ng-cloak" style="font-size:18px;">{{ totalItem }}</span></a></li>
                <li><a href="support.php"> <?php echo trans('menu_support');?> </a></li>
            </ul>
        </nav>
        <!-- <div class="hot-products" style="padding:20px;">
            <a href="products.php?best_sales=yes"><img src="assets/img/hot-product.jpg" style="width:100%;"></a>
        </div> -->
    </div>
</div>

<div class="wrapper-3">
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
       <div class="mobile-curr-lang-wrap">
            <div class="single-mobile-curr-lang">
                <div class="lang-curr-dropdown lang-dropdown-active">
                    <ul>
                        <li><a href="#">English</a></li>
                        <li><a href="#">Bangla</a></li>
                    </ul>
                </div>
            </div>
            <div class="single-mobile-curr-lang">
                <span>CURRENCY : <a class="mobile-currency-active" href="#">USD</a></span>
                <div class="lang-curr-dropdown curr-dropdown-active">
                    <ul>
                        <li><a href="#">USD</a></li>
                        <li><a href="#">TK</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile-social-wrap">
            <a href="twitter"><i class="fa fa-twitter"></i></a>
            <a href="facebook"><i class="fa fa-facebook"></i></a>
            <a href="instagram"><i class="fa fa-instagram"></i></a>
        </div> 
    </div>
</div>

<div class="home-sidebar-right-2">
<div class="wrapper wrapper-2">
    <div class="site-topbar">
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
    <header class="header-area header-padding-1 section-padding-1">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-4">
                    <h4><?php echo trans('text_contact:');?> <b><?php echo store('mobile');?></b></h4>
                    <!-- <div class="logo">
                        <a href="home.php">
                            <img alt="" src="assets/img/logo/logo-3.png">
                        </a>
                    </div> -->
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-8">
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
                    </div>
                </div>
            </div>
        </div>
    </header>