<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_brands'));
include('header_home.php');?>
    <div class="page-content-wrapper py-3">
      <div class="container">
        <div class="row gy-3">

<?php foreach (get_brands() as $the_brand) :?>
          <div class="col-12">
            <!-- Single Vendor -->
            <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('<?php echo store('apilink'); ?>/storage/<?php echo $the_brand['brand_banner'];?>')">
              <h5 class="vendor-title text-white"><?php echo $the_brand['brand_name'];?></h5>
              <div class="vendor-info">
                <p class="mb-1 text-white"><i class="fa-solid fa-location-dot me-1"></i><?php echo $the_brand['brand_details'];?></p>
                <div class="ratings lh-1"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span class="text-white"></span></div>
              </div><a class="btn btn-warning btn-sm mt-3" href="https://<?php echo $domain; ?>/products/brand/<?php echo $the_brand['brand_id'];?>">الذهاب الي <i class="fa-solid fa-arrow-right-long ms-1"></i></a>
              <!-- Vendor Profile-->
              <div class="vendor-profile shadow">
                <figure class="m-0"><img src="<?php echo store('apilink'); ?>/storage/<?php echo $the_brand['brand_image'];?>" alt="<?php echo $the_brand['brand_name'];?>"></figure>
              </div>
            </div>
          </div>
            <?php endforeach;?>
          
   
        </div>
      </div>
    </div>

    
<?php include('footer.php');?>