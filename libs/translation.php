<?php

function load_textdomain() {
    $locale = 'INDONESIA'; // 'id_ID.UTF-8'; // get_config('locale');
    //var_dump(setlocale(LC_ALL, $locale));
    bindtextdomain('app', LANGDIR);
    textdomain('app');
    bind_textdomain_codeset('app', 'UTF-8');
}

function __($message) {
    return gettext($message);
}

function _e($message) {
    echo gettext($message);
}

load_textdomain();