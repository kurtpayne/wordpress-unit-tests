<?php

/**
 * @group image
 */
abstract class WP_Image_UnitTestCase extends WP_UnitTestCase {

	/**
	 * Set the image editor engine according to the unit test's specification
	 */
	public function setUp() {
		if ( ! call_user_func( array( $this->editor_engine, 'test' ) ) ) {
			$this->markTestSkipped( sprintf('The image editor engine %s is not supported on this system', $this->editor_engine) );
		}

		add_filter( 'wp_image_editors', array( $this, 'setEngine' ), 10, 2 );
	}

	/**
	 * Undo the image editor override
	 */
	public function tearDown() {
		remove_filter( 'wp_image_editors', array( $this, 'setEngine' ), 10, 2 );
	}

	/**
	 * Override the image editor engine
	 * @return string
	 */
	public function setEngine( $editors ) {
		return array( $this->editor_engine );
	}
}
