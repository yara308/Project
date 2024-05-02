<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
$document->setTitle(trans('title_categories'));
$address = isset($session->data['address']) ? json_decode($session->data['address'], true) : array();
$product_id = isset($request->get['product_id']) ? $request->get['product_id'] : '';
$the_product = '';
if ($product_id) {
    $the_product = get_the_product($product_id);
}
$related_products = array();
if (!$the_product) {
    die('The product you are searching for was not found!');
}
$promotional_price = get_product_promotional_prices($the_product['p_id']);
$variant_slug = isset($request->get['variant_slug']) ? $request->get['variant_slug'] : '';
$variants = get_product_variants($the_product['p_id']);
$the_product_price = get_the_product_price($product_id, store_id(), $variant_slug);
$the_product_stock = get_the_product_stock($product_id, store_id(), $variant_slug);
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
                            <?php $images = get_product_images($the_product['p_id']); ?>
                            <?php if (count($images)):?>
                                <?php $inc=0;foreach ($images as $image): ?>
                                    <?php if (isset($image['url']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$image['url']) && file_exists(FILEMANAGERPATH.$image['url'])) || (is_file(DIR_STORAGE . 'products' . $image['url']) && file_exists(DIR_STORAGE . 'products' . $image['url'])))) : ?>
                                        <div class="product-dec-small">
                                            <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $image['url']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                        </div>
                                    <?php else : ?>
                                        <div class="product-dec-small">
                                            <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg">
                                        </div>
                                    <?php endif; ?>
                                <?php $inc++;endforeach ?>
                            <?php else : ?>
                                <div class="product-dec-small">
                                    <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-dec-right pro-dec-big-img-slider">
                            <?php if (count($images)):?>
                                <?php foreach ($images as $image): ?>
                                    <div class="easyzoom-style">
                                        <?php if (isset($image['url']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$image['url']) && file_exists(FILEMANAGERPATH.$image['url'])) || (is_file(DIR_STORAGE . 'products' . $image['url']) && file_exists(DIR_STORAGE . 'products' . $image['url'])))) : ?>
                                            <div class="easyzoom easyzoom--overlay">
                                                <a href="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $image['url']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                                    <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $image['url']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                                </a>
                                                <a class="easyzoom-pop-up img-popup" href="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $image['url']; ?>"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        <?php else:?>
                                            <div class="easyzoom-style">
                                                <div class="easyzoom easyzoom--overlay">
                                                    <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg">
                                                </div>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                <?php endforeach ?>
                            <?php else:?>
                                <div class="easyzoom-style">
                                    <div class="easyzoom easyzoom--overlay">
                                        <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg">
                                    </div>
                                </div>
                            <?php endif;?>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="product-details-content quickview-content">
                        <h2><?php echo $the_product['p_name'];?></h2>
                        <div class="pro-stock mt-10">
                            <?php if ($the_product['quantity_in_stock'] > 0 ):?>
                                <span><i class="negan-icon-check-circle"></i> <?php echo $the_product_stock;?> in stock</span>
                            <?php else:?>
                                <span class="text-danger">Out of stock</span>
                            <?php endif;?>
                        </div>
                        <div class="pro-details-meta clearfix">
                            <?php if ($brand = get_the_brand($the_product['brand_id'],'brand_name')):?>
                            <span class="text-muted">Brand:&nbsp;</span>
                                <span><?php echo $brand;?>&nbsp;|&nbsp;</span> 
                            <?php endif;?>
                            <?php if ($category = get_the_category($the_product['category_id'],'category_name')):?>
                                <span class="text-muted">Category:&nbsp;</span>
                                <span><?php echo $category;?></span>
                            <?php endif;?>
                        </div>
                        <hr>
                        <div class="product-details-price">
                            <div id="product-price-<?php echo $the_product['p_id'];?>" $class="product-price">
                                <span class="text-secondary"><?php echo trans('text_price');?>:</span>
                                <?php 
                                if (isset($promotional_price[0]) && !$variant_slug):?>
                                    <del><span class="text-warning"><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span></del>
                                    &nbsp;<span class="text-success"><?php echo get_currency_symbol().currency_format($the_product_price);?></span>
                                <?php else:?>
                                    <span class="text-warning"><?php echo get_currency_symbol().currency_format($the_product_price);?></span>
                                <?php endif;?>
                            </div>
                            <?php if ($variants):?>
                            <p>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h4 class="text-secondary"><?php echo trans('title_choose_variant');?></h4>
                                        <select id="product-variant-<?php echo $the_product['p_id'];?>" class="form-control product-variant">
                                            <?php foreach ($variants as $variant): if ($variant['quantity'] <= 0) continue;?> 
                                                <option value="<?php echo $variant['variant_slug'];?>"<?php echo $variant_slug == $variant['variant_slug'] ? ' selected' : null;?>>
                                                    <?php echo $variant['variant_name'];?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </p>
                            <?php endif;?>
                        </div>
                        <div class="pro-details-quality"> 
                            <span cass="text-secondary"><?php echo trans('text_quantity');?>:</span> &nbsp;
                            <div class="cart-plus-minus" style="width:180px;">
                                <div ng-click="DecreaseItemFromInvoice('<?php echo $the_product['p_id'];?>',1)" class="dec qtybutton" style="font-size:30px;">-</div>
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="" ng-init="quantity=1" ng-model="quantity" style="width:180px;">
                                <div ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" style="font-size:30px;" class="inc qtybutton">+</div>
                            </div>
                        </div>
                        <div class="pro-details-quality">
                            <div class="pro-details-cart btn-hover">
                                <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',quantity)" onClick="return false;" href="#" style="width: 250px;text-align:center;">Add To Cart</a>
                            </div>
                            <!-- <div class="pro-details-wishlist">
                                <a href="#"><i class="fa fa-heart-o"></i><span>Add To Wilhlist</span></a>
                            </div> -->
                        </div>
                        <div class="clearfix">
                            <div class="card xbg-light">
                                <div class="card-body pb-0">
                                    <?php if (!empty($address)):?>
                                        <div class="xcustomer-zone mb-20">
                                            <div style="font-size:16px;" class="cart-page-title">
                                                <div class="text-info" style="font-size:18px;margin-bottom:20px;"><b>Shipping and Biling Address :</b></div>
                                                Full name: <b><?php echo $address['full_name'];?></b> <br>
                                                Phone number: <b><?php echo $address['phone_number'];?></b> <br>
                                                Address: <b><?php echo $address['address'];?></b>

                                                <br>
                                                <a class="text-info" href="checkout.php">Change Address</a>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="customer-zone mb-20">
                                            <p style="font-size:16px;" class="cart-page-title"><a class="text-success" href="payment_cashier.php">Set Delivery Options &rarr;</a></p>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($description = $the_product['description']):?>
    <div class="description-review-area pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane active">
                                <div class="product-description-wrapper pt-20">
                                    <p><?php echo htmlspecialchars_decode($description);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if (!empty($related_products)):?>
    <div class="related-product-wrap pb-45">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h2><?php echo trans('title_related_products');?></h2>
                <p><?php echo trans('text_People Who Viewed This Item Also Viewed');?></p>
            </div>
            <div class="row">
                <?php include('_inc/tempalte/related_products.php');?>
            </div>
        </div>
    </div>
    <?php endif;?>
<?php include('footer.php');?>