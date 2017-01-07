<?php

/** Hardcoded configurations. */

$config_root = dirname(__FILE__);
$config_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $config_root);

$array = array(
	'config_path' => $config_root,
	'root_path' => $config_path,
	'index_path' => dirname($config_path),

	'password_hash_alg' => 'whirlpool',

	'css_path' => $config_path.'/includes/css/',
	'js_path' => $config_path.'/includes/js/',
	'img_path' => $config_path.'/includes/img/',
	'upload_path' => $config_root.'/uploads/',
	'update_path' => $config_root.'/includes/updates/',

	'admin_template_path' => $config_root.'/views/admin/',
	'admin_template_theme' => 'default',
	'default_admin_root_template' => 'admin.view.php',

	'template_path' => $config_root.'/views/app/',
	'template_theme' => 'default',
	'default_root_template' => 'app.view.php',

	'login_required' => true,

	'allow_image_upload' => true,

	'date_default_timezone_set' => 'America/New_York',

	'error_reporting' => true,
	'template_debug' => false,

	'caching' => true,
	'seo_friendly_url' => false,

	'remote_update_loc' => '',

	'db_info' => 'mysql:host=localhost;dbname=steelCMS',
	'db_user' => 'root',
	'db_pass' => 'root'
);

$array['current_theme_path'] = $array['template_path'].$array['template_theme'].'/';
$array['current_admin_theme_path'] = $array['admin_template_path'].$array['admin_template_theme'].'/';

$_config = (object) $array; //config object
