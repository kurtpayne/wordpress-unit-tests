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

	function test_setup_postdata_single_page() {
		$post = $this->factory->post->create_and_get( array( 'post_content' => 'Page 0' ) );
		setup_postdata( $post );

		$this->assertEquals( 0, $GLOBALS['multipage'] );
		$this->assertCount(  1, $GLOBALS['pages']     );
		$this->assertEquals( 1, $GLOBALS['numpages']  );
		$this->assertEquals( array( 'Page 0' ), $GLOBALS['pages'] );
	}

	function test_setup_postdata_multi_page() {
		$post = $this->factory->post->create_and_get( array( 'post_content' => 'Page 0<!--nextpage-->Page 1<!--nextpage-->Page 2<!--nextpage-->Page 3' ) );
		setup_postdata( $post );

		$this->assertEquals( 1, $GLOBALS['multipage'] );
		$this->assertCount(  4, $GLOBALS['pages']     );
		$this->assertEquals( 4, $GLOBALS['numpages']  );
		$this->assertEquals( array( 'Page 0', 'Page 1', 'Page 2', 'Page 3' ), $GLOBALS['pages'] );
	}
}