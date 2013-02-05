<?php
/**
 * @group formatting
 */
class Tests_Formatting_SanitizePost extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$post_id = wp_insert_post( array(
			'post_type' => 'post',
			'post_status' => 'draft',
			'post_content' => 'content',
			'post_title' => 'title',
		) );
		$this->post = get_post( $post_id );
	}

	/**
	 * @ticket 22324
	 */
	function test_int_fields() {
		$int_fields = array( 'ID', 'post_parent', 'menu_order', 'post_author', 'comment_count' );
		foreach ( $int_fields as $field )
			$this->post->{$field} = 'string';

		sanitize_post( $this->post );

		foreach ( $int_fields as $field )
			$this->assertTrue( is_int( $this->post->{$field} ), "Expected integer: {$field}" );
	}

	public function tearDown() {
		parent::tearDown();
		wp_delete_post( $this->post->ID, true );
	}
}
