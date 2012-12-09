<?php

/**
 * @group dependencies
 * @group scripts
 */
class Tests_Dependencies_jQuery extends WP_UnitTestCase {

	function test_location_of_jquery() {
		$scripts = new WP_Scripts;
		wp_default_scripts( $scripts );
		$object = $scripts->query( 'jquery', 'registered' );
		$this->assertInstanceOf( '_WP_Dependency', $object );
		$this->assertEquals( '/wp-includes/js/jquery/jquery.js', $object->src );
	}

	function test_presence_of_jquery_no_conflict() {
		$contents = trim( file_get_contents( ABSPATH . WPINC . '/js/jquery/jquery.js' ) );
		$noconflict = 'jQuery.noConflict();';
		$end = substr( $contents, - strlen( $noconflict ) );
		$this->assertEquals( $noconflict, $end );
	}
}
