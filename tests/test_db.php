<?php

/**
 * Test WPDB methods
 *
 * @group wpdb
 */
class TestWPDB extends WP_UnitTestCase {

	/**
	 * Query log
	 * @var array
	 */
	protected $_queries = array();
	
	/**
	 * Set up the test fixture
	 */
	public function setUp() {
		parent::setUp();
		$this->_queries = array();
		add_filter( 'query', array( $this, 'query_filter' ) );
	}

	/**
	 * Tear down the test fixture
	 */
	public function tearDown() {
		parent::tearDown();
		remove_filter( 'query', array( $this, 'query_filter' ) );
	}

	/**
	 * Log each query
	 * @param string $sql
	 * @return string
	 */
	public function query_filter( $sql ) {
		$this->_queries[] = $sql;
		return $sql;
	}

	/**
	 * Test that floats formatted as "0,700" get sanitized properly by wpdb
	 * @global mixed $wpdb
	 *
	 * @ticket 19861
	 */
	public function test_locale_floats() {
		global $wpdb;

		// Save the current locale
		$current_locale = setlocale( LC_ALL, NULL );
		
		// Switch to Russian
		$flag = setlocale( LC_ALL, 'ru_RU.utf8', 'rus', 'fr_FR.utf8', 'fr_FR', 'de_DE.utf8', 'de_DE', 'es_ES.utf8', 'es_ES' );
		if ( false === $flag )
			$this->markTestSkipped( 'No European languages available for testing' );
		
		// Try an update query
		$wpdb->suppress_errors( true );
		$wpdb->update( 
			'test_table', 
			array( 'float_column' => 0.7 ), 
			array( 'meta_id' => 5 ), 
			array( '%f' ), 
			array( '%d' ) 
		);
		$wpdb->suppress_errors( false );
		
		// Ensure the float isn't 0,700
		$this->assertContains( '0.700', array_pop( $this->_queries ) );

		// Try a prepare
		$sql = $wpdb->prepare( "UPDATE test_table SET float_column = %f AND meta_id = %d", 0.7, 5 );
		$this->assertContains( '0.700', $sql );

		// Restore locale
		setlocale( LC_ALL, $current_locale );
	}
}
