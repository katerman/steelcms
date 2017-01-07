<?php

	session_start();

	require_once 'includes/scripts/functions.php';
	require_once 'config.php';
	require_once 'includes/libs/flight/autoload.php';
	require_once 'includes/libs/FluentPDO/FluentPDO.php';
	require_once 'classes/alerts.class.php';
	require_once 'classes/includer.class.php';

	if(!$_config->caching){
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}

	use flight\Engine as Engine;

	$rel_path = $_config->config_path; //or root_path depending
	$index_path = $_config->index_path;

	$alerts = new alerts();

	$includer = new includer();
	$includer->includePath($rel_path.'/classes',
		array(
			"omit" => array(
				$rel_path.'/classes/includer.class.php',
				$rel_path.'/classes/alerts.class.php'
			)
		)
	);

	$pdo = new PDO($_config->db_info, $_config->db_user, $_config->db_pass);
	$fpdo = new FluentPDO($pdo);

	$user = new user();

	$app = new Engine();

	//Set App Globals
	$app->set('rel_path', $rel_path);
	$app->set('index_path', $index_path);
	$app->set('flight.views.path', $_config->current_theme_path);
	$app->set('fpdo', $fpdo);
	$app->set('includer', $includer);
	$app->set('user', $user);
	$app->set('alerts', $alerts);

	$app->map('notFound', function(){
		global $app;
		$url = $app->get('index_path') . '/404';
		header("Location: $url");
		die();
	});

	//extended classes added to app
	$app->register('controllers', 'controllers');

	require_once 'routes/routes.php';

/*
	$alerts->alert(array("type"=>"primary", "message"=>"Test"), true);
	$alerts->alert(array("type"=>"warning", "title"=>"Test", "message"=>"Test"), true);
	$alerts->alert(array("type"=>"danger", "title"=>"Test", "message"=>"Test"), true);
	$alerts->alert(array("type"=>"success", "title"=>"Test", "message"=>"Test"), true);
*/
	$app->start();



