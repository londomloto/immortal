<?php

if ( ! session_id()) {
	session_start();
}

function has_session($key) {
	return isset($_SESSION[$key]);
}

function get_session($key, $default = '') {
	return has_session($key) ? $_SESSION[$key] : $default;
}

function set_session($key, $value) {
	$_SESSION[$key] = $value;
}