<?php

/**
 * @group image
 * @group media
 * @group upload
 */
class Tests_Image_Functions extends WP_UnitTestCase {
	function test_is_image_positive() {
		// these are all image files recognized by php
		$files = array(
			'test-image-cmyk.jpg',
			'test-image.bmp',
			'test-image-grayscale.jpg',
			'test-image.gif',
			'test-image.png',
			'test-image.tiff',
			'test-image-lzw.tiff',
			'test-image.jp2',
			'test-image.psd',
			'test-image-zip.tiff',
			'test-image.jpg',
			);

		foreach ($files as $file) {
			$this->assertTrue( file_is_valid_image( DIR_TESTDATA.'/images/'.$file ), "file_is_valid_image($file) should return true" );
		}
	}

	function test_is_image_negative() {
		// these are actually image files but aren't recognized or usable by php
		$files = array(
			'test-image.pct',
			'test-image.tga',
			'test-image.sgi',
			);

		foreach ($files as $file) {
			$this->assertFalse( file_is_valid_image( DIR_TESTDATA.'/images/'.$file ), "file_is_valid_image($file) should return false" );
		}
	}

	function test_is_displayable_image_positive() {
		// these are all usable in typical web browsers
		$files = array(
			'test-image.gif',
			'test-image.png',
			'test-image.jpg',
			);

		foreach ($files as $file) {
			$this->assertTrue( file_is_displayable_image( DIR_TESTDATA.'/images/'.$file ), "file_is_valid_image($file) should return true" );
		}
	}

	function test_is_displayable_image_negative() {
		// these are image files but aren't suitable for web pages because of compatibility or size issues
		$files = array(
			// 'test-image-cmyk.jpg', Allowed in r9727
			'test-image.bmp',
			// 'test-image-grayscale.jpg', Allowed in r9727
			'test-image.pct',
			'test-image.tga',
			'test-image.sgi',
			'test-image.tiff',
			'test-image-lzw.tiff',
			'test-image.jp2',
			'test-image.psd',
			'test-image-zip.tiff',
			);

		foreach ($files as $file) {
			$this->assertFalse( file_is_displayable_image( DIR_TESTDATA.'/images/'.$file ), "file_is_valid_image($file) should return false" );
		}
	}

}
