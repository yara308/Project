<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_login'));
include('header.php');?>
<div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
    <div class="container-fluid">
        <div class="breadcrumb-content text-center breadcrumb-center">
            <h2>login into Your Account</h2>
        </div>
    </div>
</div>
<div class="main-area login-register-area pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
				    <div class="tab-content">
				        <div id="lg1" class="tab-pane active">
				            <div class="login-form-container">
				                <div class="login-register-form">
				                    <?php include('_inc/template/login_form.php');?>
				                </div>
				                <div class="create-account" style="margin-top:40px;">
				                    <h3 class="text-center">You don't have account yet ?</h3>
				                    <a href="account_register.php">Create an account now</a>
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