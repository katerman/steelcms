<?php
	$alerts = $data['alerts'];
	$rel_path = $data['config']->root_path;
?>
<div class="container">
	<form action="?" class="form-horizontal login-form">
		<fieldset>
			<legend>Login</legend>
			<div class="form-group">
				<label for="inputUsername" class="col-lg-2 control-label">Username</label>
				<div class="col-lg-10">
					<input type="text" class="form-control inputUsername" placeholder="Username">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-lg-2 control-label">Password</label>
				<div class="col-lg-10">
					<input type="password" class="form-control inputPassword" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					<p class="text-danger login-feedback-text"></p>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>