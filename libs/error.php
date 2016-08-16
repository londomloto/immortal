<?php
set_error_handler('custom_error');

function &errors() {
    static $errors = array();
    return $errors;
}

function set_errors($message, $kind = 'common') {
    clear_errors();
    add_errors($message, $kind);
}

function add_errors($message, $kind = 'common') {
    $errors =& errors();
    $errors[] = array(
        'kind' => $kind,
        'message' => $message
    );
}

function get_errors($kind = null) {
    $errors =& errors();
    if ( ! empty($kind)) {
        return array_map(
            function($err){
                return $err['message'];
            }, 
            array_filter(
                $errors, 
                function($err) use ($kind) {
                    return $err['kind'] == $kind;
                }
            )
        );
    } else {
        return array_map(
            function($err) {
                return $err['message'];
            },
            $errors
        );
    }
}

function clear_errors() {
    $errors =& errors();
    $errors = array();
}

function get_error_name($level) {
    $maps = array(
        E_ERROR => 'E-ERROR',
        E_WARNING => 'E-WARNING',
        E_PARSE => 'E-PARSE',
        E_NOTICE => 'E-NOTICE',
        E_CORE_ERROR => 'E-CORE-ERROR',
        E_CORE_WARNING => 'E-CORE-WARNING',
        E_COMPILE_ERROR => 'E-COMPILE-ERROR',
        E_COMPILE_WARNING => 'E-COMPILE-WARNING',
        E_USER_ERROR => 'E-USER-ERROR',
        E_USER_WARNING => 'E-USER-WARNING',
        E_USER_NOTICE => 'E-USER-NOTICE',
        E_STRICT => 'E-STRICT'
    );
    return isset($maps[$level]) ? $maps[$level] : 'Unknown Error';
}

function get_http_error($code) {
    $maps = array(
        403 => __('Access Denied !'),
        404 => __('Page Not Found !'),
        500 => __('Internal Server Error !')
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
    $vars = array(
        'error_code' => $level,
        'error_name' => get_error_name($level),
        'error_message' => $message, 
        'error_file' => $file,
        'error_line' => $line
    );
    
    $file = BASEPATH."modules/errors/general.php";

    if (file_exists($file)) {
        ob_start();
        extract($vars);
        include($file);
        $message = ob_get_contents();
        ob_end_clean();
        if (is_error_on()) {
            $kind = is_fatal_error($level) ? 'fatal' : 'common';
            add_errors($message, $kind);
        }
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
        ob_start();
        extract($vars);
        include($file);
        $message = ob_get_contents();
        ob_end_clean();
        add_errors($message, 'fatal');
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