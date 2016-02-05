<?php

return array(
	
	'name' => 'App',
	
	'version' => '1.0.0',
	
	'title' => 'immortal',
	
	'author' => 'supernova',
	
	'description' => 'simple php application',
	
	'keywords' => array('simple', 'php', 'application', 'procedural'),
	
	'index' => '',
	
	'default' => 'home',
	
	'suffix' => '.xyz',
	
	'autoload' => array(
		'database',
		'session',
		'pagination'
	),

	'database'=> array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'secret',
		'name' => 'immortal',
		'load' => true
	)

);