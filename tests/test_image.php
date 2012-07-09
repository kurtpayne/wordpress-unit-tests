<?php

/**
 * @group image
 * @group media
 * @group upload
 */
class TestImageMetaFunctions extends WP_UnitTestCase {
	function setUp() {
		if ( ! extension_loaded( 'gd' ) )
			$this->markTestSkipped( 'The gd PHP extension is not loaded.' );
		if ( ! extension_loaded( 'exif' ) )
			$this->markTestSkipped( 'The exif PHP extension is not loaded.' );
		if ( ! is_callable( 'wp_read_image_metadata' ) )
			$this->markTestSkipped( 'wp_read_image_metadata() is not callable.' );
		parent::setUp();
	}

	function test_exif_d70() {
		// exif from a Nikon D70
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/2004-07-22-DSC_0008.jpg');

		$this->assertEquals(6.3, $out['aperture']);
		$this->assertEquals('', $out['credit']);
		$this->assertEquals('NIKON D70', $out['camera']);
		$this->assertEquals('', $out['caption']);
		$this->assertEquals(strtotime('2004-07-22 17:14:59'), $out['created_timestamp']);
		$this->assertEquals('', $out['copyright']);
		$this->assertEquals(27, $out['focal_length']);
		$this->assertEquals(400, $out['iso']);
		$this->assertEquals(1/40, $out['shutter_speed']);
		$this->assertEquals('', $out['title']);
	}

	function test_exif_d70_mf() {
		// exif from a Nikon D70 - manual focus lens, so some data is unavailable
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/2007-06-17DSC_4173.JPG');

		$this->assertEquals(0, $out['aperture']);
		$this->assertEquals('', $out['credit']);
		$this->assertEquals('NIKON D70', $out['camera']);
		$this->assertEquals('', $out['caption']);
		$this->assertEquals(strtotime('2007-06-17 21:18:00'), $out['created_timestamp']);
		$this->assertEquals('', $out['copyright']);
		$this->assertEquals(0, $out['focal_length']);
		$this->assertEquals(0, $out['iso']); // interesting - a Nikon bug?
		$this->assertEquals(1/500, $out['shutter_speed']);
		$this->assertEquals('', $out['title']);
		#$this->assertEquals(array('Flowers'), $out['keywords']);
	}

	function test_exif_d70_iptc() {
		// exif from a Nikon D70 with IPTC data added later
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/2004-07-22-DSC_0007.jpg');

		$this->assertEquals(6.3, $out['aperture']);
		$this->assertEquals('IPTC Creator', $out['credit']);
		$this->assertEquals('NIKON D70', $out['camera']);
		$this->assertEquals('IPTC Caption', $out['caption']);
		$this->assertEquals(strtotime('2004-07-22 17:14:35'), $out['created_timestamp']);
		$this->assertEquals('IPTC Copyright', $out['copyright']);
		$this->assertEquals(18, $out['focal_length']);
		$this->assertEquals(200, $out['iso']);
		$this->assertEquals(1/25, $out['shutter_speed']);
		$this->assertEquals('IPTC Headline', $out['title']);
	}

	function test_exif_fuji() {
		// exif from a Fuji FinePix S5600 (thanks Mark)
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/a2-small.jpg');

		$this->assertEquals(4.5, $out['aperture']);
		$this->assertEquals('', $out['credit']);
		$this->assertEquals('FinePix S5600', $out['camera']);
		$this->assertEquals('', $out['caption']);
		$this->assertEquals(strtotime('2007-09-03 10:17:03'), $out['created_timestamp']);
		$this->assertEquals('', $out['copyright']);
		$this->assertEquals(6.3, $out['focal_length']);
		$this->assertEquals(64, $out['iso']);
		$this->assertEquals(1/320, $out['shutter_speed']);
		$this->assertEquals('', $out['title']);

	}

	/**
	 * @ticket 6571
	 */
	function test_exif_error() {

		// http://trac.wordpress.org/ticket/6571
		// this triggers a warning mesage when reading the exif block
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/waffles.jpg');

		$this->assertEquals(0, $out['aperture']);
		$this->assertEquals('', $out['credit']);
		$this->assertEquals('', $out['camera']);
		$this->assertEquals('', $out['caption']);
		$this->assertEquals(0, $out['created_timestamp']);
		$this->assertEquals('', $out['copyright']);
		$this->assertEquals(0, $out['focal_length']);
		$this->assertEquals(0, $out['iso']);
		$this->assertEquals(0, $out['shutter_speed']);
		$this->assertEquals('', $out['title']);
	}

