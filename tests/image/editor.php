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
		if ( !class_exists( 'WP_Image_Editor' ) )
			$this->markTestSkipped();

		// Include our custom mock
		include_once( DIR_TESTDATA . '/../includes/mock-image-editor.php' );

		// Mock up an abstract image editor based on WP_Image_Editor
		// note: this *HAS* to start with 'WP_Image_Editor_'
		$className = 'WP_Image_Editor_' . substr( md5( uniqid() ), -12 );
		$this->editor = $this->getMockForAbstractClass( 'WP_Image_Editor', array(
			'get_size',
			'get_suffix'
		), $className, false );

		// Override the filters to set our own image editor
		add_filter( 'image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'wp_editors', array( $this, 'wp_editors' ) );

		// Un-cache the chosen image implementation
		$this->_uncache_implementation();
	}

	/**
	 * Tear down test fixture
	 */
	public function tearDown() {
		remove_filter( 'image_editor_class', array( $this, 'image_editor_class' ) );
		remove_filter( 'wp_editors', array( $this, 'wp_editors' ) );
	}

	/**
	 * Unset the static implementation cache
	 */
	protected function _uncache_implementation() {
		$class = new ReflectionClass( 'WP_Image_Editor' );
		$var = $class->getProperty( 'implementation' );
		$var->setAccessible( true );
		$var->setValue( $class, null );
	}

	/**
	 * Override the wp_editors filter
	 * @return array
	 */
	public function wp_editors() {
		return array( preg_replace('/^WP_Image_Editor_/', '', get_class( $this->editor ) ) );
	}

	/**
	 * Override the image_editor_class filter
	 * @return mixed
	 */
	public function image_editor_class() {
		return get_class( $this->editor );
	}

	/**
	 * Test get_instance where load returns true
	 * @ticket 6821
	 */
	public function test_get_instance_load_returns_true() {

		// Swap out the PHPUnit mock with our custom mock
		$func = create_function( '', 'return "WP_Image_Editor_Mock";');
		remove_filter( 'image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'image_editor_class', $func );

		// Set load() to return true
		WP_Image_Editor_Mock::$load_return = true;

		// Load an image
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( 'WP_Image_Editor_Mock', $editor );

		// Remove our custom Mock
		remove_filter( 'image_editor_class', $func );
	}

	/**
	 * Test get_instance where load returns false
	 * @ticket 6821
	 */
	public function test_get_instance_load_returns_false() {

		// Swap out the PHPUnit mock with our custom mock
		$func = create_function( '', 'return "WP_Image_Editor_Mock";');
		remove_filter( 'image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'image_editor_class', $func );

		// Set load() to return true
		WP_Image_Editor_Mock::$load_return = new WP_Error();

		// Load an image
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( 'WP_Error', $editor );

		// Remove our custom Mock
		remove_filter( 'image_editor_class', $func );
	}

	/**
	 * Test the "test" method
	 * @ticket 6821
	 */
	public function test_test_returns_true() {

		// $editor::test() returns true
		$this->editor->staticExpects( $this->once() )
				     ->method( 'test' )
				     ->will( $this->returnValue( true ) );

		// Load an image
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( get_class( $this->editor ), $editor );
	}

	/**
	 * Test the "test" method returns false and the fallback editor is chosen
	 * @ticket 6821
	 */
	public function test_test_returns_false() {

		// $editor::test() returns true
		$this->editor->staticExpects( $this->once() )
				     ->method( 'test' )
				     ->will( $this->returnValue( false ) );

		// Set a fallback editor
		$className = preg_replace('/^WP_Image_Editor_/', '', get_class( $this->editor ) );
		$func = create_function( '', "return array('$className', 'Mock');" );
		remove_filter( 'wp_editors', array( $this, 'wp_editors' ) );
		remove_filter( 'image_editor_class', array( $this, 'image_editor_class' ) );
		add_filter( 'wp_editors', $func );

		// Load an image
		WP_Image_Editor_Mock::$load_return = true;
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

		// Everything should work
		$this->assertInstanceOf( 'WP_Image_Editor_Mock', $editor );

		// Unhook
		remove_filter( 'image_editor_class', '__return_null' );
		remove_filter( 'wp_editors', $func );
	}

	/**
	 * Test test_quality
	 * @ticket 6821
	 */
	public function test_set_quality() {

		// Get an editor
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

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
		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );
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

		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

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

		$editor = WP_Image_Editor::get_instance( DIR_TESTDATA . '/images/canola.jpg' );

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
