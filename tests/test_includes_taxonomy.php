<?php

/**
 * @group taxonomy
 */
class TestTaxonomy extends WP_UnitTestCase {
	function test_get_post_taxonomies() {
		$this->assertEquals(array('category', 'post_tag', 'post_format'), get_object_taxonomies('post'));
	}

	function test_get_link_taxonomies() {
		$this->assertEquals(array('link_category'), get_object_taxonomies('link'));
	}

	/**
	 * @ticket 5417
	 */
	function test_get_unknown_taxonomies() {
		// taxonomies for an unknown object type
		$this->assertEquals( array(), get_object_taxonomies(rand_str()) );
		$this->assertEquals( array(), get_object_taxonomies('') );
		$this->assertEquals( array(), get_object_taxonomies(0) );
		$this->assertEquals( array(), get_object_taxonomies(NULL) );
	}

	function test_get_post_taxonomy() {
		foreach ( get_object_taxonomies('post') as $taxonomy ) {
			$tax = get_taxonomy($taxonomy);
			// should return an object with the correct taxonomy object type
			$this->assertTrue( is_object( $tax ) );
			$this->assertTrue( is_array( $tax->object_type ) );
			$this->assertEquals( array( 'post' ), $tax->object_type );
		}
	}

	function test_get_link_taxonomy() {
		foreach ( get_object_taxonomies('link') as $taxonomy ) {
			$tax = get_taxonomy($taxonomy);
			// should return an object with the correct taxonomy object type
			$this->assertTrue( is_object($tax) );
			$this->assertTrue( is_array( $tax->object_type ) );
			$this->assertEquals( array( 'link' ), $tax->object_type );
		}
	}

	function test_taxonomy_exists_known() {
		$this->assertTrue( taxonomy_exists('category') );
		$this->assertTrue( taxonomy_exists('post_tag') );
		$this->assertTrue( taxonomy_exists('link_category') );
	}

	function test_taxonomy_exists_unknown() {
		$this->assertFalse( taxonomy_exists(rand_str()) );
		$this->assertFalse( taxonomy_exists('') );
		$this->assertFalse( taxonomy_exists(0) );
		$this->assertFalse( taxonomy_exists(NULL) );
	}

	function test_is_taxonomy_hierarchical() {
		$this->assertTrue( is_taxonomy_hierarchical('category') );
		$this->assertFalse( is_taxonomy_hierarchical('post_tag') );
		$this->assertFalse( is_taxonomy_hierarchical('link_category') );
	}

	function test_is_taxonomy_hierarchical_unknown() {
		$this->assertFalse( is_taxonomy_hierarchical(rand_str()) );
		$this->assertFalse( is_taxonomy_hierarchical('') );
		$this->assertFalse( is_taxonomy_hierarchical(0) );
		$this->assertFalse( is_taxonomy_hierarchical(NULL) );
	}

	function test_register_taxonomy() {

		// make up a new taxonomy name, and ensure it's unused
		$tax = rand_str();
		$this->assertFalse( taxonomy_exists($tax) );

		register_taxonomy( $tax, 'post' );
		$this->assertTrue( taxonomy_exists($tax) );
		$this->assertFalse( is_taxonomy_hierarchical($tax) );

		// clean up
		unset($GLOBALS['wp_taxonomies'][$tax]);
	}

	function test_register_hierarchical_taxonomy() {

		// make up a new taxonomy name, and ensure it's unused
		$tax = rand_str();
		$this->assertFalse( taxonomy_exists($tax) );

		register_taxonomy( $tax, 'post', array('hierarchical'=>true) );
		$this->assertTrue( taxonomy_exists($tax) );
		$this->assertTrue( is_taxonomy_hierarchical($tax) );

		// clean up
		unset($GLOBALS['wp_taxonomies'][$tax]);
	}
}

/**
 * @group taxonomy
 */
