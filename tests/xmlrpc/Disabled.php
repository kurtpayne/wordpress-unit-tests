<?php

require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . WPINC . '/class-IXR.php';
require_once ABSPATH . WPINC . '/class-wp-xmlrpc-server.php';

/**
 * @group xmlrpc
 */
class Tests_XMLRPC_Disabled extends WP_UnitTestCase {
	function test_disabled() {
		$myxmlrpcserver = new wp_xmlrpc_server();
		$result = $myxmlrpcserver->wp_getOptions( array( 1, 'username', 'password' ) );

		$this->assertInstanceOf( 'IXR_Error', $result );
		$this->assertEquals( 405, $result->code );
	}
}