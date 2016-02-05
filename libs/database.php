<?php

function db_start() {

	$config = get_config('database');
	$retval = false;

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
			db_set_error(mysqli_error($db));
		} else {
			set_var('db', $db);
			$retval = true;
		}
	}

	return $retval;
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
	$stmt  = mysqli_stmt_init($db);
	$sql   = trim($sql);

	if (mysqli_stmt_prepare($stmt, $sql)) {

		if (count($bind) > 0) {

			$types  = '';
			$values = array();

			foreach($bind as $key => &$value) {
				$value = stripslashes($value);
				if (is_numeric($value)) {
					$float  = floatval($value);
					$types .= ($float && intval($float) != $float) ? 'd' : 'i';
				} else {
					$types .= 's';
				}
				$values[$key] = &$bind[$key];
			}

			$params = array_merge(array($stmt, $types), $bind);
			
			set_error_handler('db_error_handler');

			try {
				call_user_func_array('mysqli_stmt_bind_param', $params);
			} catch(Exception $e) {
				db_set_error($e->getMessage());
			}

			restore_error_handler();

		}

		if (mysqli_stmt_execute($stmt)) {
			$query = (preg_match('/^(SELECT|SHOW)/i', $sql)) ? mysqli_stmt_get_result($stmt) : true;
		} else {
			db_set_error(mysqli_error($db));
		}

		mysqli_stmt_close($stmt);

	} else {
		db_set_error(mysqli_error($db));
	}

	return $query;
}

function db_free_result($result) {
	mysqli_free_result($result);
}

function db_fetch_all($sql, $bind = array()) {
	$query = db_query($sql, $bind);
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

function db_total_rows() {
	$row = db_fetch_one("SELECT FOUND_ROWS() AS total");
	return (int) $row['total'];
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

function db_error_handler($no, $msg, $file, $line) {
	throw new Exception(sprintf('%s (%s:%d)', $msg, $file, $line), $no);
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