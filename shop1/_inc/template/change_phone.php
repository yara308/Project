<div class="row">
	<div class="col-lg-6">
		<form id="changePhoneForm" action="customer.php" method="post">
			<input type="hidden" name="action_type" value="CHANGEPHONE">
            <div class="sin-login-register">
                <label>Phone Number <span>*</span></label>
                <input type="text" name="phone_number" value="<?php echo $the_customer['customer_mobile'];?>" placeholder="Enter phone number here" required>
            </div>
            <br>
            <button ng-click="ChangePhone()" onClick="return false;" class="btn" type="submit">Save</button>
        </form>
	</div>
</div>
