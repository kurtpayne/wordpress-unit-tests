<?php

/**
 * @group meta
 */
class Tests_Post_Query extends WP_UnitTestCase {
    function setUp() {
	parent::setUp();
    }

    function test_meta_key_or_query() {
	$post_id = $this->factory->post->create();
	add_post_meta( $post_id, 'foo', rand_str() );
	add_post_meta( $post_id, 'foo', rand_str() );
	$post_id2 = $this->factory->post->create();
	add_post_meta( $post_id2, 'bar', 'val2' );
	$post_id3 = $this->factory->post->create();
	add_post_meta( $post_id3, 'baz', rand_str() );
	$post_id4 = $this->factory->post->create();
	add_post_meta( $post_id4, 'froo', rand_str() );
	$post_id5 = $this->factory->post->create();
	add_post_meta( $post_id5, 'tango', 'val2' );
	$post_id6 = $this->factory->post->create();
	add_post_meta( $post_id6, 'bar', 'val1' );

	$query = new WP_Query( array(
	    'meta_query' => array(
		    array(
			    'key' => 'foo'
		    ),
		    array(
			    'key' => 'bar',
			    'value' => 'val2'
		    ),
		    array(
			    'key' => 'baz'
		    ),
		    array(
			    'key' => 'froo'
		    ),
		    'relation' => 'OR',
	    ),
	) );

	$posts = $query->get_posts();
	$this->assertEquals( 4, count( $posts ) );

	$post_ids = wp_list_pluck( $posts, 'ID' );
	$this->assertEquals( array( $post_id, $post_id2, $post_id3, $post_id4 ), $post_ids );
    }
}