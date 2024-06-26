<h4 class="sub-title">
  <?php echo trans('text_update_title'); ?>
</h4>
<form id="currency-form" class="form-horizontal" action="currency.php" method="post" enctype="multipart/form-data">
  <input type="hidden" id="action_type" name="action_type" value="UPDATE">
  <input type="hidden" id="currency_id" name="currency_id" value="<?php echo $currency['currency_id']; ?>">
  <div class="box-body">
    <div class="form-group">
      <label for="title" class="col-sm-4 control-label">
        <?php echo trans('label_currency_name'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($currency['title']) ? $currency['title'] : null; ?>" ng-init="currencyTitle='<?php echo $currency['title']; ?>'" ng-model="currencyTitle">
      </div>
    </div>

    <div class="form-group">
      <label for="code" class="col-sm-4 control-label">
        <?php echo sprintf(trans('label_code'), null); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="code" name="code"  value="<?php echo $currency['code'] ? $currency['code'] : "{{ currencyTitle | strReplace:' ':'_' | lowercase }}"; ?>">
      </div>
    </div>

    <div class="form-group">
      <label for="value" class="col-sm-4 control-label">
        <?php echo trans('label_value'); ?><i class="required">*</i>
        <span data-toggle="tooltip" title="" data-original-title="<?php echo trans('hint_currency_value'); ?>"></span>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="value" value="<?php echo $currency['value']; ?>" name="value" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}" required>
      </div>
    </div>

    <div class="form-group">
      <label for="symbol_left" class="col-sm-4 control-label">
        <?php echo trans('label_symbol_left'); ?>
        <span data-toggle="tooltip" title="" data-original-title="<?php echo trans('hint_symbol_left'); ?>"></span>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="symbol_left" value="<?php echo isset($currency['symbol_left']) ? $currency['symbol_left'] : null; ?>" placeholder="Please type left symbol" name="symbol_left">
      </div>
    </div>

    <div class="form-group">
      <label for="symbol_right" class="col-sm-4 control-label">
        <?php echo trans('label_symbol_right'); ?>
        <span data-toggle="tooltip" title="" data-original-title="<?php echo trans('hint_symbol_right'); ?>"></span>
      </label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="symbol_right" value="<?php echo isset($currency['symbol_right']) ? $currency['symbol_right'] : null; ?>" placeholder="Please type right symbol" name="symbol_right">
      </div>
    </div>

    <div class="form-group">
      <label for="decimal_place" class="col-sm-4 control-label">
        <?php echo trans('label_decimal_place'); ?><i class="required">*</i>
        <span data-toggle="tooltip" title="" data-original-title="<?php echo trans('hint_decimal_place'); ?>"></span>    
      </label>
      <div class="col-sm-6">
        <input type="number" class="form-control" id="decimal_place" value="<?php echo isset($currency['decimal_place']) ? $currency['decimal_place'] : null; ?>" placeholder="Please type decimal place" name="decimal_place" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label">
        <?php echo trans('label_store'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6 store-selector">
        <div class="checkbox selector">
          <label>
            <input type="checkbox" onclick="$('input[name*=\'currency_store\']').prop('checked', this.checked);"> Select / Deselect
          </label>
        </div>
        <div class="filter-searchbox">
          <input ng-model="search_store" class="form-control" type="text" id="search_store" placeholder="<?php echo trans('search'); ?>">
        </div>
        <div class="well well-sm store-well">
          <div filter-list="search_store">
            <?php foreach(get_stores() as $the_store) : ?>                    
              <div class="checkbox">
                <label>                         
                  <input type="checkbox" name="currency_store[]" value="<?php echo $the_store['store_id']; ?>" <?php echo in_array($the_store['store_id'], $currency['stores']) ? 'checked' : null; ?>>
                  <?php echo $the_store['name']; ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="status" class="col-sm-4 control-label">
        <?php echo trans('label_status'); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <select id="status" class="form-control" name="status" >
          <option <?php echo isset($currency['status']) && $currency['status'] == '1' ? 'selected' : null; ?> value="1">
            <?php echo trans('text_active'); ?>
          </option>
          <option <?php echo isset($currency['status']) && $currency['status'] == '0' ? 'selected' : null; ?> value="0">
            <?php echo trans('text_in_active'); ?>
          </option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="sort_order" class="col-sm-4 control-label">
        <?php echo sprintf(trans('label_sort_order'), null); ?><i class="required">*</i>
      </label>
      <div class="col-sm-6">
        <input type="number" class="form-control" id="sort_order" value="<?php echo $currency['sort_order']; ?>" name="sort_order">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label"></label>
      <div class="col-sm-6">
          <button id="currency-update" class="btn btn-info"  data-form="#currency-form" data-datatable="#currency-currency-list" name="btn_edit_customer" data-loading-text="Updating...">
            <i class="fa fa-fw fa-pencil"></i> 
            <?php echo trans('button_update'); ?>
          </button>
      </div>
    </div>

  </div>
</form>