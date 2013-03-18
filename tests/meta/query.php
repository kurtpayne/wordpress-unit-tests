<?php
/**
 * Test WP_Meta_Query, in wp-includes/meta.php
 *
 * @group meta
 */
class Tests_Meta_Query extends WP_UnitTestCase {

	function test_default_relation() {
		$query = new WP_Meta_Query( array( array( 'key' => 'abc' ) ) );

		$this->assertEquals( 'AND', $query->relation );
	}

	function test_set_relation() {

		$query = new WP_Meta_Query( array( array( 'key' => 'abc' ), 'relation' => 'AND' ) );

		$this->assertEquals( 'AND', $query->relation );

		$query = new WP_Meta_Query( array( array( 'key' => 'abc' ), 'relation' => 'OR' ) );

		$this->assertEquals( 'OR', $query->relation );
	}

	/**
	 * Test all key only meta queries use the same INNER JOIN when using relation=OR
	 *
	 * @ticket 19729
	 */
	function test_single_inner_join_for_keys_only() {

		global $wpdb;

		$query = new WP_Meta_Query( array(
			array( 'key' => 'abc' ),
			array( 'key' => 'def' ),
			'relation' => 'OR'
		) );

		$sql = $query->get_sql( 'post', $wpdb->posts, 'ID' );

		$this->assertEquals( 1, substr_count( $sql['join'], 'INNER JOIN' ) );

		// also check mixing key and key => value

		$query = new WP_Meta_Query( array(
			array( 'key' => 'abc' ),
			array( 'key' => 'def' ),
			array( 'key' => 'ghi', 'value' => 'abc' ),
			'relation' => 'OR'
		) );

		$sql = $query->get_sql( 'post', $wpdb->posts, 'ID' );

		$this->assertEquals( 2, substr_count( $sql['join'], 'INNER JOIN' ) );
	}

	/**
	 * Test the conversion between "WP_Query" style meta args (meta_value=x&meta_key=y)
	 * to a meta query array
	 */
	function test_parse_query_vars() {

		$query = new WP_Meta_Query();

		// just meta_value
		$query->parse_query_vars( array( 'meta_key' => 'abc' ) );

		$this->assertEquals( array( array( 'key' => 'abc' ) ), $query->queries );

		// meta_key & meta_value
		$query->parse_query_vars( array( 'meta_key' => 'abc', 'meta_value' => 'def' ) );

		$this->assertEquals( array( array( 'key' => 'abc', 'value' => 'def' ) ), $query->queries );

		// meta_compare
		$query->parse_query_vars( array( 'meta_key' => 'abc', 'meta_compare' => '=>' ) );

		$this->assertEquals( array( array( 'key' => 'abc', 'compare' => '=>' ) ), $query->queries );
	}
}
