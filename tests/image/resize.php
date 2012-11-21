<?php

/**
 * @group image
 * @group media
 * @group upload
 */
abstract class WP_Tests_Image_Resize_UnitTestCase extends WP_Image_UnitTestCase {
	// image_resize( $file, $max_w, $max_h, $crop=false, $suffix=null, $dest_path=null, $jpeg_quality=75)

	function test_resize_jpg() {
		$image = image_resize( DIR_TESTDATA.'/images/test-image.jpg', 25, 25 );
		$this->assertEquals( 'test-image-25x25.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 25, $w );
		$this->assertEquals( 25, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		unlink($image);
	}

	function test_resize_png() {
		$image = image_resize( DIR_TESTDATA.'/images/test-image.png', 25, 25 );
		$this->assertEquals( 'test-image-25x25.png', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 25, $w );
		$this->assertEquals( 25, $h );
		$this->assertEquals( IMAGETYPE_PNG, $type );
		unlink($image);
	}

	function test_resize_gif() {
		$image = image_resize( DIR_TESTDATA.'/images/test-image.gif', 25, 25 );
		$this->assertEquals( 'test-image-25x25.gif', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 25, $w );
		$this->assertEquals( 25, $h );
		$this->assertEquals( IMAGETYPE_GIF, $type );
		unlink($image);
	}

	function test_resize_larger() {
		// image_resize() should refuse to make an image larger
		$image = image_resize( DIR_TESTDATA.'/images/test-image.jpg', 100, 100 );
		$this->assertInstanceOf( 'WP_Error', $image );
		$this->assertEquals( 'error_getting_dimensions', $image->get_error_code() );
	}

	function test_resize_thumb_128x96() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 128, 96 );
		$this->assertEquals( '2007-06-17DSC_4173-63x96.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 63, $w );
		$this->assertEquals( 96, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( 'be8f7aaa7b939970a3ded069a6e3619b', md5_file($image) );
		unlink($image);
	}

	function test_resize_thumb_128x0() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 128, 0 );
		$this->assertEquals( '2007-06-17DSC_4173-128x192.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 128, $w );
		$this->assertEquals( 192, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( '7b1c0d5e7d4f6a18ae7541c8abf1fd09', md5_file($image) );
		unlink($image);
	}

	function test_resize_thumb_0x96() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 0, 96 );
		$this->assertEquals( '2007-06-17DSC_4173-63x96.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 63, $w );
		$this->assertEquals( 96, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( 'be8f7aaa7b939970a3ded069a6e3619b', md5_file($image) );
		unlink($image);
	}

	function test_resize_thumb_150x150_crop() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 150, 150, true );
		$this->assertEquals( '2007-06-17DSC_4173-150x150.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 150, $w );
		$this->assertEquals( 150, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( '9fdcf728e1d43da89edf866d009ca7e8', md5_file($image) );
		unlink($image);
	}

	function test_resize_thumb_150x100_crop() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 150, 100, true );
		$this->assertEquals( '2007-06-17DSC_4173-150x100.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 150, $w );
		$this->assertEquals( 100, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( '2eeb18856505ab946074d90babc46452', md5_file($image) );
		unlink($image);
	}

	function test_resize_thumb_50x150_crop() {
		$image = image_resize( DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG', 50, 150, true );
		$this->assertEquals( '2007-06-17DSC_4173-50x150.jpg', basename($image) );
		list($w, $h, $type) = getimagesize($image);
		$this->assertEquals( 50, $w );
		$this->assertEquals( 150, $h );
		$this->assertEquals( IMAGETYPE_JPEG, $type );
		// is this a valid test? do different systems always generate the same file?
		#$this->assertEquals( '94ed8e8463475774a5c5ff66118d3127', md5_file($image) );
		unlink($image);
	}

	/**
	 * Try resizing a non-existent image
	 * @ticket 6821
	 */
	public function test_resize_non_existent_image() {
		$image = image_resize( DIR_TESTDATA.'/images/test-non-existent-image.jpg', 25, 25 );
		$this->assertInstanceOf( 'WP_Error', $image );
		$this->assertEquals( 'error_loading_image', $image->get_error_code() );
	}

	/**
	 * Try resizing a php file (bad image)
	 * @ticket 6821
	 */
	public function test_resize_bad_image() {
		$image = image_resize( DIR_TESTDATA.'/export/crazy-cdata.xml', 25, 25 );
		$this->assertInstanceOf( 'WP_Error', $image );
		$this->assertEquals( 'invalid_image', $image->get_error_code() );
	}
}
