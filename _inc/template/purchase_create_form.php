<?php $invoice_id = isset($request->get['invoice_id']) && $request->get['invoice_id'] ? $request->get['invoice_id'] : '';?>
<form id="form-purchase" class="form-horizontal" action="purchase.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action_type" value="CREATE">
<input type="hidden" name="invoice_id" value="<?php echo $invoice_id;?>">
  <div class="box-body">
    <div class="form-group">
      <label for="date" class="col-sm-3 control-label">
        <?php echo trans('label_date'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <?php if ($invoice_id):?>
          <input type="text" class="form-control" name="date" value="<?php echo date('Y-m-d');?>" autocomplete="off" readonly>
        <?php else:?>
          <input type="text" class="form-control datepicker" name="date" autocomplete="off">
        <?php endif;?>
      </div>
    </div>
    <div class="form-group">
      <label for="reference_no" class="col-sm-3 control-label">
        <?php echo trans('label_reference_no'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <?php if ($invoice_id):?>
          <input type="text" class="form-control" id="reference_no" name="reference_no" autocomplete="off" readonly>
        <?php else:?>
          <input type="text" class="form-control" id="reference_no" name="reference_no" autocomplete="off">
        <?php endif;?>
      </div>
    </div>
    <div class="form-group">
      <label for="purchase-note" class="col-sm-3 control-label">
        <?php echo trans('label_note'); ?>
      </label>
      <div class="col-sm-6">
        <textarea id="purchase-note" class="form-control" name="purchase-note"></textarea>
      </div>
    </div>
    <div class="form-group hide">
      <label for="status" class="col-sm-3 control-label">
        <?php echo trans('label_status'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <select id="status" class="form-control" name="status" >
          <option value="received"><?php echo trans('text_received'); ?></option>
          <option value="pending"><?php echo trans('text_pending'); ?></option>
          <option value="ordered"><?php echo trans('text_ordered'); ?></option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="add_attachment" class="col-sm-3 control-label">
        <?php echo trans('label_attachment'); ?>
      </label>
      <div class="col-sm-7">
        <div class="preview-thumbnail">
          <a ng-click="POSFilemanagerModal({target:'image',thumb:'image_thumb'})" onClick="return false;" href="#" data-toggle="image" id="image_thumb">
            <img src="../assets/itsolution24/img/noimage.jpg">
          </a>
          <input type="hidden" name="image" id="image" value="">
        </div>
      </div>
    </div>
    <div class="well well-sm">
      <div class="form-group sup-id-selector">
        <label for="sup_id" class="col-sm-3 control-label">
          <?php echo trans('label_supplier'); ?><i class="required">*</i>
        </label>
        <div class="col-sm-6">
          <div class="input-group wide-tip">
            <div class="input-group-addon paddinglr-10">
              <i class="fa fa-user addIcon"></i>
            </div>
            <select id="sup_id" class="form-control select2" name="sup_id">
              <option value=""><?php echo trans('text_select'); ?></option>
              <?php foreach (get_suppliers() as $sup) : ?>
                <option value="<?php echo $sup['sup_id'];?>">
                  <?php echo $sup['sup_name'];?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-addon paddinglr-10">
              <a href="supplier.php?box_state=open" target="_blink">
                <i style="font-size:20px;" class="fa fa-plus-circle addIcon p-0" id="addIcon"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="image" class="col-sm-3 control-label">
          <?php echo trans('label_add_product'); ?>
        </label>
        <div class="col-sm-6">
          <div class="input-group wide-tip">
            <div class="input-group-addon paddinglr-10">
              <i class="fa fa-barcode addIcon fa-2x"></i>
            </div>
            <input type="text" name="add_item" value="" class="form-control input-lg autocomplete-product" id="add_item" data-type="p_name" onkeypress="return event.keyCode != 13;" onclick="this.select();" placeholder="<?php echo trans('placeholder_search_product'); ?>" autocomplete="off" tabindex="1">
            <div class="input-group-addon paddinglr-10">
              <a href="product.php?box_state=open" target="_blink">
                <i class="fa fa-plus-circle addIcon fa-2x" id="addIcon"></i>
              </a>
            </div>
          </div>
        </div>  
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table id="product-table" class="table table-striped table-bordered mb-0">
              <thead>
                <tr class="bg-info">
                  <th class="w-35 text-center">
                    <?php echo trans('label_product'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_global_stock'); ?>
                  </th>
                  <?php if ($invoice_id):?>
                    <th class="w-10 text-center">
                      <?php echo trans('label_status'); ?>
                    </th>
                    <th class="w-10 text-center">
                      <?php echo trans('label_sold'); ?>
                    </th>
                  <?php endif;?>
                  <th class="w-10 text-center">
                    <?php echo trans('label_quantity'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_cost_price'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_sell_price'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_item_tax'); ?>
                  </th>
                  <th class="w-10 text-center">
                    <?php echo trans('label_item_total'); ?>
                  </th>
                  <th class="w-5 text-center">
                    <i class="fa fa-trash-o"></i>
                  </th>
                </tr>
              </thead>
              <tbody> 
                <tr ng-show="!totalQuantity" class="danger empty">
                  <td class="text-center" colspan="<?php echo $invoice_id ? 10 : 8;?>"><?php echo trans('text_item_list_empty');?></td>
                </tr>
                <tr ng-repeat="item in itemArray">
                  <td class="text-center" style="min-width:100px;" data-title="<?php echo trans('label_item_name');?>">
                    <input name="products[{{ item.id }}][item_id]" type="hidden" class="item-id" value="{{ item.id }}">
                    <input name="products[{{ item.id }}][variant_name]" type="hidden" class="variant-name" value="{{ item.variantName }}">
                    <input name="products[{{ item.id }}][variant_slug]" type="hidden" class="variant-slug" value="{{ item.variantSlug }}">
                    <input name="products[{{ item.id }}][item_id]" type="hidden" class="item-id" value="{{ item.id }}">
                    <input name="products[{{ item.id }}][item_name]" type="hidden" class="item-name" value="{{ item.name }}">
                    <input name="products[{{ item.id }}][category_id]" type="hidden" class="categoryid" value="{{ item.categoryId }}">
                    <span class="name" id="name-{{ item.id }}">{{ item.name }} [{{ item.code }}] <small ng-show="item.hasVariant">({{ item.variantName }})</small>&nbsp;<i ng-show="{{ item.hasVariant }}" ng-click="PurchaseOptionSelectorModal(item)" class="fa fa-fw fa-th-large pull-right pointer" style="margin-top:4px;" title="<?php echo trans('text_select_options');?>"></i>&nbsp;</span>
                  </td>
                  <td class="text-center" data-title="<?php echo trans('label_stock');?>">
                    <span class="text-center stock" id="stock-{{ item.id }}">{{ item.available | formatDecimal:2 }}</span>
                  </td>
                  <?php if ($invoice_id):?>
                    <td class="text-center" data-title="<?php echo trans('label_status');?>">
                      <span class="text-center status" id="status-{{ item.id }}">{{ item.status }}</span>
                    </td>
                    <td class="text-center" data-title="<?php echo trans('label_sold');?>">
                      <span class="text-center sold" id="sold-{{ item.id }}">{{ item.sold | formatDecimal:2 }}</span>
                    </td>
                  <?php endif;?>
                  <td style="padding:2px;position:relative;" data-title="<?php echo trans('label_quantity');?>">
                    <input ng-show="item.status !== 'sold'" class="form-control input-sm text-center quantity" name="products[{{ item.id }}][quantity]" type="text" value="{{ item.quantity }}" data-itemid="{{ item.id }}" id="quantity-{{ item.id }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}" data-toggle="tooltip" title="" data-original-title="<?php echo trans('label_min_quantity');?> {{ item.sold || 1 | formatDecimal:2 }}"> <div style="position:absolute;top:8px;right:8px;"><span ng-show="item.status == 'sold'">{{ item.quantity }} </span><small>{{ item.unitName }}</small></div>
                  </td>
                  <td class="text-right" style="padding:2px; min-width:80px;" data-title="<?php echo trans('label_purchase_price');?>">
                    <input ng-show="item.status !== 'sold'" id="purchase-price-{{ item.id }}" class="form-control input-sm text-center purchase-price" type="text" name="products[{{ item.id }}][purchase_price]" value="{{ item.purchasePrice }}" data-itemid="{{ item.id }}" data-item="{{ item.id }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                    <span ng-show="item.status == 'sold'">{{ item.purchasePrice }}</span>
                  </td>
                  <td class="text-right" style="padding:2px;min-width:80px;" data-title="<?php echo trans('label_sell_price');?>">
                    <input ng-show="item.status !== 'sold'" id="sell-price-{{ item.id }}" class="form-control input-sm text-center sell-price" type="text" name="products[{{ item.id }}][sell_price]" value="{{ item.sellPrice }}" data-itemid="{{ item.id }}" data-item="{{ item.id }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                    <span ng-show="item.status == 'sold'">{{ item.sellPrice }}</span>
                  </td>
                  <td class="text-center" data-title="<?php echo trans('label_tax_amount');?>">
                    <input id="tax-method-{{ item.id }}" name="products[{{ item.id }}][tax_method]" type="hidden" value="{{ item.taxMethod }}">
                    <input id="taxrate-{{ item.id }}" name="products[{{ item.id }}][taxrate]" type="hidden" value="{{ item.taxrate }}">
                    <input id="item-tax-amount-{{ item.id }}" name="products[{{ item.id }}][tax_amount]" type="hidden" value="{{ item.itemTaxAmount }}">
                    <span id="item-tax-amount-view-{{ item.id }}" class="tax tax-amount-view">{{ item.itemTaxAmount | formatDecimal:2 }}</span>
                  </td>
                  <td class="text-right" data-title="<?php echo trans('label_sub_total');?>">
                    <span class="subtotal" id="subtotal-{{ item.id }}">{{ item.subTotal | formatDecimal:2 }}</span>
                  </td>    
                  <td class="text-center">
                    <i ng-click="removeItemFromInvoice($index,item.id);" class="fa fa-close text-red pointer xremove" data-itemid="{{ item.id }}" title="<?php echo trans('text_remove');?>"></i>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <?php $col_length = $invoice_id ? 8 : 6;?>
                <tr class="bg-gray">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_subtotal'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input id="total-item-tax" type="hidden" name="total-item-tax" value="{{ totalItemTaxAmount }}">
                    <input id="total-amount" type="hidden" name="total-amount" value="{{ totalAmount }}">
                    <span id="total-amount-view">{{ totalAmount | formatDecimal:2 }}</span>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_order_tax');?> (%)
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addOrderTax();" id="order-tax-amount" class="text-right p-5" type="taxt" name="order-tax-amount" ng-model="orderTaxInput" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_shipping_charge'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addShippingAmount();" id="shipping-amount" class="text-right p-5" type="taxt" name="shipping-amount" ng-model="shippingInput" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_others_charge'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addOthersCharge();" id="others-charge" class="text-right p-5" type="taxt" name="others-charge" ng-model="othersChargeInput" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_discount_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addDiscountAmount();" id="discount-input" class="text-right p-5" type="taxt" name="discount-amount" ng-model="discountInput" onclick="this.select();" ondrop="return false;" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-warning">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_payable_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input type="hidden" name="payable-amount" value="{{ totalPayable }}">
                    <h4 class="text-center"><b>{{ totalPayable | formatDecimal:2 }}</b></h4>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-info">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_payment_method'); ?>
                  </th>
                  <th class="col-sm-2 text-center">
                    <select id="pmethod-id" class="form-control select2" name="pmethod-id">
                      <?php foreach (get_pmethods() as $pmethod):?>
                        <option value="<?php echo $pmethod['pmethod_id'];?>"><?php echo $pmethod['name'];?></option>
                      <?php endforeach;?>
                    </select>
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-info">
                  <th class="text-right" colspan="<?php echo $col_length;?>">
                    <?php echo trans('label_paid_amount'); ?>
                  </th>
                  <th class="col-sm-2 text-right">
                    <input ng-change="addPaidAmount();" id="paid-amount" class="text-center paidAmount" type="taxt" name="paid-amount" ng-model="paidAmount" onclick="this.select();" ondrop="return false;" onkeypress="return IsNumeric(event);" onpaste="return false;" autocomplete="off">
                  </th>
                  <th class="w-25p">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th colspan="2" class="w-10 text-right">
                    <?php echo trans('label_due_amount'); ?>
                  </th>
                  <th colspan="4" class="w-70 bg-danger text-center">
                    <input type="hidden" name="due-amount" value="{{ dueAmount }}">
                    <span>{{ dueAmount | formatDecimal:2 }}</span>
                  </th>
                  <th colspan="2">&nbsp;</th>
                </tr>
                <tr class="bg-gray">
                  <th colspan="2" class="w-10 text-right">
                    <?php echo trans('label_change_amount'); ?>
                  </th>
                  <th colspan="4" class="w-70 bg-info text-center">
                    <input type="hidden" name="change-amount" value="{{ changeAmount }}">
                    <span>{{ changeAmount | formatDecimal:2 }}</span>
                  </th>
                  <th colspan="2">&nbsp;</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <?php if ($invoice_id):?>
        <div class="col-sm-4 col-sm-offset-4">
          <button id="create-purchase-submit" class="btn btn-block btn-lg btn-success" data-form="#form-purchase" data-datatable="#purchase-purchase-list" name="submit" data-loading-text="Processing...">
            <i class="fa fa-fw fa-edit"></i>
            <?php echo trans('button_update'); ?>
          </button>
        </div>
      <?php else:?>
        <!-- <div class="col-sm-2 col-sm-offset-2 text-center">            
          <button id="create-order-submit" class="btn btn-block btn-lg btn-info" data-form="#form-purchase" data-datatable="#purchase-purchase-list" name="submit" data-loading-text="Processing...">
            <i class="fa fa-fw fa-gavel"></i>
            <?php //echo trans('button_order'); ?>
          </button>
        </div> -->
        <div class="col-sm-4 col-sm-offset-3 text-center">            
          <button id="create-purchase-submit" class="btn btn-block btn-lg btn-success" data-form="#form-purchase" data-datatable="#purchase-purchase-list" name="submit" data-loading-text="Processing...">
            <i class="fa fa-fw fa-check"></i>
            <?php echo trans('button_received_and_pay'); ?>
          </button>
        </div>
        <div class="col-sm-2 text-center">            
          <button type="reset" class="btn btn-block btn-lg btn-danger" id="reset" name="reset">
            <span class="fa fa-fw fa-circle-o"></span>
            <?php echo trans('button_reset'); ?>
          </button>
        </div>
      <?php endif;?>
    </div>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
  $(".datepicker").datepicker({
    language: langCode,
    format: "yyyy-mm-dd",
    autoclose:true,
    todayHighlight: true
  }).datepicker("setDate","now");
});
</script>