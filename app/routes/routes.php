<?php

$template_path = $_config->current_theme_path;

require $_config->config_path . '/controllers/controllers.php'; //get our controllers


$app->route('/', function(){
	global $app, $template_path, $_config, $alerts, $user;
	$default = $_config->default_root_template;
    $app->render($template_path.$default,  array("alerts"=>$alerts, "config"=>$_config, "app"=>$app, 'user' => $user) );
});

$app->route('GET /users', function(){
    global $app, $fpdo, $template_path;

    $query = $fpdo->from('users');

    $app->render($template_path.'/test/users.view.php',  array("users"=>$query) );

});

$app->route('GET /user/@id', function($id){
    global $app, $fpdo, $template_path;

    $query = $fpdo->from('users')->where('id',$id);

    $app->render($template_path.'/test/user.view.php',  array("user"=>$query) );

});

$app->route('POST|GET /login',function(){
	global $app;
	$app->controllers()->fire('loginCtrl');
});

$app->route('POST|GET /logout',function(){
	global $app;
	$app->controllers()->fire('logoutCtrl');
});