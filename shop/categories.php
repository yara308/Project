<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_categories'));
include('header_home.php');?>
    <div class="page-content-wrapper py-3">
      <div class="container">
        <div class="row gy-3">


         
 <?php foreach (get_categorys() as $the_category) :?>
 <div class="col-12">
            <!-- Single Vendor img/bg-img/12.jpg-->
            <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('<?php echo store('apilink'); ?>/storage/<?php echo $the_category['category_banner'];?>')">
              <h5 class="vendor-title text-white"><?php echo $the_category['category_name'];?></h5>
              <div class="vendor-info">
                <p class="mb-1 text-white"><i class="fa-solid fa-location-dot me-1"></i><?php echo $the_category['category_details'];?></p>
                <div class="ratings lh-1"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span class="text-white"></span></div>
              </div>
<a class="btn btn-warning btn-sm mt-3" href="https://<?php echo $domain; ?>/products/category/<?php echo $the_category['category_id'];?>">اكتشف المنتجات<i class="fa-solid fa-arrow-right-long ms-1">
</i></a>
              <!-- Vendor Profile-->
              <div class="vendor-profile shadow">
                <figure class="m-0"><img src="<?php echo store('apilink'); ?>/storage/<?php echo $the_category['category_image'];?>" alt="<?php echo $the_category['category_name'];?>"></figure>
              </div>
            </div>
 </div>
   <?php endforeach;?>

         
         
          
          
          
        </div>
      </div>
    </div>
    
<?php 
//$cat =
//$parentCategoryId = 19; // Replace with the actual parent category ID.
//$subcategories = getSubcategoriesByCategoryId($parentCategoryId);

//foreach ($subcategories as $the_subcategory) {
  //  // Access subcategory attributes
    //$subcategoryName = $the_subcategory['category_name'];
   // $subcategoryId = $the_subcategory['category_id'];

//echo $subcategoryId;
//echo $subcategoryName;

    // Process or display the subcategory data as needed.
//}
?>
    

<?php include('footer.php');?>