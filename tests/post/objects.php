<?php

/**
 * @group post
 */
class Tests_Post_Objects extends WP_UnitTestCase {

	function test_get_post() {
		$id = $this->factory->post->create();

		$post = get_post( $id );

		$this->assertEquals( $id, $post->ID );
	}

	function test_get_post_filter() {
		$post = get_post( $this->factory->post->create() );

		$this->assertEquals( 'raw', $post->filter );

		$display_post = get_post( $post, OBJECT, 'display' );
		$this->assertEquals( 'display', $display_post->filter );
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
