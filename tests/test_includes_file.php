<?php

class TestIncludesFile extends WP_UnitTestCase {

	function setUp() {
		$this->dir = dirname(tempnam('/tmp', 'foo'));

		$this->badchars = '"\'[]*&?$';
	}

	function is_unique_writable_file($path, $filename) {
		$fullpath = $path . DIRECTORY_SEPARATOR . $filename;

		$fp = fopen( $fullpath, 'x' );
		// file already exists?
		if (!$fp)
			return false;

		// write some random contents
		$c = rand_str();
		fwrite($fp, $c);
		fclose($fp);

		if ( file_get_contents($fullpath) === $c )
			$result = true;
		else
			$result = false;

		return $result;
	}

	function test_unique_filename_is_valid() {
		// make sure it produces a valid, writable, unique filename
		$filename = wp_unique_filename( $this->dir, rand_str() . '.txt' );

		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename) );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename);
	}

	function test_unique_filename_is_unique() {
		// make sure it produces two unique filenames
		$name = rand_str();

		$filename1 = wp_unique_filename( $this->dir, $name . '.txt' );
		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename1) );
		$filename2 = wp_unique_filename( $this->dir, $name . '.txt' );
		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename2) );

		// the two should be different
		$this->assertNotEquals( $filename1, $filename2 );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename1);
		unlink($this->dir . DIRECTORY_SEPARATOR . $filename2);
	}

	function test_unique_filename_is_sanitized() {
		$name = rand_str();
		$filename = wp_unique_filename( $this->dir, $name . $this->badchars .  '.txt' );

		// make sure the bad characters were all stripped out
		$this->assertEquals( $name . '.txt', $filename );

		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename) );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename);
	}

	function test_unique_filename_with_slashes() {
		$name = rand_str();
		// "foo/foo.txt"
		$filename = wp_unique_filename( $this->dir, $name . '/' . $name .  '.txt' );

		// the slash should be removed, i.e. "foofoo.txt"
		$this->assertEquals( $name . $name . '.txt', $filename );

		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename) );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename);
	}

	function test_unique_filename_multiple_ext() {
		$name = rand_str();
		$filename = wp_unique_filename( $this->dir, $name . '.php.txt' );

		// "foo.php.txt" becomes "foo.php_.txt"
		$this->assertEquals( $name . '.php_.txt', $filename );

		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename) );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename);
	}

	function test_unique_filename_no_ext() {
		$name = rand_str();
		$filename = wp_unique_filename( $this->dir, $name );

		$this->assertEquals( $name, $filename );

		$this->assertTrue( $this->is_unique_writable_file($this->dir, $filename) );

		unlink($this->dir . DIRECTORY_SEPARATOR . $filename);
	}

}
