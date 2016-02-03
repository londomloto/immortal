<?php

return array(
	
	'name'    => 'App',

	'version' => '1.0.0',

	'title'   => 'pushstate.com',

	'index'   => '',

	'default' => 'login',
	
	'suffix'  => '.me',

	'autoload' => array(
		'database',
		'session'
	),

	'database'=> array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'secret',
		'name' => 'immortal',
		'load' => true
	)

);