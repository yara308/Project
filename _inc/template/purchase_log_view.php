<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-condensed">
				<tbody>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_reference_no'); ?>
						</td>
						<td class="w-70">
							<?php echo $transaction['reference_no']; ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_ref_invoice_Id'); ?>
						</td>
						<td class="w-70">
							<a ng-click="PurchaseInvoiceViewModal('<?php echo $transaction['ref_invoice_id']; ?>')" href="#"><?php echo $transaction['ref_invoice_id']; ?></a>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_supplier'); ?>
						</td>
						<td class="w-70">
							<?php echo get_the_supplier($transaction['sup_id'],'sup_name'); ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_type'); ?>
						</td>
						<td class="w-70">
							<?php echo $transaction['type']; ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_pmethod_name'); ?>
						</td>
						<td class="w-70">
							<?php echo get_the_pmethod($transaction['pmethod_id'],'name'); ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_description'); ?>
						</td>
						<td class="w-70">
							<?php echo $transaction['description']; ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_amount'); ?>
						</td>
						<td class="w-70">
							<?php echo currency_format($transaction['amount']); ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_created_by'); ?>
						</td>
						<td class="w-70">
							<?php echo get_the_user($transaction['created_by'],'username'); ?>
						</td>
					</tr>
					<tr>
						<td class="w-30 bg-gray text-right">
							<?php echo trans('label_created_at'); ?>
						</td>
						<td class="w-70">
							<?php echo format_date($transaction['created_at']); ?>
						</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>