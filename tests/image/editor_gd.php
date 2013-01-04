<?php

/**
 * Test the WP_Image_Editor_GD class
 * @group image
 * @group media
 */

class Tests_Image_Editor_GD extends WP_Image_UnitTestCase {
	public $editor_engine = 'WP_Image_Editor_GD';

	public function setup() {
		require_once( ABSPATH . WPINC . '/class-wp-image-editor.php' );
		require_once( ABSPATH . WPINC . '/class-wp-image-editor-gd.php' );
		parent::setUp();
	}

	/**
	 * Test the image created with WP_Image_Edior_GD preserves alpha when resizing
	 * 
	 * @ticket 23039
	 */
	public function test_image_preserves_alpha_on_resize() {

		$file = DIR_TESTDATA . '/images/transparent.png';

		$editor = wp_get_image_editor( $file );
		$editor->load();
		$editor->resize(5,5);
		$save_to_file = tempnam( get_temp_dir(), '' ) . '.png';
		
		$editor->save( $save_to_file );

		$this->assertImageAlphaAtPoint( $save_to_file, array( 0,0 ), 127 );

	}
	
	/**
	 * Test the image created with WP_Image_Edior_GD preserves alpha with no resizing etc
	 * 
	 * @ticket 23039
	 */
	public function test_image_preserves_alpha() {

		$file = DIR_TESTDATA . '/images/transparent.png';

		$editor = wp_get_image_editor( $file );
		$editor->load();

		$save_to_file = tempnam( get_temp_dir(), '' ) . '.png';
		
		$editor->save( $save_to_file );

		$this->assertImageAlphaAtPoint( $save_to_file, array( 0,0 ), 127 );
	}

}
