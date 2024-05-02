<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;

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
$document->setTitle($the_product['p_name']);


//$mego ="https://control.elmattger.com/storage/";
//$document->getiamge(<?php echo  $the_product['p_image'];);
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    // Use $product_id to retrieve product details from your database or source.
} else {
    // Handle the case when no product ID is provided.
    // You can display an error or a default page.
}
if (isset($_GET['p_name'])) {
    $product_name = $_GET['p_name'];

    // Query your database or data structure to find the corresponding product ID based on the product name.
    $product_id = getProductIDByName($product_name);

    if ($product_id !== false) {
        // Use $product_id to retrieve product details from your database or source.
    } else {
        // Handle the case when the product name is not found (e.g., show a 404 page).
    }
} else {
    // Handle the case when no product name is provided (e.g., show a default page).
}
include('header_home.php');?>
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "<?php echo $the_product['p_name'];?>",
  "image": "https://control.elmattger.com/storage/<?php echo $the_product['p_image'];?>",
<?php if ($description = $the_product['description']):?>
  "description": "<?php echo htmlspecialchars_decode($description);?>",
 <?php endif;?>
  "offers": {
    "@type": "Offer",
    "priceCurrency": "KWD",
    "price": "<?php echo currency_format($the_product['sell_price']);?>",
    "availability": "http://schema.org/InStock",
    "itemCondition": "http://schema.org/NewCondition"
  },
 "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.5",  // Replace with your actual rating
    "reviewCount": "50"    // Replace with your actual review count
  },
  "brand": {
    "@type": "Brand",
<?php if ($brand = get_the_brand($the_product['brand_id'],'brand_name')):?>
    "name": "<?php echo $brand;?>"  // Replace with your brand's name
<?php endif;?>
  }
}
</script>
  <div class="page-content-wrapper">
      <div class="product-slide-wrapper">
        <!-- Product Slides-->
        <div class="product-slides owl-carousel">
        

<div class="single-product-slide" ><img src="https://control.elmattger.com/storage/<?php echo $the_product['p_image'];?>" alt="<?php echo $the_product['p_name'];?>">
</div>


        </div>
        <!-- Video Button--><a class="video-btn shadow-sm" id="singleProductVideoBtn" href="https://www.youtube.com/watch?v=4MOZLVf1UTM"><i class="fa-solid fa-play"></i></a>
      </div>
      <div class="product-description pb-3">
        <!-- Product Title & Meta Data-->
        <div class="product-title-meta-data bg-white mb-3 py-3">
          <div class="container d-flex justify-content-between rtl-flex-d-row-r">
            <div class="p-title-price">
              <h5 class="mb-1"><?php echo $the_product['p_name'];?></h5>
              <p class="sale-price mb-0 lh-1"><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></p>
            </div>

            <div class="p-wishlist-share"><a href="#"><i class="fa-solid fa-heart"></i></a></div>
          </div>

          <!-- Ratings-->
   <div class="product-ratings">
            <div class="container d-flex align-items-center justify-content-between rtl-flex-d-row-r">
               <div class="total-result-of-ratings">
                            <?php if ($brand = get_the_brand($the_product['brand_id'],'brand_name')):?>
                            <span>Brand:&nbsp;</span>
                                <span><?php echo $brand;?>&nbsp;|&nbsp;</span> 
                            <?php endif;?>

                            
            </div>
          </div>
        </div>
