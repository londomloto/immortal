<?php

function xss_protect($data) {
	$magic = get_magic_quotes_gpc();
	if (is_array($data)) {
		foreach($data as $key => $val) {
			$data[$key] = xss_protect($val);
		}
	} else {
		if (is_string($data)) {
			if ( ! $magic) {
				$data = addslashes($data);
			}
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
		}
	}
	return $data;
}

function csrf_token($name) {
	if (function_exists('hash_algos') && in_array('sha512', hash_algos())) {
		$token = hash('sha512', mt_rand(0, mt_getrandmax()));
	} else {
		$token = '';
		for ($i = 0; $i < 128; ++$i) {
			$r = mt_rand(0, 35);
			if ($r < 26) {
				$c = chr(ord('a') + $r);
			} else {
				$c = chr(ord('0') + $r - 26);
			}
			$token .= $c;
		}
	}
	set_session($name, $token);
	return $token;
}

function csrf_inject() {
	$name  = md5(uniqid(rand(), true));
	$token = csrf_token($name);
	echo "<input type='hidden' name='__xn' value='$name'>";
	echo "<input type='hidden' name='__xt' value='$token'>";
}

function csrf_validate($name, $token) {
	$hash  = get_session($name);
	$valid = false;
	if ($hash === $token) {
		$valid = true;
	}
	unset_session($name);
	return $valid;
}

function csrf_protect() {
	if (count($_POST) > 0) {
		if (isset($_POST['__xn'], $_POST['__xt'])) {
			$valid = csrf_validate($_POST['__xn'], $_POST['__xt']);
			unset($_POST['__xn'], $_POST['__xt']);
			if ( ! $valid) {
				if (is_ajax()) {
					print json_encode(array(
						'success' => false,
						'message' => 'You are not authorized!'
					));
					exit();
				} else {
					trigger_error("You are not authorized", E_USER_ERROR);
				}
			}
		}
	}
}