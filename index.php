<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', __DIR__.DS);

// cores libraries...
include('libs/common.php');
include('libs/output.php');
include('libs/url.php');
include('libs/asset.php');

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

	set_var('module', $module);

	$layout = 'main.php';

	if ( $module != '') {
		
		$module = BASEPATH.'modules/'.$module.'/';
		
		if (is_dir($module)) {

			if (file_exists($module.'config.php')) {
				
				$modcfg = include($module.'config.php');

				if (isset($modcfg['layout'])) {
					$layout = $modcfg['layout'].'.php';
				}

				if (isset($modcfg['script'])) {
					add_script($modcfg['script']);
				}
				
			}

			$page = array_shift($segments);

			// crawl extra path
			while(count($segments) > 0) {
				$path = implode('/', $segments);
				if (file_exists($module.$path.'.php')) {
					$page = $path;
					break;
				}
				$curr = array_pop($segments);
			}
			
			$path = implode('/', $segments);
			
			if (file_exists($module.$path.'.php')) {
				$page = $path;
			}

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

	}

	if ( ! is_ajax()) {
		include(BASEPATH.'layouts/'.$layout);
	} else {
		echo get_content();
	}

}

start();