<?php
include_once(ABSPATH . 'wp-admin/includes/admin.php');
include_once(ABSPATH . WPINC . '/class-IXR.php');
include_once(ABSPATH . WPINC . '/class-wp-xmlrpc-server.php');

/**
 * @group xmlrpc
 */
class TestXMLRPCServer_Disabled extends WP_UnitTestCase {
	function test_disabled() {
		$myxmlrpcserver = new wp_xmlrpc_server();
		$result = $myxmlrpcserver->wp_getOptions( array( 1, 'username', 'password' ) );
		
		$this->assertInstanceOf( 'IXR_Error', $result );
		$this->assertEquals( 405, $result->code );
	}
}