<?php

/**
 * @group dependencies
 * @group scripts
 */
class Tests_Dependencies_jQuery extends WP_UnitTestCase {

	function test_location_of_jquery() {
        $jquery_scripts = array(
            'jquery-core'    => '/wp-includes/js/jquery/jquery.js',
            'jquery-migrate' => '/wp-includes/js/jquery/jquery-migrate.js'
        );
		$scripts = new WP_Scripts;
		wp_default_scripts( $scripts );
		$object = $scripts->query( 'jquery', 'registered' );
		$this->assertInstanceOf( '_WP_Dependency', $object );
        $this->assertEqualSets( $object->deps, array_keys( $jquery_scripts ) );
        foreach( $object->deps as $dep ) {
            $o = $scripts->query( $dep, 'registered' );
            $this->assertInstanceOf( '_WP_Dependency', $object );
            $this->assertTrue( isset( $jquery_scripts[ $dep ] ) );
            $this->assertEquals( $jquery_scripts[ $dep ], $o->src );
        }
	}

	function test_presence_of_jquery_no_conflict() {
		$contents = trim( file_get_contents( ABSPATH . WPINC . '/js/jquery/jquery.js' ) );
		$noconflict = 'jQuery.noConflict();';
		$end = substr( $contents, - strlen( $noconflict ) );
		$this->assertEquals( $noconflict, $end );
	}
}
