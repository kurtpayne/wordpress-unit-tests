<?php

/**
 * @group admin-bar
 * @group toolbar
 * @group admin
 */
class TestWPAdminBar extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		$this->current_user = get_current_user_id();
		wp_set_current_user( $this->factory->user->create( array( 'role' => 'editor' ) ) );
	}

	function tearDown() {
		wp_set_current_user( $this->current_user );
		parent::tearDown();
	}

	/**
	 * @ticket 21117
	 */
	function test_content_post_type() {
		register_post_type( 'content', array( 'show_in_admin_bar' => true ) );

		require_once ABSPATH . WPINC . '/class-wp-admin-bar.php';
		$admin_bar = new WP_Admin_Bar;

		wp_admin_bar_new_content_menu( $admin_bar );

		$nodes = $admin_bar->get_nodes();
		$this->assertFalse( $nodes['new-content']->parent );
		$this->assertEquals( 'new-content', $nodes['add-new-content']->parent );

		_unregister_post_type( 'content' );
	}

}