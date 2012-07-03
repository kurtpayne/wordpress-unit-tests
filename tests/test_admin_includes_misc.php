<?php

/**
 * @group admin
 */
class TestShortenUrl extends WP_UnitTestCase {
	function test_shorten_url() {
		$tests = array(
			// strip slashes
			'wordpress\.org/about/philosophy'
				=> 'wordpress.org/about/philosophy', // strip slashes
			'http://wordpress.org/about/philosophy/'
				=> 'wordpress.org/about/philosophy', // remove http, trailing slash
			'http://www.wordpress.org/about/philosophy/'
				=> 'wordpress.org/about/philosophy', // remove http, www
			'http://wordpress.org/about/philosophy/#box'
				=> 'wordpress.org/about/philosophy/#box', // don't shorten 35 characters
			'http://wordpress.org/about/philosophy/#decisions'
				=> 'wordpress.org/about/philosophy/#...', // shorten to 32 if > 35 after cleaning
		);
		foreach ( $tests as $k => $v ) 
			$this->assertEquals( $v, url_shorten( $k ) );
	}
}