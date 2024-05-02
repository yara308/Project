<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';
$document->setTitle(trans('title_stores'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Available Shops</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li class="active">Shops</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area shop-page-area pt-30 pb-30 padding-5-row-col">
        <div class="container">
            <div class="row">

                <?php foreach (get_stores(true) as $ths_store) :?>
                    <div class="col-lg-4 col-sm-6 col-12 col-md-6">
                        <div class="category-wrap-2 mb-10 default-overlay item-overlay-2">
                            
                            <a href="home.php?store_id=<?php echo $ths_store['store_id'];?>">

                                <?php if (isset($ths_store['thumbnail']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$ths_store['thumbnail']) && file_exists(FILEMANAGERPATH.$ths_store['thumbnail'])) || (is_file(DIR_STORAGE . 'stores' . $ths_store['thumbnail']) && file_exists(DIR_STORAGE . 'stores' . $ths_store['thumbnail'])))) : ?>
                                  <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/stores'; ?>/<?php echo $ths_store['thumbnail']; ?>" alt="<?php echo $ths_store['thumbnail'];?>">
  <h1><?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/stores'; ?>/<?php echo $ths_store['thumbnail']; ?>" alt="<?php echo $ths_store['thumbnail'];?></h1>
                                <?php else : ?>
                                  <img src="<?php echo root_url();?>/assets/img/store.png" <?php echo $ths_store['thumbnail'];?>>
                                <?php endif; ?>
                            </a>


                            <div class="category-btn-2">
                                <a href="home.php?store_id=<?php echo $ths_store['store_id'];?>"><?php echo $ths_store['name'];?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>

<?php include('footer.php');?>