<?php
include( 'images-base/image-data.php' );
require( 'color-module.php' );

function serve_image($slice = '') {
	global $info;

	// Prepare template image.
	$source = imagecreatefrompng('images-base/' . $slice);
	$width = imagesx($source);
	$height = imagesy($source);

	// Prepare target buffer.
	$target = imagecreatetruecolor($width, $height);
	imagealphablending($target, true);

	// Fill regions
	foreach ( $info[$slice] as $fill ) {
		$x = isset($fill['x']) ? $fill['x'] : 0;
		$y = isset($fill['y']) ? $fill['y'] : 0;
		$w = isset($fill['w']) ? $fill['w'] : $width;
		$h = isset($fill['h']) ? $fill['h'] : $height;
		if ( 'fill' == $fill['type'] ) {
			imagefilledrectangle($target, $x, $y, $x + $w, $y + $h, _color_gd($target, $fill['color']));
		} elseif ( 'gradient' == $fill['type'] ) {
			$start = (isset($fill['start']) && $fill['start']) ? $fill['start'] : $y;
			$stop = (isset($fill['stop']) && $fill['stop']) ? $fill['stop'] : $y + $h;
			for ($yy = $y; $yy < $y + $h; ++$yy) {
				$color = _color_blend($target, $fill['top'], $fill['bottom'], ( $yy - $start ) / ( $stop - $start - 1));
				imagefilledrectangle($target, $x, $yy, $x + $w, $yy + 1, $color);
			}
		}
	}

	// Blend over template.
	imagecopy($target, $source, 0, 0, 0, 0, $width, $height);

	// Clean up template image.
	imagedestroy($source);

	// Save image.
	header('Content-Type: image/png');
	header("Vary: Accept-Encoding"); // Handle proxies
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT"); // 10 days
	imagepng($target);
	imagedestroy($target);
	exit;
}

if ( isset($info[$_GET['src']]) )
	serve_image( $_GET['src'] );

?>
