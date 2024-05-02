<div class="row">
    <div class="col-lg-6">
        <form id="changeEmailForm" action="customer.php" method="post">
            <input type="hidden" name="action_type" value="CHANGEEMAIL">
            <div class="sin-login-register">
                <label>Email Address <span>*</span></label>
                <input type="email" name="email_address" value="<?php echo $the_customer['customer_email'];?>" placeholder="Enter email address here" required>
            </div>
            <br>
            <button ng-click="ChangeEmail()" onClick="return false;" class="btn" type="submit">Save</button>
        </form>
    </div>
</div>
