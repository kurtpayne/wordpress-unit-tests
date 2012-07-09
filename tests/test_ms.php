<?php

if ( is_multisite() ) :

/**
 * A set of unit tests for WordPress Multisite
 *
 * @group multisite
 */
class WPTestMS extends WP_UnitTestCase {

	protected $plugin_hook_count = 0;

	function test_create_and_delete_blog() {
		global $wpdb, $current_site;

		$blog_ids = $this->factory->blog->create_many( 4 );
		foreach ( $blog_ids as $blog_id ) {
			$this->assertInternalType( 'int', $blog_id );
			$prefix = $wpdb->get_blog_prefix( $blog_id );

			foreach ( $wpdb->tables( 'blog', false ) as $table ) {
				$table_fields = $wpdb->get_results( "DESCRIBE $prefix$table;" );
				$this->assertNotEmpty( $table_fields );
				$result = $wpdb->get_results( "SELECT * FROM $prefix$table LIMIT 1" );
				if ( 'commentmeta' == $table )
					$this->assertEmpty( $result );
				else
					$this->assertNotEmpty( $result );
			}
		}

		// update the blog count cache to use get_blog_count()
		wp_update_network_counts(); 
		$this->assertEquals( 4 + 1, (int) get_blog_count() );

		$drop_tables = false;
		// delete all blogs
		foreach ( $blog_ids as $blog_id ) {
			// drop tables for every second blog
			$drop_tables = ! $drop_tables;
			wpmu_delete_blog( $blog_id, $drop_tables );

			$prefix = $wpdb->get_blog_prefix( $blog_id );
			foreach ( $wpdb->tables( 'blog', false ) as $table ) {
				$table_fields = $wpdb->get_results( "DESCRIBE $prefix$table;" );
				if ( $drop_tables )
					$this->assertEmpty( $table_fields );
				else
					$this->assertNotEmpty( $table_fields, $prefix . $table );
			}
		}

		// update the blog count cache to use get_blog_count()
		wp_update_network_counts(); 
		$this->assertEquals( 1, get_blog_count() );
	}

	function test_get_blogs_of_user() {
		global $current_site;

		// Logged out users don't have blogs.
		$this->assertEquals( array(), get_blogs_of_user( 0 ) );

		$user1_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$blog_ids = $this->factory->blog->create_many( 10, array( 'user_id' => $user1_id ) );

		foreach ( $blog_ids as $blog_id )
			$this->assertInternalType( 'int', $blog_id );

		$blogs_of_user = array_keys( get_blogs_of_user( $user1_id, $all = false ) );
		sort( $blogs_of_user );
		$this->assertEquals ( array_merge( array( 1 ), $blog_ids), $blogs_of_user );

		$this->assertTrue( remove_user_from_blog( $user1_id, 1 ) );

		$blogs_of_user = array_keys( get_blogs_of_user( $user1_id, $all = false ) );
		sort( $blogs_of_user );
		$this->assertEquals ( $blog_ids, $blogs_of_user );

		// Non-existent users don't have blogs.
		wpmu_delete_user( $user1_id );
		$user = new WP_User( $user1_id );
		$this->assertFalse( $user->exists(), 'WP_User->exists' );
		$this->assertEquals( array(), get_blogs_of_user( $user1_id ) );
	}

	function test_is_blog_user() {
		global $current_site, $wpdb;

		$user1_id = $this->factory->user->create( array( 'role' => 'administrator' ) );

		$old_current = get_current_user_id();
		wp_set_current_user( $user1_id );

		$this->assertTrue( is_blog_user() );
		$this->assertTrue( is_blog_user( $wpdb->blogid ) );

		$blog_ids = array();

		$blog_ids = $this->factory->blog->create_many( 5 );
		foreach ( $blog_ids as $blog_id ) {
			$this->assertInternalType( 'int', $blog_id );
			$this->assertTrue( is_blog_user( $blog_id ) );
			$this->assertTrue( remove_user_from_blog( $user1_id, $blog_id ) );
			$this->assertFalse( is_blog_user( $blog_id ) );
		}

		wp_set_current_user( $old_current );
	}

