<?php

function protocol() {
	static $protocol;
	if ( ! $protocol) {
		$protocol = 
			(! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || $_SERVER['SERVER_PORT'] == 443 
			? 'https://'
			: 'http://';
	}
	return $protocol;
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
		$base = protocol().$_SERVER['HTTP_HOST'].base_uri();
	}
	return $base;
}

function site_url($uri) {
	
	$site   = base_url();
	$index  = get_config('index');
	$suffix = get_config('suffix');

	if ( $uri != '/' && ! preg_match('/\\'.$suffix.'$/', $uri)) {
		$uri .= $suffix;
	}

	if ( ! empty($index)) {
		$site .= $index.'/';
	}

	$site .= trim($uri, '/');
	return $site;
}

function uri_segments() {
	$suf = get_config('suffix');

	$uri = trim(get_var('uri'), '/');
	$uri = preg_replace('/(\\'.$suf.')$/', '', $uri);
	$seg = explode('/', $uri);

	return $seg;
}

function uri_segment($index = 0) {
	$seg = uri_segments();
	return isset($seg[$index]) ? $seg[$index] : '';
}

/** common url helper */
function asset_url($path) {
	return base_url().'assets/'.$path;
}

function redirect($url) {
	if ( ! preg_match('/^http/', $url)) {
		$url = site_url($url);
	}
	header('Location: '.$url);
	exit();
}

function breadcrumb() {
	$segments = uri_segments();
	$default  = get_config('default');
	$current  = array_pop($segments);
	
	$html = '';
	$uris = array();

	if (count($segments) == 0 && $current != $default) {
		$html .= sprintf('<li><a href="%s" data-push="1">%s</a></li>', site_url($default), $default);
	}

	foreach($segments as $seg) {
		$uris[] = $seg;
		$html .= sprintf('<li><a href="%s" data-push="1">%s</a></li>', site_url(implode('/', $uris)), $seg);
	}

	if ( ! empty($current)) {
		$html .= sprintf('<li class="active">%s</li>', $current);
	}
	
	return '<ol class="breadcrumb" style="padding: 8px 0; margin-bottom: 0;">'.$html.'</ol><hr style="margin: 5px 0;">';
}