class TestTermAPI extends WP_UnitTestCase {
	var $taxonomy = 'category';

	function setUp() {
		parent::setUp();
		// insert one term into every post taxonomy
		// otherwise term_ids and term_taxonomy_ids might be identical, which could mask bugs
		$term = rand_str();
		foreach(get_object_taxonomies('post') as $tax)
			wp_insert_term( $term, $tax );
	}

	function test_wp_insert_delete_term() {
		// a new unused term
		$term = rand_str();
		$this->assertNull( term_exists($term) );

		$initial_count = wp_count_terms( $this->taxonomy );

		$t = wp_insert_term( $term, $this->taxonomy );
		$this->assertTrue( is_array($t) );
		$this->assertFalse( is_wp_error($t) );
		$this->assertTrue( $t['term_id'] > 0 );
		$this->assertTrue( $t['term_taxonomy_id'] > 0 );
		$this->assertEquals( $initial_count + 1, wp_count_terms($this->taxonomy) );

		// make sure the term exists
		$this->assertTrue( term_exists($term) > 0 );
		$this->assertTrue( term_exists($t['term_id']) > 0 );

		// now delete it
		$this->assertTrue( wp_delete_term($t['term_id'], $this->taxonomy) );
		$this->assertNull( term_exists($term) );
		$this->assertNull( term_exists($t['term_id']) );
		$this->assertEquals( $initial_count, wp_count_terms($this->taxonomy) );
	}

	function test_term_exists_known() {
		// insert a term
		$term = rand_str();
		$t = wp_insert_term( $term, $this->taxonomy );

		$this->assertEquals( $t['term_id'], term_exists($t['term_id']) );
		$this->assertEquals( $t['term_id'], term_exists($term) );

		// clean up
		$this->assertTrue( wp_delete_term($t['term_id'], $this->taxonomy) );
	}

	function test_term_exists_unknown() {
		$this->assertNull( term_exists(rand_str()) );
		$this->assertEquals( 0, term_exists(0) );
		$this->assertEquals( 0, term_exists('') );
		$this->assertEquals( 0, term_exists(NULL) );
	}

	/**
	 * @ticket 5381
	 */
	function test_is_term_type() {
		// insert a term
		$term = rand_str();
		$t = wp_insert_term( $term, $this->taxonomy );

		$term_obj = get_term_by('name', $term, $this->taxonomy);
		$this->assertEquals( $t['term_id'], term_exists($term_obj->slug) );

		// clean up
		$this->assertTrue( wp_delete_term($t['term_id'], $this->taxonomy) );
	}

	function test_set_object_terms_by_id() {
		$ids = $this->factory->post->create_many(5);

		$terms = array();
		for ($i=0; $i<3; $i++ ) {
			$term = rand_str();
			$result = wp_insert_term( $term, $this->taxonomy );
			$term_id[$term] = $result['term_id'];
		}

		foreach ($ids as $id) {
				$tt = wp_set_object_terms( $id, array_values($term_id), $this->taxonomy );
				// should return three term taxonomy ids
				$this->assertEquals( 3, count($tt) );
		}

		// each term should be associated with every post
		foreach ($term_id as $term=>$id) {
			$actual = get_objects_in_term($id, $this->taxonomy);
			$this->assertEquals( $ids, array_map('intval', $actual) );
		}

		// each term should have a count of 5
		foreach (array_keys($term_id) as $term) {
			$t = get_term_by('name', $term, $this->taxonomy);
			$this->assertEquals( 5, $t->count );
		}
	}

