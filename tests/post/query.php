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

    /**
     * @ticket 18158
     */
    function test_meta_key_not_exists() {
	$post_id = $this->factory->post->create();
	add_post_meta( $post_id, 'foo', rand_str() );
	$post_id2 = $this->factory->post->create();
	add_post_meta( $post_id2, 'bar', rand_str() );
	$post_id3 = $this->factory->post->create();
	add_post_meta( $post_id3, 'bar', rand_str() );
	$post_id4 = $this->factory->post->create();
	add_post_meta( $post_id4, 'baz', rand_str() );
	$post_id5 = $this->factory->post->create();
	add_post_meta( $post_id5, 'foo', rand_str() );

	$query = new WP_Query( array(
	    'meta_query' => array(
		array(
		    'key' => 'foo',
		    'compare' => 'NOT EXISTS',
		),
	    ),
	) );

	$posts = $query->get_posts();
	$this->assertEquals( 3, count( $posts ) );

	$query = new WP_Query( array(
	    'meta_query' => array(
		array(
		    'key' => 'foo',
		    'compare' => 'NOT EXISTS',
		),
	        array(
		    'key' => 'bar',
		    'compare' => 'NOT EXISTS',
		),
	    ),
	) );

	$posts = $query->get_posts();
	$this->assertEquals( 1, count( $posts ) );

	$query = new WP_Query( array(
	    'meta_query' => array(
		array(
		    'key' => 'foo',
		    'compare' => 'NOT EXISTS',
		),
	        array(
		    'key' => 'bar',
		    'compare' => 'NOT EXISTS',
		),
	        array(
		    'key' => 'baz',
		    'compare' => 'NOT EXISTS',
		),
	    )
	) );

	$posts = $query->get_posts();
	$this->assertEquals( 0, count( $posts ) );
    }

    /**
     * @ticket 20604
     */
    function test_taxonomy_empty_or() {
	// An empty tax query should return an empty array, not all posts.

	$this->factory->post->create_many( 10 );

	$query = new WP_Query( array(
	    'fields'	=> 'ids',
	    'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'post_tag',
			'field' => 'id',
			'terms' => false,
			'operator' => 'IN'
		),
		array(
			'taxonomy' => 'category',
			'field' => 'id',
			'terms' => false,
			'operator' => 'IN'
		)
	    )	
	) );

	$posts = $query->get_posts();
	$this->assertEquals( 0 , count( $posts ) );
    }

    function test_meta_between_not_between() {
	$post_id = $this->factory->post->create();
	add_post_meta( $post_id, 'time', 500 );
	$post_id2 = $this->factory->post->create();
	add_post_meta( $post_id2, 'time', 1001 );
	$post_id3 = $this->factory->post->create();
	add_post_meta( $post_id3, 'time', 0 );
	$post_id4 = $this->factory->post->create();
	add_post_meta( $post_id4, 'time', 1 );
	$post_id5 = $this->factory->post->create();
	add_post_meta( $post_id5, 'time', 1000 );
    
	$args = array(
		'meta_key' => 'time',
		'meta_value' => array( 1, 1000 ),
		'meta_type' => 'numeric',
		'meta_compare' => 'NOT BETWEEN'
	    );

	$query = new WP_Query( $args );
	$this->assertEquals( 2, count ( $query->posts ) );
	$posts = wp_list_pluck( $query->posts, 'ID' );
	$this->assertEquals( array( $post_id2, $post_id3 ), $posts );
	
	$args = array(
		'meta_key' => 'time',
		'meta_value' => array( 1, 1000 ),
		'meta_type' => 'numeric',
		'meta_compare' => 'BETWEEN'
	    );

	$query = new WP_Query( $args );
	$this->assertEquals( 3, count ( $query->posts ) );
	$posts = wp_list_pluck( $query->posts, 'ID' );
	$this->assertEquals( array( $post_id, $post_id4, $post_id5 ), $posts );
    }
}