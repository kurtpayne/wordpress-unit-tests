<?php

/**
 * @group post
 */
class Tests_Post_Formats extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function test_set_get_post_format_for_post() {
		$post_id = $this->factory->post->create();

		$format = get_post_format( $post_id );
		$this->assertFalse( $format );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );

		$format = get_post_format( $post_id );
		$this->assertEquals( 'aside', $format );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		$result = set_post_format( $post_id, '' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );
	}

	/**
	 * @ticket 22473
	 */
	function test_set_get_post_format_for_page() {
		$post_id = $this->factory->post->create( array( 'post_type' => 'page' ) );

		$format = get_post_format( $post_id );
		$this->assertFalse( $format );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );
		// The format can be set but not retrieved until it is registered.
		$format = get_post_format( $post_id );
		$this->assertFalse( $format );
		// Register format support for the page post type.
		add_post_type_support( 'page', 'post-formats' );
		// The previous set can now be retrieved.
		$format = get_post_format( $post_id );
		$this->assertEquals( 'aside', $format );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		$result = set_post_format( $post_id, '' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		remove_post_type_support( 'page', 'post-formats' );
	}

	function test_has_format() {
		$post_id = $this->factory->post->create();

		$this->assertFalse( has_post_format( 'standard', $post_id ) );
		$this->assertFalse( has_post_format( '', $post_id ) );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );
		$this->assertTrue( has_post_format( 'aside', $post_id ) );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );
		// Standard is a special case. It shows as false when set.
		$this->assertFalse( has_post_format( 'standard', $post_id ) );

		// Dummy format type
		$this->assertFalse( has_post_format( 'dummy', $post_id ) );

		// Dummy post id
		$this->assertFalse( has_post_format( 'aside', 12345 ) );
	}
}