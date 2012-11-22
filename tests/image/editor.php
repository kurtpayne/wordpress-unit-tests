<?php

/**
 * Test the WP_Image_Editor base class
 * @group image
 * @group media
 */
class Tests_Image_Editor extends WP_UnitTestCase {

	/**
	 * Image editor
	 * @var WP_Image_Editor
	 */
	protected $editor = null;

	/**
	 * Setup test fixture
	 */
	public function setup() {
		require_once( ABSPATH . WPINC . '/class-wp-image-editor.php' );

		include_once( DIR_TESTDATA . '/../includes/mock-image-editor.php' );

		// Mock up an abstract image editor based on WP_Image_Editor
		// note: this *HAS* to start with 'WP_Image_Editor_'
		$className = 'WP_Image_Editor_' . substr( md5( uniqid() ), -12 );
		$this->editor = $this->getMockForAbstractClass( 'WP_Image_Editor', array(
			'get_size',
			'get_suffix'
		), $className, false );

		// Override the filters to set our own image editor
		add_filter( 'wp_image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'wp_image_editors', array( $this, 'wp_editors' ) );
	}

	/**
	 * Tear down test fixture
	 */
	public function tearDown() {
		remove_filter( 'wp_image_editor_class', array( $this, 'image_editor_class' ) );
		remove_filter( 'wp_image_editors', array( $this, 'wp_editors' ) );
	}

	/**
	 * Override the wp_editors filter
	 * @return array
	 */
	public function wp_editors() {
		return array( get_class( $this->editor ) );
	}

	/**
	 * Override the image_editor_class filter
	 * @return mixed
	 */
	public function image_editor_class() {
		return get_class( $this->editor );
	}

	/**
	 * Test wp_get_image_editor() where load returns true
	 * @ticket 6821
	 */
	public function test_get_editor_load_returns_true() {

		// Swap out the PHPUnit mock with our custom mock
		$func = create_function( '', 'return "WP_Image_Editor_Mock";');
		remove_filter( 'wp_image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'wp_image_editor_class', $func );

		// Set load() to return true
		WP_Image_Editor_Mock::$load_return = true;

		// Load an image
		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( 'WP_Image_Editor_Mock', $editor );

		// Remove our custom Mock
		remove_filter( 'wp_image_editor_class', $func );
	}

	/**
	 * Test wp_get_image_editor() where load returns false
	 * @ticket 6821
	 */
	public function test_get_editor_load_returns_false() {

		// Swap out the PHPUnit mock with our custom mock
		$func = create_function( '', 'return "WP_Image_Editor_Mock";');
		remove_filter( 'wp_image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'wp_image_editor_class', $func );

		// Set load() to return true
		WP_Image_Editor_Mock::$load_return = new WP_Error();

		// Load an image
		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( 'WP_Error', $editor );

		// Remove our custom Mock
		remove_filter( 'wp_image_editor_class', $func );
	}

	/**
	 * Test test_quality
	 * @ticket 6821
	 */
	public function test_set_quality() {

		// Get an editor
		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		// Make quality readable
		$property = new ReflectionProperty( $editor, 'quality' );
		$property->setAccessible( true );

		// Ensure set_quality works
		$this->assertTrue( $editor->set_quality( 75 ) );
		$this->assertEquals( 75, $property->getValue( $editor ) );

		// Ensure the quality filter works
		$func = create_function( '', "return 100;");
		add_filter( 'wp_editor_set_quality', $func );
		$this->assertTrue( $editor->set_quality( 75 ) );
		$this->assertEquals( 100, $property->getValue( $editor ) );

		// Clean up
		remove_filter( 'wp_editor_set_quality', $func );
	}

	/**
	 * Test generate_filename
	 * @ticket 6821
	 */
	public function test_generate_filename() {

		// Get an editor
		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		$property = new ReflectionProperty( $editor, 'size' );
		$property->setAccessible( true );
		$property->setValue( $editor, array(
			'height' => 50,
			'width'  => 100
		));

		// Test with no parameters
		$this->assertEquals( 'canola-100x50.jpg', basename( $editor->generate_filename() ) );

		// Test with a suffix only
		$this->assertEquals( 'canola-new.jpg', basename( $editor->generate_filename( 'new' ) ) );

		// Test with a destination dir only
		$this->assertEquals(trailingslashit( realpath( get_temp_dir() ) ), trailingslashit( realpath( dirname( $editor->generate_filename( null, get_temp_dir() ) ) ) ) );

		// Test with a suffix only
		$this->assertEquals( 'canola-100x50.png', basename( $editor->generate_filename( null, null, 'png' ) ) );

		// Combo!
		$this->assertEquals( trailingslashit( realpath( get_temp_dir() ) ) . 'canola-new.png', $editor->generate_filename( 'new', realpath( get_temp_dir() ), 'png' ) );
	}

	/**
	 * Test get_size
	 * @ticket 6821
	 */
	public function test_get_size() {

		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		// Size should be false by default
		$this->assertNull( $editor->get_size() );

		// Set a size
		$size = array(
			'height' => 50,
			'width'  => 100
		);
		$property = new ReflectionProperty( $editor, 'size' );
		$property->setAccessible( true );
		$property->setValue( $editor, $size );

		$this->assertEquals( $size, $editor->get_size() );
	}

	/**
	 * Test get_suffix
	 * @ticket 6821
	 */
	public function test_get_suffix() {
		$editor = wp_get_image_editor( DIR_TESTDATA . '/images/canola.jpg' );

		// Size should be false by default
		$this->assertFalse( $editor->get_suffix() );

		// Set a size
		$size = array(
			'height' => 50,
			'width'  => 100
		);
		$property = new ReflectionProperty( $editor, 'size' );
		$property->setAccessible( true );
		$property->setValue( $editor, $size );

		$this->assertEquals( '100x50', $editor->get_suffix() );
	}
}
