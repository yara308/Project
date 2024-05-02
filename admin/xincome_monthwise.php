<?php 
ob_start();
session_start();
include ("../_init.php");

// Redirect, If user is not logged in
if (!$user->isLogged()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if ($user->getGroupId() != 1 && !$user->hasPermission('access', 'read_income_monthwise')) {
  redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

//  Load Language File
$language->load('accounting');

// Set Document Title
$document->setTitle($language->get('title_income_monthwise'));

// Add Script
$document->addScript('../assets/js/uikit-icons.min.js'); //midpos3 stop here
$document->addScript('../assets/js/uikit.min.js');
$document->addScript('../assets/midpos/angular/controllers/IncomeMonthwiseController.js');

// ADD BODY CLASS
$document->setBodyClass('sidebar-collapse');

// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php") ;
?>

<!-- Content Wrapper Start -->
<div class="content-wrapper">

  <!-- Content Header Start -->
  <section class="content-header" ng-controller="IncomeMonthwiseController">
    <?php include ("../_inc/template/partials/apply_filter.php"); ?>
    <h1>
      <?php echo $language->get('text_income_monthwise_title'); ?>
      <small>
        <?php echo store('name'); ?>
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> 
          <?php echo $language->get('text_dashboard'); ?>
        </a>
      </li>
      <li class="active">
        <?php echo $language->get('text_income_monthwise_title'); ?>
      </li>
    </ol>
  </section>
  <!-- Content Header end -->

  <!-- Content Start -->
  <section class="content">

    <?php if(DEMO) : ?>
    <div class="box">
      <div class="box-body">
        <div class="alert alert-info mb-0">
          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $language->get('text_demo'); ?></p>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              <?php 
              $year = from() ? date('Y', strtotime(from())) : year();
              $month = from() ? date('m', strtotime(from())) : month();
              $days_in_month = get_total_day_in_month();
              echo date("F", mktime(0, 0, 0, $month, 10)).', '.$year;
              if (to()) {
                echo '<i> <small>to</small> </i>';
                $year = date('Y', strtotime(to()));
                $month = date('m', strtotime(to()));
                echo date("F", mktime(0, 0, 0, $month, 10)).', '.$year;
              }
              ?>
            </h3>
          </div>
          <div class="box-body pt-0">
            <div class="table-responsive">                     
              <table id="expense-expense-list" class="table table-bordered table-striped table-hovered">
                <thead>
                  <tr class="bg-success">
                      <th class="text-center bg-black"><?php echo $language->get('label_serial_no'); ?></th>
                      <th class="text-center"><?php echo $language->get('label_capital'); ?></th>
                      <th class="text-center"><?php echo $language->get('label_profit'); ?></th>
                    <?php foreach (get_income_sources(array('filter_type'=>'credit','filter_show_in_income'=>'yes')) as $source):?>
                      <th class="w-5 text-center">
                        <?php echo $source['source_name'];?>
                      </th>
                    <?php endforeach; ?>
                      <th class="text-center bg-red">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $inc = 1;
                    for ($i=0; $i < $days_in_month; $i++) : 
                      $from = date('Y-m-d',strtotime($year.'-'.$month.'-'.$inc));
                      $profit = profit_amount($from,$from);
                      $capital = selling_price($from,$from) - $profit;
                      ?>
                      <tr class="bg-gray">
                          <td class="w-5 text-center bg-black"><?php echo $inc;?></td>
                          <td class="w-5 text-center"><?php echo $capital ? currency_format($capital) : '-';?></td>
                          <td class="w-5 text-center"><?php echo $profit ? currency_format($profit) : '-';?></td>
                        <?php foreach (get_income_sources(array('filter_type'=>'credit','filter_show_in_income'=>'yes')) as $source):?>
                          <td class="w-5 text-center">
                            <?php echo get_total_source_income($source['source_id'], $from, $from) ? currency_format(get_total_source_income($source['source_id'], $from, $from)) : '-';?>
                          </td>
                        <?php endforeach;?>
                        <td class="w-5 text-center bg-green">
                          <?php echo get_total_income($from, $from) ? currency_format(get_total_income($from, $from)) : '-';?>
                        </td>
                      </tr>
                  <?php $inc++;endfor;?>
                </tbody>
                <tfoot>
                  
                  <tr class="bg-success">
                      <?php
                        $from = date('Y-m-d',strtotime($year.'-'.$month.'-1'));
                        $to = $year.'-'.$month.'-'.$days_in_month;
                        $profit = profit_amount($from,$to);
                        $capital = selling_price($from,$to);
                      ?>
                      <th class="w-5 text-center bg-red"><?php echo $language->get('label_total'); ?></th>
                      <th class="w-5 text-center"><?php echo currency_format($capital-$profit);?></th>
                      <th class="w-5 text-center"><?php echo currency_format($profit);?></th>
                    <?php foreach (get_income_sources(array('filter_type'=>'credit','filter_show_in_income'=>'yes')) as $source) :?>
                      <th class="w-5 text-center">
                        <?php echo get_total_source_income($source['source_id'], $from, $to) ? currency_format(get_total_source_income($source['source_id'], $from, $to)) : '-';?>
                      </th>
                    <?php endforeach; ?>
                      <th class="text-center bg-primary"><?php echo get_total_income($from, $to) ? currency_format(get_total_income($from, $to)) : '-';?></th>
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