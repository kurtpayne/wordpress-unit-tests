<?php

/**
 * @group xmlrpc
 */
class Tests_XMLRPC_wp_uploadFile extends WP_XMLRPC_UnitTestCase {
	function test_valid_attachment() {
		$this->make_user_by_role( 'editor' );

		// create attachment
		$filename = ( DIR_TESTDATA.'/images/a2-small.jpg' );
		$contents = file_get_contents( $filename );
		$data = array(
			'name' => 'a2-small.jpg',
			'type' => 'image/jpeg',
			'bits' => base64_encode( $contents )
		);


		$result = $this->myxmlrpcserver->mw_newMediaObject( array( 0, 'editor', 'editor', $data ) );
		$this->assertNotInstanceOf( 'IXR_Error', $result );

		// check data types
		$this->assertInternalType( 'string', $result['id'] );
		$this->assertStringMatchesFormat( '%d', $result['id'] );
		$this->assertInternalType( 'string', $result['file'] );
		$this->assertInternalType( 'string', $result['url'] );
		$this->assertInternalType( 'string', $result['type'] );
	}

	/**
	 * @ticket 21292
	 */
	function test_network_limit() {
		if ( is_multisite() ) {
			$this->make_user_by_role( 'editor' );

			update_option( 'blog_upload_space', 0.1 );

			// create attachment
			$filename = ( DIR_TESTDATA.'/images/canola.jpg' );
			$contents = file_get_contents( $filename );
			$data = array(
				'name' => 'a2-small.jpg',
				'type' => 'image/jpeg',
				'bits' => base64_encode( $contents )
			);

			$result = $this->myxmlrpcserver->mw_newMediaObject( array( 0, 'editor', 'editor', $data ) );
			$this->assertInstanceOf( 'IXR_Error', $result );
		}
	}
}