<div id="loginform">
<h3 id="loginheader">LOGIN</h3>
<a href="<?php echo get_settings('home') ?>/create_account.php" title="Create account" class="create-accountHeader">Create account</a>
 | 
<a href="<?php echo get_settings('home') ?>/forgot_password.php" title="Forgot password?" class="forgot-passHeader">Reset password</a>
<form method="get" id="login_form" action="<?php bloginfo('home'); ?>/">			
	<input type="text" name="username" id="userid" value="Username" />
	<input type="password" name="password" id="pwd" value="password" />
	<input type="submit" id="loginsubmit" value="Go" />
	</form>
</div>