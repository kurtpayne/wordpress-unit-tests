<?php

// Test the output of Comment Querying functions

/**
 * @group comment
 */
class Test_Comment_Query extends WP_UnitTestCase {
	var $post_id;
	var $comment_id;
	var $comment_data;

	function setUp() {
		parent::setUp();

		$this->post_id = $this->factory->post->create();

		$this->comment_data = array(
			'comment_post_ID' => $this->post_id,
			'comment_author' => 'Test commenter',
			'comment_author_url' => 'http://example.com/',
			'comment_author_email' => 'example@example.com',
			'comment_content' => rand_str( 100 ),
		);
		$this->comment_id = wp_insert_comment( $this->comment_data );
	}

	function test_get_comment_comment_approved_0() {
		$this->knownWPBug( 21101 );
		$comments_approved_0 = get_comments( array( 'comment_approved' => '0' ) );
		$this->assertEquals( 0, count( $comments_approved_0 ) );
	}

	function test_get_comment_comment_approved_1() {
		$this->knownWPBug( 21101 );
		$comments_approved_1 = get_comments( array( 'comment_approved' => '1' ) );

		$this->assertEquals( 1, count( $comments_approved_1 ) );
		$result = $comments_approved_1[0];

		$this->assertEquals( $this->comment_id, $result->comment_ID );
		$this->assertEquals( 0, $result->comment_parent );
		$this->assertEquals( $this->comment_data['comment_content'], $result->comment_content );
		$this->assertEquals( $this->post_id, $result->comment_post_ID );
		$this->assertEquals( $this->comment_data['comment_author'], $result->comment_author );
		$this->assertEquals( $this->comment_data['comment_author_url'], $result->comment_author_url );
		$this->assertEquals( $this->comment_data['comment_author_email'], $result->comment_author_email );
	}
}
