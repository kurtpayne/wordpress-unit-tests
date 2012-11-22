<?php

/**
 * @group image
 */
abstract class WP_Image_UnitTestCase extends WP_UnitTestCase {

	/**
	 * Set the image editor engine according to the unit test's specification
	 */
	public function setUp() {
		$class = $this->editor_engine;
		if ( ! call_user_func( array( $class, 'test' ) ) ) {
			$this->markTestSkipped( sprintf('The image editor engine %s is not supported on this system', $this->editor_engine) );
		}
		add_filter( 'wp_image_editor_class', array( $this, 'setEngine') );
	}

	/**
	 * Undo the image editor override
	 */
	public function tearDown() {
		remove_filter( 'wp_image_editor_class', array( $this, 'setEngine' ) );
	}

	/**
	 * Override the image editor engine
	 * @return string
	 */
	public function setEngine() {
		return $this->editor_engine;
	}
}
