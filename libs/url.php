<?php

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

/** common url helper */
function asset_url($path) {
	return base_url().'assets/'.$path;
}