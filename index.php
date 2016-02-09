<?php

error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Jakarta');

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', __DIR__.DS);
include('libs/cores.php');
start();