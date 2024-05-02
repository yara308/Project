<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_categories'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Shop With Brand</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li class="active">Shop With Brand </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area shop-page-area pt-30 pb-30 padding-5-row-col">
        <div class="container">
            <div class="row">

                <?php foreach (get_brands() as $the_brand) :?>
                    <div class="col-lg-4 col-sm-6 col-12 col-md-6">
                        <div class="category-wrap-2 mb-10 default-overlay item-overlay-2">
                            <a href="products.php?brand_id=<?php echo $the_brand['brand_id'];?>">

                                <?php if (isset($the_brand['brand_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_brand['brand_image']) && file_exists(FILEMANAGERPATH.$the_brand['brand_image'])) || (is_file(DIR_STORAGE . 'categories' . $the_brand['brand_image']) && file_exists(DIR_STORAGE . 'categories' . $the_brand['brand_image'])))) : ?>
                                  <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/brands'; ?>/<?php echo $the_brand['brand_image']; ?>" alt="<?php echo $the_brand['brand_image'];?>">
                                <?php else : ?>
                                  <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_brand['brand_image'];?>>
                                <?php endif; ?>

                            </a>
                            <div class="category-btn-2">
                                <a href="products.php?brand_id=<?php echo $the_brand['brand_id'];?>"><?php echo $the_brand['brand_name'];?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>

<?php include('footer.php');?>