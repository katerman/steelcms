<?php
	$alerts = $data['alerts'];
	$rel_path = $data['config']->root_path;
	$app = $data['app'];
	$user = $data['user'];
?>
<html>
	<head>
		<title>Steel CMS</title>
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/global.css">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $rel_path ?>/includes/img/favicon.ico"/>
	</head>
	<body>

		<?php

		if($_config->login_required && !$user->loggedIn()){ //if not logged in and required to login
			$app->render('bare.header.view', array("alerts"=>$alerts, "config"=>$_config, "app"=>$app));
			$app->render('elements/login.form.view', array("alerts"=>$alerts, "config"=>$_config, "app"=>$app));
		}else { //if logged in
			$app->render('header.view', array("alerts"=>$alerts, "config"=>$_config, "app"=>$app));
		}

		?>

		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/global/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/global/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/app/ajax.js"></script>

	</body>
</html>