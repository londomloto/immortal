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

	$module = uri_segment(0);
	$layout = 'main.php';

	if ($uri == '/') {
		$module = get_config('default');
	}

	set_var('module', $module);

	if ( $module != '') {
		
		$module = BASEPATH.'modules/'.$module.'/';
		
		if (is_dir($module)) {
			if (file_exists($module.'config.php')) {
				$modcfg = include($module.'config.php');
				if (isset($modcfg['layout'])) {
					$layout = $modcfg['layout'].'.php';
				}
			}
		}

		$page = uri_segment(1);

		if (empty($page) || ! file_exists($module.$page.'.php')) {
			$page = get_var('module');
		}

		$page = $module.$page.'.php';

		if (file_exists($page)) {
			ob_start();
			include($page);
			set_content(ob_get_contents());
			ob_end_clean();
		}

	}

	if ( ! is_ajax()) {
		include(BASEPATH.'layouts/'.$layout);
	} else {
		echo get_content();
	}

}

start();