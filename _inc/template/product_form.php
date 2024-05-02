<h4 class="sub-title">
  <?php echo trans('text_update_title'); ?>
</h4>
<?php $tab_active = isset($request->get['tab']) ? $request->get['tab'] : 'general';?>
<style type="text/css">
.image-thumbnail {
  position: relative;
  width: 80px;
  height: 75px;
  overflow: hidden;
  display: inline-block;
}
.image-thumbnail img {
    position: relative;
    width: 100%;
    height: auto;
    max-height: 100%;
}
</style>
<form id="product-update-form" class="form-horizontal" action="product.php" method="post">
  <input type="hidden" id="action_type" name="action_type" value="UPDATE">
  <input type="hidden" id="p_id" name="p_id" value="<?php echo $product['p_id']; ?>">
  <div class="xbox-body">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="<?php echo $tab_active == 'general' ? 'active' : null;?>">
            <a href="#general" data-toggle="tab" aria-expanded="false">
            <?php echo trans('text_general'); ?>
          </a>
        </li>
        <li class="<?php echo $tab_active == 'variant' ? 'active' : null;?>">
            <a href="#variant" data-toggle="tab" aria-expanded="false">
            <?php echo trans('text_variants'); ?>
          </a>
        </li>
        <li class="<?php echo $tab_active == 'promotional_price' ? 'active' : null;?>">
            <a href="#promotional_price" data-toggle="tab" aria-expanded="false">
            <?php echo trans('text_promotional_price'); ?>
          </a>
        </li>
        <li class="<?php echo $tab_active == 'image' ? 'active' : null;?>">
            <a href="#image" data-toggle="tab" aria-expanded="false">
            <?php echo trans('text_images'); ?>
          </a>
        </li>
      </ul>
      <div class="tab-content">

        <!-- Promotional Price Start -->
        <div class="tab-pane<?php echo $tab_active == 'promotional_price' ? ' active' : null;?>" id="promotional_price">

          <div class="form-group">
            <label for="has_promotional_price" class="col-sm-3 control-label">
              <?php echo trans('label_has_promotional_price'); ?>
            </label>
            <div class="col-sm-6">
              <div class="checkbox">
                  <input type="checkbox" id="has_promotional_price" value="1" name="has_promotional_price" <?php echo $product['has_promotional_price'] ? 'checked' : null;?> ng-init="hasPromotionalPrice=<?php echo $product['has_promotional_price'] ? '1' : '0';?>">
              </div>
            </div>
          </div>
          <div ng-show="hasPromotionalPrice" class="row">
            <div class="col-md-6 col-md-offset-3">
              <table class="table table-bordered table-condenced table-striped">
                <thead>
                  <tr>
                    <td class="w-50 text-right bg-gray">Sell Price:</td>
                    <td class="w-50"><?php echo currency_format($product['sell_price']);?>
                  </tr>
                  <tr>
                    <td class="w-50 text-right bg-gray">Purchase Price:</td>
                    <td class="w-50"><?php echo currency_format($product['purchase_price']);?></td>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <table ng-show="hasPromotionalPrice" class="table table-bordered table-condenced table-striped">
            <thead>
              <tr class="bg-gray">
                <td class="w-10 text-center"><?php echo trans('label_serial_no');?></td>
                <td class="w-30 text-center"><?php echo trans('label_promotional_price');?></td>
                <td class="w-20 text-center"><?php echo trans('label_start_date');?></td>
                <td class="w-20 text-center"><?php echo trans('label_end_date');?></td>
                <td class="w-10 text-center"><?php echo trans('label_sort_order');?></td>
                <td class="w-10 text-center"><?php echo trans('label_action');?></td>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="promotional_price in promotionalPriceArray" id="{{ $index }}" class="promotional_price-item">
                <td class="text-center">{{ promotional_price.id }}</td>
                <td class="text-center">
                  <input class="form-control text-center" type="text" name="promotional_price[{{promotional_price.id}}][promotional_price]" id="promotional_price{{promotional_price.id}}" value="{{ promotional_price.promotional_price }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                </td>
                <td class="text-center">
                  <input class="form-control text-center date" type="text" name="promotional_price[{{promotional_price.id}}][start_date]" id="promotional_price{{promotional_price.start_date}}" value="{{ promotional_price.start_date }}" ondrop="return false;" onpaste="return false;">
                </td>
                <td class="text-center">
                  <input class="form-control text-center date" type="text" name="promotional_price[{{promotional_price.id}}][end_date]" id="promotional_price{{promotional_price.end_date}}" value="{{ promotional_price.end_date }}" ondrop="return false;" onpaste="return false;">
                </td>
                <td class="text-center">
                  <input type="text" name="promotional_price[{{promotional_price.id}}][sort_order]" class="form-control sort_order text-center" value="{{ promotional_price.sort_order | formatDate:2 }}" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                </td>
                <td class="text-center pointer remove-promotional_price">
                  <span ng-click="remotePromotionalPriceItem($index)" class="fa fa-fw fa-close text-red"></span>
                </td>
              </tr>
              <tr>
                <td ng-click="addPromotionalPriceItem(promotionalPriceSerial);" colspan="6" class="text-center bg-info add-promotional_price-row pointer">
                  <span class="fa fa-fw fa-plus text-white"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Promotional Price End -->

        <!-- Variant Start -->
        <div class="tab-pane<?php echo $tab_active == 'variant' ? ' active' : null;?>" id="variant">

          <div class="form-group">
            <label for="has_variant" class="col-sm-2 control-label">
              <?php echo trans('label_has_variant'); ?>
            </label>
            <div class="col-sm-6">
              <div class="checkbox">
                  <input type="checkbox" id="has_variant" value="1" name="has_variant" <?php echo $product['has_variant'] ? 'checked' : null;?> ng-init="hasVariant=<?php echo $product['has_variant'] ? '1' : '0';?>">
              </div>
            </div>
          </div>

          <div ng-show="hasVariant" class="row">
            <div class="col-md-6 col-md-offset-3">
              <table class="table table-bordered table-condenced table-striped">
                <thead>
                  <tr>
                    <td class="w-50 text-right bg-gray">Sell Price:</td>
                    <td class="w-50"><?php echo currency_format($product['sell_price']);?>
                  </tr>
                  <tr>
                    <td class="w-50 text-right bg-gray">Purchase Price:</td>
                    <td class="w-50"><?php echo currency_format($product['purchase_price']);?></td>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <table ng-show="hasVariant" class="table table-bordered table-condenced table-striped">
            <thead>
              <tr class="bg-gray">
                <td class="w-10 text-center"><?php echo trans('label_serial_no');?></td>
                <td class="w-30 text-center"><?php echo trans('label_variant_name');?></td>
                <td class="w-20 text-center"><?php echo trans('label_purchase_price_addition');?></td>
                <td class="w-20 text-center"><?php echo trans('label_sell_price_addition');?></td>
                <td class="w-10 text-center"><?php echo trans('label_sort_order');?></td>
                <td class="w-10 text-center"><?php echo trans('label_action');?></td>
              </tr>
            </thead>
            <tbody>
               <tr ng-repeat="variant in variantArray" id="{{ $index }}" class="variant-item">
                <td class="text-center">{{ variant.id }}</td>
                <td class="text-center">
                  <input class="form-control text-center" type="text" name="variant[{{variant.id}}][name]" id="variant{{variant.id}}" value="{{ variant.name }}">
                </td>
                <td class="text-center">
                  <input class="form-control text-center" type="text" name="variant[{{variant.id}}][purchase_price_addition]" id="variant{{variant.purchase_price_addition}}" value="{{ variant.purchase_price_addition }}">
                </td>
                <td class="text-center">
                  <input class="form-control text-center" type="text" name="variant[{{variant.id}}][sell_price_addition]" id="variant{{variant.sell_price_addition}}" value="{{ variant.sell_price_addition }}">
                </td>
                <td class="text-center">
                  <input type="text" name="variant[{{variant.id}}][sort_order]" class="form-control sort_order text-center" value="{{ variant.sort_order }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                </td>
                <td class="text-center pointer remove-variant">
                  <span ng-click="remoteVariantItem($index)" class="fa fa-fw fa-close text-red"></span>
                </td>
              </tr>
              <tr>
                <td ng-click="addVariantItem(variantSerial);" colspan="6" class="text-center bg-info add-variant-row pointer">
                  <span class="fa fa-fw fa-plus text-white"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Variant End -->

        <!-- Image Start -->
        <div class="tab-pane<?php echo $tab_active == 'image' ? ' active' : null;?>" id="image">
          <table class="table table-bordered table-condenced table-striped">
            <thead>
              <tr class="bg-gray">
                <td class="w-10 text-center"><?php echo trans('label_serial_no');?></td>
                <td class="w-20 text-center"><?php echo trans('label_image');?></td>
                <td class="w-40"><?php echo trans('label_url');?></td>
                <td class="w-20 text-center"><?php echo trans('label_sort_order');?></td>
                <td class="w-10 text-center"><?php echo trans('label_action');?></td>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="img in imgArray" id="{{ $index }}" class="image-item">
                <td class="text-center">{{ img.id }}</td>
                <td class="text-center">
                  <div class="image-thumbnail">
                    <a class="open-filemanager" data-imageid="{{img.id}}" data-toggle="image" id="thumb{{img.id}}" href="#">
                      <img ng-show="img.url" ng-src="<?php echo FILEMANAGERURL;?>{{ img.url }}">
                      <img ng-show="!img.url" src="../assets/itsolution24/img/noimage.jpg">
                    </a>
                  </div>
                </td>
                <td>
                  <input class="form-control" type="text" name="image[{{img.id}}][url]" id="image{{img.id}}" value="{{ img.url }}" autocomplete="off" readonly>
                </td>
                <td>
                  <input type="text" name="image[{{img.id}}][sort_order]" class="form-control sort_order text-center" value="{{ img.sort_order }}" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}">
                </td>
                <td class="text-center pointer remove-image">
                  <span ng-click="remoteImageItem($index)" class="fa fa-fw fa-close text-red"></span>
                </td>
              </tr>
              <tr>
                <td ng-click="addImageItem(imgSerial);" colspan="5" class="text-center bg-info add-image-row pointer">
                  <span class="fa fa-fw fa-plus text-white"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Image End -->


        <!-- General Start -->
        <div class="tab-pane<?php echo $tab_active == 'general' ? ' active' : null;?>" id="general">

          <div class="form-group">
            <label class="col-sm-3 control-label">
              <?php echo trans('label_thumbnail'); ?>
            </label>
            <div class="col-sm-2">
              <div class="preview-thumbnail">
                <a ng-click="POSFilemanagerModal({target:'product_image',thumb:'product_thumbnail'})" onClick="return false;" href="" data-toggle="image" id="product_thumbnail">
                  <?php if (isset($product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$product['p_image']) && file_exists(FILEMANAGERPATH.$product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $product['p_image']) && file_exists(DIR_STORAGE . 'products' . $product['p_image'])))) : ?>
                    <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $product['p_image']; ?>">
                  <?php else : ?>
                    <img src="../assets/itsolution24/img/noimage.jpg">
                  <?php endif; ?>
                </a>
                <input type="hidden" name="p_image" id="product_image" value="<?php echo isset($product['p_image']) ? $product['p_image'] : null; ?>">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="p_type" class="col-sm-3 control-label">
              <?php echo trans('label_product_type'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select id="p_type" class="form-control" name="p_type" >
                <option value="standard" <?php echo $product['p_type'] == 'standard' ? 'selected' : null; ?>><?php echo trans('text_standard'); ?></option>
                <option value="service" <?php echo $product['p_type'] == 'service' ? 'selected' : null; ?>><?php echo trans('text_service'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="p_name" class="col-sm-3 control-label">
              <?php echo sprintf(trans('label_name'),null); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="p_name" name="p_name" value="<?php echo $product['p_name']; ?>" required>
            </div>
          </div>

          <div class="form-group all">
            <label for="p_code" class="col-sm-3 control-label">
              <?php echo trans('label_pcode'); ?> <i class="required">*</i>
            </label>             
            <div class="col-sm-8">           
              <input type="text" name="p_code" value="<?php echo $product['p_code']; ?>" class="form-control" id="p_code" required>
            </div>
          </div>

          <div class="form-group">
            <label for="category_id" class="col-sm-3 control-label">
              <?php echo trans('label_category'); ?>
            </label>
            <div class="col-sm-8">
              <select class="form-control select2" name="category_id" required>
                <option value="">
                  <?php echo trans('text_select'); ?>
                </option>
                <?php foreach (get_category_tree(array('filter_fetch_all' => true)) as $category_id => $category_name) { ?>
                    <?php if($product['category_id'] == $category_id) : ?>
                      <option value="<?php echo $category_id; ?>" selected><?php echo $category_name ; ?></option>
                    <?php else: ?>
                      <option value="<?php echo $category_id; ?>"><?php echo $category_name ; ?></option>
                    <?php endif; ?>
                <?php } ?>
             </select>
            </div>
          </div>

          <!-- <div ng-hide="hideSupplier" class="form-group">
            <label for="sup_id" class="col-sm-3 control-label">
              <?php echo trans('label_supplier'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="sup_id" required>
                <option value="">
                  <?php echo trans('text_select'); ?>
                </option>
                <?php foreach(get_suppliers() as $supplier) {
                    if($supplier['sup_id'] == $product['sup_id']) { ?>
                      <option value="<?php echo $supplier['sup_id']; ?>" selected>
                        <?php echo $supplier['sup_name']; ?>
                      </option>
                    <?php } else { ?>
                      <option value="<?php echo $supplier['sup_id']; ?>">
                        <?php echo $supplier['sup_name']; ?>
                      </option>
                    <?php }}?>
              </select>
            </div>
          </div> -->

          <div ng-hide="hideBrand" class="form-group">
            <label for="brand_id" class="col-sm-3 control-label">
              <?php echo trans('label_brand'); ?>
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="brand_id" required>
                <option value="">
                  <?php echo trans('text_select'); ?>
                </option>
                <?php foreach(get_brands() as $brand) {
                    if($brand['brand_id'] == $product['brand_id']) { ?>
                      <option value="<?php echo $brand['brand_id']; ?>" selected>
                        <?php echo $brand['brand_name']; ?>
                      </option>
                    <?php
                    } else { ?>
                      <option value="<?php echo $brand['brand_id']; ?>">
                        <?php echo $brand['brand_name']; ?>
                      </option>
                    <?php
                    }
                  }
                ?>
              </select>
            </div>
          </div>

          <div ng-hide="hideGenderFor" class="form-group">
            <label for="gender_for" class="col-sm-3 control-label">
              <?php echo trans('label_gender_for'); ?>
            </label>
            <div class="col-sm-8">
              <select id="gender_for" class="form-control" name="gender_for" required>
                <option value="">
                  <?php echo trans('text_select'); ?>
                </option>
                <?php foreach (get_gender_types() as $key => $gender) : ?>
                  <!-- <option value="<?php echo $key; ?>">
                    <?php echo $gender; ?>
                  </option> -->
                  <?php if($key == $product['gender_for']) { ?>
                      <option value="<?php echo $key; ?>" selected>
                        <?php echo $gender; ?>
                      </option>
                    <?php
                    } else { ?>
                      <option value="<?php echo $key ?>">
                        <?php echo $gender; ?>
                      </option>
                    <?php }?>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="barcode_symbology" class="col-sm-3 control-label">
              <?php echo trans('label_barcode_symbology'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select id="barcode_symbology" class="form-control select2" name="barcode_symbology">
                <option value="code25" <?php echo  $product['barcode_symbology'] == 'code25' ? 'selected' : null;?>>code25</option>
                <option value="code39" <?php echo  $product['barcode_symbology'] == 'code39' ? 'selected' : null;?>>code39</option>
                <option value="code128" <?php echo  $product['barcode_symbology'] == 'code128' ? 'selected' : null;?>>code128</option>
                <option value="ean5" <?php echo  $product['barcode_symbology'] == 'ean5' ? 'selected' : null;?>>ean5</option>
                <option value="ean13" <?php echo  $product['barcode_symbology'] == 'ean13' ? 'selected' : null;?>>ean13</option>
                <option value="upca" <?php echo  $product['barcode_symbology'] == 'upca' ? 'selected' : null;?>>upca</option>
                <option value="upce" <?php echo  $product['barcode_symbology'] == 'upce' ? 'selected' : null;?>>upce</option>
              </select>
            </div>
          </div>

          <div ng-hide="hideBox" class="form-group">
            <label for="box_id" class="col-sm-3 control-label">
              <?php echo trans('label_box'); ?>
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="box_id" required>
                  <option value="">
                    <?php echo trans('text_select'); ?>
                  </option>
                  <?php foreach(get_boxes() as $box_row) {
                      if($box_row['box_id'] == $product['box_id']) { ?>
                        <option value="<?php echo $box_row['box_id']; ?>" selected><?php echo $box_row['box_name']; ?></option><?php
                      } else {
                        ?>
                        <option value="<?php echo $box_row['box_id']; ?>">
                          <?php echo $box_row['box_name']; ?>
                        </option>
                      <?php
                      }
                    }
                  ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="purchase_price" class="col-sm-3 control-label">
              <?php echo trans('label_product_cost'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="text" step="0.01" class="form-control" id="purchase_price" value="<?php echo $product['purchase_price']; ?>" name="purchase_price" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}" required>
            </div>
          </div>

          <div class="form-group">
            <label for="sell_price" class="col-sm-3 control-label">
              <?php echo trans('label_product_price'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="text" step="0.01" class="form-control" id="sell_price" value="<?php echo $product['sell_price']; ?>" name="sell_price" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}" required>
            </div>
          </div>

          <div ng-show="!hideExpiredAt" class="form-group<?php echo !get_preference('expiry_yes') ? ' hide' : null;?>">
            <label for="e_date" class="col-sm-3 control-label">
              <?php echo trans('label_expired_date'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="date" class="form-control date" id="e_date" value="<?php echo $product['e_date']; ?>" name="e_date" autocomplete="off" required>
            </div>
          </div>

          <div ng-hide="hideUnit" class="form-group">
            <label for="unit_id" class="col-sm-3 control-label">
              <?php echo trans('label_unit'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="unit_id" required>
                  <option value="">
                    <?php echo trans('text_select'); ?>
                  </option>
                  <?php foreach(get_units() as $unit_row) {
                      if($unit_row['unit_id'] == $product['unit_id']) { ?>
                        <option value="<?php echo $unit_row['unit_id']; ?>" selected><?php echo $unit_row['unit_name']; ?></option><?php
                      } else {
                        ?>
                        <option value="<?php echo $unit_row['unit_id']; ?>">
                          <?php echo $unit_row['unit_name']; ?>
                        </option>
                      <?php
                      }
                    }
                  ?>
              </select>
            </div>
          </div>

          <?php if (get_preference('invoice_view') == 'indian_gst') : ?>
          <div class="form-group all">
            <label for="hsn_code" class="col-sm-3 control-label">
              <?php echo trans('label_hsn_code'); ?>
            </label>             
            <div class="col-sm-8">           
              <input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?php echo $product['hsn_code']; ?>" autocomplete="off" required>
            </div>
          </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="taxrate_id" class="col-sm-3 control-label">
              <?php echo trans('label_product_tax'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="taxrate_id" required>
                  <option value="">
                    <?php echo trans('text_select'); ?>
                  </option>
                  <?php foreach(get_taxrates() as $taxrate_row) {
                      if($taxrate_row['taxrate_id'] == $product['taxrate_id']) { ?>
                        <option value="<?php echo $taxrate_row['taxrate_id']; ?>" selected><?php echo $taxrate_row['taxrate_name']; ?></option><?php
                      } else {
                        ?>
                        <option value="<?php echo $taxrate_row['taxrate_id']; ?>">
                          <?php echo $taxrate_row['taxrate_name']; ?>
                        </option>
                      <?php
                      }
                    }
                  ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="tax_method" class="col-sm-3 control-label">
              <?php echo trans('label_tax_method'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select id="tax_method" class="form-control" name="tax_method" >
                <option <?php echo isset($product['tax_method']) && $product['tax_method'] == 'inclusive' ? 'selected' : null; ?> value="inclusive">
                  <?php echo trans('text_inclusive'); ?>
                </option>
                <option <?php echo isset($product['tax_method']) && $product['tax_method'] == 'exclusive' ? 'selected' : null; ?> value="exclusive">
                  <?php echo trans('text_exclusive'); ?>
                </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">
              <?php echo trans('label_supplier'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8 supplier-selector">
              <div class="checkbox selector">
                <label>
                  <input type="checkbox" onclick="$('input[name*=\'supplier\']').prop('checked', this.checked);"> Select / Deselect
                </label>
              </div>
              <div class="filter-searchbox">
                <input ng-model="search_supplier" class="form-control" type="text" id="search_supplier" placeholder="<?php echo trans('search'); ?>">
              </div>
              <div class="well well-sm store-well">
                <div filter-list="search_supplier">
                  <?php foreach(get_suppliers() as $the_supplier) : ?>                    
                    <div class="checkbox">
                      <label>      
                        <input type="checkbox" name="supplier[]" value="<?php echo $the_supplier['sup_id']; ?>" <?php echo in_array($the_supplier['sup_id'], $product['suppliers']) ? 'checked' : null; ?>>
                        <?php echo $the_supplier['sup_name']; ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">
              <?php echo trans('label_store'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8 store-selector">
              <div class="checkbox selector">
                <label>
                  <input type="checkbox" onclick="$('input[name*=\'product_store\']').prop('checked', this.checked);"> Select / Deselect
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
                        <input type="checkbox" name="product_store[]" value="<?php echo $the_store['store_id']; ?>" <?php echo in_array($the_store['store_id'], $product['stores']) ? 'checked' : null; ?>>
                        <?php echo $the_store['name']; ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <div ng-hide="hideAlertQuantity" class="form-group">
            <label for="alert_quantity" class="col-sm-3 control-label">
              <?php echo trans('label_alert_quantity'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" value="<?php echo format_input_number($product['alert_quantity']); ?>" onclick="this.select();" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" onKeyUp="if(this.value<0){this.value='1';}" required>
            </div>
          </div>

          <div class="form-group">
            <label for="e_date" class="col-sm-3 control-label">
              <?php echo trans('label_description'); ?>
            </label>
            <div class="col-sm-8">
              <textarea class="form-control description" id="edit_description" name="description" rows="3"><?php echo $product['description']; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="status" class="col-sm-3 control-label">
              <?php echo trans('label_status'); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <select id="status" class="form-control" name="status" >
                <option <?php echo isset($product['status']) && $product['status'] == '1' ? 'selected' : null; ?> value="1">
                  <?php echo trans('text_active'); ?>
                </option>
                <option <?php echo isset($product['status']) && $product['status'] == '0' ? 'selected' : null; ?> value="0">
                  <?php echo trans('text_inactive'); ?>
                </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="sort_order" class="col-sm-3 control-label">
              <?php echo sprintf(trans('label_sort_order'), null); ?><i class="required">*</i>
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="sort_order" value="<?php echo $product['sort_order']; ?>" name="sort_order">
            </div>
          </div>


        </div>
        <!-- General End -->

        <div class="form-group">
          <label class="col-sm-3 control-label"></label>
          <div class="col-sm-8">
            <button class="btn btn-info btn-lg btn-block" id="product-update-submit" name="form_update" data-form="#product-update-form" data-loading-text="Updating...">
              <i class="fa fa-fw fa-pencil"></i> 
              <?php echo trans('button_update'); ?>
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Box Body -->
</form>