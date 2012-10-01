<?php

/**
 * @group image
 * @group media
 * @group upload
 */
class Tests_Image_Functions extends WP_UnitTestCase {

	/**
	 * Get the MIME type of a file
	 * @param string $filename
	 * @return string
	 */
	protected function get_mime_type( $filename ) {
		$mime_type = ''; 
		if ( extension_loaded( 'fileinfo' ) ) { 
			$finfo = new finfo();
			$mime_type = $finfo->file( $filename, FILEINFO_MIME );
		} elseif ( function_exists('mime_content_type') ) { 
			$mime_type = mime_content_type( $filename );
		}
		if ( false !== strpos( $mime_type, ';' ) ) {
			list( $mime_type, $charset ) = explode( ';', $mime_type, 2 );
		}
		return $mime_type;
	}
	
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
	
	/**
	 * Test save image file and mime_types
	 * @ticket 6821
	 */
	public function test_wp_save_image_file() {
		include_once( ABSPATH . 'wp-admin/includes/image-edit.php' );

		// Mime types
		$mime_types = array(
			'image/jpeg',
			'image/gif',
			'image/png'
		);
		
		// Test each image editor engine
		$classes = array('WP_Image_Editor_GD', 'WP_Image_Editor_Imagick');
		foreach ( $classes as $class ) {
			
			// If the image editor isn't available, skip it
			if ( !$class::test() ) {
				continue;
			}
			$filter = create_function( '', "return '$class';" );
			add_filter( 'image_editor_class', $filter );

			// Call wp_save_image_file
			$img = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );
			
			// Save a file as each mime type, assert it works
			foreach ( $mime_types as $mime_type ) {
				$file = wp_tempnam();				
				$ret = wp_save_image_file( $file, $img, $mime_type, 1 );
				$this->assertNotEmpty( $ret );
				$this->assertNotInstanceOf( 'WP_Error', $ret );
				$this->assertEquals( $mime_type, $this->get_mime_type( $ret['path'] ) );
				
				// Clean up
				@unlink( $file );
				@unlink( $ret['path'] );
			}

			// Clean up
			unset( $img );
		}
	}
	
	/**
	 * Test that a passed mime type overrides the extension in the filename
	 * @ticket 6821
	 */
	public function test_mime_overrides_filename() {

		// Test each image editor engine
		$classes = array('WP_Image_Editor_GD', 'WP_Image_Editor_Imagick');
		foreach ( $classes as $class ) {

			// If the image editor isn't available, skip it
			if ( !$class::test() ) {
				continue;
			}
			$filter = create_function( '', "return '$class';" );
			add_filter( 'image_editor_class', $filter );

			// Save the file
			$img = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );
			$mime_type = 'image/gif';
			$file = wp_tempnam( 'tmp.jpg' );
			$ret = $img->save( $file, $mime_type );
			
			// Make assertions
			$this->assertNotEmpty( $ret );
			$this->assertNotInstanceOf( 'WP_Error', $ret );
			$this->assertEquals( $mime_type, $this->get_mime_type( $ret['path'] ) );
			
			// Clean up
			@unlink( $file );
			@unlink( $ret['path'] );
			unset( $img );
		}
	}

	/**
	 * Test that mime types are correctly inferred from file extensions
	 * @ticket 6821
	 */
	public function test_inferred_mime_types() {

		// Mime types
		$mime_types = array(
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpe'  => 'image/jpeg',
			'gif'  => 'image/gif',
			'png'  => 'image/png',
			'unk'  => 'image/jpeg' // Default, unknown
		);

		// Test each image editor engine
		$classes = array('WP_Image_Editor_GD', 'WP_Image_Editor_Imagick');
		foreach ( $classes as $class ) {

			// If the image editor isn't available, skip it
			if ( !$class::test() ) {
				continue;
			}
			$filter = create_function( '', "return '$class';" );
			add_filter( 'image_editor_class', $filter );
			
			// Save the image as each file extension, check the mime type
			$img = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );
			$temp = get_temp_dir();
			foreach ( $mime_types as $ext => $mime_type ) {
				$file = wp_unique_filename( $temp, uniqid() . ".$ext" );
				$ret = $img->save( trailingslashit( $temp ) . $file );
				$this->assertNotEmpty( $ret );
				$this->assertNotInstanceOf( 'WP_Error', $ret );
				$this->assertEquals( $mime_type, $this->get_mime_type( $ret['path'] ) );
				@unlink( $file );
				@unlink( $ret['path'] );
			}

			// Clean up
			unset( $img );
		}
	}
}
