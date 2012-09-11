<?php

require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . WPINC . '/class-IXR.php';
require_once ABSPATH . WPINC . '/class-wp-xmlrpc-server.php';

/**
 * @group xmlrpc
 */
class Tests_XMLRPC_Enabled extends WP_UnitTestCase {
	function test_enabled() {
		$myxmlrpcserver = new wp_xmlrpc_server();
		$result = $myxmlrpcserver->wp_getOptions( array( 1, 'username', 'password' ) );

		$this->assertInstanceOf( 'IXR_Error', $result );
		// If disabled, 405 would result.
		$this->assertEquals( 403, $result->code );
	}
}