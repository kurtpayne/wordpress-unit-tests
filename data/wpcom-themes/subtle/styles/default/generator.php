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

	if (isset($wp_version) and $wp_version == "MU") {
		$sHeaderFile = $sStyleFolder . 'headers/' . md5($_SERVER['HTTP_HOST']) . '.jpg';
		$sMenuFile = $sStyleFolder . 'headers/' . md5($_SERVER['HTTP_HOST']) . '_menu.jpg';
	} else {
		$sHeaderFile = $sStyleFolder . 'headers/header.jpg';
		$sMenuFile = $sStyleFolder . 'headers/header_menu.jpg';
	}

	if (is_writable($sStyleFolder . 'headers/')) {
	
		if (function_exists('imagecopy')) {
			if ($bReset == 'true') {
				$imgHeaderBase = imagecreatefromjpeg($sStyleFolder . 'header_default.jpg');
			} else {
				$imgHeaderBase = imagecreatefromjpeg($_FILES['gi_subtle_header']['tmp_name']);
			}
			$imgHeaderOverlay = imagecreatefrompng($sStyleFolder . 'header.png');
			$imgMenuOverlay = imagecreatefrompng($sStyleFolder . 'header_menu.png');
	
			$imgHeader = imagecreatetruecolor(imagesx($imgHeaderOverlay), imagesy($imgHeaderOverlay));
			$imgMenu = imagecreatetruecolor(imagesx($imgMenuOverlay), imagesy($imgMenuOverlay));
			
			imagecopy($imgMenu, $imgHeaderBase, 0, 0, 20, 100, 780, 45);
			imagecopy($imgMenu, $imgMenuOverlay, 0, 0, 0, 0, 780, 45);
			imagejpeg($imgMenu, $sMenuFile, 100);
	
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
		$sMenuFile = 'headers/' . md5($_SERVER['HTTP_HOST']) . '_menu.jpg';
	} else {
		$sHeaderFile = 'headers/header.jpg';
		$sMenuFile = 'headers/header_menu.jpg';
	}

	$sStyleURL = str_replace(str_replace('\\', '/', ABSPATH), get_settings('siteurl') . '/', str_replace('\\', '/', dirname(__FILE__))) . '/';

	if (!file_exists($sStyleFolder . $sHeaderFile)) {
		$sOutput .= '#header .style_content { background-image: url(' . $sStyleURL . 'header.jpg); background-repeat: no-repeat; }';
		$sOutput .= '#menu { background-image: url(' . $sStyleURL . 'header_menu.jpg); background-repeat: no-repeat; }';
	} else {
		$sOutput .= '#header .style_content { background-image: url(' . $sStyleURL . $sHeaderFile . '); background-repeat: no-repeat; }';
		$sOutput .= '#menu { background-image: url(' . $sStyleURL . $sMenuFile . '); background-repeat: no-repeat; }';
	}
	return $sOutput;
}
?>