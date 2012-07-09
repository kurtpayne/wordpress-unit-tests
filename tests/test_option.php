<?php

/**
 * @group options
 */
class TestOption extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function tearDown() {
		parent::tearDown();
	}

	function __return_foo() {
		return 'foo';	
	}

	function test_the_basics() {
		$key = rand_str();
		$key2 = rand_str();
		$value = rand_str();
		$value2 = rand_str();

		$this->assertFalse( get_option( 'doesnotexist' ) );
		$this->assertTrue( add_option( $key, $value ) );
		$this->assertEquals( $value, get_option( $key ) );
		$this->assertFalse( add_option( $key, $value ) );  // Already exists
		$this->assertFalse( update_option( $key, $value ) );  // Value is the same
		$this->assertTrue( update_option( $key, $value2 ) );
		$this->assertEquals( $value2, get_option( $key ) );
		$this->assertFalse( add_option( $key, $value ) );
		$this->assertEquals( $value2, get_option( $key ) );
		$this->assertTrue( delete_option( $key ) );
		$this->assertFalse( get_option( $key ) );
		$this->assertFalse( delete_option( $key ) );

		$this->assertTrue( update_option( $key2, $value2 ) );
		$this->assertEquals( $value2, get_option( $key2 ) );
		$this->assertTrue( delete_option( $key2 ) );
		$this->assertFalse( get_option( $key2 ) );
	}

	function test_default_filter() {
		$random = rand_str();

		$this->assertFalse( get_option( 'doesnotexist' ) );

		// Default filter overrides $default arg.
		add_filter( 'default_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( 'foo', get_option( 'doesnotexist', 'bar' ) );

		// Remove the filter and the $default arg is honored.
		remove_filter( 'default_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( 'bar', get_option( 'doesnotexist', 'bar' ) );

		// Once the option exists, the $default arg and the default filter are ignored.
		add_option( 'doesnotexist', $random );
		$this->assertEquals( $random, get_option( 'doesnotexist', 'foo' ) );
		add_filter( 'default_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( $random, get_option( 'doesnotexist', 'foo' ) );
		remove_filter( 'default_option_doesnotexist', array( $this, '__return_foo' ) );

		// Cleanup
		$this->assertTrue( delete_option( 'doesnotexist' ) );
		$this->assertFalse( get_option( 'doesnotexist' ) );
	}

	function test_serialized_data() {
		$key = rand_str();
		$value = array( 'foo' => true, 'bar' => true );

		$this->assertTrue( add_option( $key, $value ) );
		$this->assertEquals( $value, get_option( $key ) );

		$value = (object) $value;
		$this->assertTrue( update_option( $key, $value ) );
		$this->assertEquals( $value, get_option( $key ) );
		$this->assertTrue( delete_option( $key ) );
	}
}

/**
 * @group options
 */
class TestSiteOption extends WP_UnitTestCase {
	function __return_foo() {
		return 'foo';	
	}

	function test_the_basics() {
		$key = rand_str();
		$key2 = rand_str();
		$value = rand_str();
		$value2 = rand_str();

		$this->assertFalse( get_site_option( 'doesnotexist' ) );
		$this->assertTrue( add_site_option( $key, $value ) );
		$this->assertEquals( $value, get_site_option( $key ) );
		$this->assertFalse( add_site_option( $key, $value ) );  // Already exists
		$this->assertFalse( update_site_option( $key, $value ) );  // Value is the same
		$this->assertTrue( update_site_option( $key, $value2 ) );
		$this->assertEquals( $value2, get_site_option( $key ) );
		$this->assertFalse( add_site_option( $key, $value ) );
		$this->assertEquals( $value2, get_site_option( $key ) );
		$this->assertTrue( delete_site_option( $key ) );
		$this->assertFalse( get_site_option( $key ) );
		$this->assertFalse( delete_site_option( $key ) );

		$this->assertTrue( update_site_option( $key2, $value2 ) );
		$this->assertEquals( $value2, get_site_option( $key2 ) );
		$this->assertTrue( delete_site_option( $key2 ) );
		$this->assertFalse( get_site_option( $key2 ) );
	}

	function test_default_filter() {
		$random = rand_str();

		$this->assertFalse( get_site_option( 'doesnotexist' ) );

		// Default filter overrides $default arg.
		add_filter( 'default_site_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( 'foo', get_site_option( 'doesnotexist', 'bar' ) );

		// Remove the filter and the $default arg is honored.
		remove_filter( 'default_site_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( 'bar', get_site_option( 'doesnotexist', 'bar' ) );

		// Once the option exists, the $default arg and the default filter are ignored.
		add_site_option( 'doesnotexist', $random );
		$this->assertEquals( $random, get_site_option( 'doesnotexist', 'foo' ) );
		add_filter( 'default_site_option_doesnotexist', array( $this, '__return_foo' ) );
		$this->assertEquals( $random, get_site_option( 'doesnotexist', 'foo' ) );
		remove_filter( 'default_site_option_doesnotexist', array( $this, '__return_foo' ) );

		// Cleanup
		$this->assertTrue( delete_site_option( 'doesnotexist' ) );
		$this->assertFalse( get_site_option( 'doesnotexist' ) );
	}

	function test_serialized_data() {
		$key = rand_str();
		$value = array( 'foo' => true, 'bar' => true );

		$this->assertTrue( add_site_option( $key, $value ) );
		$this->assertEquals( $value, get_site_option( $key ) );

		$value = (object) $value;
		$this->assertTrue( update_site_option( $key, $value ) );
		$this->assertEquals( $value, get_site_option( $key ) );
		$this->assertTrue( delete_site_option( $key ) );
	}

	// #15497 - ensure update_site_option will add options with false-y values
	function test_update_adds_falsey_value() {
		$key = rand_str();
		$value = 0;

		delete_site_option( $key );
		$this->assertTrue( update_site_option( $key, $value ) );
		wp_cache_flush(); // ensure we're getting the value from the DB
		$this->assertEquals( $value, get_site_option( $key ) );
	}

	// #18955 - ensure get_site_option doesn't cache the default value for non-existent options
	function test_get_doesnt_cache_default_value() {
		$option = rand_str();
		$default = 'a default';

		$this->assertEquals( get_site_option( $option, $default ), $default );
		$this->assertFalse( get_site_option( $option ) );	
	}
}

/**
 * @group options
 */
class TestTransient extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function tearDown() {
		parent::tearDown();
	}

	function test_the_basics() {
		$key = rand_str();
		$value = rand_str();
		$value2 = rand_str();

		$this->assertFalse( get_transient( 'doesnotexist' ) );
		$this->assertTrue( set_transient( $key, $value ) );
		$this->assertEquals( $value, get_transient( $key ) );
		$this->assertFalse( set_transient( $key, $value ) );
		$this->assertTrue( set_transient( $key, $value2 ) );
		$this->assertEquals( $value2, get_transient( $key ) );
		$this->assertTrue( delete_transient( $key ) );
		$this->assertFalse( get_transient( $key ) );
		$this->assertFalse( delete_transient( $key ) );
	}

	function test_serialized_data() {
		$key = rand_str();
		$value = array( 'foo' => true, 'bar' => true );

		$this->assertTrue( set_transient( $key, $value ) );
		$this->assertEquals( $value, get_transient( $key ) );

		$value = (object) $value;
		$this->assertTrue( set_transient( $key, $value ) );
		$this->assertEquals( $value, get_transient( $key ) );
		$this->assertTrue( delete_transient( $key ) );
	}
}

/**
 * @group options
 */
class TestSiteTransient extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function tearDown() {
		parent::tearDown();
	}

	function test_the_basics() {
		$key = rand_str();
		$value = rand_str();
		$value2 = rand_str();

		$this->assertFalse( get_site_transient( 'doesnotexist' ) );
		$this->assertTrue( set_site_transient( $key, $value ) );
		$this->assertEquals( $value, get_site_transient( $key ) );
		$this->assertFalse( set_site_transient( $key, $value ) );
		$this->assertTrue( set_site_transient( $key, $value2 ) );
		$this->assertEquals( $value2, get_site_transient( $key ) );
		$this->assertTrue( delete_site_transient( $key ) );
		$this->assertFalse( get_site_transient( $key ) );
		$this->assertFalse( delete_site_transient( $key ) );
	}

	function test_serialized_data() {
		$key = rand_str();
		$value = array( 'foo' => true, 'bar' => true );

		$this->assertTrue( set_site_transient( $key, $value ) );
		$this->assertEquals( $value, get_site_transient( $key ) );

		$value = (object) $value;
		$this->assertTrue( set_site_transient( $key, $value ) );
		$this->assertEquals( $value, get_site_transient( $key ) );
		$this->assertTrue( delete_site_transient( $key ) );
	}
}

if ( is_multisite() ) :
/**
 * @group options
 */
class TestBlogOption extends WP_UnitTestCase {
	function test_from_same_site() {
		$key = rand_str();
		$key2 = rand_str();
		$value = rand_str();
		$value2 = rand_str();

		$this->assertFalse( get_blog_option( 1, 'doesnotexist' ) );
		$this->assertFalse( get_option( 'doesnotexist' ) ); // check get_option()

		$this->assertTrue( add_blog_option( 1, $key, $value ) );
		// Assert all values of $blog_id that means the current or main blog (the same here).
		$this->assertEquals( $value, get_blog_option( 1, $key ) );
		$this->assertEquals( $value, get_blog_option( null, $key ) );
		$this->assertEquals( $value, get_blog_option( '1', $key ) );
		$this->assertEquals( $value, get_option( $key ) ); // check get_option()

		$this->assertFalse( add_blog_option( 1, $key, $value ) );  // Already exists
		$this->assertFalse( update_blog_option( 1, $key, $value ) );  // Value is the same
		$this->assertTrue( update_blog_option( 1, $key, $value2 ) );
		$this->assertEquals( $value2, get_blog_option( 1, $key ) );
		$this->assertEquals( $value2, get_option( $key ) ); // check get_option()
		$this->assertFalse( add_blog_option( 1, $key, $value ) );
		$this->assertEquals( $value2, get_blog_option( 1, $key ) );
		$this->assertEquals( $value2, get_option( $key ) ); // check get_option()

		$this->assertTrue( delete_blog_option( 1, $key ) );
		$this->assertFalse( get_blog_option( 1, $key ) );
		$this->assertFalse( get_option( $key ) ); // check get_option()
		$this->assertFalse( delete_blog_option( 1, $key ) );
		$this->assertTrue( update_blog_option( 1, $key2, $value2 ) );
		$this->assertEquals( $value2, get_blog_option( 1, $key2 ) );
		$this->assertEquals( $value2, get_option( $key2 ) ); // check get_option()
		$this->assertTrue( delete_blog_option( 1, $key2 ) );
		$this->assertFalse( get_blog_option( 1, $key2 ) );
		$this->assertFalse( get_option( $key2 ) ); // check get_option()
	}
}
endif;