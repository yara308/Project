<form id="form-transfer" class="form-horizontal" action="transfer.php" method="post">
  <input type="hidden" id="action_type" name="action_type" value="TRANSFER">  
  <div class="box-body">
    <div class="form-group">
      <label for="image" class="col-sm-3 control-label">
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
    <div class="form-group">
      <?php $ref_no = isset($transter['ref_no']) ? $transter['ref_no'] : null; ?>
      <label for="ref_no" class="col-sm-3 control-label">
          <?php echo trans('label_ref_no'); ?> 
      </label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="ref_no" value="<?php echo $ref_no; ?>" name="ref_no" <?php echo $ref_no ? 'readonly' : null; ?> autocomplete="off">
      </div>
    </div>
    <div class="form-group">
      <label for="status" class="col-sm-3 control-label">
        <?php echo trans('label_status'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7">
        <select id="status" class="form-control" name="status" >
          <option value="sent" selected><?php echo trans('text_sent'); ?></option>
          <option value="pending"><?php echo trans('text_pending'); ?></option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="note" class="col-sm-3 control-label">
        <?php echo trans('label_note'); ?>
      </label>
      <div class="col-sm-7">
        <textarea name="note" id="note" class="form-control"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="from_store_id" class="col-sm-3 control-label">
        <?php echo trans('label_from'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7">
        <p class="mt-5"><?php echo store('name');?></p>
        <input type="hidden" name="from_store_id" value="<?php echo store_id();?>">
      </div>
    </div>
    <div class="form-group">
      <label for="to_store_id" class="col-sm-3 control-label">
        <?php echo trans('label_to'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-7">
        <select id="to_store_id" class="form-control" name="to_store_id" >
          <option value="">
            <?php echo trans('text_select'); ?>
          </option>
          <?php foreach (get_stores() as $the_store) : ?>
            <option value="<?php echo $the_store['store_id'];?>">
              <?php echo $the_store['name']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="box-body">
      <div class="col-sm-6" style="padding:0;">
        <h4>
          <b><i><?php echo trans('text_stock_list'); ?></i></b>
        </h4>
        <div class="filter-searchbox">
            <input ng-model="search_list" class="form-control" type="text" placeholder="<?php echo trans('search'); ?>">
        </div>
        <div class="well well-sm product-well">
          <div>
            <div class="stock-item" ng-repeat="product in productsArray| filter:search_list" ng-click="addItemToTransferList(product.id, 1);" id="stock-item-{{ product.id }}" style="cursor:pointer;padding:5px 0;border-bottom: 1px dotted #ccc;:">
                -- {{ product.item_name }}, <?php echo trans('text_invoice_id'); ?>: {{ product.invoice_id}}, <?php echo trans('text_stock'); ?>: <span class="badge badge-info">{{ product.quantity }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <h4>
          <b><i><?php echo trans('text_transfer_list'); ?></i></b>
        </h4>
        <table style="margin-bottom:0;" class="table table-striped table-bordered mb0">
          <thead>
            <tr class="bg-gray">
              <th class="w-45 text-center" style="padding:8px;"><?php echo trans('label_item_name'); ?></th>
              <th class="w-25 text-center" style="padding:8px;"><?php echo trans('label_invoice_id'); ?></th>
              <th class="w-25 text-center" style="padding:8px;"><?php echo trans('label_transfer_qty'); ?></th>
              <th class="w-5 text-center" style="padding:8px;"><span class="fa fa-trash"></span></th>
            </tr>
          </thead>
        </table>
        <div class="well well-sm product-well" style="padding:0;margin-bottom:0;">
          <table class="table table-striped table-bordered table-condensed">
            <tbody>
                <tr class="info" ng-repeat="item in tItemArray">
                  <td class="w-45" style="">{{ item.item_name }} [{{ item.p_code }}] <small ng-show="item.has_variant">({{ item.item_variant_name }})</small>&nbsp;<i ng-show="item.has_variant" ng-click="SellOptionSelectorModal(item)" class="fa fa-fw fa-th-large pull-right pointer" style="margin-top:4px;" title="<?php echo trans('text_select_options');?>"></i>&nbsp;</td>
                  <td class="w-25 text-center">{{ item.invoice_id }}</td>
                  <td class="w-25 text-center">
                    <input id="id-{{ item.invoice_id }}" type="hidden" name="items[{{ item.id }}][invoice_id]" value="{{ item.invoice_id }}">
                    <input id="id-{{ item.id }}" type="hidden" name="items[{{ item.id }}][id]" value="{{ item.id }}">
                    <input name="items[{{ item.id }}][sup_id]" type="hidden" class="sup-id" value="{{ item.sup_id }}">
                    <input name="items[{{ item.id }}][variant_name]" type="hidden" class="variant-name" value="{{ item.item_variant_name }}">
                    <input name="items[{{ item.id }}][variant_slug]" type="hidden" class="variant-slug" value="{{ item.item_variant_slug }}">
                    <input id="quantity-{{ item.id }}" class="text-center quantity" type="text" name="items[{{ item.id }}][quantity]" value="{{ item.quantity }}" onClick="this.select();">
                  </td>
                  <td class="w-5 text-center text-red">
                    <span ng-click="removeItemFromList($index, item.id)" class="fa fa-close pointer"></span>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-4 col-sm-offset-3 text-center">            
        <button id="transfer-confirm-btn" class="btn btn-block btn-lg btn-info r-50" data-form="#form-transfer" data-datatable="#transter-transter-list" name="submit" data-loading-text="Processing...">
          <span class="fa fa-fw fa-car"></span><?php echo trans('button_transfer_now'); ?> &rarr;
        </button>
      </div>
      <div class="col-sm-3">
        <button type="reset" class="btn btn-warning btn-block" id="reset" name="reset">
          <span class="fa fa-circle-o"></span>
         <?php echo trans('button_reset'); ?></button>
      </div>
    </div>
  </div>
</form>