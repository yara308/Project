<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

// $email_model = registry()->get('loader')->model('email');
// $email_model->send();

$document->setTitle(trans('title_home'));
include('header_home.php');?>

    <div class="banner-area">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <?php $inc = 0;foreach (get_banner_images('default_banner') as $banner):?>
                        <div class="carousel-item <?php echo $inc == 0 ? 'active' : null;?>">
                            <?php if (isset($banner['url']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$banner['url']) && file_exists(FILEMANAGERPATH.$banner['url'])) || (is_file(DIR_STORAGE . 'banners' . $banner['url']) && file_exists(DIR_STORAGE . 'banners' . $banner['url'])))) : ?>
                                <a href="<?php echo $banner['link'] ? $banner['link'] : 'products.php';?>" target="_blink">
                                    <img class="d-block w-100" src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/banners'; ?>/<?php echo $banner['url']; ?>" alt="<?php echo $banner['name'];?>">
                                 </a>
                            <?php endif; ?>
                        </div>
                    <?php $inc++;endforeach;?>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo trans('button_previous');?></span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo trans('button_next');?></span>
                  </a>
                </div>
            </div>
        </div>
    </div>

    <!-- search start -->
    <div class="search-content-wrap main-search-active">
        <a class="search-close"><i class="negan-icon-simple-close"></i></a>
        <div class="search-content">
            <p><?php echo trans('title_search_entire_store');?></p>
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
                            <span>{{ items.quantity }} {{ items.unitName }} × <?php echo get_currency_symbol();?>{{ items.price | formatDecimal:2 }}</span>
                        </div>
                        <div class="cart-delete">
                            <a ng-click="removeItemFromInvoice($index, items.id)" onClick="return false;" href="#">×</a>
                        </div>
                    </li>
                </ul>
                <div ng-show="totalQuantity" class="cart-total">
                    <h4><?php echo trans('title_subtotal');?> <span><?php echo get_currency_symbol();?>{{ totalAmount | formatDecimal:2 }}</span></h4>
                </div>
                <div ng-hide="totalQuantity" class="cart-total">
                    <h4 class="text-center text-danger"><?php echo trans('text_empty');?></h4>
                </div>
                <div ng-show="totalQuantity" class="cart-checkout-btn">
                    <a class="btn-hover cart-btn-style" href="cart.php"><?php echo trans('button_view_cart');?></a>
                    <a class="no-mrg btn-hover cart-btn-style" href="checkout.php"><?php echo trans('button_checkout');?></a>
                </div>
                <div class="mt-20 text-center">
                    <a class="text-info" href="products.php">&larr; <?php echo trans('button_continue_shopping');?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="banner-area pt-20">
        <div class="container">
            <div class="row cat-quicklinks__list ">
                <?php foreach (get_categorys(array('start'=>0, 'limit'=>6)) as $the_category): $color=random_color();?>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-banner-6 mb-30 cat-quicklinks__item">
                        <div class="cat-quicklinks__item-background-container">
                            <div style="border-color:#<?php echo $color;?>" class="cat-quicklinks__item-background"></div>
                            <div style="border-color:#<?php echo $color;?>" class="cat-quicklinks__item-background cat-quicklinks__item-background--middle"></div>
                            <div style="border-color:#<?php echo $color;?>" class="cat-quicklinks__item-background cat-quicklinks__item-background--end"></div>
                        </div>

                        <a href="products.php?category_id=<?php echo $the_category['category_id'];?>"><img alt="" src="assets/img/banner/368x193.jpg">
                        <div class="banner-content-10">
                            <h3><?php echo $the_category['category_name'];?></h3>
                            <span><?php echo limit_char($the_category['category_details'],150);?></span>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div><a href="categories.php"><?php echo trans('button_show_more');?> &raquo;</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="best-seller-area pt-65">
        <div class="container">
            <div class="section-title text-center mb-55 section-title-border">
                <h2><?php echo trans('title_best_sales');?></h2>
                <p><?php echo trans('text_Best Sales Product Listing Below');?></p>
            </div>
            <div class="product-area-wrap">
                <div class="row">
                    <?php foreach (get_best_sales(array('start'=>0,'limit'=>8)) as $the_product) :?>
                    <div id="prod-<?php echo $the_product['p_id'];?>" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="product-wrap mb-45">
                            <div class="prod-inner-loader"">
                                <div class="loader-inner">
                                    <img src="assets/img/loading.gif">
                                </div>
                            </div>
                            <div class="product-img default-overlay item-overlay-1">
                                <a href="product_details.php?product_id=<?php echo $the_product['p_id'];?>">
                                    <?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>
                                      <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $the_product['p_image']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                    <?php else : ?>
                                      <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?>>
                                    <?php endif; ?>
                                </a>
                                <?php $stock = $the_product['quantity_in_stock'];
                                if ($stock > 0) : ?>
                                    <span class="green">Stock: <?php echo currency_format($stock);?> <?php echo get_the_unit($the_product['unit_id'],'unit_name');?></span>
                                <?php else:?>
                                    <span class="red">Out of Stock</span>
                                <?php endif;?>
                                <!-- <div class="product-action">
                                    <div class="pro-same-action pro-wishlist-icon">
                                        <a title="Add To Wishlist" href="wishlist.php"><i class="fa fa-heart-o"></i><i class="heart-hover fa fa-heart"></i></a>
                                    </div>
                                    <div class="pro-same-action pro-switch-icon">
                                        <a title="Add To Compare" href="#"><i class="negan-icon-switch"></i></a>
                                    </div>
                                </div> -->
                                <div class="product-quickview">
                                    <!-- <a title="Quick Shop" href="#" data-toggle="modal" data-target="#exampleModal">Quick Shop</a> -->
                                    <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;" class="addtocart-hm2" title="Add To Cart" href="#">Add to cart</a>
                                </div>
                            </div>
                            <div class="product-content-2">
                                <h3><a href="product_details.php"><?php echo $the_product['p_name'];?></a></h3>
                                <div class="pro-price-rating-wrap">
                                    <div class="pro-price-3">
                                        <span><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="row" style="margin-bottom:40px;">
                    <div class="col-sm-12">
                        <div class="text-center"><a class="btn" href="products.php?best_sales=yes">Show More &raquo;</a></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- <div class="feature-area pb-25 bg-gray-4 pt-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-wrap mb-30 text-center">
                        <i class="nc-icon-glyph shopping_delivery bg-white-icon"></i>
                        <h5 class="magin-incress">Quick Delivery</h5>
                        <p>We are always try to deliver in a short time possible</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-wrap mb-30 text-center">
                        <i class="nc-icon-glyph objects_support-17 bg-white-icon"></i>
                        <h5 class="magin-incress">Expert Support</h5>
                        <p>We have an expert team to support you 24 hours</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-wrap mb-30 text-center">
                        <i class="nc-icon-glyph holidays_gift bg-white-icon"></i>
                        <h5 class="magin-incress">Resonable Discount</h5>
                        <p>We give our customer maximus discount time to time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feature-wrap mb-30 text-center">
                        <i class="nc-icon-glyph tech-2_l-security bg-white-icon"></i>
                        <h5 class="magin-incress">Buyer Protection</h5>
                        <p>Customer security/protection is one of our main feature</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<?php include('footer.php');?>