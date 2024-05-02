<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
//$store = get_stores(true);
// $email_model = registry()->get('loader')->model('email');
// $email_model->send();
//$storess = store('store_id');

// Get the store ID from the query string
//$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : null;

// Now, you can use the $store_id variable in your PHP code as needed.

$document->setTitle(trans('title_home'));
include('header_home.php');
$storess = store('store_id');
?>
<!-- Hero Wrapper -->
<div class="hero-wrapper">
        <div class="container">
          <div class="pt-3">
            <!-- Hero Slides-->
      <div class="hero-slides owl-carousel">
              <!-- Single Hero Slide-->      
   

   <?php $inc = 0;foreach (get_banner_images($storess) as $banner):?>





		<div class='single-hero-slide' style='background-image: url(<?php echo $banner['url'];?>)'>
        <div class='slide-content h-100 d-flex align-items-center'>
				 <div class='slide-text'>
					<h4 class='text-white mb-0' data-animation='fadeInUp' data-delay='100ms' data-duration='1000ms'></h4>
				<p class='text-white' data-animation='fadeInUp' data-delay='400ms' data-duration='1000ms'></p>
                 <a class='btn btn-primary' href='<?php echo $banner['link'] ;?>' data-animation='fadeInUp' data-delay='800ms' data-duration='1000ms'>اشتري الان</a>
									  </div>
									</div>
							</div>	 


                        
                    <?php $inc++;endforeach;?>
 </div>


			     </div>
          </div>
		     </div>
 <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="row g-2 rtl-flex-d-row-r">
  <?php foreach (get_categorys() as $the_category) :?>
            <!-- Catagory Card -->
            <div class="col-3">
              <div class="card catagory-card">

                <div class="card-body px-2"><a href="http://<?php echo $domain;?>/products/category/<?php echo $the_category['category_id'];?>">