	function test_is_user_member_of_blog() {
		global $current_site, $wpdb;

		$user1_id = $this->factory->user->create( array( 'role' => 'administrator' ) );

		$old_current = get_current_user_id();
		wp_set_current_user( $user1_id );

		$this->assertTrue( is_user_member_of_blog() );
		$this->assertTrue( is_user_member_of_blog( 0, 0 ) );
		$this->assertTrue( is_user_member_of_blog( 0, $wpdb->blogid ) );
		$this->assertTrue( is_user_member_of_blog( $user1_id ) );
		$this->assertTrue( is_user_member_of_blog( $user1_id, $wpdb->blogid ) );

		$blog_ids = $this->factory->blog->create_many( 5 );
		foreach ( $blog_ids as $blog_id ) {
			$this->assertInternalType( 'int', $blog_id );
			$this->assertTrue( is_user_member_of_blog( $user1_id, $blog_id ) );
			$this->assertTrue( remove_user_from_blog( $user1_id, $blog_id ) );
			$this->assertFalse( is_user_member_of_blog( $user1_id, $blog_id ) );
		}

		wpmu_delete_user( $user1_id );
		$user = new WP_User( $user1_id );
		$this->assertFalse( $user->exists(), 'WP_User->exists' );
		$this->assertFalse( is_user_member_of_blog( $user1_id ), 'is_user_member_of_blog' );

		wp_set_current_user( $old_current );
	}

	function test_active_network_plugins() {
		$path = "hello.php";

		// local activate, should be invisible for the network
		activate_plugin($path); // $network_wide = false
		$active_plugins = wp_get_active_network_plugins();
		$this->assertEquals( Array(), $active_plugins );

		add_action( 'deactivated_plugin', array( $this, '_helper_deactivate_hook' ) );

		// activate the plugin sitewide
		activate_plugin($path, '', $network_wide = true);
		$active_plugins = wp_get_active_network_plugins();
		$this->assertEquals( Array(WP_PLUGIN_DIR . '/hello.php'), $active_plugins ); 

		//deactivate the plugin
		deactivate_plugins($path);
		$active_plugins = wp_get_active_network_plugins();
		$this->assertEquals( Array(), $active_plugins );

		$this->assertEquals( 1, $this->plugin_hook_count ); // testing actions and silent mode

		activate_plugin($path, '', $network_wide = true);
		deactivate_plugins($path, true); // silent

		$this->assertEquals( 1, $this->plugin_hook_count ); // testing actions and silent mode
	}

	function _helper_deactivate_hook() {
		$this->plugin_hook_count++;
	}

	function test_get_user_count() {
		// Refresh the cache
		wp_update_network_counts();
		$start_count = get_user_count();

		$this->factory->user->create( array( 'role' => 'administrator' ) );

		$count = get_user_count(); // No change, cache not refreshed
		$this->assertEquals( $start_count, $count );

		wp_update_network_counts(); // Magic happens here

		$count = get_user_count();
		$this->assertEquals( $start_count + 1, $count );
	}

	function test_wp_schedule_update_network_counts() {
		$this->assertFalse(wp_next_scheduled('update_network_counts'));	

		// We can't use wp_schedule_update_network_counts() because WP_INSTALLING is set
		wp_schedule_event(time(), 'twicedaily', 'update_network_counts');

		$this->assertInternalType('int', wp_next_scheduled('update_network_counts'));	
	}

	function test_users_can_register_signup_filter() {

		$registration = get_site_option('registration');
		$this->assertFalse( users_can_register_signup_filter() );

		update_site_option('registration', 'all');
		$this->assertTrue( users_can_register_signup_filter() );	

		update_site_option('registration', 'user');
		$this->assertTrue( users_can_register_signup_filter() );

		update_site_option('registration', 'none');
		$this->assertFalse( users_can_register_signup_filter() );		
	}

	function test_get_dashboard_blog() {
		global $current_site;

		// if there is no dashboard blog set, current blog is used
		$dashboard_blog = get_dashboard_blog();
		$this->assertEquals( 1, $dashboard_blog->blog_id );

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$blog_id = $this->factory->blog->create( array( 'user_id' => $user_id ) );
		$this->assertInternalType( 'int', $blog_id );

		// set the dashboard blog to another one
		update_site_option( 'dashboard_blog', $blog_id );
		$dashboard_blog = get_dashboard_blog();
		$this->assertEquals( $blog_id, $dashboard_blog->blog_id );
	}

	function test_wpmu_log_new_registrations() {
		global $wpdb;

		$user = new WP_User( 1 );
		$ip = preg_replace( '/[^0-9., ]/', '',$_SERVER['REMOTE_ADDR'] );

		wpmu_log_new_registrations(1,1);

		// currently there is no wrapper function for the registration_log
		$reg_blog = $wpdb->get_col( "SELECT email FROM {$wpdb->registration_log} WHERE {$wpdb->registration_log}.blog_id = 1 AND IP LIKE '" . $ip . "'" );
		$this->assertEquals( $user->user_email, $reg_blog[ count( $reg_blog )-1 ] );
	}

