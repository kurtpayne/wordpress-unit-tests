<?php

class Tests_Query extends WP_UnitTestCase {

	/**
	 * @ticket 16746
	 */
	function test_nextpage_at_start_of_content() {
		$post = $this->factory->post->create_and_get( array( 'post_content' => '<!--nextpage-->Page 1<!--nextpage-->Page 2<!--nextpage-->Page 3' ) );
		setup_postdata( $post );

		$this->assertEquals( 1, $GLOBALS['multipage'] );
		$this->assertCount(  3, $GLOBALS['pages']     );
		$this->assertEquals( 3, $GLOBALS['numpages']  );
		$this->assertEquals( array( 'Page 1', 'Page 2', 'Page 3' ), $GLOBALS['pages'] );
	}
}