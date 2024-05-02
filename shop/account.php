<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$tab = isset($request->get['tab']) ? $request->get['tab'] : 'profile';
$customrer_id = isset($session->data['cid']) ? $session->data['cid'] : '';
$the_customer = get_the_customer($customrer_id);
if (!isset($the_customer['customer_id']) || !is_clogged_in()) {
    redirect('account_login.php');
}
$document->setTitle(trans('title_account'));
include('header.php');?>
<style type="text/css">
a.active {
    color: #dcb86c!important;
}
.sidebar-widget.sidebar-border {
	border-bottom: none;
}
</style>
	<div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container">
            <div class="breadcrumb-content breadcrumb-center">
                <small>Profile of</small> <h2><?php echo $the_customer['customer_name'];?></span></h2>
            </div>
        </div>
    </div>
    <div class="main-area login-register-area pt-30 pb-30">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">

                    <?php if ($tab == 'profile'):?>
                    	<h2>My Profile</h2>
                    	<?php include('_inc/template/profile.php');?>
                    <?php endif;?>

                    <?php if ($tab == 'profile_edit'):?>
                    	<h2>Edit Profile</h2>
                    	<?php include('_inc/template/profile_edit.php');?>
                    <?php endif;?>

                    <?php if ($tab == 'change_password'):?>
                    	<h2>Change Password</h2>
                    	<?php include('_inc/template/change_password.php');?>
                    <?php endif;?>

                    <?php if ($tab == 'change_email'):?>
                        <h2>Change Email</h2>
                        <?php include('_inc/template/change_email.php');?>
                    <?php endif;?>

                    <?php if ($tab == 'change_phone'):?>
                        <h2>Change Phone</h2>
                        <?php include('_inc/template/change_phone.php');?>
                    <?php endif;?>

                    <?php if ($tab == 'orders'):?>
                    	<h2>My Orders</h2>
                        <?php include('_inc/template/profile_orders.php');?>
                    <?php endif;?>      	

                </div>
                <div class="col-lg-3">
                    <div class="shop-sidebar">
                    	<div class="sidebar-widget sidebar-border pb-45">
                            <div class="sidebar-widget sidebar-border mt-20  mb-20">
                                <h4 class="pro-sidebar-title">
                                    <a class="<?php echo $tab == 'orders' ? 'active' : '';?>" href="account.php?tab=orders">My Orders</a>
                                </h4>
                            </div>
                            <div class="sidebar-widget sidebar-border mt-20  mb-20">
                                <h4 class="pro-sidebar-title">
                                    <a class="<?php echo $tab == 'profile' || $tab == 'profile_edit' || $tab == 'change_password' ? 'active' : '';?>" href="account.php?tab=profile">Manage Account</a>
                                </h4>
                            </div>
                            <div class="sidebar-widget-list mt-10">
                               <ul>
                                   <li><a class="<?php echo $tab == 'profile' ? 'active' : '';?>" href="account.php?tab=profile"><i class="fa fa-fw fa-angle-right"></i>My Profile</a></li>

                                   <li><a class="<?php echo $tab == 'profile_edit' ? 'active' : '';?>" href="account.php?tab=profile_edit"><i class="fa fa-fw fa-angle-right"></i>Edit My Profile</a></li>

                                   <li><a class="<?php echo $tab == 'change_password' ? 'active' : '';?>" href="account.php?tab=change_password"><i class="fa fa-fw fa-angle-right"></i>Change Password</a></li>

                                   <li><a class="<?php echo $tab == 'change_email' ? 'active' : '';?>" href="account.php?tab=change_email"><i class="fa fa-fw fa-angle-right"></i>Change Email</a></li>

                                   <li><a class="<?php echo $tab == 'change_phone' ? 'active' : '';?>" href="account.php?tab=change_phone"><i class="fa fa-fw fa-angle-right"></i>Change Phone</a></li>
                               </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php');?>