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

function unset_session($key) {
	if (has_session($key)) {
		unset($_SESSION[$key]);
	}
}

function clear_session() {
	session_destroy();
}

function get_user_session($key, $default = '') {
	if (has_session('user')) {
		$user = get_session('user');
		return isset($user[$key]) ? $user[$key] : $default;
	}
	return $default;
}