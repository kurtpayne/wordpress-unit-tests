<?php

/**
 * @group post
 */
class Tests_Post_Objects extends WP_UnitTestCase {

	function test_get_post() {
		$id = $this->factory->post->create();

		$post = get_post( $id );

		$this->assertEquals( $id, $post->ID );

		$this->assertTrue( isset( $post->post_type ) );
		$this->assertEquals( 'post', $post->post_type );

		unset( $post->post_type );
		$this->assertFalse( isset( $post->post_type ) );
	}

	function test_get_post_filter() {
		$post = get_post( $this->factory->post->create( array(
			'post_title' => "Mary's home"
		) ) );

		$this->assertEquals( 'raw', $post->filter );
		$this->assertInternalType( 'int', $post->post_parent );

		$display_post = get_post( $post, OBJECT, 'js' );
		$this->assertEquals( 'js', $display_post->filter );
		$this->assertEquals( esc_js( "Mary's home" ), $display_post->post_title );

		// Pass a js filtered WP_Post to get_post() with the filter set to raw.
		// The post should be fetched from cache instead of using the passed object.
		$raw_post = get_post( $display_post, OBJECT, 'raw' );
		$this->assertEquals( 'raw', $raw_post->filter );
		$this->assertNotEquals( esc_js( "Mary's home" ), $raw_post->post_title );
	}

	function test_get_post_identity() {
		$post = get_post( $this->factory->post->create() );

		$post->foo = 'bar';

		$this->assertEquals( 'bar', get_post( $post )->foo );
		$this->assertEquals( 'bar', get_post( $post, OBJECT, 'display' )->foo );
	}

	function test_get_post_array() {
		$id = $this->factory->post->create();

		$post = get_post( $id, ARRAY_A );

		$this->assertEquals( $id, $post['ID'] );
		$this->assertInternalType( 'array', $post['ancestors'] );
		$this->assertEquals( 'raw', $post['filter'] );
	}
}
