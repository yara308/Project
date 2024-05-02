<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$is_new_products = isset($request->get['new_products']) && $request->get['new_products'] == 'yes';
$is_bast_sales = isset($request->get['best_sales']) && $request->get['best_sales'] == 'yes';

if (isset($request->get['page'])) {
    $page = $request->get['page'];
} else {
    $page = 1;
}
if (isset($request->get['limit'])) {
    $limit = (int)$request->get['limit'];
} else {
    $limit = 50;
}
$start = ($page - 1) * $limit;
$products = array();
$filters = array('filter_p_type' => 'standard','filter_quantity' => 1);
// $filters = array();
$search_key = isset($request->get['s']) ? $request->get['s'] : '';
if ($search_key) {
    $filters['filter_search_key'] = $search_key;
}
$category_id = isset($request->get['category_id']) ? $request->get['category_id'] : '';
if ($category_id) {
    $the_category = get_the_category($category_id);
    $filters['filter_category_id'] = $category_id;
}
$brand_id = isset($request->get['brand_id']) ? $request->get['brand_id'] : '';
if ($brand_id) {
    $the_brand = get_the_brand($brand_id);
    $filters['filter_brand_id'] = $brand_id;
}
$gender = isset($request->get['gender']) ? $request->get['gender'] : '';
if ($gender) {
    $the_brand = get_the_brand($gender);
    $filters['filter_gender'] = $gender;
}
if (empty($filters)) {
    $filters['start'] = $start;
    $filters['limit'] = $limit;
}
$total = count(get_products($filters));
// dd($filters);
$filters['start'] = $start;
$filters['limit'] = $limit;
if ($is_new_products) {
    $products = get_new_products(array('start'=>0,'limit'=>50));
} else if ($is_bast_sales) {
    $products = get_best_sales(array('start'=>0,'limit'=>50));
} else if (!empty($filters)) {
    $products = get_products($filters);
}
$pagination = new Pagination();
$pagination->total = $total;
$pagination->page = $page;
$pagination->limit = $limit;
$pagination->url = root_url().'/shop/products.php?category_id='.$category_id.'&page={page}';
$pagination = $pagination->render();

