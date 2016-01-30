<?php

function db_start() {

	$config = get_config('database');

	$db = mysqli_connect(
		$config->host,
		$config->user,
		$config->pass,
		$config->name
	);

	if (mysqli_connect_errno()) {
		echo 'Failed to connect to database '.mysqli_connect_error();
		exit();
	}

	set_var('db', $db);
}

function db_stop() {
	$db = get_var('db');
	if ($db) {
		mysqli_close($db);
	}
}
