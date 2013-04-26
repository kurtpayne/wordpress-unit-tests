<?php
/*
Thumby v 0.1, GPL 2, http://eight6.com/projects/thumby/

Created by Noel Jackson (http://eight6.com) for PhotoStack (http://photostack.org).

A simple class that creates and caches a thumbnail of the specified size for the specified image.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

$cache = $_SERVER['DOCUMENT_ROOT'].'/cache/';

$image_request = $_REQUEST['image'];
if(get_magic_quotes_gpc()) $image_request = stripslashes($_REQUEST['image']);

new Thumby($image_request, $cache, (int) $_REQUEST["w"], (int) ($_REQUEST["h"]), isset($_REQUEST['f']) );

class Thumby {

function not_found() {
	header("HTTP/1.0 404 Not Found");
	echo 'File not found.';
	exit;
}
	
function Thumby($image, $pathto_cache, $max_width = 1200, $max_height = 1200, $force_size = 0) {
	if($force_size = '') $force_size = 0;
	if($max_width == 0) $max_width = 1200;
	if($max_height == 0) $max_height = 1200;

	// If you know what you're doing, you can set this to "im" for ImageMagick, make sure to change $convert_path below
	$software = 'gd';
	$gal_path = $_SERVER['DOCUMENT_ROOT'];
	$ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
	$extensions = explode(",", 'jpg,jpe,jpeg,png,gif');
  	$image_path = $gal_path.'/'.$image;

	if( strpos($image, './') or !in_array($ext, $extensions) or !file_exists($image_path))
  		$this->not_found();

  	$thumb_path = $pathto_cache.$max_width."x".$max_height.($force_size?"f":"").strtr("-$gallery-$image",":/?\\","----");
  	$imageModified = @filemtime($image_path);
  	$thumbModified = @filemtime($thumb_path);	

	switch($ext) {
		case 'gif' : header("Content-type: image/gif"); break;
		case 'png' : header("Content-type: image/png"); break;
		default: header("Content-type: image/jpeg"); break;
	}
  	//if thumbnail is newer than image then output cached thumbnail and exit
 	if($imageModified<$thumbModified) { 
    	header("Last-Modified: ".gmdate("D, d M Y H:i:s",$thumbModified)." GMT");
    	readfile($thumb_path);
    	exit;
  	} else {
		$this->make_thumb($image_path, $thumb_path, $max_width, $max_height, $force_size);
	}
}

function make_thumb($image_path, $thumb_path, $max_width = 1200, $max_height = 1200, $force_size, $software="gd2", $convert_path = null) {

	$convert_path = '/opt/local/bin/convert';
		
	$thumbQuality = 95;
	list($image_width, $image_height, $image_type) = GetImageSize($image_path);
	
	 //if aspect ratio is to be constrained set crop size
	if($force_size) {
		$newAspect = $max_width/$max_height;
	    $oldAspect = $image_width/$image_height;
	
	    if($newAspect > $oldAspect) {
	      $cropWidth = $image_width;
	      $cropHeight = round($oldAspect/$newAspect * $image_height);
	    } else {
	      $cropWidth = round($newAspect/$oldAspect * $image_width);
	      $cropHeight = $image_height;
	    }
	  //else crop size is image size
	} else {
		$cropWidth = $image_width;
		$cropHeight = $image_height;
	}

	//set cropping offset
	$cropX = floor(($image_width-$cropWidth)/2);
	$cropY = floor(($image_height-$cropHeight)/2);

	//compute width and height of thumbnail to create
	if($cropWidth >= $max_width && ($cropHeight < $max_height || ($cropHeight > $max_height && round($cropWidth/$cropHeight * $max_height) > $max_width))) {
		$thumbWidth = $max_width;
	    $thumbHeight = round($cropHeight/$cropWidth * $max_width);
	} elseif($cropHeight >= $max_height) {
		$thumbWidth = round($cropWidth/$cropHeight * $max_height);
	    $thumbHeight = $max_height;
	} else {
		//image is smaller than required dimensions so output it and exit
	    readfile($image_path);
	    exit;
	}
	
	switch($software) {
		case "im" : //use ImageMagick
	  	// hack for square thumbs;
	  	if(($thumbWidth == $thumbHeight) or $force_size) {
	  		$thumbsize = $thumbWidth;
			if($image_height > $image_width) {
				$cropY = -($thumbsize / 2);
				$cropX = 0;
				$thumbcommand = "{$thumbsize}x";
			} else {
				$cropY = -($thumbsize / 2);
				$cropX = 0;
				$thumbcommand = "x{$thumbsize}";
			}
	    } else {
	    	$thumbcommand = $thumbWidth.'x'.$thumbHeight;
	    }
	    $cmd  = '"'.$convert_path.'"';
	    if($force_size) $cmd .= " -gravity center -crop {$thumbWidth}x{$thumbHeight}!+0+0";
	    $cmd .= " -resize {$thumbcommand}";
	    if($image_type == 2) $cmd .= " -quality $thumbQuality";
	    $cmd .= " -interlace Plane";
	    $cmd .= ' +profile "*"';
	    $cmd .= ' '.escapeshellarg($image_path).' '.escapeshellarg($thumb_path);
	   	exec($cmd);  
	   	readfile($thumb_path);
		exit;
	    break;

	  case "gd2" :
	  default : //use GD by default
	    //read in image as appropriate type
	    switch($image_type) {
	      case 1 : $image = ImageCreateFromGIF($image_path); break;
	      case 3 : $image = ImageCreateFromPNG($image_path); break;
	      case 2 : 
	      default: $image = ImageCreateFromJPEG($image_path); break;
	    }
		
		//create blank truecolor image
	    $thumb = ImageCreateTrueColor($thumbWidth,$thumbHeight);
	    
		//resize image with resampling
	    ImageCopyResampled( $thumb, $image, 0, 0, $cropX, $cropY, $thumbWidth, $thumbHeight, $cropWidth, $cropHeight);

	    //set image interlacing
	    ImageInterlace($thumb, $this->config->progressive_thumbs);

	    //output image of appropriate type
	    switch($image_type) {
	      case 1 :
	        //GIF images are output as PNG
	      case 3 :
	        ImagePNG($thumb,$thumb_path);
	        break;
	      case 2 :
	      default: 
	        ImageJPEG($thumb,$thumb_path,$thumbQuality);
	        break;
	    }
	    ImageDestroy($image);
	    ImageDestroy($thumb);
		readfile($thumb_path);
		
	  }	
	}
}
?>