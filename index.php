<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', __DIR__.DS);

// cores libraries...
include('libs/common.php');
include('libs/output.php');
include('libs/url.php');

load_config();
load_libraries();

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

start();