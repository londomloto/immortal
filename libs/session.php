<?php

if ( ! session_id()) {
	session_start();
}

/**
 * fungsi untuk memeriksa apakah data ada di dalam session
 */
function has_session($key) {
	return isset($_SESSION[$key]);
}

/**
 * fungsi untuk mendapatkan data dari session
 */
function get_session($key, $default = '') {
	return has_session($key) ? $_SESSION[$key] : $default;
}

/**
 * fungsi untuk menyimpan data ke session
 */
function set_session($key, $value) {
	$_SESSION[$key] = $value;
}

/**
 * fungsi untuk menghapus session tertentu, 
 * bukan mengapus semua data dalam session
 */
function unset_session($key) {
	if (has_session($key)) {
		unset($_SESSION[$key]);
	}
}

/**
 * fungsi untuk membersihkan semua data dalam session
 */
function clear_session() {
	session_destroy();
}

/**
 * fungsi khusus untuk mendapatkan session user
 */
function get_user_session($key, $default = '') {
	if (has_session('user')) {
		$user = get_session('user');
		return isset($user[$key]) ? $user[$key] : $default;
	}
	return $default;
}