
<div uk-grid>

                    <div class="uk-width-2-3@m fead-area">
                        <div class="uk-position-relative" uk-slider="finite: true">

                            <div class="uk-slider-container pb-3">

                                <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-3 story-slider uk-grid">
                                   <?php if (user_group_id() == 1 || has_permission('access', 'withdraw')): ?>                                	
									<li>
                                        <a ng-click="BankingWithdrawModal()" onClick="return false;" href="bank_account.php">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_new_withdraw'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
									 <?php endif; ?> 
									<?php if (user_group_id() == 1 || has_permission('access', 'deposit')): ?>                                	
									<li>
                                        <a ng-click="BankingDepositModal()" onClick="return false;" href="#">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_new_deposit'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
									 <?php endif; ?>
				<?php if (user_group_id() == 1 || has_permission('access', 'transfer')): ?>                                	
									<li>
                                        <a ng-click="BankTransferModal()" onClick="return false;" href="bank_account.php">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_new_transfer'); ?></h4>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
									 <?php endif; ?>
							<?php if (user_group_id() == 1 || has_permission('access', 'transfer')): ?>                                	
									<li>
                                        <a ng-click="BankTransferModal()" onClick="return false;" href="bank_account.php">
                                            <div class="story-card" data-src="../assets/images/avatars/avatar-lg-1.jpg"
                                                uk-img>
                                                <i class="uil-plus"></i>
                                                <div class="story-card-content">
                                                    <h4><?php echo trans('menu_list_transfer'); ?></h4>
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

