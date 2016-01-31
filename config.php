<?php

return array(
	
	'name'    => 'App',

	'version' => '1.0.0',

	'title'   => 'pushstate.com',

	'index'   => '',

	'default' => 'home',
	
	'suffix'  => '.aspx',

	'autoload' => array(
		'database',
		'session'
	),

	'database'=> array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => 'secret',
		'name' => 'test',
		'load' => true
	)

);