<!-- Ratings-->
   <div class="product-ratings">
            <div class="container d-flex align-items-center justify-content-between rtl-flex-d-row-r">
               <div class="total-result-of-ratings">
                           <?php if ($category = get_the_category($the_product['category_id'],'category_name')):?>
                                <span class="total-result-of-ratings">Category:&nbsp;</span>
                                <span><?php echo $category;?></span>
                            <?php endif;?>

                            
            </div>
          </div>
        </div>
          <div class="product-ratings">
            <div class="container d-flex align-items-center justify-content-between rtl-flex-d-row-r">
              <div class="ratings"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span class="ps-1">3 ratings</span></div>
              <div class="total-result-of-ratings"><span>5.0</span><span>Very Good                                </span></div>
            </div>
          </div>
        </div>
        <!-- Flash Sale Panel-->
        <div class="flash-sale-panel bg-white mb-3 py-3">
          <div class="container">
            <!-- Sales Offer Content-->
            <div class="sales-offer-content d-flex align-items-end justify-content-between">
              <!-- Sales End-->
              <div class="sales-end">
                <p class="mb-1 font-weight-bold"><i class="fa-solid fa-bolt-lightning lni-flashing-effect text-danger"></i> Flash sale end in</p>
                <!-- Please use event time this format: YYYY/MM/DD hh:mm:ss-->
                <ul class="sales-end-timer ps-0 d-flex align-items-center" data-countdown="2024/01/01 14:21:37">
                  <li><span class="days">0</span>d</li>
                  <li><span class="hours">0</span>h</li>
                  <li><span class="minutes">0</span>m</li>
                  <li><span class="seconds">0</span>s</li>
                </ul>
              </div>
              <!-- Sales Volume-->
              <div class="sales-volume text-end">
                <p class="mb-1 font-weight-bold">22% Sold Out</p>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Selection Panel-->
 <!-- Flash Sale Panel-->
        <div class="flash-sale-panel bg-white mb-3 py-3">
          <div class="container">
            <!-- Sales Offer Content-->
            <div class="sales-offer-content d-flex align-items-end justify-content-between">
              <!-- Sales End-->
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
          </div>
        </div>
        <!-- Add To Cart-->
        <div class="cart-form-wrapper bg-white mb-3 py-3">
          <div class="container">
            <form class="cart-form" action="#" method="">
              <div class="order-plus-minus d-flex align-items-center">
                        <div class="quantity-button-handler" ng-click="DecreaseItemFromInvoice('<?php echo $the_product['p_id'];?>',1)" class="dec qtybutton" style="font-size:30px;">-</div>
                                    <input class="form-control cart-quantity-input" class="cart-plus-minus-box" type="text" name="qtybutton" value="" ng-init="quantity=1" ng-model="quantity" style="width:180px;">
                                <div class="quantity-button-handler" ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" style="font-size:30px;" class="inc qtybutton">+</div>

                
              </div>
<div class="btn btn-danger ms-3" class="pro-details-cart btn-hover">
                                <a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',quantity)" onClick="return false;" href="#" style="width: 250px;text-align:center;">شراء</a>
                            </div>
              
            </form>
          </div>
        </div>
<?php if ($description = $the_product['description']):?>
        <!-- Product Specification-->
        <div class="p-specification bg-white mb-3 py-3">
          <div class="container">
          <p><?php echo htmlspecialchars_decode($description);?></p>
            
          </div>
        </div>
    <?php endif;?>
        <!-- Product Video -->
        <div class="bg-img" style="background-image: url(img/product/119.jpg)">
          <div class="container">
            <div class="video-cta-content d-flex align-items-center justify-content-center">
              <div class="video-text text-center">
                <h2 style="background-color:rgb(255, 99, 71);" class="mb-3">اتفرج واعرف  </h2><a class="btn btn-info rounded-circle" id="videoButton" href="https://www.youtube.com/watch?v=4MOZLVf1UTM"><i class="fa-solid fa-play"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="pb-3"></div>
        <!-- Related Products Slides-->
        <div class="related-product-wrapper bg-white py-3 mb-3">
          <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
              <h6>منتجات اخري</h6><a class="btn p-0" href="#">View All</a>
            </div>
            <div class="related-product-slide owl-carousel">
              <div class="card product-card bg-gray shadow-none">
                
<div class="card-body">
                  <!-- Badge--><span class="badge rounded-pill badge-warning">Sale</span>
                  <!-- Wishlist Button--><a class="wishlist-btn" href="#"><i class="fa-solid fa-heart">                       </i></a>
                  <!-- Thumbnail --><a class="product-thumbnail d-block" href="#">
                               <img class="mb-2" src="#" alt="<?php echo $the_product['p_name'];?>">
                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                    </a>
                  <!-- Product Title --><a class="product-title" href="#">Beach Cap</a>
                  <!-- Product Price -->
                  <p class="sale-price">$13<span>$42</span></p>
                  <!-- Rating -->
                  <div class="product-rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                  <!-- Add to Cart --><a class="btn btn-success btn-sm" href="#"><i class="fa-solid fa-plus"></i></a>
                </div>

              </div>
     
      
      
             
          
            </div>
          </div>
        </div>
        <!-- Rating & Review Wrapper -->
   
        <!-- Ratings Submit Form-->

      </div>
    </div>
    
  
<?php include('footer.php');?>