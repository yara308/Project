<?php
$quotation_model = registry()->get('loader')->model('quotation');
$my_orders = $quotation_model->getQuotations(store_id(), 20, $customrer_id);
?>
<!-- MY ORDERS START -->
<div class="row">
<div class="col-lg-12">
    <?php if (!empty($my_orders)):?>
        <?php foreach ($my_orders as $order):?>
        	<div class="card mb-20">
        		<div class="card-header">
        			<h4 class="card-title">
                        <?php echo trans('text_ref_ID');?>: <a href="order_view.php?reference_no=<?php echo $order['reference_no'];?>"><span class="text-info"><?php echo $order['reference_no'];?></span></a>
                        
                        <span class="pull-right"><?php echo $order['status'] == 'complete' ? '<span class="text-success">completed</span>' : '<span class="text-warning">'.$order['status'].'</span>';?></span>
                    </h4>
        				<span><?php echo trans('text_placed_on');?> <?php echo format_date($order['created_at']);?></span>
                        <button id="delete-order" class="btn btn-danger pull-right" data-refno="<?php echo $order['reference_no'];?>"><?php echo trans('button_delete');?></button>
        		</div>
        		<div class="card-body">
                   <?php $order_items = $quotation_model->getQuotationItems($order['reference_no']);?>
        			<table class="table">
        				<tbody>
                            <?php foreach ($order_items as $item): 
                            $the_product = get_the_product($item['item_id']);?>
        					<tr>
        					   <td class="text-center">
                                    <?php if (isset($the_product['p_image']) && ((FILEMANAGERPATH && is_file(FILEMANAGERPATH.$the_product['p_image']) && file_exists(FILEMANAGERPATH.$the_product['p_image'])) || (is_file(DIR_STORAGE . 'products' . $the_product['p_image']) && file_exists(DIR_STORAGE . 'products' . $the_product['p_image'])))) : ?>
                                      <img  src="<?php echo FILEMANAGERURL ? FILEMANAGERURL : root_url().'/storage/products'; ?>/<?php echo $the_product['p_image']; ?>" alt="<?php echo $the_product['p_name'];?>" style="width:40px;height:40px;">
                                    <?php else : ?>
                                      <img src="<?php echo root_url();?>/assets/itsolution24/img/noimage.jpg" <?php echo $the_product['p_name'];?> style="width:40px;height:40px;">
                                    <?php endif; ?>
                                </td>
        						<td><?php echo $item['item_name'];?></td>
        						<td class="text-center"><?php echo trans('text_qty');?>: <?php echo currency_format($item['item_quantity']);?> <?php echo get_the_unit($the_product['unit_id'], 'unit_name');?></td>
        						<td class="text-center">
                                    <?php echo trans('text_price');?>: <span class="text-success"><?php echo get_currency_symbol();?><?php echo currency_format($item['item_total']);?></span>
                                </td>
                            </tr>
                            <?php endforeach;?>
        				</tbody>
        			</table>
        		</div>
        	</div>
        <?php endforeach;?>
    <?php else:?>
        <div class="card bg-light">
            <h4 class="card-body text-danger"><?php echo trans('text_order_not_found');?></h4>
        </div>
    <?php endif;?>
</div>
</div>
<!-- MY ORDERS END -->