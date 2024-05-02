
<div uk-grid>

        
                    <div class="uk-width-2-3@m fead-area">
                        <div class="uk-position-relative" uk-slider="finite: true">

                            <div class="uk-slider-container pb-3">

                                <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-3 story-slider uk-grid">
                                 
								 
								<?php if (user_group_id() == 1 || has_permission('access', 'read_overview_report')) : ?>
								 <li>
                                        <a href="report_overview.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4> <?php echo trans('menu_report_overview'); ?> </h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                      <?php endif; ?>
   								 
								      
									  	  <?php if (user_group_id() == 1 || has_permission('access', 'read_customer_due_collection_report')) : ?>
								      <li>
                                        <a href="report_customer_due_collection.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_report_due_collection'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
								
										  	  <?php if (user_group_id() == 1 || has_permission('access', 'read_supplier_due_paid_report')) : ?>
								      <li>
                                        <a href="/admin/report_supplier_due_paid.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('text_supplier_due_paid_title'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>
 <?php endif; ?>
   								     
									
        			  						   	  <?php if (user_group_id() == 1 || has_permission('access', 'read_purchase_report')) : ?>
								      <li>
                                        <a href="/admin/report_purchase_supplierwise.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_purchase_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>

                                       <?php if (user_group_id() == 1 || has_permission('access', 'read_sell_payment_report')) : ?>
								      <li>
                                        <a href="/admin/report_sell_payment.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_sell_payment_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									    <?php if (user_group_id() == 1 || has_permission('access', 'read_purchase_payment_report')) : ?>
								      <li>
                                        <a href="/admin/report_purchase_payment.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_purchase_payment_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_tax_overview_report')) : ?>
								      <li>
                                        <a href="/admin/report_sell_tax.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('title_sell_tax_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
										<?php if (user_group_id() == 1 || has_permission('access', 'read_tax_overview_report')) : ?>
								      <li>
                                        <a href="/admin/report_purchase_tax.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('title_purchase_tax_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>									   
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_stock_report')) : ?>
								      <li>
                                        <a href="/admin/report_stock.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('title_stock_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_bank_transactions')) : ?>
								      <li>
                                        <a href="/admin/bank_transactions.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('title_bank_transactions'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_bank_account_sheet')) : ?>
								      <li>
                                        <a href="/admin/bank_account_sheet.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_balance_sheet'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_income_monthwise')) : ?>
								      <li>
                                        <a href="/admin/income_monthwise.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_income_monthwise'); ?></h4>
                                                </div>
                                            </div>
                                        </a>	

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_income_and_expense_report')) : ?>
								      <li>
                                        <a href="/admin/report_income_and_expense.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('text_income_and_expense_title'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_profit_and_loss_report')) : ?>
								      <li>
                                        <a href="/admin/report_profit_and_loss.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('profit_and_loss_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_cashbook_report')) : ?>
								      <li>
                                        <a href="/admin/report_cashbook.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('text_cashbook_report'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
									  <?php if (user_group_id() == 1 || has_permission('access', 'read_income_monthwise')) : ?>
								      <li>
                                        <a href="/admin/expense_monthwise.php"  ">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('text_expense_monthwise_title'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                       </li>

   								      <?php endif; ?>
                                </ul>

                                <div class="uk-visible@m">
                                    <a class="uk-position-center-left-out slidenav-prev" href="#"
                                        uk-slider-item="previous"></a>
                                    <a class="uk-position-center-right-out slidenav-next" href="#"
                                        uk-slider-item="next"></a>
                                </div>
                                <div class="uk-hidden@m">
                                    <a class="uk-position-center-left slidenav-prev" href="#"
                                        uk-slider-item="previous"></a>
                                    <a class="uk-position-center-right slidenav-next" href="#"
                                        uk-slider-item="next"></a>
                                </div>

                            </div>
                        </div> 
						</div>
                        </div>

