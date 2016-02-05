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

function image_thumb($file, $width = 184, $height = 240) {
	if (file_exists($file)) {

		// ini_set('memory_limit', '500MB');	
		
		if ($info = @getimagesize($file)) {

			$mime = $info['mime'];
			
			$orig_width  = $info[0];
			$orig_height = $info[1];

			if ($width >= $orig_width && $height >= $orig_height) {
				$width  = $orig_width;
				$height = $orig_height;
			}

			$offset_x = 0;
			$offset_y = 0;

			$orig_ratio = $orig_width / $orig_height;
			$crop_ratio = $orig_width < $orig_height ? ($width / $height) : ($height / $width);

			if ($orig_ratio < $crop_ratio) {
				$temp        = $orig_height;
				$orig_height = $orig_width / $crop_ratio;
				$offset_y    = ($temp - $orig_height) / 2;
			} else if ($orig_ratio > $crop_ratio) {
				$temp       = $orig_width;
				$orig_width = $orig_height / $crop_ratio;
				$offset_x   = ($temp - $orig_width) / 2;
			}

			$ratio_x  = $width / $orig_width;
			$ratio_y  = $height / $orig_height;

			if ($ratio_x * $orig_height < $height) {
				$crop_width  = $width;
				$crop_height = ceil($ratio_x * $orig_height);
			} else {
				$crop_width  = ceil($ratio_y * $orig_width);
				$crop_height = $height;
			}

			$target  = imagecreatetruecolor($crop_width, $crop_height);
			$source  = imagecreatefromjpeg($file);
			$quality = 100;

			imagecopyresampled(
				$target, 
				$source, 
				0, 
				0, 
				$offset_x, 
				$offset_y, 
				$crop_width, 
				$crop_height, 
				$orig_width, 
				$orig_height
			);

			ob_start();
			imagejpeg($target, null, $quality);
			$content = ob_get_contents();
			ob_end_clean();

			imagedestroy($target);
			imagedestroy($source);

			header('Content-Type: '.$mime);
			header('Content-Length: '.strlen($content));

			echo $content;
			exit();

		}

	}

}