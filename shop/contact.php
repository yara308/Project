<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_contact_us'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2><?php echo trans('title_contact_us');?></h2>
                <ul>
                    <li>
                        <a href="index.html"><?php echo trans('text_home');?></a>
                    </li>
                    <li><?php echo trans('title_contact_us');?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area contact-area contact-area-mrg pt-20 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i style="font-size:80px;" class="fa fa-phone"></i>
                                        <h3><?php echo store('mobile');?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i style="font-size:80px;" class="fa fa-envelope-o"></i>
                                        <h3><a href="#"><?php echo store('email');?></a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i style="font-size:80px;" class="fa fa-map-marker"></i>
                                        <h3><?php echo store('address');?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-50">
                <div class="col-lg-12">
                    <div class="jumbotron bg-info text-white">
                        <div class="row">
                            <div class="col-lg-4 text-center">
                                <i style="font-size:15rem;" class="fa fa-headphones text-white"></i>
                            </div>
                            <div class="col-lg-8">
                                <div class="pt-10 pb-10">
                                    <?php echo trans('text_For any type of relevenat inquiry, please');?> <a class="text-warning" href="contact.php"><?php echo trans('text_contact_us');?></a>
                                </div> 
                                <h2 class="text-white">Live Chat Time Schedule</h2>
                                <div class="mb-20">
                                    <div><?php echo trans('text_sunday_to_thrusday');?></div>
                                    <div><?php echo trans('text_time:_9_AM_to_8_AM');?></div>
                                </div>
                                <a class="btn" href="#" role="button"><?php echo trans('text_live_chat_with_us');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="contact-page-map">
            <div id="contact-2"></div>
        </div>
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="ml-auto col-lg-6 col-md-12 col-12">
                    <div class="contact-info-area pr-40">
                        <h3> Let us know what you have in mind, and we’ll get back to you in an instant!</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris su</p>
                        <div class="contact-from-2">
                            <form id="contact-form" action="assets/php/mail.php" method="post">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <input name="first_name" type="text" placeholder="Your Name"> 
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <input name="email_address" type="text" placeholder="Email Address">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <input name="phone" type="text" placeholder="Phone Number">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <textarea name="message" placeholder="Your Message"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button class="submit" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                            <p class="form-messege"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

<?php include('footer.php');?>