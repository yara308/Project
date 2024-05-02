<?php 



if (isset($request->get['store_id']) && $request->get['store_id']) {
    $store->openTheStore($request->get['store_id']);
}
$body_class = $document->getBodyClass();
$title = $document->getTitle();
$description = $document->getDescription();
$keywords = $document->getKeywords();
$styles = $document->getStyles();
$scripts = $document->getScripts(); 
$price = $document->getPrice(); 
//$availability = $document->getavailability(); 
//$image = $document->getiamge(); 
$query_string = '';
if (!empty($request->get)) {
    $inc=1;foreach ($request->get as $key => $value) {
      if (!in_array($key, array('from', 'to', 'filter','ftype', 'type'))) {
        if ($inc==1) {
            $query_string .= '?'.$key.'='.$value;
        } else {
            $query_string .= '&'.$key.'='.$value;
        }
      }
    $inc++;}
} else {
    $query_string = '?filter=yes';
}
$query_string = str_replace(array('&'), '?', $query_string);
$domain = $_SERVER['HTTP_HOST'];
?>

<!--- start form here header-->
<!DOCTYPE html>
<html lang="ar"  class="no-js"  ng-app="angularApp" view-mode="rtl">
  <head>
<!-- Meta Pixel Code -->

<script>
    // Assuming window.baseUrl is defined somewhere before this script
    // window.baseUrl = "https://yourwebsite.com";
var controller;
    var lang = "arabic"; // Example language. You can change this or get the value dynamically.

    var langCode = 'ar';
    switch(lang) {
        case "arabic":
            langCode = "ar";
            break;
        // ... other cases ...
        default:
            langCode = 'en';
            break;
    }

    var langName = 'Arabic';
    var langUrl = 'Arabic';
    switch(langCode) { // Note the change here: I'm using langCode instead of lang for the second switch
        case "ar":
            langName = "Arabic";
            langUrl = "/assets/DataTables/i18n/Arabic.json";
            break;
        // ... other cases ...
        default:
            langName = 'English';
            langUrl = "/assets/DataTables/i18n/English.json";
            break;
    }

    // If you want to display the results in the HTML:
   
</script>
<!-- End Meta Pixel Code -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="<?php echo $title ? $title . ' &raquo; ' : null; ?><?php echo store('name'); ?>">
 <title><?php echo $title ? $title . ' &raquo; ' : null; ?><?php echo store('name'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Alretajvape </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <!-- <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500&family=El+Messiri:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="https://<?php echo $domain; ?>/img/icons/icon-72x72.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="https://<?php echo $domain; ?>/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://<?php echo $domain; ?>/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="https://<?php echo $domain; ?>/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://<?php echo $domain; ?>/img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/animate.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/all.min.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/brands.min.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/solid.min.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/magnific-popup.css">
    <link rel="stylesheet" href="https://<?php echo $domain; ?>/css/nice-select.css">
  <link rel="stylesheet" href="<?php echo store('apilink'); ?>/assets/toastr/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Stylesheet -->
<!-- jQuery JS -->
<script src="https://<?php echo $domain; ?>/assets/js/vendor/jquery-1.12.4.min.js"></script>
<!-- Popper JS -->
<script src="https://<?php echo $domain; ?>/assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://<?php echo $domain; ?>/assets/js/bootstrap.min.js"></script>
<!-- Plugins JS -->
<script src="https://<?php echo $domain; ?>/assets/js/plugins.js"></script>
<!-- Main JS -->
<script src="https://<?php echo $domain; ?>/assets/js/main.js"></script>
<script src="https://<?php echo $domain; ?>/assets/angular/controllers/PosController.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://<?php echo $domain; ?>/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="https://<?php echo $domain; ?>/manifest.json">
 <!-- Bootstrap Timepicker J سS-->
    <script src="<?php echo store('apilink'); ?>/assets/timepicker/bootstrap-timepicker.min.js" type="text/javascript" ></script>
    <!-- Angular JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angularmin/angular.js" type="text/javascript"></script> 
    <!-- AngularApp JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angular/angularApp.js" type="text/javascript"></script>
    <!-- Filemanager JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angularmin/filemanager.js" type="text/javascript"></script>
    <!-- Angular JS Modal -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/angularmin/modal.js" type="text/javascript"></script>
    <!-- Select2 JS -->
    <script src="<?php echo store('apilink'); ?>/assets/select2/select2.min.js" type="text/javascript"></script>
    <!-- Perfect Scroolbar JS -->
    <script src="<?php echo store('apilink'); ?>/assets/perfectScroll/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!-- Sweet ALert JS -->
    <script src="<?php echo store('apilink'); ?>/assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- Toastr JS -->
    <script src="<?php echo store('apilink'); ?>/assets/toastr/toastr.min.js" type="text/javascript"></script>
    <!-- Accounting JS -->
    <script src="<?php echo store('apilink'); ?>/assets/accounting/accounting.min.js" type="text/javascript"></script>
    <!-- Underscore JS -->
    <script src="<?php echo store('apilink'); ?>/assets/underscore/underscore.min.js" type="text/javascript"></script>
    <!-- Plugins JS -->
    <script src="https://kuw1.com/assets/js/plugins.js"></script>
    <!-- Common JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/js/common.js"></script>
    <!-- Main JS -->
    <script src="<?php echo store('apilink'); ?>/assets/itsolution24/js/main.js"></script>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '707007064189338');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=707007064189338&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

  </head>
  <body ng-controller="PosController">
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status"> 
        <div class="sr-only"></div>
      </div>
    </div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
        <!-- Logo Wrapper -->
        <div class="logo-wrapper"><a href="https://<?php echo $domain; ?>/home.php"><img src="<?php echo store('apilink'); ?>/assets/itsolution24/img/logo-favicons/<?php echo store('logo');?>" alt=""></a></div>
        <div class="navbar-logo-container d-flex align-items-center">
