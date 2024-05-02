<!-- PROFILE EDIT START -->
<form id="profileEditForm" action="customer.php" method="post">
	<input type="hidden" name="action_type" value="UPDATE">
	<div class="form-row">
		<div class="col-lg-4">
            <div class="sin-login-register">
                <label>Name <span>*</span></label>
                <input type="text" name="customer_name" value="<?php echo $the_customer['customer_name'];?>" placeholder="Enter you fullname">
            </div>
        </div>
        <div class="col-lg-1">&nbsp;</div>
        <div class="col-lg-3">
			<div>
    			<span>Email Address | <a style="color:blue;" href="account.php?tab=change_email">Change</a></span>
    			<h4><?php echo $the_customer['customer_email'];?></h4>
			</div>
		</div>
		<div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-3">
			<div>
    			<span>Phone | <a style="color:blue;" class="text-blue" href="account.php?tab=change_phone">Change</a></span>
    			<h4><?php echo $the_customer['customer_mobile'];?></h4>
			</div>
		</div>
	</div>
	<br>
	<div class="form-row">
		<div class="col-lg-6">
			<div class="sin-login-register">
                <label>Birthday <span>*</span></label>
                <div class="row">
                	<div class="col-lg-4">
                		<?php 
                		$sex = $the_customer['customer_sex'];
                		$dob = $the_customer['dob'];
                		$dob_day = $dob ? (int)date('d', strtotime($the_customer['dob'])) : '';
                		$dob_month = $dob ? (int)date('m', strtotime($the_customer['dob'])) : '';
                		$dob_year = $dob ? (int)date('Y', strtotime($the_customer['dob'])) : '';
                		$months = array(
                			'January',
                			'February',
                			'March',
                			'April',
                			'May',
                			'June',
                			'July',
                			'August',
                			'September',
                			'October',
                			'November',
                			'December',
                		);
                		$genders = array('Male', 'Female', "Others");
                		?>
                		<select id="birthday_month" name="birthday_month">
            				<?php $i=1;foreach ($months as $month):?>
            					<option value="<?php echo $i;?>"<?php echo $dob_month == $i ? ' selected' : null;?>><?php echo $month;?></option>
            				<?php $i++;endforeach;?>
            			</select>
                	</div>
                	<div class="col-lg-3">
                		<select id="birthday_day" name="birthday_day">
            				<?php $i=1;for (; $i < 32; $i++):?>
                				<option value="<?php echo $i;?>" <?php echo $dob_day == $i ? ' selected' : null;?>><?php echo $i;?></option>
                			<?php endfor;?>
            			</select>
                	</div>
                	<div class="col-lg-4">
                		<select id="birthday_year" name="birthday_year">
                			<?php $i=1900;for (; $i < date('Y')+1; $i++):?>
                				<option value="<?php echo $i;?>" <?php echo $dob_year == $i ? ' selected' : null;?>><?php echo $i;?></option>
                			<?php endfor;?>
            			</select>
                	</div>			
                </div>
            </div>
            <div class="row mt-20">
            	<div class="col-lg-3">
					<div class="sin-login-register">
		                <label>Gender <span>*</span></label>
		                <select id="gender" name="gender">
		                	<?php $i=0;for (; $i < count($genders); $i++):?>
		                		<option value="<?php echo $i+1;?>"<?php echo $sex == $i+1 ? ' selected' : null;?>><?php echo $genders[$i];?></option>
		                	<?php endfor;?>
		    			</select>
		            </div>
				</div>
            </div>	
		</div>	
		<div class="col-lg-6">
			<label>Address <span>*</span></label>
			<textarea id="customer_address" name="customer_address" cols="10" rows="5"><?php echo $the_customer['customer_address'];?></textarea>
		</div>		
	</div>
	<div class="form-row">
		<div class="col-lg-12">
			<br>
			<button ng-click="ProfileEdit()" onClick="return false;" class="btn" type="submit">Update</button>
		</div>
    </div>
</form>
<!-- PROFILE EDIT END -->