<?php

	session_start();

	require_once 'includes/scripts/functions.php';
	require_once 'config.php';
	require_once 'includes/libs/flight/autoload.php';
	require_once 'includes/libs/FluentPDO/FluentPDO.php';
	require_once 'classes/alerts.class.php';
	require_once 'classes/includer.class.php';

	use flight\Engine as Engine;

	$rel_path = '.'.$_config->root_path;

	$alerts = new alerts();

	$includer = new includer();
	$includer->includePath($rel_path.'/classes', array(
		$rel_path.'/classes/includer.class.php',
		$rel_path.'/classes/alerts.class.php'),
	false);

	$pdo = new PDO($_config->db_info, $_config->db_user, $_config->db_pass);
	$fpdo = new FluentPDO($pdo);

	$user = new user();

	$app = new Engine();
	$app->set('flight.views.path', $_config->current_theme_path);

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

?>



