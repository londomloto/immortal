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

function &libraries() {
    static $libs = array();
    return $libs;
}

function load_library($name) {
    $libs =& libraries();
    $file = BASEPATH.'libs/'.$name.'.php';
    $load = false;
    if ( ! isset($libs[$name])) {
        if (file_exists($file)) {
            $libs[] = $name;
            include($file);
            $load = true;
        }
    } else {
        $load = true;
    }
    return $load;
}

function load_libraries() {
    $libs = array(
        'error',
        'module',
        'security',
        'url',
        'asset',
        'session'
    );

    $libs = array_unique(array_merge($libs, get_config('autoload', array())));
    $conn = get_config('database')->load;

    foreach($libs as $lib) {
        if (load_library($lib)) {
            if ($lib == 'database' && $conn) {
                db_start();
            }
        }
    }
}

function &content() {
    static $content = '';
    return $content;
}

function set_content($type, $data, $vars = array()) {
    $content =& content();
    $content = '';
    add_content($type, $data, $vars);
}

function add_content($type, $data, $vars = array()) {
    $content =& content();
    switch($type) {
        default:
        case 'plain':
            $content .= $data;
        break;
        case 'file':
            if (file_exists($data)) {
                ob_start();
                extract($vars);
                include($data);
                $content .= ob_get_contents();
                ob_end_clean();
            }
        break;
    }
}

function get_content() {
    $content =& content();
    $errors  =& errors();

    if (count($errors) > 0) {
        $fatal  = false;
        $errmsg = array();

        foreach($errors as $err) {
            $errmsg[] = $err['message'];
            if ($err['kind'] == 'fatal') {
                $fatal = true;
                break;
            }
        }

        $errmsg = implode('', $errmsg);
        
        if ($fatal) {
            $content = $errmsg;
        } else {
            $content = $errmsg.$content;
        }

        clear_errors();
    }

    return $content;
}

function is_ajax() {
    return ( 
        ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    );
}

function get_post($field = null, $default = '') {
    $_POST = xss_protect($_POST);
    if ( ! empty($field)) {
        return isset($_POST[$field]) ? $_POST[$field] : $default;
    }
    return $_POST;  
}

function get_param($field = null, $default = '') {
    $query  = get_var('qry');
    $params = array();
    if ( ! empty($query)) {
        parse_str($query, $params);
        $params = xss_protect($params);
    }
    if ( ! empty($field)) {
        return isset($params[$field]) ? $params[$field] : $default; 
    }
    return $params;
}

/**
 * Application entry point
 */
function start() {

    load_config();
    load_libraries();

    validate_uri($_SERVER['REQUEST_URI']);

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
    $segments = array_pad($segments, 1, '');
    $module   = $segments[0];

    if ($uri == '/') {
        $segments = explode('/', get_config('default'));
        $segments = array_pad($segments, 1, '');
        $module   = $segments[0];
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
            set_content('file', $page);

        }
    }

    if ( ! is_ajax()) {
        include(BASEPATH.'layouts/'.$layout);
    } else {
        echo get_content();
    }

}