<?php if (isset($the_category['category_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_category['category_image']) && file_exists(FILEMANAGERPATH.$the_category['category_image'])) || (is_file(DIR_STORAGE . 'categories' . $the_category['category_image']) && file_exists(DIR_STORAGE . 'categories' . $the_category['category_image'])))) : ?>

                       <img  src="https://control.elmattger.com/storage/<?php echo $the_category['category_image']; ?>" alt="<?php echo $the_category['category_image'];?>">
                                <?php else : ?>
                                  <img src="https://control.elmattger.com/storage/assets/itsolution24/img/noimage.jpg" <?php echo $the_category['category_image'];?>>
                                <?php endif; ?>


                                <span><?php echo $the_category['category_name'];?></span>
</a></div>
              </div>
            </div>
               <?php endforeach;?>
          </div>
        </div>
      </div>

  <!-- Dark Mode -->
<div class="container">
        <div class="dark-mode-wrapper mt-3 bg-img p-4 p-lg-5">
          <p class="text-white">You can change your display to a dark background using a dark mode.</p>
          <div class="form-check form-switch mb-0">
            <label class="form-check-label text-white h6 mb-0" for="darkSwitch">Switch to Dark Mode</label>
            <input class="form-check-input" id="darkSwitch" type="checkbox" role="switch">
          </div>
        </div>
      </div>
      

         
  <!-- Top Products -->
      <div class="top-products-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>منتجات اكثر مبيعا </h6><a class="btn p-0" href="http://<?php echo $domain;?>/bestsales">منتجات اكثر &raquo;<i class="ms-1 fa-solid fa-arrow-right-long"></i></a>
          </div>
          <div class="row g-2">
            <!-- Product Card -->
				<?php foreach (get_best_sales(array('start'=>0,'limit'=>10)) as $the_product) :?>
           <div class='col-6 col-md-4'>
              <div class='card product-card'>
                <div class='card-body' id="prod-<?php echo $the_product['p_id'];?>">
                <span class='badge rounded-pill badge-warning'>الاحدث في المتجر</span>
                 <a class='wishlist-btn' href=''>
				 <i class='fa-solid fa-heart'>                       </i></a>
                  <!-- Thumbnail --><a class='product-thumbnail d-block' href='http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>'>
<?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>

<img class='mb-2' src='https://control.elmattger.com/storage/<?php echo $the_product['p_image']; ?>' alt='<?php echo $the_product['p_name'];?>'>

 <?php else : ?>
       <img class='mb-2'  src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?>>
                                    <?php endif; ?>

                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                    <ul class='offer-countdown-timer d-flex align-items-center shadow-sm' data-countdown='$pdate'>
                      <li><span class='days'>0</span>d</li>
                      <li><span class='hours'>0</span>h</li>
                      <li><span class='minutes'>0</span>m</li>
                      <li><span class='seconds'>0</span>s</li>
                    </ul></a>
      <?php $stock = $the_product['quantity_in_stock'];
                                if ($stock > 0) : ?>
                                    <span class="sale-price">متاح</span>
                                <?php else:?>
                                    <span class="red">غير متاح</span>
                                <?php endif;?>
                  <!-- Product Title --><a class='product-title' href='http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>'><?php echo $the_product['p_name'];?></a>
				  					
                  <!-- Product Price -->
                  <p class='sale-price'><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></p>
                  <!-- Rating -->
                  <div class='product-rating'><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i></div>
                <a class='btn btn-success btn-sm'ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;"  title="Add To Cart">
				  <i class='fa-solid fa-plus'></i></a>
                </div>
              </div>
            </div>
 <?php endforeach;?>
           

       <!-- Product Card -->
           
          </div>
        </div>
      </div>

 <!-- CTA Area -->
      <div class="container">
        <div class="cta-text dir-rtl p-4 p-lg-5">
          <div class="row">
            <div class="col-9">
              <h4 class="text-white mb-1">احصل علي خصم 40% علي </h4>
              <p class="text-white mb-2 opacity-75">كل منتجات الشيشه الاكترونيه </p><a class="btn btn-warning" href="#">احصل علي العرض</a>
            </div>
          </div><img src="img/bg-img/vape.png" alt="">
        </div>
      </div>
			<!-- Top Products -->
      <div class="top-products-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between dir-rtl">
            <h6>منتجات وصلت حديثا </h6><a class="btn p-0" href="http://<?php echo $domain;?>/newproducts">منتجات اكثر &raquo;<i class="ms-1 fa-solid fa-arrow-right-long"></i></a>
          </div>
          <div class="row g-2">
            <!-- Product Card -->
				<?php foreach (get_new_products(array('start'=>0,'limit'=>10)) as $the_product) :?>
           <div class='col-6 col-md-4'>
              <div class='card product-card'>
                <div class='card-body' id="prod-<?php echo $the_product['p_id'];?>">
                <span class='badge rounded-pill badge-warning'>الاكثرمبيعا</span>
                 <a class='wishlist-btn' href=''>
				 <i class='fa-solid fa-heart'>                       </i></a>
                  <!-- Thumbnail --><a class='product-thumbnail d-block' href='http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>'>
<?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>

<img class='mb-2' src='https://control.elmattger.com/storage/<?php echo $the_product['p_image']; ?>' alt='<?php echo $the_product['p_name'];?>'>

 <?php else : ?>
       <img class='mb-2'  src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?>>
                                    <?php endif; ?>

                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                    <ul class='offer-countdown-timer d-flex align-items-center shadow-sm' data-countdown='$pdate'>
                      <li><span class='days'>0</span>d</li>
                      <li><span class='hours'>0</span>h</li>
                      <li><span class='minutes'>0</span>m</li>
                      <li><span class='seconds'>0</span>s</li>
                    </ul></a>
      <?php $stock = $the_product['quantity_in_stock'];
                                if ($stock > 0) : ?>
                                    <span class="sale-price">متاح</span>
                                <?php else:?>
                                    <span class="red">غير متاح</span>
                                <?php endif;?>
                  <!-- Product Title --><a class='product-title' href='http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>'><?php echo $the_product['p_name'];?></a>
				  					
                  <!-- Product Price -->
                  <p class='sale-price'><?php echo get_currency_symbol().currency_format($the_product['sell_price']);?></p>
                  <!-- Rating -->
                  <div class='product-rating'><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i><i class='fa-solid fa-star'></i></div>
                <a class='btn btn-success btn-sm'ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;"  title="Add To Cart">
				  <i class='fa-solid fa-plus'></i></a>
                </div>
              </div>
            </div>
 <?php endforeach;?>
           

       <!-- Product Card -->
           
          </div>
        </div>
      </div>
															
						
     
    
<?php include('footer.php');?>