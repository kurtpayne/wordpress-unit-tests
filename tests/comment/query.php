<?php

// Test the output of Comment Querying functions

/**
 * @group comment
 */
class Tests_Comment_Query extends WP_UnitTestCase {
	var $comment_id;

	function setUp() {
		parent::setUp();
	}

	/**
	 * @ticket 21101
	 */
	function test_get_comment_comment_approved_0() {
		$comment_id = $this->factory->comment->create();
		$comments_approved_0 = get_comments( array( 'status' => 'hold' ) );
		$this->assertEquals( 0, count( $comments_approved_0 ) );
	}

	/**
	 * @ticket 21101
	 */
	function test_get_comment_comment_approved_1() {
		$comment_id = $this->factory->comment->create();
		$comments_approved_1 = get_comments( array( 'status' => 'approve' ) );

		$this->assertEquals( 1, count( $comments_approved_1 ) );
		$result = $comments_approved_1[0];

		$this->assertEquals( $comment_id, $result->comment_ID );
	}
}
