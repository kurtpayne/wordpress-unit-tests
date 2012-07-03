<?php
/**
 * @group dependencies
 * @group scripts
 */
class TestWP_Dependencies extends WP_UnitTestCase {
	function test_add() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$this->assertInstanceOf('_WP_Dependency', $dep->query( 'one' ));
		$this->assertInstanceOf('_WP_Dependency', $dep->query( 'two' ));

		//Cannot reuse names
		$this->assertFalse($dep->add( 'one', '' ));
	}

	function test_remove() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$dep->remove( 'one' );

		$this->assertFalse($dep->query( 'one'));
		$this->assertInstanceOf('_WP_Dependency', $dep->query( 'two' ));

	}

	function test_enqueue() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$this->assertFalse($dep->query( 'one', 'queue' ));
		$dep->enqueue('one');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertFalse($dep->query( 'two', 'queue' ));

		$dep->enqueue('two');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));
	}

	function test_dequeue() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$dep->enqueue('one');
		$dep->enqueue('two');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));

		$dep->dequeue('one');
		$this->assertFalse($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));

		$dep->dequeue('two');
		$this->assertFalse($dep->query( 'one', 'queue' ));
		$this->assertFalse($dep->query( 'two', 'queue' ));
	}

	function test_enqueue_args() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$this->assertFalse($dep->query( 'one', 'queue' ));
		$dep->enqueue('one?arg');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertFalse($dep->query( 'two', 'queue' ));
		$this->assertEquals('arg', $dep->args['one']);

		$dep->enqueue('two?arg');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));
		$this->assertEquals('arg', $dep->args['two']);
	}

	function test_dequeue_args() {
		// Create a new object
		$dep = new WP_Dependencies;

		$this->assertTrue($dep->add( 'one', '' ));
		$this->assertTrue($dep->add( 'two', '' ));

		$dep->enqueue('one?arg');
		$dep->enqueue('two?arg');
		$this->assertTrue($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));
		$this->assertEquals('arg', $dep->args['one']);
		$this->assertEquals('arg', $dep->args['two']);

		$dep->dequeue('one');
		$this->assertFalse($dep->query( 'one', 'queue' ));
		$this->assertTrue($dep->query( 'two', 'queue' ));
		$this->assertFalse(isset($dep->args['one']));

		$dep->dequeue('two');
		$this->assertFalse($dep->query( 'one', 'queue' ));
		$this->assertFalse($dep->query( 'two', 'queue' ));
		$this->assertFalse(isset($dep->args['two']));
	}

}
