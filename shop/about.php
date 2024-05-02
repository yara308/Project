<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_about'));
include('header.php');?>
    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-60 pb-60">
        <div class="container">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>About Us</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area about-content-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-8">
                    <div class="about-content-2">
                        
                        <?php echo html_entity_decode(shop('about'));?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial-area pt-60 pb-60 bg-light">
        <div class="container">
            <div class="section-title text-center mb-45 section-title-border">
                <h2 class="font-weight-bold mt-20">what Our Clients Say</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 ml-auto mr-auto col-md-8">
                    <div class="testimonial-active-3 owl-carousel owl-dot-style-1">
                        <div class="single-testimonial-wrap text-center">
                            <img src="assets/img/testimonial/testimonial-1.jpg" alt="">
                            <div class="client-imfo">
                                <h4>"In convallis nulla et magna congue convallis. Donec eu nunc vel justo maximus posuere. Sed viverra nunc erat, a efficitur nibh"</h4>
                                <h5>Francisco Newton</h5>
                            </div>
                        </div>
                        <div class="single-testimonial-wrap text-center">
                            <img src="assets/img/testimonial/testimonial-2.jpg" alt="">
                            <div class="client-imfo">
                                <h4>"In convallis nulla et magna congue convallis. Donec eu nunc vel justo maximus posuere. Sed viverra nunc erat, a efficitur nibh"</h4>
                                <h5>Francisco Newton</h5>
                            </div>
                        </div>
                        <div class="single-testimonial-wrap text-center">
                            <img src="assets/img/testimonial/testimonial-1.jpg" alt="">
                            <div class="client-imfo">
                                <h4>"In convallis nulla et magna congue convallis. Donec eu nunc vel justo maximus posuere. Sed viverra nunc erat, a efficitur nibh"</h4>
                                <h5>Francisco Newton</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>