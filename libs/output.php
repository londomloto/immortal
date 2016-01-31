<?php

function &content() {
	static $content = '';
	return $content;
}

function set_content($page) {
	$content =& content();
	$content = $page;
}

function get_content() {
	$content =& content();
	return $content;
}