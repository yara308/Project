<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_cart_empty'));
include('header_home.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-50 pb-50">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Cart Empty</h2>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>Cart Empty</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area cart-main-area pt-70 pb-70">
        <div class="container">
            <div class="cart-empty-content text-center">
                <i class="negan-icon-cart-modern"></i>
                <p>Your cart is currently empty.</p>
                <div class="empty-btn">
                    <a href="#">Return to shop</a>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>