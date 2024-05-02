<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
// Catogre Url
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
//end url
$category_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// Start new_products best 
$is_new_products = isset($request->get['new_products']) && $request->get['new_products'] == 'yes';
$is_bast_sales = isset($request->get['best_sales']) && $request->get['best_sales'] == 'yes';

if (isset($_GET['new_products']) && $_GET['new_products'] == 'yes') {
    // Your code for new products here
}
// End new_products
$currentUrl = $_SERVER['REQUEST_URI'];

// Split the URL by "/"
$urlParts = explode('/', $currentUrl);

// Find the category ID
$categoryID = end($urlParts);

// Make sure $categoryID is numeric
if (is_numeric($categoryID)) {
    // You now have the category ID
  //  echo "Category ID: " . $categoryID;
} else {
    // Handle the case where a numeric ID is not present
   // echo "Category ID not found or invalid.";
}
// Get the current URL
$currentURL = $_SERVER['REQUEST_URI'];

// Define the pattern to match the brand ID in the URL
$pattern = '/\/products\/brand\/(\d+)/';

// Use preg_match to find the brand ID in the URL
if (preg_match($pattern, $currentURL, $matches)) {
    // Extract the brand ID from the matches
    $brandID = $matches[1];
    
} else {
   // echo "Brand ID not found in the URL.";
}
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
// Check if brand_id is available and set the URL accordingly
if (isset($brand_id)) {
    $pagination->url = ''.$domain.'/products/brand/'.$brand_id.'/{page}';
} else {
    // Check if category_id is available and set the URL accordingly
    if (isset($category_id)) {
        $pagination->url = ''.$domain.'/products/category/'.$category_id.'/{page}';
    } else {
        // Handle the case where neither brand_id nor category_id is available
        // You can set a default URL or handle it as needed
        $pagination->url = ''.$domain.'/products/{page}';
    }
}
//$pagination->url = ''.$domain.'/products/category/'.$category_id.'/{page}'; 

$pagination = $pagination->render();

$document->setTitle(trans('title_products'));
include('header_home.php');

 if ($category_id) {
$parentCategoryId = $category_id; // Replace with the actual parent category ID.
$subcategories = getSubcategoriesByCategoryId($category_id);
 }
if (isset($_GET['s'])) {
    $search_query = urldecode($_GET['s']);
    // Use $search_query to perform the search operation.
} else {
    // Handle the case when no search query is provided.
    // You can display a default search page or message.
}
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    // Use $category_id to filter and display products based on the category.
} else {
    // Handle the case when no category ID is provided.
    // You can display a default category page or message.
}
if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    // Use $brand_id to filter and display products based on the brand.
} else {
    // Handle the case when no brand ID is provided.
    // You can display a default brand page or message.
}
if ($categoryID) {
    $the_category = get_the_category($category_id);
    $filters['filter_category_id'] = $category_id;
$document->setTitle($the_category['category_name']);
}
//echo "Domain URL: http://$domain";

?>

<?php if ($category_id):?>
<div class="page-content-wrapper pb-3">
      <!-- Vendor Details Wrap -->
      <div class="vendor-details-wrap bg-img bg-overlay py-4" style="background-image: url('https://control.elmattger.com/storage<?php echo $the_category['category_banner']; ?>')">
        <div class="container">
          <div class="d-flex align-items-start">
            <!-- Vendor Profile-->
            <div class="vendor-profile shadow me-3 mt-1">
              <figure class="m-0"><img src="https://control.elmattger.com/storage<?php echo $the_category['category_image']; ?>" alt=""></figure>
            </div>
            <!-- Vendor Info-->
            <div class="vendor-info">
              <h5 class="vendor-title text-white"><?php echo $the_category['category_name'];?></h5>
              <p class="mb-1 text-white"><i class="fa-solid fa-location-dot me-1"></i><?php echo $the_category['category_details'];?></p>
              <div class="ratings lh-1"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span class="text-white">()</span></div>
            </div>
          </div>
          <!-- Vendor Basic Info-->
       
          </div>
        </div>
      </div>
      <!-- Vendor Tabs -->
      <div class="vendor-tabs">
        <div class="container">
          <ul class="nav nav-tabs mb-3" id="vendorTab" role="tablist">
     
          </ul>
        </div>
      </div>
     
   <?php endif;?>










<?php if ($category_id):?>

       <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="section-heading rtl-text-right">
            <h6> جميع اقسام </h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row g-2 rtl-flex-d-row-r">
            <?php foreach ($subcategories as $the_subcategory) :?>
  <!-- Catagory Card -->
              <div class="col-3">
                <div class="card catagory-card">
                  <div class="card-body px-2">

                    <a href="https://<?php echo $domain;?>/products/category/<?php echo $the_subcategory['category_id'];?>">
                     <img src="https://control.elmattger.com/storage<?php echo $the_subcategory['category_image'];?>" alt="<?php echo $the_subcategory['category_name'];?>">
                         <span><?php echo $the_subcategory['category_name'];?></span>
                             </a>
                                  </div>
                </div>
              </div>
              <!-- Catagory Card -->
            <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
  <?php endif;?>
    <div class="page-content-wrapper container">
      <div class="py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">

  
  
         
  

        
     
      <!-- Top Products-->
          <div class="row g-2 rtl-flex-d-row-r">
                        <?php foreach($products as $the_product) :
                                            $the_product_price = get_the_product_price($the_product['p_id'], store_id());
                                            ?>

           
    <!-- Product Card -->
            <div class="col-6 col-md-4">
              <div class="card product-card">
                <div class="card-body">
                  <!-- Badge--><span class="badge rounded-pill badge-warning">اكثر مبيعات</span>
                  <!-- Wishlist Button--><a class="wishlist-btn" href="#"><i class="fa-solid fa-heart"></i></a>
                  <!-- Thumbnail --><a class="product-thumbnail d-block" href="http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>">

<?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>
                                                          <img  src="https://control.elmattger.com/storage<?php echo $the_product['p_image']; ?>" alt="<?php echo $the_product['p_name'];?>">
                                                        <?php else : ?>
                                                          <img src="https://control.elmattger.com/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?>>
                                                        <?php endif; ?>



                    <!-- Offer Countdown Timer: Please use event time this format: YYYY/MM/DD hh:mm:ss $the_product['p_id']-->
                    </a>
                  <!-- Product Title --><a class="product-title" href="http://<?php echo $domain;?>/product/<?php echo $the_product['p_name_url'];?>-<?php echo $the_product['p_id'];?>"><?php echo $the_product['p_name'];?></a>
                  <!-- Product Price -->
                  <p class="sale-price"> <?php echo get_currency_symbol().currency_format($the_product['sell_price']);?> </p>
                  <!-- Rating -->
                  <div class="product-rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                  <!-- Add to Cart --><a ng-click="addItemToInvoice('<?php echo $the_product['p_id'];?>',1)" onClick="return false;"  class="btn btn-success btn-sm" href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
            </div>
       

<?php endforeach;?>
          <div class="pagination">
                            <?php echo $pagination;?>
                            <!-- <ul>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a class="next" href="#">Next</a></li>
                            </ul> -->
                        </div>

           
           
<?php include('footer.php');?>