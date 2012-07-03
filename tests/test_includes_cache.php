<?php

/**
 * @group cache
 */
class TestObjectCache extends WP_UnitTestCase {
	var $cache = NULL;

	function setUp() {
		parent::setUp();
		// create two cache objects with a shared cache dir
		// this simulates a typical cache situation, two separate requests interacting
		$this->cache =& $this->init_cache();
	}

	function tearDown() {
		parent::tearDown();
		$this->flush_cache();
	}

	function &init_cache() {
		$cache = new WP_Object_Cache();
		return $cache;
	}

	function test_miss() {
		$this->assertEquals(NULL, $this->cache->get(rand_str()));
	}

	function test_add_get() {
		$key = rand_str();
		$val = rand_str();

		$this->cache->add($key, $val);
		$this->assertEquals($val, $this->cache->get($key));
	}

	function test_add_get_0() {
		$key = rand_str();
		$val = 0;

		// you can store zero in the cache
		$this->cache->add($key, $val);
		$this->assertEquals($val, $this->cache->get($key));
	}

	function test_add_get_null() {
		$key = rand_str();
		$val = null;

		$this->assertTrue( $this->cache->add($key, $val) );
		// null is converted to empty string
		$this->assertEquals( '', $this->cache->get($key) );
	}

	function test_add() {
		$key = rand_str();
		$val1 = rand_str();
		$val2 = rand_str();

		// add $key to the cache
		$this->assertTrue($this->cache->add($key, $val1));
		$this->assertEquals($val1, $this->cache->get($key));
		// $key is in the cache, so reject new calls to add()
		$this->assertFalse($this->cache->add($key, $val2));
		$this->assertEquals($val1, $this->cache->get($key));
	}

	function test_replace() {
		$key = rand_str();
		$val = rand_str();

		// memcached rejects replace() if the key does not exist
		$this->assertFalse($this->cache->replace($key, $val));
		$this->assertFalse($this->cache->get($key));
	}

	function test_set() {
		$key = rand_str();
		$val = rand_str();

		// memcached accepts set() if the key does not exist
		$this->assertTrue($this->cache->set($key, $val));
		$this->assertEquals($val, $this->cache->get($key));
	}

	function test_flush() {
		$key = rand_str();
		$val = rand_str();

		$this->cache->add($key, $val);
		// item is visible to both cache objects
		$this->assertEquals($val, $this->cache->get($key));
		$this->cache->flush();
		// If there is no value get returns false.
		$this->assertFalse($this->cache->get($key));
	}

	// Make sure objects are cloned going to and from the cache
	function test_object_refs() {
		$key = rand_str();
		$object_a = new stdClass;
		$object_a->foo = 'alpha';
		$this->cache->set( $key, $object_a );
		$object_a->foo = 'bravo';
		$object_b = $this->cache->get( $key );
		$this->assertEquals( 'alpha', $object_b->foo );
		$object_b->foo = 'charlie';
		$this->assertEquals( 'bravo', $object_a->foo );

		$key = rand_str();
		$object_a = new stdClass;
		$object_a->foo = 'alpha';
		$this->cache->add( $key, $object_a );
		$object_a->foo = 'bravo';
		$object_b = $this->cache->get( $key );
		$this->assertEquals( 'alpha', $object_b->foo );
		$object_b->foo = 'charlie';
		$this->assertEquals( 'bravo', $object_a->foo );
	}

	function test_incr() {
		$key = rand_str();

		$this->assertFalse( $this->cache->incr( $key ) );

		$this->cache->set( $key, 0 );
		$this->cache->incr( $key );
		$this->assertEquals( 1, $this->cache->get( $key ) );

		$this->cache->incr( $key, 2 );
		$this->assertEquals( 3, $this->cache->get( $key ) );
	}

	function test_decr() {
		$key = rand_str();

		$this->assertFalse( $this->cache->decr( $key ) );

		$this->cache->set( $key, 0 );
		$this->cache->decr( $key );
		$this->assertEquals( 0, $this->cache->get( $key ) );

		$this->cache->set( $key, 3 );
		$this->cache->decr( $key );
		$this->assertEquals( 2, $this->cache->get( $key ) );

		$this->cache->decr( $key, 2 );
		$this->assertEquals( 0, $this->cache->get( $key ) );
	}
}
