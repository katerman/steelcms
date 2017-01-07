<?php
	$alerts = $data['alerts'];
	$rel_path = $data['config']->root_path;
	$app = $data['app'];
	$user = $data['user'];
	$admin_path = $data['config']->current_admin_theme_path;

	$templateToRender = isset($data['templateToRender']) ? $data['templateToRender'] : null ;
	$dataToPass = isset($data['dataToPass']) ? $data['dataToPass'] : array() ;
	$extraJs = isset($data['jsInclude']) ? $data['jsInclude'] : array() ;

?>
<html>
	<head>
		<title>Steel CMS</title>
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $rel_path ?>/includes/css/global/global.css">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $rel_path ?>/includes/img/favicon.ico"/>
	</head>
	<body <?php if(isset($data['page_name'])){ echo $data['page_name'].'-page'; }?>>

		<?php

			if($_config->login_required && !$user->loggedIn()){ //if not logged in and required to login

				$app->render('bare.header.view', array("alerts"=>$alerts, "config"=>$_config, "app"=>$app));
				$app->render('elements/login.form.view', array("alerts"=>$alerts, "config"=>$_config, "app"=>$app));

			}else{

				if($user->isAdmin()){
					$app->render($admin_path.'header.view', array("dataToPass" => $dataToPass, "alerts"=>$alerts, "config"=>$_config, "app"=>$app, "user" => $user));
				}else{
					$app->render('header.view', array("dataToPass" => $dataToPass, "alerts"=>$alerts, "config"=>$_config, "app"=>$app, "user" => $user));
				}

				if($templateToRender != null){
					$app->render($templateToRender, array("alerts"=>$alerts, "config"=>$_config, "app"=>$app, "user" => $user, "dataToPass" => $dataToPass));
				}

			}

			//$app->render('footer.view', array("config" => $_config) );

		?>

		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/global/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/global/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/global/steel.framework.js"></script>
		<script type="text/javascript" src="<?php echo $rel_path ?>/includes/js/app/ajax.js"></script>

	</body>
</html>