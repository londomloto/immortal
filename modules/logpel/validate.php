<?php
	$post = get_post();
	
	$pelanggan = db_fetch_one('SELECT * FROM pelanggan WHERE email = ?', array($post['email']));

	$result = array(
		'success' => false,
		'message' => 'Email atau password salah !'
	);
	
	if ($pelanggan && md5($post['password']) == $pelanggan['password']) {
		
		csrf_protect();

		$result['success'] = true;
		$result['message'] = '';

		unset($pelanggan['password']);
		set_session('pelanggan', $pelanggan);
	}
	
	sleep(1); // test doank
	print(json_encode($result));
?>