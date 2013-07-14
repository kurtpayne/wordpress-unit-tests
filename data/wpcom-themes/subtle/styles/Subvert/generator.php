<?php
/*
Filename: 		generator.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Header generator script
Requires:
*/

function generateHeader ($sStyleFolder, $bReset) {

	global $wp_version;
	$aErrors = array();
	
	echo($wp_version);

	if (isset($wp_version) and $wp_version == "MU") {
		$sHeaderFile = $sStyleFolder . 'headers/' . md5($_SERVER['HTTP_HOST']) . '.jpg';
	} else {
		$sHeaderFile = $sStyleFolder . 'headers/header.jpg';
	}

	if (is_writable($sStyleFolder . 'headers/')) {
	
		if (function_exists('imagecopy')) {
			if ($bReset == 'true') {
				$imgHeaderBase = imagecreatefromjpeg($sStyleFolder . 'header_default.jpg');
			} else {
				$imgHeaderBase = imagecreatefromjpeg($_FILES['gi_subtle_header']['tmp_name']);
			}
			$imgHeaderOverlay = imagecreatefrompng($sStyleFolder . 'header.png');
	
			$imgHeader = imagecreatetruecolor(imagesx($imgHeaderOverlay), imagesy($imgHeaderOverlay));
			
			imagecopy($imgHeader, $imgHeaderBase, 20, 0, 0, 0, 820, 145);
			imagecopy($imgHeader, $imgHeaderOverlay, 0, 0, 0, 0, 860, 145);
			imagejpeg($imgHeader, $sHeaderFile, 100);
	
		} else {
	
			$aErrors[] = "Your host does not support the GD extension.  Check with them to see if support is available.";
	
		}
	
	} else {
	
		$aErrors[] = "The header file you uploaded was not written correctly.  Make sure that the header folder is writable.";
	
	}
	
	return $aErrors;
}

function getHeaderCSS ($sStyleFolder) {

	global $wp_version;
	$sOutput = '';

	if (isset($wp_version) and $wp_version == "MU") {
		$sHeaderFile = 'headers/' . md5($_SERVER['HTTP_HOST']) . '.jpg';
	} else {
		$sHeaderFile = 'headers/header.jpg';
	}

	$sStyleURL = str_replace(str_replace('\\', '/', ABSPATH), get_settings('siteurl') . '/', str_replace('\\', '/', dirname(__FILE__))) . '/';

	if (!file_exists($sStyleFolder . $sHeaderFile)) {
		$sOutput .= '#header .style_content { background-image: url(' . $sStyleURL . 'header.jpg); background-repeat: no-repeat; }';
	} else {
		$sOutput .= '#header .style_content { background-image: url(' . $sStyleURL . $sHeaderFile . '); background-repeat: no-repeat; }';
	}
	return $sOutput;
}
?>