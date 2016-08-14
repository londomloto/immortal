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

function validate_uri($uri) {
    $chr = '?&#=+'.get_config('urlchars');
    $uri = str_replace('/', '', $uri);

    if ( ! empty($uri) && ! empty($chr) && ! preg_match('|^['.$chr.']+$|i', $uri)) {
        trigger_error('Disallowed URL chars', E_USER_ERROR);
    }
    return $uri;
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

function site_url($uri, $query = '') {
    
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

    if ($query) {
        $site = append_url($site, $query);
    }

    return $site;
}

function current_url($query = '') {
    $url  = rtrim(base_url(), '/').get_var('uri');
    $qry  = get_var('qry');
    
    if ( ! empty($qry)) {
        $url = append_url($url, $qry);
    }

    if ( ! empty($query)) {
        $url = append_url($url, $query);
    }
    return $url;
}

function xss_protect_query($query) {
    if ( ! empty($query)) {
        parse_str($query, $array);
        $array = xss_protect($array);
        $query = http_build_query($array);
    }
    return $query;
}

function append_url($url, $query) {

    $parsed = parse_url($url);
    $param1 = array();
    $param2 = array();

    // PHP 4: undefined index `path`
    if ( ! isset($parsed['path'])) {
        $uri = $_SERVER['REQUEST_URI'];
        $parsed['path'] = substr($uri, 0, strpos($uri, '?'));
    }

    if (isset($parsed['query'])) {
        $parsed['query'] = xss_protect_query($parsed['query']);
        parse_str($parsed['query'], $param1);
    }

    $query = xss_protect_query($query);
    parse_str($query, $param2);

    $params = array_merge($param1, $param2);
    $query  = http_build_query($params);

    $url = $parsed['scheme'].'://'.$parsed['host'].$parsed['path'];

    return $url.'?'.$query;
}

function uri_segments() {
    $suf = get_config('suffix');

    $uri = trim(get_var('uri'), '/');
    $uri = preg_replace('/(\\'.$suf.')$/', '', $uri);
    $seg = explode('/', $uri);

    return $seg;
}

function uri_segment($index = 0, $default = '') {
    $seg = uri_segments();
    return isset($seg[$index]) ? $seg[$index] : $default;
}

/** common url helper */
function asset_url($path) {
    return base_url().'assets/'.$path;
}

function redirect($url) {
    if ( ! preg_match('/^http/', $url)) {
        $url = site_url($url);
    }

    if (is_ajax()) {
        echo json_encode(array(
            'success'  => true,
            'redirect' => $url
        ));
    } else {
        header('Location: '.$url);
    }
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