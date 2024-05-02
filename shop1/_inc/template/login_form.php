<form id="loginForm" action="customer.php" method="post">
    <input type="hidden" name="action_type" value="LOGIN">
    <div class="sin-login-register">
        <label>Phone or email address <span>*</span></label>
        <input type="text" name="username">
    </div>
    <div class="sin-login-register">
        <label>Passwords <span>*</span></label>
        <input type="password" name="password">
    </div>
    <button ng-click="Login()" onClick="return false;" type="submit">Login</button>
    <!-- <div class="login-toggle-btn">
        <input type="checkbox">
        <label>Remember me</label>
        <a href="#"> Lost your password?</a>
    </div> -->
</form>