<?php

function load_textdomain() {
    $locale = get_config('locale');
    $encoding = 'UTF-8';

    if (defined('LC_MESSAGES')) {
        setlocale(LC_MESSAGES, $locale);
    } else {
        putenv("LC_ALL=$locale");
    }
    
    bindtextdomain('app', LANGDIR);
    bind_textdomain_codeset('app', $encoding);
    
    textdomain('app');
}

function __($message) {
    return gettext($message);
}

function _e($message) {
    echo gettext($message);
}

load_textdomain();