<!-- CHANGE PASSWORD START -->
<div class="row">
	<div class="col-lg-6">
		<form id="changePasswordForm" action="customer.php" method="post">
			<input type="hidden" name="action_type" value="CHANGEPASSWORD">
            <div class="sin-login-register">
                <label>Current Password <span>*</span></label>
                <input type="password" name="current_password" placeholder="Current password" required>
            </div>
            <br>
            <div class="sin-login-register">
                <label>New Passwords <span>*</span></label>
                <input type="password" name="new_password" placeholder="New password" required>
            </div>
            <br>
            <div class="sin-login-register">
                <label>Retype Passwords <span>*</span></label>
                <input type="password" name="retype_password" placeholder="Retype your password" required>
            </div>
            <br>
            <button ng-click="ChangePassword()" onClick="return false;" class="btn" type="submit">Save</button>
        </form>
	</div>
</div>
<!-- CHANGE PASSWORD END -->