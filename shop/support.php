<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_support'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Support</h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>Support</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area support-content-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="font-weight-bold mb-20"><a class="font-weight-bold" href="faq.php">Hi, how can we help you?</a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                                <div class="card-title"><a class="font-weight-bold text-info" href="faq.php">I want to know where my order is?</a></div>
                                <div class="card-text">
                                    Get status updates about your order with our Tracking Tool
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                                <div class="card-title font-weight-bold text-info"><a class="font-weight-bold text-info" href="faq.php">I want to return an item?</a></div>
                                <div class="card-text">
                                    Use our Online Return Form to start your return
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                                <div class="card-title font-weight-bold text-info"><a class="font-weight-bold text-info" href="faq.php">I want to cancel an order?</a></div>
                                <div class="card-text">
                                    Use our Online Cancellation Form to start your order cancellation
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
                                    For any type of relevenat inquiry, please <a class="text-warning" href="contact.php">contact us</a>
                                </div> 
                                <h2 class="text-white">Live Chat Time Schedule</h2>
                                <div class="mb-20">
                                    <div>Sunday - Thrusday</div>
                                    <div>Time: 9 AM - 8 PM</div>
                                </div>
                                <a class="btn" href="#" role="button">Live Chat with Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>