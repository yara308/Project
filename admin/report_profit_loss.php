<?php 
ob_start();
session_start();
include ("../_init.php");

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if (user_group_id() != 1 && !has_permission('access', 'read_profit_loss_report')) {
  redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

$type = isset($request->get['type']) ? $request->get['type'] : 'itemwise';

// Set Document Title
$document->setTitle(trans('title_profit_loss_report'));

// Add Script
$document->addScript('../assets/js/uikit-icons.min.js'); //midpos3 stop here
$document->addScript('../assets/js/uikit.min.js');
$document->addScript('../assets/midpos/angular/controllers/ReportProfitLossController.js');

// ADD BODY CLASS
$document->setBodyClass('sidebar-collapse');

// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php") ;
?>

<!-- Content Wrapper Start -->
<div class="content-wrapper" ng-controller="ReportProfitLossController">
<?php include ("rebo.php"); ?>
  <!-- Content Header Start -->
  <section class="content-header">
    <?php include ("../_inc/template/partials/apply_filter.php"); ?>
    <h1>
      <?php echo trans('text_profit_loss_report_title'); ?>
      <small>
        <?php echo store('name'); ?>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i>
           <?php echo trans('text_dashboard'); ?>
         </a>
       </li>
      <li class="active">
        <?php echo trans('text_profit_loss_title'); ?>
      </li>
    </ol>
  </section>
  <!-- Content Header End -->

  <!-- Content Start -->
  <section class="content">

    <?php if(DEMO) : ?>
    <div class="box">
      <div class="box-body">
        <div class="alert alert-info mb-0">
          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              <?php echo trans('text_profit_loss_details_title'); ?>
            </h3>
            <div class="box-tools pull-right">
              <div class="btn-group">
                <button type="button" class="btn btn-info">
                  <span class="fa fa-filter"></span> 
                  <?php if (current_nav() == 'report_profit_loss' && $type == 'itemwise') : ?>
                    <?php echo trans('button_itemwise'); ?>
                  <?php elseif (current_nav() == 'report_profit_loss' && $type == 'categorywise') : ?>
                    <?php echo trans('button_categorywise'); ?>
                  <?php elseif (current_nav() == 'report_profit_loss' && $type == 'supplierwise') : ?>
                    <?php echo trans('button_supplierwise'); ?>
                  <?php elseif (current_nav() == 'report_profit_loss' && $type == 'brandwise') : ?>
                    <?php echo trans('button_brandwise'); ?>
                  <?php elseif (current_nav() == 'report_profit_loss' && $type == 'genderwise') : ?>
                    <?php echo trans('button_genderwise'); ?>
                  <?php else: ?>
                    <?php echo trans('button_filter'); ?>
                  <?php endif; ?>
                </button>
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="report_profit_loss.php?type=itemwise">
                      <?php echo trans('button_itemwise'); ?>
                    </a>
                  </li>
                  <li>
                    <a href="report_profit_loss.php?type=categorywise">
                      <?php echo trans('button_categorywise'); ?>
                    </a>
                  </li>
                  <li>
                    <a href="report_profit_loss.php?type=supplierwise">
                      <?php echo trans('button_supplierwise'); ?>
                    </a>
                  </li>
                  <li>
                    <a href="report_profit_loss.php?type=brandwise">
                      <?php echo trans('button_brandwise'); ?>
                    </a>
                  </li>
                  <li>
                    <a href="report_profit_loss.php?type=genderwise">
                      <?php echo trans('button_genderwise'); ?>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">  
              <?php
                  $print_columns = '0,1,2,3,4,5';
                  $hide_colums = "";
                ?>
              <table id="report-report-list" class="table table-bordered table-striped table-hover" data-hide-colums="<?php echo $hide_colums; ?>" data-print-columns="<?php echo $print_columns;?>">
                <thead>
                  <tr class="bg-gray">
                    <th class="w-10">
                      <?php echo trans('label_sl'); ?>
                    </th>
                    <th class="w-50">
                      <?php echo trans('label_name'); ?>
                    </th>
                    <th class="w-40">
                      <?php echo trans('label_profit'); ?>
                    </th>
                  </tr>
                </thead>
                <tfoot>
                  <tr class="bg-gray">
                    <th class="w-10">
                      <?php echo trans('label_sl'); ?>
                    </th>
                    <th class="w-50">
                      <?php echo trans('label_name'); ?>
                    </th>
                    <th class="w-40">
                      <?php echo trans('label_profit'); ?>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Content End -->

</div>
<!-- Content Wrapper End -->

<?php include ("footer.php"); ?>