	function test_exif_no_data() {
		// no exif data in this image (from burningwell.org)
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/canola.jpg');

		$this->assertEquals(0, $out['aperture']);
		$this->assertEquals('', $out['credit']);
		$this->assertEquals('', $out['camera']);
		$this->assertEquals('', $out['caption']);
		$this->assertEquals(0, $out['created_timestamp']);
		$this->assertEquals('', $out['copyright']);
		$this->assertEquals(0, $out['focal_length']);
		$this->assertEquals(0, $out['iso']);
		$this->assertEquals(0, $out['shutter_speed']);
		$this->assertEquals('', $out['title']);
	}

	/**
	 * @ticket 9417
	 */
	function test_utf8_iptc_tags() {

		// trilingual UTF-8 text in the ITPC caption-abstract field 
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/test-image-iptc.jpg');

		$this->assertEquals('This is a comment. / Это комментарий. / Βλέπετε ένα σχόλιο.', $out['caption']);
	}
	
	/**
	 * wp_read_image_metadata() should false if the image file doesn't exist
	 * @return void
	 */
	public function test_missing_image_file() {
		$out = wp_read_image_metadata(DIR_TESTDATA.'/images/404_image.png');
		$this->assertFalse($out);
	}
}

/**
 * @group image
 * @group media
 * @group upload
 */
class TestImageSizeFunctions extends WP_UnitTestCase {
	function test_constrain_dims_zero() {
		if (!is_callable('wp_constrain_dimensions'))
			$this->markTestSkipped('wp_constrain_dimensions() is not callable.');

		// no constraint - should have no effect
		$out = wp_constrain_dimensions(640, 480, 0, 0);
		$this->assertEquals(array(640, 480), $out);

		$out = wp_constrain_dimensions(640, 480);
		$this->assertEquals(array(640, 480), $out);

		$out = wp_constrain_dimensions(0, 0, 0, 0);
		$this->assertEquals(array(0, 0), $out);
	}

	function test_constrain_dims_smaller() {
		if (!is_callable('wp_constrain_dimensions'))
			$this->markTestSkipped('wp_constrain_dimensions() is not callable.');

		// image size is smaller than the constraint - no effect
		$out = wp_constrain_dimensions(500, 600, 1024, 768);
		$this->assertEquals(array(500, 600), $out);

		$out = wp_constrain_dimensions(500, 600, 0, 768);
		$this->assertEquals(array(500, 600), $out);

		$out = wp_constrain_dimensions(500, 600, 1024, 0);
		$this->assertEquals(array(500, 600), $out);
	}

	function test_constrain_dims_equal() {
		if (!is_callable('wp_constrain_dimensions'))
			$this->markTestSkipped('wp_constrain_dimensions() is not callable.');

		// image size is equal to the constraint - no effect
		$out = wp_constrain_dimensions(1024, 768, 1024, 768);
		$this->assertequals(array(1024, 768), $out);

		$out = wp_constrain_dimensions(1024, 768, 0, 768);
		$this->assertequals(array(1024, 768), $out);

		$out = wp_constrain_dimensions(1024, 768, 1024, 0);
		$this->assertequals(array(1024, 768), $out);
	}

	function test_constrain_dims_larger() {
		if (!is_callable('wp_constrain_dimensions'))
			$this->markTestSkipped('wp_constrain_dimensions() is not callable.');

		// image size is larger than the constraint - result should be constrained
		$out = wp_constrain_dimensions(1024, 768, 500, 600);
		$this->assertequals(array(500, 375), $out);

		$out = wp_constrain_dimensions(1024, 768, 0, 600);
		$this->assertequals(array(800, 600), $out);

		$out = wp_constrain_dimensions(1024, 768, 500, 0);
		$this->assertequals(array(500, 375), $out);

		// also try a portrait oriented image
		$out = wp_constrain_dimensions(300, 800, 500, 600);
		$this->assertequals(array(225, 600), $out);

		$out = wp_constrain_dimensions(300, 800, 0, 600);
		$this->assertequals(array(225, 600), $out);

		$out = wp_constrain_dimensions(300, 800, 200, 0);
		$this->assertequals(array(200, 533), $out);
	}

