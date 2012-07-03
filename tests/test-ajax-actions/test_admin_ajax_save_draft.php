<?php

/**
 * Admin ajax functions to be tested
 */
include_once( ABSPATH . 'wp-admin/includes/ajax-actions.php' );

/**
 * Testing ajax save draft functionality
 *
 * @package    WordPress
 * @subpackage UnitTests
 * @since      3.4.0
 * @group      ajax
 * @runTestsInSeparateProcesses
 */
class TestAjaxSaveDraft extends WP_Ajax_UnitTestCase {

	/**
	 * Post
	 * @var mixed
	 */
	protected $_post = null;
	
	/**
	 * Set up the test fixture
	 */
	public function setUp() {
		parent::setUp();
		$post_id = $this->factory->post->create( array( 'post_status' => 'draft' ) );
		$this->_post = get_post( $post_id );
	}

	/**
	 * Test autosaving as a logged out user
	 * @return void
	 */
	public function test_nopriv_autosave() {
		
		// Log out
		wp_logout();
		
		// Set up a default request
		$_POST = array(
		    'post_ID'  => 1,
		    'autosave' => 1
		);
		
		// Make the request
		try {
			$this->_handleAjax( 'nopriv_autosave' );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		// Get the response
		$xml = simplexml_load_string( $this->_last_response, 'SimpleXMLElement', LIBXML_NOCDATA );

		// Ensure everything is correct
		$this->assertEquals( 1, (string) $xml->response[0]->autosave['id'] );
		$this->assertEquals( 'nopriv_autosave_1', (string) $xml->response['action'] );
	}

	/**
	 * Test as a logged out user with no post id
	 * @return void
	 */
	public function test_nopriv_no_postid() {
		
		// Log out
		wp_logout();
		
		// Set up a request
		$_POST = array(
		    'autosave'      => 1
		);
		
		// Make the request
		$this->setExpectedException( 'WPAjaxDieStopException', '-1' );
		$this->_handleAjax( 'nopriv_autosave' );
	}
	
	/**
	 * Test autosaving a post
	 * @return void
	 */
	public function test_autosave_post() {

		// Become an admin
		$this->_setRole( 'administrator' );
			
		// Set up the $_POST request
		$md5 = md5( uniqid() );
		$_POST = array(
		    'post_ID'       => $this->_post->ID,
		    'autosavenonce' => wp_create_nonce( 'autosave' ),
		    'post_content'  => $this->_post->post_content . PHP_EOL . $md5,
		    'autosave'      => 1
		);

		// Make the request
		try {
			$this->_handleAjax( 'autosave' );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}
		
		// Get the response
		$xml = simplexml_load_string( $this->_last_response, 'SimpleXMLElement', LIBXML_NOCDATA );

		// Ensure everything is correct
		$this->assertEquals( $this->_post->ID, (int) $xml->response[0]->autosave['id'] );
		$this->assertEquals( 'autosave_' . $this->_post->ID, (string) $xml->response['action']);
		
		// Check that the edit happened
		$post = get_post( $this->_post->ID) ;
		$this->assertGreaterThanOrEqual( 0, strpos( $post->post_content, $md5 ) );
	}

	/**
	 * Test with an invalid nonce
	 * @return void
	 */
	public function test_with_invalid_nonce( ) {
		
		// Become an administrator		
		$this->_setRole( 'administrator' );

		// Set up the $_POST request
		$_POST = array(
		    'post_ID'       => $this->_post->ID,
		    'autosavenonce' => md5( uniqid() ),
		    'autosave'      => 1
		);

		// Make the request
		$this->setExpectedException( 'WPAjaxDieStopException', '-1' );
		$this->_handleAjax( 'autosave' );
	}
	
	/**
	 * Test with a bad post id
	 * @return void
	 */
	public function test_with_invalid_post_id( ) {
		
		// Become an administrator	
		$this->_setRole( 'administrator' );

		// Set up the $_POST request
		$_POST = array(
		    'post_ID'       => 0,
		    'autosavenonce' => wp_create_nonce( 'autosave' ),
		    'autosave'      => 1
		);

		// Make the request
		$this->setExpectedException( 'WPAjaxDieStopException', 'You are not allowed to edit this post.' );
		$this->_handleAjax( 'autosave' );
	}
	
	/**
	 * Test with a locked post
	 * @return void
	 */
	public function test_locked_post() {

		// Become an administrator		
		$this->_setRole( 'administrator' );
		
		// Lock the post
		wp_set_post_lock( $this->_post->ID );
		
		// Become a different administrator
		$this->_setRole( 'administrator' );
	
		// Set up the $_POST request
		$_POST = array(
		    'post_ID'       => $this->_post->ID,
		    'autosavenonce' => wp_create_nonce( 'autosave' ),
		    'autosave'      => 1
		);

		// Make the request
		try {
			$this->_handleAjax( 'autosave' );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		// Get the response
		$xml = simplexml_load_string( $this->_last_response, 'SimpleXMLElement', LIBXML_NOCDATA );

		// Ensure everything is correct
		$this->assertEquals( $this->_post->ID, (int) $xml->response[0]->autosave['id'] );
		$this->assertEquals( 'autosave_' . $this->_post->ID, (string) $xml->response['action']);
		$this->assertEquals( 'disable', (string) $xml->response[0]->autosave[0]->supplemental[0]->disable_autosave);
	}


	/**
	 * Test with a browser that is about to be logged out
	 * @return void
	 */
	public function test_past_grace_period() {
		global $login_grace_period;
		$login_grace_period = 1;

		// Become an admnistrator		
		$this->_setRole( 'administrator' );
			
		// Set up the $_POST request
		$_POST = array(
		    'post_ID'       => $this->_post->ID,
		    'autosavenonce' => wp_create_nonce( 'autosave' ),
		    'autosave'      => 1
		);

		// Make the request
		try {
			$this->_handleAjax( 'autosave' );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		// Look for the warning
		$this->assertRegExp( '/Your login has expired. Please open a new browser window/' , $this->_last_response );
	}
}
