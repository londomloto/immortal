<?php

function &vars() {
	static $vars;
	if (empty($vars)) {
		$vars = new stdClass();
	}
	return $vars;
}

function set_var($key, $value) {
	$vars =& vars();
	$vars->$key = $value;
}

function get_var($key, $default = '') {
	$vars =& vars();
	return isset($vars->$key) ? $vars->$key : $default;
}

function &config() {
	static $config;
	if (empty($config)) {
		$config = new stdClass();
	}
	return $config;
}

function set_config($key, $value) {
	$config =& config();
	$config->$key = $value;
}

function get_config($key, $default = '') {
	$config =& config();
	return isset($config->$key) ? $config->$key : $default;
}

function load_config() {
	$file = BASEPATH.'config.php';
	$config =& config();
	if (file_exists($file)) {
		$config = json_decode(json_encode(include($file)));
	}
}

function load_libraries() {
	$autoload = get_config('autoload');
	$dbload   = get_config('database')->load;

	foreach($autoload as $lib) {
		$file = BASEPATH.'libs/'.$lib.'.php';
		if (file_exists($file)) {
			include($file);
			if ($lib == 'database' && $dbload) {
				db_start();
			}
		}
	}
}

function &content() {
	static $content = '';
	return $content;
}

function set_content($page) {
	$content =& content();
	$content = $page;
}

function get_content() {
	$content =& content();
	return $content;
}

function is_ajax() {
	return ( 
		! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
	);
}

function get_post($field = null, $default = '') {
	$magic = get_magic_quotes_gpc();

	foreach($_POST as $key => $val) {
		if ( ! $magic) {
			 $val = addslashes($val);
		}
		$val = strip_tags($val);
		$_POST[$key] = $val;
	}	

	if ( ! empty($field)) {
		return isset($_POST[$field]) ? $_POST[$field] : $default;
	}

	return $_POST;	
}

function get_param($field = null, $default = '') {

	$query  = get_var('qry');
	$magic  = get_magic_quotes_gpc();
	$params = array();

	if ( ! empty($query)) {
		
		parse_str($query, $params);

		foreach($params as $key => $val) {
			if ( ! $magic) {
				$val = addslashes($val);
			}
			$val = strip_tags($val);
			$params[$key] = $val;
		}

	}

	if ( ! empty($field)) {
		return isset($params[$field]) ? $params[$field] : $default;	
	}
	
	return $params;
}