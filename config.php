<?php

switch($_SERVER['SERVER_ADMIN']) {

	default:
		$database = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => '',
			'name' => 'immortal',
			'load' => true
		);
	break;

	case 'supernova@dev.local':
		$database = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => 'secret',
			'name' => 'immortal',
			'load' => true
		);
	break;

}

return array(
	'name' => 'App',
	'version' => '1.0.0',
	'title' => 'immortal',
	'author' => 'supernova, arief',
	'description' => 'simple php application',
	'keywords' => 'simple, php, application',
	'index' => '',
	'default' => 'home',
	'suffix' => '.xyz',
	'autoload' => array(
		'database',
		'session',
		'pagination'
	),
	'database'=> $database
);