$document->setTitle(trans('title_products'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>
                    <div>
                        <?php if ($is_new_products):?>
                            New
                        <?php elseif($is_bast_sales):?>
                            Best Sales
                        <?php endif;?>
                         Products
                    <?php if ($category_id):?>
                        in <?php echo $the_category['category_name'];?></div>
                        <h4 class="description mt-10">
                            <?php echo $the_category['category_details'];?>
                        </h4>
                    <?php endif;?>
                    <?php if ($brand_id):?>
                        in <?php echo $the_brand['brand_name'];?>
                        <h4 class="description mt-10">
                            <?php echo $the_brand['brand_details'];?>
                        </h4>
                    <?php endif;?>
                </h2>
                <ul>
                    <li>
                        <a href="categories.php"><?php echo trans('text_home');?></a>
                    </li>
                    <li><a href="products.php"><?php echo trans('text_products');?></a></li>
                    <?php if ($category_id) :?>
                        <li class="active"><?php echo $the_category['category_name'];?></li>
                    <?php endif;?>
                    <?php if ($brand_id) :?>
                        <li class="active"><?php echo $the_brand['brand_name'];?></li>
                    <?php endif;?>
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area shop-page-area pt-40 pb-40">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-10">
                    <div class="shop-top-bar shop-top-bar-flex mb-40">
                        <div class="shop-topbar-left">
                            <p><?php echo trans('text_showing');?> <?php 
                            $to = $page*$limit > $total ? $total : $page*$limit;
                            echo $start;?>–<?php echo $to;?> of <?php echo $total;?> <?php echo trans('text_products');?></p>
                            <!-- <div class="page-show">
                                <span>Show</span>
                                <ul>
                                    <li><a class="active" href="#">12</a></li>
                                    <li><a href="#">15</a></li>
                                    <li><a href="#">30</a></li>
                                </ul>
                            </div> -->
                        </div>
                        <div class="shop-topbar-right shop-tab-flex">
                            <div class="shop-tab nav">
                                <a class="active" href="#shop-1" data-toggle="tab">
                                    <i class="fa fa-table"></i>
                                </a>
                                <a href="#shop-2" data-toggle="tab">
                                    <i class="fa fa-list-ul"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="product-area-wrap">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">
                                <div class="row">
                                    <?php if (empty($products)):?>
                                        <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 ">
                                            <div class="card mb-20">
                                                <div class="card-body">
                                                    <div class="card-header">
                                                        <h4 class="card-title text-danger text-center"><?php echo trans('text_product_item_not_found');?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <?php foreach($products as $the_product) :
                                            $the_product_price = get_the_product_price($the_product['p_id'], store_id());
                                            ?>
                                        <div id="prod-<?php echo $the_product['p_id'];?>" class="col-6 col-xl-3 col-lg-4 col-sm-6 col-md-6 ">
                                            <div class="product-wrap mb-40">
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
                                                        <span class="green"><?php echo trans('text_stock');?>: <?php echo currency_format($stock);?> <?php echo get_the_unit($the_product['unit_id'],'unit_name');?></span>
                                                    <?php else:?>
                                                        <span class="red"><?php echo trans('text_out_of_stock');?></span>
                                                     <?php endif;?>
                                                    <div class="product-action">
                                                        <!-- <div class="pro-same-action pro-wishlist-icon">
                                                            <a title="Add To Wishlist" href="wishlist.html"><i class="fa fa-heart-o"></i><i class="heart-hover fa fa-heart"></i></a>
                                                        </div> -->
                                                        <!-- <div class="pro-same-action pro-switch-icon">
                                                            <a title="Add To Compare" href="#"><i class="negan-icon-switch"></i></a>
                                                        </div> -->
                                                    </div>
                                                    <!-- <div class="product-quickview">
                                                        <a title="Quick View" href="#" data-toggle="modal" data-target="#exampleModal">Quick View</a>
                                                    </div> -->
                                                    <div class="product-quickview">
                                                        <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;" title="<?php echo trans('text_add_to_cart');?>" href="#"><?php echo trans('text_add_to_cart');?></a>
                                                    </div>
                                                </div>
                                                <div class="product-content text-center">
                                                    <h3><a href="product_details.php?product_id=<?php echo $the_product['p_id'];?>"><?php echo $the_product['p_name'];?></a></h3>
                                                    <div class="product-price product-price-3">
                                                        <!-- <span class="old"><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span>
                                                        <span><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span> -->

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

                                                    </div>
                                                    <!-- <div class="product-cart">
                                                        <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;" title="Add To Cart" href="#">Add to cart</a>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div id="shop-2" class="tab-pane">
                                <?php if (empty($products)):?>
                                    <div class="shop-list-wrap">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 ">
                                                <div class="card mb-20">
                                                    <div class="card-body">
                                                        <div class="card-header">
                                                            <h4 class="card-title text-danger text-center"><?php echo trans('text_prodouct_item_was_not_found');?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                <?php else:?>
                                    <?php foreach($products as $the_product) :?>
                                    <div id="prod-<?php echo $the_product['p_id'];?>" class="shop-list-wrap mb-70">
                                        <div class="prod-inner-loader"">
                                            <div class="loader-inner">
                                                <img src="assets/img/loading.gif">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-lg-4 col-md-4 col-sm-5">
                                                <div class="product-img-list">
                                                    <a href="product_details.php?product_id=<?php echo $the_product['p_id'];?>">
                                                        <?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>
                                                          <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $the_product['p_image']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                                        <?php else : ?>
                                                          <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?>>
                                                        <?php endif; ?>
                                                    </a>
                                                    <!-- <div class="product-quickview-list">
                                                        <a title="Quick View" href="#" data-toggle="modal" data-target="#exampleModal">Quick View</a>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-7">
                                                <div class="shop-list-content">
                                                    <div class="product-details-content quickview-content">
                                                        <h2><a href="product_details.php?product_id=<?php echo $the_product['p_id'];?>"><?php echo $the_product['p_name'];?></a></h2>
                                                        <div>
                                                            <?php if ($stock > 0) : ?>
                                                                <span class="green">Stock: <?php echo currency_format($stock);?> <?php echo get_the_unit($the_product['unit_id'],'unit_name');?></span>
                                                            <?php else:?>
                                                                <span class="red">Out of Stock</span>
                                                            <?php endif;?>
                                                        </div>
                                                        <div class="product-details-price">
                                                            <span><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></span>
                                                        </div>
                                                        <p><?php echo html_entity_decode($the_product['description']);?></p>
                                                        <div class="pro-details-quality">
                                                            <div class="pro-details-cart btn-hover">
                                                                <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;" href="#">Add To Cart</a>
                                                            </div>
                                                            <!-- <div class="pro-details-wishlist">
                                                                <a  href="#"><i class="fa fa-heart-o"></i><span>Add To Wilhlist</span></a>
                                                            </div> -->
                                                            <!-- <div class="pro-details-compare">
                                                                <a href="#"><i class="negan-icon-switch"></i> <span>Add To Compare</span></a>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="pro-pagination-style text-center">
                            <?php echo $pagination;?>
                            <!-- <ul>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a class="next" href="#">Next</a></li>
                            </ul> -->
                        </div>
                    </div>
                </div>
                <!-- End Content Column-->

                <div class="col-lg-2">
                    <div class="shop-sidebar">
                        <div class="sidebar-widget sidebar-border pb-45">
                            <h4 class="pro-sidebar-title">Categories </h4>
                            <div class="sidebar-widget-list mt-30">
                               <ul>
                                <?php foreach (get_categorys(array('start' => 0, 'limit' => 7)) as $the_category) :?>
                                   <li><a href="products.php?category_id=<?php echo $the_category['category_id'];?>"><?php echo $the_category['category_name'];?></a></li>
                                <?php endforeach;?>
                                    <li>
                                        <a class="text-muted" href="<?php echo root_url();?>/shop/categories.php"><small><span class="fa fa-angle-right"></span><?php echo trans('text_all_catgories');?></small></a>
                                    </li>
                               </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-40 pb-40">
                            <h4 class="pro-sidebar-title">Genders </h4>
                            <div class="sidebar-widget-list mt-30">
                               <ul>
                                    <?php foreach (get_gender_types() as $key => $gender) : ?>
                                      <li><a href="products.php?gender=<?php echo $key; ?>"><?php echo $gender; ?></a></li>
                                    <?php endforeach; ?>
                               </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-40 pb-40">
                            <h4 class="pro-sidebar-title">Brands </h4>
                            <div class="sidebar-widget-list mt-30">
                               <ul>
                                   <?php foreach (get_brands(array('start' => 0, 'limit' => 7)) as $the_brand) :?>
                                       <li><a href="products.php?brand_id=<?php echo $the_brand['brand_id'];?>"><?php echo $the_brand['brand_name'];?></a></li>
                                    <?php endforeach;?>
                                    <li>
                                        <a class="text-muted" href="<?php echo root_url();?>/shop/brands.php"><small><span class="fa fa-angle-right"></span><?php echo trans('text_all_brands');?></small></a>
                                    </li>
                               </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sidebar Column-->

            </div>    
        </div>
    </div>

<?php include('footer.php');?>