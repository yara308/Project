<form id="createCustomerForm" action="customer.php" method="post">
    <input type="hidden" name="action_type" value="CREATE">
	<div class="sin-login-register">
        <label>Name <span>*</span></label>
        <input type="text" name="name">
    </div>
    <div class="sin-login-register">
        <label>Email address <span>*</span></label>
        <input type="email" name="email">
    </div>
    <div class="sin-login-register">
        <label>Phone <span>*</span></label>
        <input type="text" name="phone">
    </div>
    <div class="sin-login-register">
        <label>Passwords <span>*</span></label>
        <input type="password" name="password">
    </div>
    <div class="sin-login-register">
        <label>Retype Passwords <span>*</span></label>
        <input type="password" name="retype_password">
    </div>
    <button ng-click="CreateCustomer()" onClick="return false" type="submit">Register</button>
</form>