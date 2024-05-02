<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_categories'));

$product_id = isset($request->get['product_id']) ? $request->get['product_id'] : '';
$product_id = isset($request->get['variant_slug']) ? $request->get['variant_slug'] : '';
$the_product = '';
if ($product_id) {
    $the_product = get_the_product($product_id);
}

$related_products = array();

if (!$the_product) {
    die('The product you are searching for was not found!');
}
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-50 pb-50">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2><?php echo $the_product['p_name'];?></h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li class="active"><?php echo $the_product['p_name'];?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area product-details-area pt-70 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="product-details-tab mr-30">
                        <div class="product-dec-slider product-dec-left">
                            <div class="product-dec-small active">
                                <img src="assets/img/product-details/small-1.jpg" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="assets/img/product-details/small-2.jpg" alt="">
                                <i class="fa-play-circle-o"></i>
                            </div>
                            <div class="product-dec-small">
                                <img src="assets/img/product-details/small-3.jpg" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="assets/img/product-details/small-4.jpg" alt="">
                            </div>
                            <div class="product-dec-small">
                                <img src="assets/img/product-details/small-5.jpg" alt="">
                            </div>
                        </div>
                        <div class="product-dec-right pro-dec-big-img-slider">
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="assets/img/product-details/b-large-1.jpg">
                                        <img src="assets/img/product-details/large-1.jpg" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="assets/img/product-details/b-large-1.jpg"><i class="fa fa-search-plus"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom-popup">
                                    <a href="#">
                                        <img src="assets/img/product-details/large-2.jpg" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up video-popup" href="https://player.vimeo.com/video/65647050"><i class="fa fa-video-camera"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="assets/img/product-details/b-large-3.jpg">
                                        <img src="assets/img/product-details/large-3.jpg" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="assets/img/product-details/b-large-3.jpg"><i class="fa fa-search-plus"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="assets/img/product-details/b-large-4.jpg">
                                        <img src="assets/img/product-details/large-4.jpg" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="assets/img/product-details/b-large-4.jpg"><i class="fa fa-search-plus"></i></a>
                            </div>
                            <div class="easyzoom-style">
                                <div class="easyzoom easyzoom--overlay">
                                    <a href="assets/img/product-details/b-large-5.jpg">
                                        <img src="assets/img/product-details/large-5.jpg" alt="">
                                    </a>
                                </div>
                                <a class="easyzoom-pop-up img-popup" href="assets/img/product-details/b-large-5.jpg"><i class="fa fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="product-details-content quickview-content">
                        <h2><?php echo $the_product['p_name'];?></h2>
                        <div class="pro-stock mt-10">
                            <span><i class="negan-icon-check-circle"></i> <?php echo currency_format($the_product['quantity_in_stock']);?> in stock</span>
                        </div>
                        <div class="product-rating-stock">
                            <div class="product-dec-rating-reviews">
                                <div class="product-dec-rating">
                                    <i class="negan-icon-star"></i>
                                    <i class="negan-icon-star"></i>
                                    <i class="negan-icon-star"></i>
                                    <i class="negan-icon-star"></i>
                                    <i class="negan-icon-star"></i>
                                </div>
                                <div class="product-dec-reviews">
                                    <a> (3 customer reviews)</a>
                                </div>
                            </div>
                        </div>
                        <div class="pro-details-meta clearfix">
                            <span class="text-muted">Brand:&nbsp;</span>
                                <span><?php echo get_the_brand($the_product['brand_id'],'brand_name');?></span> 
                            <span class="text-muted">&nbsp;|&nbsp;Category:&nbsp;</span>
                                <span><?php echo get_the_category($the_product['category_id'],'category_name');?></span>
                        </div>

                        <hr>
                        
                        <div class="product-details-price">
                            <span><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span>
                        </div>
                        <div class="pro-details-sku">
                            <span>SKU: D-12525</span>
                        </div>
                        <p></p>
                        <div class="pro-details-quality">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="" ng-init="quantity=1" ng-model="quantity">
                            </div>
                            <div class="pro-details-cart btn-hover">
                                <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',quantity)" onClick="return false;" href="#">Add To Cart</a>
                            </div>
                            <div class="pro-details-wishlist">
                                <a href="#"><i class="fa fa-heart-o"></i><span>Add To Wilhlist</span></a>
                            </div>
                            <div class="pro-details-compare">
                                <a href="#"><i class="negan-icon-switch"></i> <span>Add To Compare</span></a>
                            </div>
                        </div>
                        <div class="pro-details-meta">
                            <span>Tag:&nbsp;</span>
                            <ul>
                                <li><a href="#">Furniture,</a></li>
                                <li><a href="#">Fashion</a></li>
                            </ul>
                        </div>
                        <div class="pro-details-social">
                            <h5 class="mb-20 mt-20">Share With</h5>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                            <a data-toggle="tab" href="#des-details2">Reviews (3)</a>
                            <a data-toggle="tab" href="#add-a-review">Add a Review</a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane active">
                                <div class="product-description-wrapper pt-20">
                                    <p>Pellentesque orci lectus, bibendum iaculis aliquet id, ullamcorper nec ipsum. In laoreet ligula vitae tristique viverra. Suspendisse augue nunc, laoreet in arcu ut, vulputate malesuada justo. Donec porttitor elit justo, sed lobortis nulla interdum et. Sed lobortis sapien ut augue condimentum, eget ullamcorper nibh lobortis. Cras ut bibendum libero. Quisque in nisl nisl. Mauris vestibulum leo nec pellentesque sollicitudin.</p>
                                    <p>Pellentesque lacus eros, venenatis in iaculis nec, luctus at eros. Phasellus id gravida magna. Maecenas fringilla auctor diam consectetur placerat. Suspendisse non convallis ligula. Aenean sagittis eu erat quis efficitur. Maecenas volutpat erat ac varius bibendum. Ut tincidunt, sem id tristique commodo, nunc diam suscipit lectus, vel</p>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane">
                                <div class="review-wrapper pt-20">
                                    <div class="single-review">
                                        <div class="review-img">
                                            <img src="assets/img/product-details/client-1.jpg" alt="">
                                        </div>
                                        <div class="review-content">
                                            <p style="font-style:normal;">“In convallis nulla et magna congue convallis. Donec eu nunc vel justo maximus posuere. Sed viverra nunc erat, a efficitur nibh”</p>
                                            <div class="review-top-wrap mb-10">
                                                <div class="review-name">
                                                    <h4>Stella McGee</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="negan-icon-star"></i>
                                                    <i class="negan-icon-star"></i>
                                                    <i class="negan-icon-star"></i>
                                                    <i class="negan-icon-star"></i>
                                                    <i class="negan-icon-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="add-a-review" class="tab-pane">
                                <div class="review-wrapper">
                                    <div class="ratting-form-wrapper">
                                        <p>Your email address will not be published. Required fields are marked <span>*</span></p>
                                        <div class="star-box-wrap">
                                            <div class="single-ratting-star">
                                                <i class="negan-icon-star"></i>
                                            </div>
                                            <div class="single-ratting-star">
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                            </div>
                                            <div class="single-ratting-star">
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                            </div>
                                            <div class="single-ratting-star">
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                            </div>
                                            <div class="single-ratting-star">
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                                <i class="negan-icon-star"></i>
                                            </div>
                                        </div>
                                        <div class="ratting-form">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                            <label>Your review <span>*</span></label>
                                                            <textarea name="Your Review"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                           <label>Name <span>*</span></label>
                                                            <input type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                           <label>Email <span>*</span></label>
                                                            <input type="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-submit">
                                                            <input type="submit" value="Submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
    <?php if (!empty($related_products)):?>
    <div class="related-product-wrap pb-45">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h2>Related Products</h2>
                <p>People Who Viewed This Item Also Viewed</p>
            </div>
            <div class="row">
                <?php include('_inc/tempalte/related_products.php');?>
            </div>
        </div>
    </div>
    <?php endif;?>
    
<?php include('footer.php');?>