<?php if(!is_clogged_in()):?>
                   
                <?php else:?>
             <div class="user-profile-icon ms-2"><a href="https://<?php echo $domain; ?>/profile.php"><img src="https;//<?php echo $domain; ?>/img/bg-img/9.jpg" alt=""></a></div>
                <?php endif;?>
<br>
<br>
          <!-- Cart Icon -->
          <div  class="cart-icon-wrap"><a href="https://<?php echo $domain; ?>/cart.php"><i class="fa-solid fa-bag-shopping"></i><span>{{ totalItem }}</span></a></div>
          <!-- User Profile Icon -->

                

          <!-- Navbar Toggler -->
          <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas" aria-controls="suhaOffcanvas">
            <div><span></span><span></span><span></span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas" aria-labelledby="suhaOffcanvasLabel">
      <!-- Close button-->
      <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <!-- Offcanvas body-->
      <div class="offcanvas-body">
        <!-- Sidenav Profile-->
        <div class="sidenav-profile">
          <div class="user-profile"><img src="https://<?php echo $domain; ?>/img/bg-img/118.jpg" alt=""></div>
          <div class="user-info">
            <h5 class="user-name mb-1 text-white"><?php echo store('name'); ?></h5>
            <p class="available-balance text-white"><?php echo trans('text_contact:');?><?php echo store('mobile');?></p>
          </div>
        </div>
        <!-- Sidenav Nav-->
        <ul class="sidenav-nav ps-0">
          <li><a href="products.php?best_sales=yes"><i class="fa-brands fa-salesforce"></i><?php echo trans('menu_best_sales');?></a></li>
          <li><a href="products.php?new_products=yes"><i class="fa-solid fa-bell lni-tada-effect"></i><?php echo trans('menu_new_products');?><span class="ms-1 badge badge-warning">3</span></a></li>
          <li ><a href="products.php"><i class="fa-solid fa-store"></i><?php echo trans('menu_all_products');?></a>
           
          </li>
          <li class="suha-dropdown-menu"><a href="#"><i class="fa-solid fa-box-archive"></i><?php echo trans('menu_all_brand');?> </a>

<ul>
                                    <?php foreach (get_brands() as $the_brand) :?>

                                    <li><a href="https://<?php echo $domain; ?>/products/brand/<?php echo $the_brand['brand_id'];?>"><?php echo $the_brand['brand_name'];?></a></li>
                                    <?php endforeach;?>
                                </ul>

</li>
          <li class="suha-dropdown-menu"><a href="wishlist-grid.html"><i class="fa-solid fa-layer-group"></i><?php echo trans('menu_all_cat');?></a>
            <ul>
  <?php foreach (get_categorys() as $the_category) :?>
                                    <li><a href="https://<?php echo $domain; ?>/products/category/<?php echo $the_category['category_id'];?>"><?php echo $the_category['category_name'];?></a></li>
                                    <?php endforeach;?>
            </ul>
          </li>
         
          <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><?php echo trans('menu_shopping_cart');?><span ng-show="totalItem" class="ms-1 badge badge-warning">{{ totalItem }}</span></a></li>
          <li><a href="settings.php"><i class="fa-solid fa-sliders"></i><?php echo trans('menu_Settings');?></a></li>

                <?php if(!is_clogged_in()):?>
                    <li><a href="https://<?php echo $domain; ?>/account_login.php"><i class="fa-solid fa-toggle-off"></i><?php echo trans('menu_login');?></a></li>
                    <li><a href="https://<?php echo $domain; ?>/account_register.php"><i class="fa-solid fa-toggle-off"></i><?php echo trans('menu_register');?></a></li>
                <?php else:?>
                    <li><a href="https://<?php echo $domain; ?>/account.php?action=logout"><i class="fa-solid fa-toggle-off"></i><?php echo trans('menu_out');?></a></li>
                <?php endif;?>

        </ul>
      </div>
<h5 class="user-name mb-1 text-white">&copy; <?php echo store('name');?>, <?php echo date('Y');?></h5>


    </div>
    <!-- PWA Install Alert -->
    <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
      <div class="toast-body">
        <div class="content d-flex align-items-center mb-2"><img src="https://<?php echo $domain; ?>/img/icons/icon-72x72.png" alt="">
          <h6 class="mb-0">Add to Home Screen</h6>
          <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
        </div><span class="mb-0 d-block">Add kUW on your mobile home screen. Click the<strong class="mx-1">Add to Home Screen</strong>button &amp; enjoy it like a regular app.</span>
      </div>
    </div>
    <div class="page-content-wrapper container">
      <!-- Search Form-->
      <!-- Search Form-->
      <div class="container">
        <div class="search-form pt-3 rtl-flex-d-row-r">
          <form action="https://<?php echo $domain; ?>/products.php" method="GET">
            
            <input id="main-search-input" class="form-control" name="s" type="search" placeholder="ابحث عما تريد">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
          <!-- Alternative Search Options -->
          <div class="alternative-search-options">
            <div class="dropdown"><a class="btn btn-danger dropdown-toggle" id="altSearchOption" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-sliders"></i></a>
              <!-- Dropdown Menu -->
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="altSearchOption">
              
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- end here header -->
