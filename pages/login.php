<?php

$action = uri_segment(1);

if ($action == 'validate') {
	$post = get_post();
	print_r($post);
}

?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4 text-center">
		<p>Sign into your account</p>
		<form method="post" action="<?php echo site_url('login/validate'); ?>">
	        <div class="form-group">
	            <label class="sr-only" for="inputEmail">Email</label>
	            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
	        </div>
	        <div class="form-group">
	            <label class="sr-only" for="inputPassword">Password</label>
	            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
	        </div>
	        <div class="form-group clearfix">
	            <div class="checkbox-custom checkbox-inline pull-left">
	                <input type="checkbox" id="inputCheckbox" name="checkbox">
	                <label for="inputCheckbox">Remember me</label>
	            </div>
	            <a class="pull-right" href="forgot-password.html">Forgot password?</a>
	        </div>
	        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
	    </form>

	</div>
</div>