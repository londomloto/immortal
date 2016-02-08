<?php
	
	$post = get_post();
	
	$result = array(
		'success' => false,
		'message' => 'Invalid email address or password'
	);

	$login_attempt = get_session('login_attempt', 1);
	$remains = 30;

	if (has_session('login_timer')) {
		
		$elapsed = microtime(true) - get_session('login_timer');
		$remains = round(30 - $elapsed);

		if ($elapsed >= 30) {
			unset_session('login_timer');
			$login_attempt = 1;
		}

	}

	if ($login_attempt == 3) {
		
		$result['message'] = 'Too many failed login attempts. Please try again in '.$remains.' seconds';

		if ( ! has_session('login_timer')) {
			set_session('login_timer', microtime(true));
		}
	} else {
		
		$user = db_fetch_one('SELECT * FROM users WHERE email = ?', array($post['email']));

		if ($user && md5($post['password']) == $user['passwd']) {
				
			csrf_protect();

			$result['success'] = true;
			$result['message'] = '';

			unset($user['passwd']);
			set_session('user', $user);
			unset_session('login_attempt');
			unset_session('login_timer');
		} else {
			$login_attempt++;
			set_session('login_attempt', $login_attempt);
		}
	}

	sleep(1); // test doank
	print(json_encode($result));
?>