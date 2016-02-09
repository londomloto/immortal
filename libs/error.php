<?php
set_error_handler('custom_error');

function get_error_name($level) {
	$maps = array(
		E_ERROR => 'Error',
		E_WARNING => 'Warning',
		E_PARSE => 'Parsing Error',
		E_NOTICE => 'Notice',
		E_CORE_ERROR => 'Core Error',
		E_CORE_WARNING => 'Core Warning',
		E_COMPILE_ERROR => 'Compile Error',
		E_COMPILE_WARNING => 'Compile Warning',
		E_USER_ERROR => 'User Error',
		E_USER_WARNING => 'User Warning',
		E_USER_NOTICE => 'User Notice',
		E_STRICT => 'Runtime Notice'
	);
	return isset($maps[$level]) ? $maps[$level] : 'Unknown Error';
}

function get_http_error($code) {
	$maps = array(
		403 => 'Access Denied !',
		404 => 'Page Not Found !',
		500 => 'Internal Server Error !'
	);
	return isset($maps[$code]) ? $maps[$code] : "Error $code";
}

function is_error_on() {
	return str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors'));
}

function is_fatal_error($level) {
	return ((E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $level) === $level;
}

function custom_error($level, $message, $file, $line) {
	$name = get_error_name($level);
	if (is_fatal_error() || is_error_on()) {
		show_general_error($level, $message, $file, $line);
	}
}

function show_general_error($code, $message, $file = null, $line = null) {
	$vars = array(
		'error_code' => $code,
		'error_name' => get_error_name($code),
		'error_message' => $message, 
		'error_file' => $file,
		'error_line' => $line
	);
	
	$file = BASEPATH."modules/errors/general.php";

	if (file_exists($file)) {
		ob_start();
		extract($vars);
		include($file);
		$content = ob_get_contents();
		ob_end_clean();
		echo $content;
	}
}

function show_error($code, $message, $file = null, $line = null) {
	$vars = array(
		'error_code' => $code,
		'error_name' => get_http_error($code),
		'error_message' => $message
	);
	
	$file = BASEPATH."modules/errors/error.php";

	if (file_exists($file)) {
		set_content('file', $file, $vars);
	}
}

function show_alert($code, $message, $file = null, $line = null) {
	show_general_error($code, $message, $file = null, $line = null);
}

function show_403($message = 'Access Denied !') {
	show_error(403, $message);
}

function show_404($message = 'Page Not Found !') {
	show_error(404, $message);
}

function show_500($message = 'Internal Server Error !') {
	show_error(500, $message);
}