	function test_set_object_terms_by_name() {
		$ids = $this->factory->post->create_many(5);

		$terms = array(
				rand_str(),
				rand_str(),
				rand_str());

		foreach ($ids as $id) {
				$tt = wp_set_object_terms( $id, $terms, $this->taxonomy );
				// should return three term taxonomy ids
				$this->assertEquals( 3, count($tt) );
				// remember which term has which term_id
				for ($i=0; $i<3; $i++) {
					$term = get_term_by('name', $terms[$i], $this->taxonomy);
					$term_id[$terms[$i]] = intval($term->term_id);
				}
		}

		// each term should be associated with every post
		foreach ($term_id as $term=>$id) {
			$actual = get_objects_in_term($id, $this->taxonomy);
			$this->assertEquals( $ids, array_map('intval', $actual) );
		}

		// each term should have a count of 5
		foreach ($terms as $term) {
			$t = get_term_by('name', $term, $this->taxonomy);
			$this->assertEquals( 5, $t->count );
		}
	}

	function test_change_object_terms_by_name() {
		// set some terms on an object; then change them while leaving one intact

		$post_id = $this->factory->post->create();

		$terms_1 = array('foo', 'bar', 'baz');
		$terms_2 = array('bar', 'bing');

		// set the initial terms
		$tt_1 = wp_set_object_terms( $post_id, $terms_1, $this->taxonomy );
		$this->assertEquals( 3, count($tt_1) );

		// make sure they're correct
		$terms = wp_get_object_terms($post_id, $this->taxonomy, array('fields' => 'names', 'orderby' => 't.term_id'));
		$this->assertEquals( $terms_1, $terms );

		// change the terms
		$tt_2 = wp_set_object_terms( $post_id, $terms_2, $this->taxonomy );
		$this->assertEquals( 2, count($tt_2) );

		// make sure they're correct
		$terms = wp_get_object_terms($post_id, $this->taxonomy, array('fields' => 'names', 'orderby' => 't.term_id'));
		$this->assertEquals( $terms_2, $terms );

		// make sure the tt id for 'bar' matches
		$this->assertEquals( $tt_1[1], $tt_2[0] );

	}

	function test_change_object_terms_by_id() {
		// set some terms on an object; then change them while leaving one intact

		$post_id = $this->factory->post->create();

		// first set: 3 terms
		$terms_1 = array();
		for ($i=0; $i<3; $i++ ) {
			$term = rand_str();
			$result = wp_insert_term( $term, $this->taxonomy );
			$terms_1[$i] = $result['term_id'];
		}

		// second set: one of the original terms, plus one new term
		$terms_2 = array();
		$terms_2[0] = $terms_1[1];

		$term = rand_str();
		$result = wp_insert_term( $term, $this->taxonomy );
		$terms_2[1] = $result['term_id'];


		// set the initial terms
		$tt_1 = wp_set_object_terms( $post_id, $terms_1, $this->taxonomy );
		$this->assertEquals( 3, count($tt_1) );

		// make sure they're correct
		$terms = wp_get_object_terms($post_id, $this->taxonomy, array('fields' => 'ids', 'orderby' => 't.term_id'));
		$this->assertEquals( $terms_1, $terms );

		// change the terms
		$tt_2 = wp_set_object_terms( $post_id, $terms_2, $this->taxonomy );
		$this->assertEquals( 2, count($tt_2) );

		// make sure they're correct
		$terms = wp_get_object_terms($post_id, $this->taxonomy, array('fields' => 'ids', 'orderby' => 't.term_id'));
		$this->assertEquals( $terms_2, $terms );

		// make sure the tt id for 'bar' matches
		$this->assertEquals( $tt_1[1], $tt_2[0] );

	}

	function test_get_object_terms_by_slug() {
		$post_id = $this->factory->post->create();

		$terms_1 = array('Foo', 'Bar', 'Baz');
		$terms_1_slugs = array('foo', 'bar', 'baz');

		// set the initial terms
		$tt_1 = wp_set_object_terms( $post_id, $terms_1, $this->taxonomy );
		$this->assertEquals( 3, count($tt_1) );

		// make sure they're correct
		$terms = wp_get_object_terms($post_id, $this->taxonomy, array('fields' => 'slugs', 'orderby' => 't.term_id'));
		$this->assertEquals( $terms_1_slugs, $terms );
	}

