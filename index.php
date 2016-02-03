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

	$layout = 'main.php';

	if ( $module != '') {
		
		$modpath = BASEPATH.'modules/'.$module.'/';
		
		if (is_dir($modpath)) {

			$modcfg = new stdClass();
			$modcfg->path = $modpath;

			$validate = false;
			$redirect = 'login';

			if (file_exists($modpath.'config.php')) {
				
				$modcfg = json_decode(json_encode(include($modpath.'config.php')));
				$modcfg->path = $modpath;

				if (isset($modcfg->layout)) {
					$layout = $modcfg->layout.'.php';
				}

				if (isset($modcfg->validate)) {
					$validate = $modcfg->validate;
				}

				if (isset($modcfg->redirect)) {
					$redirect = $modcfg->redirect;
				}

			}

			add_module($module, $modcfg);

			if ($validate) {
				if ( ! has_session($validate)) {
					redirect($redirect);
				}
			}

			$page = array_shift($segments);

			// crawl extra path
			while(count($segments) > 0) {
				$path = implode('/', $segments);
				if (file_exists($modpath.$path.'.php')) {
					$page = $path;
					break;
				}
				array_pop($segments);
			}

			if (empty($page) || ! file_exists($modpath.$page.'.php')) {
				$page = $module;
			}

			$page = $modpath.$page.'.php';

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