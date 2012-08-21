<?php

// Test the output of Comment Querying functions

/**
 * @group comment
 */
class Test_Comment_Query extends WP_UnitTestCase {
	var $comment_id;

	function setUp() {
		parent::setUp();

		$this->comment_id = $this->factory->comment->create();
	}

	/**
	 * @ticket 21101
	 */
	function test_get_comment_comment_approved_0() {
		$comments_approved_0 = get_comments( array( 'comment_approved' => '0' ) );
		$this->assertEquals( 0, count( $comments_approved_0 ) );
	}

	/**
	 * @ticket 21101
	 */
	function test_get_comment_comment_approved_1() {
		$comments_approved_1 = get_comments( array( 'comment_approved' => '1' ) );

		$this->assertEquals( 1, count( $comments_approved_1 ) );
		$result = $comments_approved_1[0];

		$this->assertEquals( $this->comment_id, $result->comment_ID );
	}
}
