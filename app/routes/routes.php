<?php

$template_path = $_config->current_theme_path;
$admin_path = $_config->current_admin_theme_path;

require $_config->config_path . '/controllers/controllers.php'; //get our controllers


$app->route('/', function(){
	global $app, $template_path, $_config, $alerts, $user, $fpdo;
	$default = $_config->default_root_template;

	$pageQuery = $fpdo->from('pages')->fetchAll();

    $app->render($template_path.$default,  array("dataToPass" => array("pages" => $pageQuery), "alerts"=>$alerts, "config"=>$_config, "app"=>$app, 'user' => $user) );
});


$app->route('GET /admin/pages/', function(){
	global $app, $admin_path, $_config, $alerts, $user, $template_path, $fpdo;

	$default = $_config->default_root_template;
	$page_name = 'admin-pages';

	if($user->isAdmin()){

		$pageQuery = $fpdo->from('pages')->fetchAll();

		$app->render($template_path . $default,  array("templateToRender" => $admin_path.'admin.pages.view.php', "dataToPass" => array("pages" => $pageQuery), "alerts"=>$alerts, "config"=>$_config, "app"=>$app, 'user' => $user, 'template_path' => $admin_path ) );
	}else{
		send_404();
	}
});

$app->route('/404', function(){
	global $app, $template_path, $_config, $alerts, $user, $fpdo;

	$default = $_config->default_root_template;

    $app->render($template_path.$default,  array("templateToRender"=> $template_path.'fourohfour.view.php', "alerts"=>$alerts, "config"=>$_config, "app"=>$app, 'user' => $user ) );
});

$app->route('POST|GET /login',function(){
	global $app;
	$app->controllers()->fire('loginCtrl');
});

$app->route('POST|GET /logout',function(){
	global $app;
	$app->controllers()->fire('logoutCtrl');
});

$app->route('POST|GET /register',function(){
	global $app;
	$app->controllers()->fire('basicRegisterCtrl');
});
