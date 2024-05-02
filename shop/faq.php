<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_faq'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Frequently Asked Questions</h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>FAQs</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area faq-area">
        <div class="single-faq-wrap pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="panel-group sc-accordion-peragraph" id="accordion">
                            <div class="panel faq-accordion mb-20" style="border:1px solid #ccc;border-radius:0;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#faq-accordion1">
                                            I want to know where my order is?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq-accordion1" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <p>Vivamus feugiat, eros pretium porta porttitor, tortor ligula venenatis elit, ac porta turpis neque ut neque. In condimentum massa lacus, rutrum sollicitudin ligula lobortis ac. Aenean interdum accumsan leo, quis convallis nisi sagittis ac. Suspendisse malesuada ullamcorper fermentum. Vestibulum viverra interdum mauris.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel faq-accordion mb-20" style="border:1px solid #ccc;border-radius:0;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#faq-accordion2">
                                            I want to return an item?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq-accordion2" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <p>Vivamus feugiat, eros pretium porta porttitor, tortor ligula venenatis elit, ac porta turpis neque ut neque. In condimentum massa lacus, rutrum sollicitudin ligula lobortis ac. Aenean interdum accumsan leo, quis convallis nisi sagittis ac. Suspendisse malesuada ullamcorper fermentum. Vestibulum viverra interdum mauris.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel faq-accordion mb-20" style="border:1px solid #ccc;border-radius:0;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#faq-accordion3">
                                            I want to cancel an order?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq-accordion3" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <p>Vivamus feugiat, eros pretium porta porttitor, tortor ligula venenatis elit, ac porta turpis neque ut neque. In condimentum massa lacus, rutrum sollicitudin ligula lobortis ac. Aenean interdum accumsan leo, quis convallis nisi sagittis ac. Suspendisse malesuada ullamcorper fermentum. Vestibulum viverra interdum mauris.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php include('footer.php');?>