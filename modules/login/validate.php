<?php
	$post = get_post();

	// $user = db_fetch_one("SELECT * FROM users WHERE email = '". db_escape($post['email']) ."'");
	// atau lebih aman...
	
	$user = db_fetch_one('SELECT * FROM users WHERE email = ?', array($post['email']));
	
	$result = array(
		'success' => false,
		'message' => 'Invalid email address or password'
	);

	if ($user && password_verify($post['password'], $user['passwd'])) {
		$result['success'] = true;
		$result['message'] = '';

		unset($user['passwd']);
		set_session('user', $user);
		
	}

	sleep(1); // test doank
	print(json_encode($result));
?>