	function test_set_object_terms_invalid() {
		$post_id = $this->factory->post->create();

		// bogus taxonomy
		$result = wp_set_object_terms( $post_id, array(rand_str()), rand_str() );
		$this->assertTrue( is_wp_error($result) );
	}

	function test_term_is_ancestor_of( ) {
		$term = rand_str();
		$term2 = rand_str();

		$t = wp_insert_term( $term, 'category' );
		$t2 = wp_insert_term( $term, 'category', array( 'parent' => $t['term_id'] ) );
		if ( function_exists( 'term_is_ancestor_of' ) ) {
			$this->assertTrue( term_is_ancestor_of( $t['term_id'], $t2['term_id'], 'category' ) );
			$this->assertFalse( term_is_ancestor_of( $t2['term_id'], $t['term_id'], 'category' ) );
		}
		$this->assertTrue( cat_is_ancestor_of( $t['term_id'], $t2['term_id']) );
		$this->assertFalse( cat_is_ancestor_of( $t2['term_id'], $t['term_id']) );

		wp_delete_term($t['term_id'], 'category');
		wp_delete_term($t2['term_id'], 'category');
	}

	function test_wp_insert_delete_category() {
		$term = rand_str();
		$this->assertNull( category_exists( $term ) );

		$initial_count = wp_count_terms( 'category' );

		$t = wp_insert_category( array( 'cat_name' => $term ) );
		$this->assertTrue( is_numeric($t) );
		$this->assertFalse( is_wp_error($t) );
		$this->assertTrue( $t > 0 );
		$this->assertEquals( $initial_count + 1, wp_count_terms( 'category' ) );

		// make sure the term exists
		$this->assertTrue( term_exists($term) > 0 );
		$this->assertTrue( term_exists($t) > 0 );

		// now delete it
		$this->assertTrue( wp_delete_category($t) );
		$this->assertNull( term_exists($term) );
		$this->assertNull( term_exists($t) );
		$this->assertEquals( $initial_count, wp_count_terms('category') );
	}

	function test_wp_unique_term_slug() {
		// set up test data
		$a = wp_insert_term( 'parent', $this->taxonomy );
		$b = wp_insert_term( 'child',  $this->taxonomy, array( 'parent' => $a['term_id'] ) );
		$c = wp_insert_term( 'neighbor', $this->taxonomy );
		$d = wp_insert_term( 'pet',  $this->taxonomy, array( 'parent' => $c['term_id'] )  );

		$a_term = get_term( $a['term_id'], $this->taxonomy );
		$b_term = get_term( $b['term_id'], $this->taxonomy );
		$c_term = get_term( $c['term_id'], $this->taxonomy );
		$d_term = get_term( $d['term_id'], $this->taxonomy );

		// a unique slug gets unchanged
		$this->assertEquals( 'unique-term', wp_unique_term_slug( 'unique-term', $c_term ) );

		// a non-hierarchicial dupe gets suffixed with "-#"
		$this->assertEquals( 'parent-2', wp_unique_term_slug( 'parent', $c_term ) );

		// a hierarchical dupe initially gets suffixed with its parent term
		$this->assertEquals( 'child-neighbor', wp_unique_term_slug( 'child', $d_term ) );

		// a hierarchical dupe whose parent already contains the {term}-{parent term}
		// term gets suffixed with parent term name and then '-#'
		$e = wp_insert_term( 'child-neighbor', $this->taxonomy, array( 'parent' => $c['term_id'] ) );
		$this->assertEquals( 'child-neighbor-2', wp_unique_term_slug( 'child', $d_term ) );

		// clean up
		foreach ( array( $a, $b, $c, $d, $e ) as $t )
			$this->assertTrue( wp_delete_term( $t['term_id'], $this->taxonomy ) );
	}
}
