<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', __DIR__.DS);

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
	
	foreach($autoload as $lib) {
		
		include('libs/'.$lib.'.php');

		if ($lib == 'database') {
			if (get_config('database')->load) {
				db_start();
			}
		}
	}

}

function base_uri() {
	static $base;
	if (empty($base)) {
		$base = substr(
			$_SERVER['SCRIPT_NAME'], 
			0, 
			strpos(
				$_SERVER['SCRIPT_NAME'], 
				basename($_SERVER['SCRIPT_FILENAME'])
			)
		);
	}
	return $base;
}

function base_url() {
	static $base;
	if (empty($base)) {
		$base = 'http://'.$_SERVER['HTTP_HOST'].base_uri();
	}
	return $base;
}

function site_url($uri) {

	$site   = base_url();
	$index  = get_config('index');
	$suffix = get_config('suffix');

	if ( ! preg_match('|'.$suffix.'$|', $uri)) {
		$uri .= $suffix;
	}

	if ( ! empty($index)) {
		$site .= $index.'/';
	}

	$site .= trim($uri, '/');
	return $site;
}

function uri_segment($index = 0) {
	$suf = get_config('suffix');

	$uri = trim(get_var('uri'), '/');
	$uri = preg_replace('|('.$suf.')$|', '', $uri);
	$seg = explode('/', $uri);

	return isset($seg[$index]) ? $seg[$index] : '';
}

function is_ajax() {
	return ( 
		! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
	);
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

function start() {

	$url = parse_url($_SERVER['REQUEST_URI']);
	$uri = isset($url['path']) ? $url['path'] : '';

	$svc = $_SERVER['SCRIPT_NAME'];

	if (strpos($uri, $svc) === 0) {
		$uri = (string) substr($uri, strlen($svc));
	} else if (strpos($uri, dirname($svc)) === 0) {
		$uri = (string) substr($uri, strlen(dirname($svc)));
	}

	if ($uri == '') {
		$uri = '/';
	}
	
	set_var('uri', $uri);

	$page = uri_segment(0);

	if ($uri == '/') {
		$page = get_config('default');
	}

	set_var('page', $page);

	if ( $page != '') {
		
		$page = BASEPATH.'pages/'.$page.'.php';
		
		if (file_exists($page)) {
			ob_start();
			include($page);
			set_content(ob_get_contents());
			ob_end_clean();
		}

	}
	
	if ( ! is_ajax()) {
		include(BASEPATH.'pages/layout.php');
	} else {
		echo get_content();
	}

}

load_config();
load_libraries();

start();