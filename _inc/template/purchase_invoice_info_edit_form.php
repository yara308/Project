<h4 class="sub-title">
  <?php echo trans('text_update_title'); ?>
</h4>
<form class="form-horizontal" id="invoice-form" action="purchase.php" method="post">
  <input type="hidden" id="action_type" name="action_type" value="UPDATEINVOICEINFO">
  <input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo $invoice['invoice_id']; ?>">
  <div class="box-body">
      <div class="form-group">
        <label for="purchase_note" class="col-sm-3 control-label">
          <?php echo trans('label_purchase_note'); ?>
        </label>
        <div class="col-sm-7">
          <textarea class="form-control no-resize" id="purchase_note" name="purchase_note"><?php echo $invoice['purchase_note']; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <h4 class="text-center">
            <?php echo trans('label_invoice_items'); ?>
          </h4>
        </div>
        <div class="col-sm-12">
          <table class="table table-bordered table-ondensed">
            <thead>
              <tr class="bg-gray">
                <th class="w-5 text-center"><?php echo trans('label_sl');?></th>
                <th class="w-35 text-center"><?php echo trans('label_item_name');?></th>
                <th class="w-15 text-center"><?php echo trans('label_qty_ordered');?></th>
                <th class="w-15 text-center"><?php echo trans('label_qty_received');?></th>
                <th class="w-15 text-center"><?php echo trans('label_qty_pending');?></th>
                <th class="w-15 text-center"><?php echo trans('label_receive');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $inc=0;foreach ($items as $item):?>
                <tr>
                  <td class="text-center"><?php echo $inc+1;?></td>
                  <td class="text-center"><?php echo $item['item_name'];?><?php echo $item['item_variant_name'] ? ' ('.$item['item_variant_name'].')' : null;?></td>
                  <td class="text-center"><?php echo currency_format($item['item_ordered']);?></td>
                  <td class="text-center"><?php echo currency_format($item['item_quantity']);?></td>
                  <td class="text-center"><?php 
                    $pending = $item['item_ordered']-$item['item_quantity'];
                    echo currency_format($pending);?>
                  </td>
                  <td class="text-center">
                    <?php if ($pending > 0):?>
                    <input class="text-center form-control" type="text" name="items[<?php echo $item['item_id'];?>][receive]" value="0" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                    <?php else:?>
                      <span class="fa fa-check text-green"></span>
                    <?php endif;?>
                  </td>
                </tr>
              <?php $inc++;endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-7">
          <button id="invoice-update" data-form="#invoice-form" data-datatable="#invoice-invoice-list" class="btn btn-block btn-info" name="btn_edit_invoice" data-loading-text="Updating...">
            <span class="fa fa-fw fa-pencil"></span>
            <?php echo trans('button_update'); ?>
          </button>
        </div>
      </div>
  </div>
</form>