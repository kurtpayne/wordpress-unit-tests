<?php
// FILENAME: gdi.php - A basic GDI library for PHP
// DATE: 05-07-14
// COPYRIGHT: 2005, Frazier Media
// AUTHOR: Christopher Frazier (cfrazier@fraziermedia.com)
// REQUIRES:

function getImageFromPath ($sURL) {
	if (strpos($sURL, 'http://') === false) {
		$sURL = getImagePath($sURL);
		list($iWidth, $iHeight, $iType, $sAttr) = getimagesize($sURL);
	} else {
		$aImageSize = getimagesize($sURL);
		list($iWidth, $iHeight, $iType, $sAttr) = $aImageSize;
	}

	switch ($iType) {
	case 1 : 
		$objImage = imagecreatefromgif($sURL);
		break;
	case 2 : 
		$objImage = imagecreatefromjpeg($sURL);
		break;
	case 3 : 
		$objImage = imagecreatefrompng($sURL);
		break;
	}
	return $objImage;
}

function displayImage ($objImage) {
	header("Content-type: image/jpeg");
	imagejpeg($objImage, null, 100);
}

function saveImage ($objImage, $sFilePath) {
	imagejpeg($objImage, $sFilePath, 100);
}

function resampleImage ($objImage, $iTargetWidth, $iTargetHeight) {
	$iMultiWidth = imagesx($objImage) / $iTargetWidth;
	$iMultiHeight = imagesy($objImage) / $iTargetHeight;
	if ($iMultiHeight < $iMultiWidth) {
		$iMultiple = $iMultiHeight;
	} else {
		$iMultiple = $iMultiWidth;
	}

	$objResampled = imagecreatetruecolor($iTargetWidth, $iTargetHeight);
	imagecopyresampled($objResampled, $objImage, 0, 0, 0, 0, imagesx($objImage) / $iMultiple, imagesy($objImage) / $iMultiple, imagesx($objImage), imagesy($objImage));	
	
	return $objResampled;
}

function overlayImage ($objImage, $objOverlay) {
	imagecopy($objImage, $objOverlay, 0, 0, 0, 0, imagesx($objOverlay), imagesy($objOverlay));
	return $objImage;
}

function getImagePath ($sPath) {
	$aStack = array();
	$aPath = explode('/', str_replace('\\', '/', $sPath));
	foreach ($aPath as $sPathStep) {
		if ($sPathStep == '..') {
			array_pop($aStack);
		} elseif ($sPathStep != '') {
			array_push($aStack, $sPathStep);
		}
	}
	return '/' . implode("/", $aStack);
}

?>