	/**
	 * @ticket 18119
	 */
	function test_upload_is_user_over_quota() {
		$default_space_allowed = 50;
		$echo = false;

		$this->assertFalse( upload_is_user_over_quota( $echo ) );
		$this->assertTrue( is_upload_space_available() );

		update_site_option('upload_space_check_disabled', true);
		$this->assertFalse( upload_is_user_over_quota( $echo ) );
		$this->assertTrue( is_upload_space_available() );

		update_site_option( 'blog_upload_space', 0 );
		$this->assertFalse( upload_is_user_over_quota( $echo ) );
		$this->assertEquals( $default_space_allowed, get_space_allowed() );
		$this->assertTrue( is_upload_space_available() );

		update_site_option('upload_space_check_disabled', false);
		$this->assertFalse( upload_is_user_over_quota( $echo ) );
		$this->assertTrue( is_upload_space_available() );

		if ( ! file_exists( BLOGSUPLOADDIR ) )
			$this->markTestSkipped( 'This test is broken when blogs.dir does not exist. ');

		/*
		This is broken when blogs.dir does not exist, as get_upload_space_available()
		simply returns the value of blog_upload_space (converted to bytes), which would
		be negative but still not false. When blogs.dir does exist, < 0 is returned as 0.
		*/

		update_site_option( 'blog_upload_space', -1 );
		$this->assertTrue( upload_is_user_over_quota( $echo ) );
		$this->assertEquals( -1, get_space_allowed() );
		$this->assertFalse( is_upload_space_available() );

		update_option( 'blog_upload_space', 0 );
		$this->assertFalse( upload_is_user_over_quota( $echo ) );
		$this->assertEquals( $default_space_allowed, get_space_allowed() );
		$this->assertTrue( is_upload_space_available() );

		update_option( 'blog_upload_space', -1 );
		$this->assertTrue( upload_is_user_over_quota( $echo ) );
		$this->assertEquals( -1, get_space_allowed() );
		$this->assertFalse( is_upload_space_available() );
	}

	function test_wpmu_update_blogs_date() {
		global $wpdb;

		wpmu_update_blogs_date();

		// compare the update time with the current time, allow delta < 2
		$blog = get_blog_details( $wpdb->blogid );
		$current_time = time();
		$time_difference = $current_time - strtotime( $blog->last_updated );
		$this->assertLessThan( 2, $time_difference );
	}

	function test_getters(){
		global $current_site;

		$blog_id = get_current_blog_id();
		$blog = get_blog_details( $blog_id );
		$this->assertEquals( $blog_id, $blog->blog_id );
		$this->assertEquals( $current_site->domain, $blog->domain );
		$this->assertEquals( '/', $blog->path );

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$blog_id = $this->factory->blog->create( array( 'user_id' => $user_id, 'path' => '/test_blogname', 'title' => 'Test Title' ) );
		$this->assertInternalType( 'int', $blog_id );

		$this->assertEquals( 'http://' . DOMAIN_CURRENT_SITE . PATH_CURRENT_SITE . 'test_blogname/', get_blogaddress_by_name('test_blogname') );

		$this->assertEquals( $blog_id, get_id_from_blogname('test_blogname') );
	}

	function test_update_blog_details() {
		global $current_site;

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$blog_id = $this->factory->blog->create( array( 'user_id' => $user_id, 'path' => '/test_blogpath', 'title' => 'Test Title' ) );
		$this->assertInternalType( 'int', $blog_id );

		$result = update_blog_details( $blog_id, array('domain' => 'example.com', 'path' => 'my_path/') );
		$this->assertTrue( $result );

		$blog = get_blog_details( $blog_id );
		$this->assertEquals( 'example.com', $blog->domain );
		$this->assertEquals( 'my_path/', $blog->path );
		$this->assertEquals( '0', $blog->spam );	

		$result = update_blog_details( $blog_id, array('domain' => 'example2.com','spam' => 1) );
		$this->assertTrue( $result );
		$blog = get_blog_details( $blog_id );
		$this->assertEquals( 'example2.com', $blog->domain );
		$this->assertEquals( 'my_path/', $blog->path );
		$this->assertEquals( '1', $blog->spam );

		$result = update_blog_details( $blog_id );
		$this->assertFalse( $result );
		$blog = get_blog_details( $blog_id );
		$this->assertEquals( 'example2.com', $blog->domain );
		$this->assertEquals( 'my_path/', $blog->path );
		$this->assertEquals( '1', $blog->spam );
		$this->assertFalse( $result );
	}
}

endif;
