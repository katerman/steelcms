<?php

//Controllers
//Controllers can be put in here or in external files the next 2 lines will auto import all controller files (*.php)

global $app;

$includer = $app->get('includer');
$path = $app->get('rel_path');

$includer->includePath(dirname(__FILE__), array("omit" => array(__FILE__) ));

