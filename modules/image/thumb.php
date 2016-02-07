<?php

$segs = array_slice(uri_segments(), 2);
$size = array_shift($segs);
$file = implode('/', $segs);

$path = BASEPATH.'assets/'.$file;

if (file_exists($path)) {
	$size = explode('x', $size);
	$size = array_pad($size, 1, $size[0]);
	thumbify($path, $size[0], $size[1]);
}

exit();
?>