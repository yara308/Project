<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_return_refund'));
include('header.php');?>
    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Return & Refund</h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>Return & Refund</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area support-content-area pt-50 pb-90">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-8">
                    <div class="support-content-2">

                        <?php echo html_entity_decode(shop('refund_policy'));?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>