	function test_constrain_dims_boundary() {
		if (!is_callable('wp_constrain_dimensions'))
			$this->markTestSkipped('wp_constrain_dimensions() is not callable.');

		// one dimension is larger than the constraint, one smaller - result should be constrained
		$out = wp_constrain_dimensions(1024, 768, 500, 800);
		$this->assertequals(array(500, 375), $out);

		$out = wp_constrain_dimensions(1024, 768, 2000, 700);
		$this->assertequals(array(933, 700), $out);

		// portrait
		$out = wp_constrain_dimensions(768, 1024, 800, 500);
		$this->assertequals(array(375, 500), $out);

		$out = wp_constrain_dimensions(768, 1024, 2000, 700);
		$this->assertequals(array(525, 700), $out);
	}

	function test_shrink_dimensions_default() {
		$out = wp_shrink_dimensions(640, 480);
		$this->assertEquals(array(128, 96), $out);

		$out = wp_shrink_dimensions(480, 640);
		$this->assertEquals(array(72, 96), $out);
	}

	function test_shrink_dimensions_smaller() {
		// image size is smaller than the constraint - no effect
		$out = wp_shrink_dimensions(500, 600, 1024, 768);
		$this->assertEquals(array(500, 600), $out);

		$out = wp_shrink_dimensions(600, 500, 1024, 768);
		$this->assertEquals(array(600, 500), $out);
	}

	function test_shrink_dimensions_equal() {
		// image size is equal to the constraint - no effect
		$out = wp_shrink_dimensions(500, 600, 500, 600);
		$this->assertEquals(array(500, 600), $out);

		$out = wp_shrink_dimensions(600, 500, 600, 500);
		$this->assertEquals(array(600, 500), $out);
	}

	function test_shrink_dimensions_larger() {
		// image size is larger than the constraint - result should be constrained
		$out = wp_shrink_dimensions(1024, 768, 500, 600);
		$this->assertequals(array(500, 375), $out);

		$out = wp_shrink_dimensions(300, 800, 500, 600);
		$this->assertequals(array(225, 600), $out);
	}

	function test_shrink_dimensions_boundary() {
		// one dimension is larger than the constraint, one smaller - result should be constrained
		$out = wp_shrink_dimensions(1024, 768, 500, 800);
		$this->assertequals(array(500, 375), $out);

		$out = wp_shrink_dimensions(1024, 768, 2000, 700);
		$this->assertequals(array(933, 700), $out);

		// portrait
		$out = wp_shrink_dimensions(768, 1024, 800, 500);
		$this->assertequals(array(375, 500), $out);

		$out = wp_shrink_dimensions(768, 1024, 2000, 700);
		$this->assertequals(array(525, 700), $out);
	}

	function test_constrain_size_for_editor_thumb() {
		$out = image_constrain_size_for_editor(600, 400, 'thumb');
		$this->assertEquals(array(150, 100), $out);

		$out = image_constrain_size_for_editor(64, 64, 'thumb');
		$this->assertEquals(array(64, 64), $out);
	}

	function test_constrain_size_for_editor_medium() {
		// default max width is 500, no constraint on height
		global $content_width;
		$content_width = 0;
		update_option('medium_size_w', 500);
		update_option('medium_size_h', 0);

		$out = image_constrain_size_for_editor(600, 400, 'medium');
		$this->assertEquals(array(500, 333), $out);

		$out = image_constrain_size_for_editor(400, 600, 'medium');
		$this->assertEquals(array(400, 600), $out);

		$out = image_constrain_size_for_editor(64, 64, 'medium');
		$this->assertEquals(array(64, 64), $out);

		// content_width should be ignored
		$content_width = 350;
		$out = image_constrain_size_for_editor(600, 400, 'medium');
		$this->assertEquals(array(500, 333), $out);
	}

	function test_constrain_size_for_editor_full() {
		global $content_width;
		$content_width = 400;
		$out = image_constrain_size_for_editor(600, 400, 'full');
		$this->assertEquals(array(600, 400), $out);

		$out = image_constrain_size_for_editor(64, 64, 'full');
		$this->assertEquals(array(64, 64), $out);

		// content_width default is 500
		$content_width = 0;

		$out = image_constrain_size_for_editor(600, 400, 'full');
		$this->assertEquals(array(600, 400), $out);

		$out = image_constrain_size_for_editor(64, 64, 'full');
		$this->assertEquals(array(64, 64), $out);
	}

}

/**
 * @group image
 * @group media
 * @group upload
 */
