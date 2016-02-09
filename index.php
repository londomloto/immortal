<?php

error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Jakarta');

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', __DIR__.DS);

include('libs/cores.php');

load_config();
load_libraries();

function start() {

	$url = parse_url($_SERVER['REQUEST_URI']);
	$uri = isset($url['path']) ? $url['path'] : '';
	$qry = isset($url['query']) ? $url['query'] : '';

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
	set_var('qry', $qry);

	$segments = uri_segments();
	$module   = isset($segments[0]) ? $segments[0] : '';

	if ($uri == '/') {
		$module = get_config('default');
	}

	$layout = 'main.php';

	if ( $module != '') {

		$module = init_module($module);

		if ($module) {
			$layout = $module->layout.'.php';
			$page   = array_shift($segments);

			while(count($segments) > 0) {
				$path = implode('/', $segments);
				if (file_exists($module->path.$path.'.php')) {
					$page = $path;
					break;
				}
				array_pop($segments);
			}

			if (empty($page) || ! file_exists($module->path.$page.'.php')) {
				$page = $module->name;
			}
			
			$page = $module->path.$page.'.php';

			if (file_exists($page)) {
				ob_start();
				include($page);
				set_content(ob_get_contents());
				ob_end_clean();
			}

		}

	}

	if ( ! is_ajax()) {
		include(BASEPATH.'layouts/'.$layout);
	} else {
		echo get_content();
	}

}

start();