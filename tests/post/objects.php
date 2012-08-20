<?php

/**
 * @group post
 */
class Tests_Post_Objects extends WP_UnitTestCase {

	function test_get_post() {
		$id = $this->factory->post->create();

		$post = get_post( $id );
		$this->assertInstanceOf( 'WP_Post', $post );
		$this->assertEquals( $id, $post->ID );
		$this->assertTrue( isset( $post->ancestors ) );
		$this->assertEquals( array(), $post->ancestors );

		// Unset and then verify that the magic method fills the property again
		unset( $post->ancestors );
		$this->assertEquals( array(), $post->ancestors );

		// Magic get should make meta accessible as properties
		add_post_meta( $id, 'test', 'test' );
		$this->assertEquals( 'test', get_post_meta( $id, 'test', true ) );
		$this->assertEquals( 'test', $post->test );

		// Make sure meta does not eclipse true properties
		add_post_meta( $id, 'post_type', 'dummy' );
		$this->assertEquals( 'dummy', get_post_meta( $id, 'post_type', true ) );
		$this->assertEquals( 'post', $post->post_type );

		// Excercise the output argument
		$post = get_post( $id, ARRAY_A );
		$this->assertInternalType( 'array', $post );
		$this->assertEquals( 'post', $post[ 'post_type' ] );

		$post = get_post( $id, ARRAY_N );
		$this->assertInternalType( 'array', $post );
		$this->assertFalse( isset( $post[ 'post_type' ] ) );
		$this->assertTrue( in_array( 'post', $post ) );

		$post = get_post( $id );
		$post = get_post( $post, ARRAY_A );
		$this->assertInternalType( 'array', $post );
		$this->assertEquals( 'post', $post[ 'post_type' ] );
		$this->assertEquals( $id, $post[ 'ID' ] );

		// Should default to OBJECT when given invalid output argument
		$post = get_post( $id, 'invalid-output-value' );
		$this->assertInstanceOf( 'WP_Post', $post );
		$this->assertEquals( $id, $post->ID );
	}

	function test_get_post_ancestors() {
		$parent_id = $this->factory->post->create();
		$child_id = $this->factory->post->create();
		$grandchild_id = $this->factory->post->create();
		$updated = wp_update_post( array( 'ID' => $child_id, 'post_parent' => $parent_id ) );
		$this->assertEquals( $updated, $child_id );
		$updated = wp_update_post( array( 'ID' => $grandchild_id, 'post_parent' => $child_id ) );
		$this->assertEquals( $updated, $grandchild_id );

		$this->assertEquals( array( $parent_id ), get_post( $child_id )->ancestors );
		$this->assertEquals( array( $parent_id ), get_post_ancestors( $child_id ) );
		$this->assertEquals( array( $parent_id ), get_post_ancestors( get_post( $child_id ) ) );

		$this->assertEquals( array( $child_id, $parent_id ), get_post( $grandchild_id )->ancestors );
		$this->assertEquals( array( $child_id, $parent_id ), get_post_ancestors( $grandchild_id ) );
		$this->assertEquals( array( $child_id, $parent_id ), get_post_ancestors( get_post( $grandchild_id ) ) );

		$this->assertEquals( array(), get_post( $parent_id )->ancestors );
		$this->assertEquals( array(), get_post_ancestors( $parent_id ) );
		$this->assertEquals( array(), get_post_ancestors( get_post( $parent_id ) ) );
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

		$raw_post->filter( 'js' );
		$this->assertEquals( 'js', $post->filter );
		$this->assertEquals( esc_js( "Mary's home" ), $raw_post->post_title );
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