class TestImageResizeDimensions extends WP_UnitTestCase {
	function test_400x400_no_crop() {
		// landscape: resize 640x480 to fit 400x400: 400x300
		$out = image_resize_dimensions(640, 480, 400, 400, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 400, 300, 640, 480), $out );

		// portrait: resize 480x640 to fit 400x400: 300x400
		$out = image_resize_dimensions(480, 640, 400, 400, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 300, 400, 480, 640), $out );
	}

	function test_400x0_no_crop() {
		// landscape: resize 640x480 to fit 400w: 400x300
		$out = image_resize_dimensions(640, 480, 400, 0, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 400, 300, 640, 480), $out );

		// portrait: resize 480x640 to fit 400w: 400x533
		$out = image_resize_dimensions(480, 640, 400, 0, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 400, 533, 480, 640), $out );
	}

	function test_0x400_no_crop() {
		// landscape: resize 640x480 to fit 400h: 533x400
		$out = image_resize_dimensions(640, 480, 0, 400, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 533, 400, 640, 480), $out );

		// portrait: resize 480x640 to fit 400h: 300x400
		$out = image_resize_dimensions(480, 640, 0, 400, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 300, 400, 480, 640), $out );
	}

	function test_800x800_no_crop() {
		// landscape: resize 640x480 to fit 800x800
		$out = image_resize_dimensions(640, 480, 800, 800, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );

		// portrait: resize 480x640 to fit 800x800
		$out = image_resize_dimensions(480, 640, 800, 800, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );
	}

	function test_800x0_no_crop() {
		// landscape: resize 640x480 to fit 800w
		$out = image_resize_dimensions(640, 480, 800, 0, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );

		// portrait: resize 480x640 to fit 800w
		$out = image_resize_dimensions(480, 640, 800, 0, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );
	}

	function test_0x800_no_crop() {
		// landscape: resize 640x480 to fit 800h
		$out = image_resize_dimensions(640, 480, 0, 800, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );

		// portrait: resize 480x640 to fit 800h
		$out = image_resize_dimensions(480, 640, 0, 800, false);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( false, $out );
	}

	// cropped versions

	function test_400x400_crop() {
		// landscape: crop 640x480 to fit 400x400: 400x400 taken from a 480x480 crop at (80. 0)
		$out = image_resize_dimensions(640, 480, 400, 400, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 80, 0, 400, 400, 480, 480), $out );

		// portrait: resize 480x640 to fit 400x400: 400x400 taken from a 480x480 crop at (0. 80)
		$out = image_resize_dimensions(480, 640, 400, 400, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 80, 400, 400, 480, 480), $out );
	}

	function test_400x0_crop() {
		// landscape: resize 640x480 to fit 400w: 400x300
		$out = image_resize_dimensions(640, 480, 400, 0, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 400, 300, 640, 480), $out );

		// portrait: resize 480x640 to fit 400w: 400x533
		$out = image_resize_dimensions(480, 640, 400, 0, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 400, 533, 480, 640), $out );
	}

	function test_0x400_crop() {
		// landscape: resize 640x480 to fit 400h: 533x400
		$out = image_resize_dimensions(640, 480, 0, 400, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 533, 400, 640, 480), $out );

		// portrait: resize 480x640 to fit 400h: 300x400
		$out = image_resize_dimensions(480, 640, 0, 400, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 0, 300, 400, 480, 640), $out );
	}

	function test_400x500_crop() {
		// landscape: crop 640x480 to fit 400x500: 400x400 taken from a 480x480 crop at (80. 0)
		$out = image_resize_dimensions(640, 480, 400, 500, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 120, 0, 400, 480, 400, 480), $out );

		// portrait: resize 480x640 to fit 400x400: 400x400 taken from a 480x480 crop at (0. 80)
		$out = image_resize_dimensions(480, 640, 400, 500, true);
		// dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
		$this->assertEquals( array(0, 0, 0, 20, 400, 500, 480, 600), $out );
	}

}

/**
 * @group image
 * @group media
 * @group upload
 */
class TestImageResize extends WP_UnitTestCase {
	// image_resize( $file, $max_w, $max_h, $crop=false, $suffix=null, $dest_path=null, $jpeg_quality=75)

	function setUp() {
		if ( ! extension_loaded( 'gd' ) )
			$this->markTestSkipped( 'The gd PHP extension is not loaded.' );
		parent::setUp();
	}

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

}

/**
 * @group image
 * @group media
 * @group upload
 */
class TestIsImageFunctions extends WP_UnitTestCase {
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
