<?php

/**
 * @group taxonomy
 */
class Tests_Term_getTerms extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();

		wp_cache_delete( 'last_changed', 'terms' );
	}

	/**
	 * @ticket 23326
	 */
	function test_get_terms_cache() {
		global $wpdb;

		$posts = $this->factory->post->create_many( 15, array( 'post_type' => 'post' ) );
		foreach ( $posts as $post )
			wp_set_object_terms( $post, rand_str(), 'post_tag' );

		$this->assertFalse( wp_cache_get( 'last_changed', 'terms' ) );

		$num_queries = $wpdb->num_queries;
		$last_changed = 1;

		// last_changed and num_queries should bump
		$terms = get_terms( 'post_tag' );
		$this->assertEquals( 15, count( $terms ) );
		$this->assertEquals( 1, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Again. last_changed and num_queries should remain the same.
		$terms = get_terms( 'post_tag' );
		$this->assertEquals( 15, count( $terms ) );
		$this->assertEquals( $last_changed, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;


		// Different query. num_queries should bump, last_changed should remain the same.
		$terms = get_terms( 'post_tag', array( 'number' => 10 ) );
		$this->assertEquals( 10, count( $terms ) );
		$this->assertEquals( $last_changed, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Again. last_changed and num_queries should remain the same.
		$terms = get_terms( 'post_tag', array( 'number' => 10 ) );
		$this->assertEquals( 10, count( $terms ) );
		$this->assertEquals( $last_changed, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries, $wpdb->num_queries );

		// Force last_changed to bump
		wp_delete_term( $terms[0]->term_id, 'post_tag' );

		$num_queries = $wpdb->num_queries;
		// Bump by two because both wp_delete_term() and wp_update_term_count_now() call clean_term_cache().
		$last_changed += 2;

		// last_changed and num_queries should bump after a term is deleted
		$terms = get_terms( 'post_tag' );
		$this->assertEquals( 14, count( $terms ) );
		$this->assertEquals( $last_changed, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Again. last_changed and num_queries should remain the same.
		$terms = get_terms( 'post_tag' );
		$this->assertEquals( 14, count( $terms ) );
		$this->assertEquals( $last_changed, wp_cache_get( 'last_changed', 'terms' ) );
		$this->assertEquals( $num_queries, $wpdb->num_queries );

		// @todo Repeat with term insert and update.
	}
}