<?php $hide_colums = "";?> 
<div class="table-responsive" ng-controller="ReportStockController">
  <table id="report_stock" class="table table-striped" data-hide-colums="<?php echo $hide_colums; ?>">
    <thead>
      <tr class="bg-gray">
        <th class="w-5">#</th>
        <th class="w-20">
          <?php echo trans('label_name'); ?>
        </th>
        <th class="w-10">
          <?php echo trans('label_store'); ?>
        </th>
        <th class="w-25">
          <?php echo trans('label_stock'); ?>
        </th>
        <th class="w-20">
          <?php echo trans('label_sell_price'); ?>
        </th>
        <th class="w-20">
          <?php echo trans('label_purchase_price'); ?>
        </th>
      </tr>
    </thead>
    <tfoot>
      <tr class="bg-gray">
        <th class="w-5">#</th>
        <th class="w-20">
          <?php echo trans('label_name'); ?>
        </th>
        <th class="w-10">
          <?php echo trans('label_store'); ?>
        </th>
        <th class="w-25">
          <?php echo trans('label_stock'); ?>
        </th>
        <th class="w-20">
          <?php echo trans('label_sell_price'); ?>
        </th>
        <th class="w-20">
          <?php echo trans('label_purchase_price'); ?>
        </th>
      </tr>
    </tfoot>
  </table>
</div>