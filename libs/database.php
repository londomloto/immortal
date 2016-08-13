<?php

function db() {
    return get_var('db');
}

function db_native_driver() {
    static $native;

    if ( ! $native) {
        $native = function_exists('mysqli_stmt_get_result');
    }

    return $native;
}

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
        add_errors(mysqli_connect_error());
    } else {
        if ( ! mysqli_set_charset($db, 'utf8')) {
            add_errors(mysqli_error($db));
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

function db_query($sql, $bind = null) {
    $db = get_var('db');

    $query = false;
    $stmt  = mysqli_stmt_init($db);
    $sql   = trim($sql);

    if (mysqli_stmt_prepare($stmt, $sql)) {

        if ( ! empty($bind)) {

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
            call_user_func_array('mysqli_stmt_bind_param', $params);
        }

        if (mysqli_stmt_execute($stmt)) {
            if (preg_match('/^(SELECT|SHOW)/i', $sql)) {
                if (db_native_driver()) {
                    $query = mysqli_stmt_get_result($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    return $stmt;
                }
            } else {
                $query = TRUE;
                mysqli_stmt_close($stmt);
            }
        } else {
            trigger_error(mysqli_stmt_error($stmt), E_USER_WARNING);
        }
    } else {
        trigger_error(mysqli_error($db), E_USER_WARNING);
    }
    return $query;
}

/**
 * free up memory for mysqli_result or mysqli_stmt
 */
function db_free_result($result) {
    if ($result instanceof mysqli_stmt) {
        $meta = mysqli_stmt_result_metadata($result);
        mysqli_stmt_close($result);
        mysqli_free_result($meta);
    } else {
        mysqli_free_result($result);    
    }
}

function db_list_fields($result) {
    if ($result instanceof mysqli_stmt) {
        $meta = mysqli_stmt_result_metadata($result);
        $fields = mysqli_fetch_fields($meta);
    } else {
        $fields = mysqli_fetch_fields($query);
    }
    return array_map(function($field) { return $field->name; }, $fields);
}

function db_bind_result($stmt) {
    $vars = db_list_fields($stmt);
    $size = count($vars);
    $args = array();

    for ($i = 0; $i < $size; $i++) {
        $args[] = &$vars[$i];
    }

    array_unshift($args, $stmt);
    call_user_func_array('mysqli_stmt_bind_result', $args);

    return $vars;
}

function db_fetch_all($sql, $bind = null) {
    $query = is_string($sql) ? db_query($sql, $bind) : $sql;
    $data  = array();
    if ($query) {
        if ($query instanceof mysqli_stmt) {

            $vars = db_list_fields($query);
            $size = count($vars);
            $args = $vars;

            for ($i = 0; $i < $size; $i++) {
                $args[$i] = &$args[$i];
            }

            call_user_func_array('mysqli_stmt_bind_result', array_merge(array($query), $args));

            while(mysqli_stmt_fetch($query)) {
                $row = array();
                for ($i = 0; $i < $size; $i++) {
                    $row[$vars[$i]] = $args[$i];
                }
                $data[] = $row;
            }
        } else {
            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
        }
        db_free_result($query);
    }
    return $data;
}

function db_fetch_one($sql, $bind = null) {
    $query = is_string($sql) ? db_query($sql, $bind) : $sql;
    $data  = null;
    if ($query) {
        if ($query instanceof mysqli_stmt) {
            $vars = db_list_fields($query);
            $size = count($vars);
            $args = $vars;

            for ($i = 0; $i < $size; $i++) {
                $args[$i] = &$args[$i];
            }

            call_user_func_array('mysqli_stmt_bind_result', array_merge(array($query), $args));
            
            if (mysqli_stmt_fetch($query)) {
                $data = array();
                for ($i = 0; $i < $size; $i++) {
                    $data[$vars[$i]] = $args[$i];
                }
            }
        } else {
            $data = mysqli_fetch_array($query, MYSQLI_ASSOC);
        }
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
    static $meta = array();

    if ( ! isset($meta[$table])) {
        $fields = db_fetch_all("SHOW COLUMNS FROM $table");
        $result = array();

        foreach($fields as $fld) {
            $row = array();

            $row['type'] = preg_replace('/(\(.*\))/', '', $fld['Type']);
            $row['name'] = $fld['Field'];
            $row['primary'] = $fld['Key'] == 'PRI';

            $result[] = $row;
        }

        $meta[$table] = $result;
    }
    return $meta[$table];
}

function db_field_name($table) {
    $fields = db_field_data($table);
    return array_map(function($f){ return $f['name']; }, $fields);
}

function db_insert($table, $data) {
    $names = db_field_name($table);
    $valid = false;
    
    $binds = array();
    $field = array();
    $token = array();

    foreach($data as $key => $val) {
        if (in_array($key, $names)) {
            $field[] = $key;
            $binds[] = $val;
            $token[] = '?';

            $valid   = true;
        }
    }

    if ($valid) {
        $sql = "INSERT INTO $table (".implode(", ", $field).") VALUES (".implode(", ", $token).")";
        return db_query($sql, $binds);
    }

    return false;
}

function db_update($table, $data, $keys = null) {
    $names = db_field_name($table);
    $valid = false;

    $field = array();
    $binds = array();
    $where = array();

    foreach($data as $key => $val) {
        if (in_array($key, $names)) {
            $field[] = "$key = ?";
            $binds[] = $val;
            $valid   = true;
        }
    }

    if ( ! empty($keys)) {
        foreach($keys as $key => $val) {
            if (in_array($key, $names)) {
                $where[] = "$key = ?";
                $binds[] = $val;
            }
        }
    }

    if ($valid) {
        $sql = "UPDATE $table SET ".implode(", ", $field)." WHERE 1 = 1";
        if ( ! empty($where)) {
            $sql .= " AND ".implode(" AND ", $where);
        }
        return db_query($sql, $binds);
    }
    return false;
}

function db_delete($table, $keys = null) {
    $names = db_field_name($table);
    $binds = array();
    $where = array();

    if ( ! empty($keys)) {
        foreach($keys as $key => $val) {
            if (in_array($key, $names)) {
                $where[] = "$key = ?";
                $binds[] = $val;
            }
        }
    }

    $sql = "DELETE FROM $table WHERE 1 = 1";
    if ( ! empty($where)) {
        $sql .= " AND ".implode(" AND ", $where);
    }
    return db_query($sql, $binds);
}

function db_insert_id() {
    return mysqli_insert_id(db());
}
