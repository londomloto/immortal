<?php

function db_start() {

	$config = get_config('database');

	$db = @mysqli_connect(
		$config->host,
		$config->user,
		$config->pass,
		$config->name
	);

	if (mysqli_connect_errno()) {
		db_set_error(mysqli_connect_error());
	} else {
		if ( ! mysqli_set_charset($db, 'utf8')) {
			db_set_error(mysqli_erorr($db));
		} else {
			set_var('db', $db);	
		}
	}
}

function db_stop() {
	
	$db = get_var('db');

	if ($db) {
		mysqli_close($db);
	}

}

function db_escape($value) {
	$db = get_var('db');
	return mysqli_real_escape_string($db, stripslashes($value));
}

function db_query($sql, $bind = array()) {
	$db = get_var('db');

	$query = false;
	$dml   = ! preg_match('/^SELECT/i', trim($sql));

	if (count($bind) > 0) {

		$stmt = mysqli_stmt_init($db);

		if ( ! mysqli_stmt_prepare($stmt, $sql)) {
			db_set_error("Failed to prepare statement for query $sql");
		} else {
			
			$types  = '';
			$values = array();

			foreach($bind as $key => &$value) {

				$value = stripslashes($value);

				if (is_numeric($value)) {
					$float = floatval($value);
					if ($float && intval($float) != $float) {
						$types .= 'd';
					} else {
						$types .= 'i';
					}
				} else {
					$types .= 's';
				}

				$values[$key] = &$bind[$key];

			}

			$params  = array_merge(array($stmt, $types), $bind);
			$success = call_user_func_array('mysqli_stmt_bind_param', $params);

			if ( ! $success) {
				db_set_error("Failed to bind param $value");
			}
			
			if (mysqli_stmt_execute($stmt)) {
				$query = mysqli_stmt_get_result($stmt);
			}
		}

		mysqli_stmt_close($stmt);

	} else {
		$query = mysqli_query($db, $sql);	
	}

	if ($dml) {
		if (($error = mysqli_error($db))) {
			$query = false;
			db_set_error($error);
		} else {
			$query = true;
		}
	}
	
	return $query;
}

function db_free_result($result) {
	mysqli_free_result($result);
}

function db_fetch_all($sql) {
	$query = db_query($sql);
	$data  = array();
	if ($query) {
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		db_free_result($query);
	}
	return $data;
}

function db_fetch_one($sql, $bind = array()) {
	$query = db_query($sql, $bind);
	$data  = null;
	if ($query) {
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		db_free_result($query);
	}
	return $data;	
}

function db_list_tables() {
	$tables = db_fetch_all('SHOW TABLES');
	$dbname = get_config('database')->name;
	return array_map(
		function($row) use($dbname) { 
			return $row["Tables_in_$dbname"]; 
		}, 
		$tables
	);
}

function db_field_data($table) {
	$fields = db_fetch_all("SHOW COLUMNS FROM $table");
	$result = array();

	foreach($fields as $fld) {
		$row = array();

		$row['type'] = preg_replace('/(\(.*\))/', '', $fld['Type']);
		$row['name'] = $fld['Field'];
		$row['primary'] = $fld['Key'] == 'PRI';

		$result[] = $row;
	}
	return $result;
}

function &db_errors() {
	static $errors = [];
	return $errors;
}

function db_set_error($message) {
	$errors =& db_errors();
	$errors[] = $message;
}

function db_get_errors() {
	$errors =& db_errors();
	return $errors;
}