<?php

function &asset_group() {
	
	static $group = array(
		'header' => array(),
		'footer' => array()
	);

	return $group;
}

function add_script($file) {
	if (is_array($file)) {
		foreach($file as $u) {
			add_script($u);
		}
	} else {
		$group =& asset_group();
		$group['footer'][] = $file;
	}
}

function get_script() {
	$group =& asset_group();
	$html  = '';
	foreach($group['footer'] as $file) {
		$html .= '<script src="'.$file.'"></script>'."\n";
	}
	return $html;
}