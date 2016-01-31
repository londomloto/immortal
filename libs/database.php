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

function db_query($sql) {
	$db = get_var('db');
	$query = mysqli_query($db, $sql);
	return $query;
}

function db_free_result($result) {
	mysqli_free_result($result);
}

function db_fetch_all($sql) {
	$query = db_query($sql);
	$data  = array();
	if ($query) {
		while($row = mysqli_fetch_object($query)) {
			$data[] = $row;
		}
		db_free_result($query);
	}
	return $data;
}

function db_fetch_one($sql) {
	$query = db_query($sql);
	$data  = null;
	if ($query) {
		$data = mysqli_fetch_object($query);
		db_free_result($query);
	}
	return $data;	
}

function db_list_tables() {
	$tables = db_fetch_all('SHOW TABLES');
	$dbname = get_config('database')->name;
	return array_map(
		function($row) use($dbname) { 
			return $row->{"Tables_in_$dbname"}; 
		}, 
		$tables
	);
}

function db_field_data($table) {
	$fields = db_fetch_all("SHOW COLUMNS FROM $table");
	$result = array();

	foreach($fields as $fld) {
		$row = new stdClass();

		$row->type = preg_replace('/(\(.*\))/', '', $fld->Type);
		$row->name = $fld->Field;
		$row->primary  = $fld->Key == 'PRI';

		$result[] = $row;
	}
	return $result;
}
