<?php

/**
 * @group functions.php
 */
class TestFunctions extends WP_UnitTestCase {
	function test_wp_parse_args_object() {
		$x = new MockClass;
		$x->_baba = 5;
		$x->yZ = "baba";
		$x->a = array(5, 111, 'x');
		$this->assertEquals(array('_baba' => 5, 'yZ' => 'baba', 'a' => array(5, 111, 'x')), wp_parse_args($x));
		$y = new MockClass;
		$this->assertEquals(array(), wp_parse_args($y));
	}
	function test_wp_parse_args_array()  {
		// arrays
		$a = array();
		$this->assertEquals(array(), wp_parse_args($a));
		$b = array('_baba' => 5, 'yZ' => 'baba', 'a' => array(5, 111, 'x'));
		$this->assertEquals(array('_baba' => 5, 'yZ' => 'baba', 'a' => array(5, 111, 'x')), wp_parse_args($b));
	}
	function test_wp_parse_args_defaults() {
		$x = new MockClass;
		$x->_baba = 5;
		$x->yZ = "baba";
		$x->a = array(5, 111, 'x');
		$d = array('pu' => 'bu');
		$this->assertEquals(array('pu' => 'bu', '_baba' => 5, 'yZ' => 'baba', 'a' => array(5, 111, 'x')), wp_parse_args($x, $d));
		$e = array('_baba' => 6);
		$this->assertEquals(array('_baba' => 5, 'yZ' => 'baba', 'a' => array(5, 111, 'x')), wp_parse_args($x, $e));
	}
	function test_wp_parse_args_other() {
		$b = true;
		wp_parse_str($b, $s);
		$this->assertEquals($s, wp_parse_args($b));
		$q = 'x=5&_baba=dudu&';
		wp_parse_str($q, $ss);
		$this->assertEquals($ss, wp_parse_args($q));
	}
	function test_size_format() {
		$kb = 1024;
		$mb = $kb*1024;
		$gb = $mb*1024;
		$tb = $gb*1024;
		// test if boundaries are correct
		$this->assertEquals('1 GB', size_format($gb, 0));
		$this->assertEquals('1 MB', size_format($mb, 0));
		$this->assertEquals('1 kB', size_format($kb, 0));
		// now some values around
		// add some bytes to make sure the result isn't 1.4999999
		$this->assertEquals('1.5 TB', size_format($tb + $tb/2 + $mb, 1));
		$this->assertEquals('1,023.999 GB', size_format($tb-$mb-$kb, 3));
		// edge
		$this->assertFalse(size_format(-1));
		$this->assertFalse(size_format(0));
		$this->assertFalse(size_format('baba'));
		$this->assertFalse(size_format(array()));
	}

	function test_path_is_absolute() {
		if ( !is_callable('path_is_absolute') )
			$this->markTestSkipped();

		$absolute_paths = array(
			'/',
			'/foo/',
			'/foo',
			'/FOO/bar',
			'/foo/bar/',
			'/foo/../bar/',
			'\\WINDOWS',
			'C:\\',
			'C:\\WINDOWS',
			'\\\\sambashare\\foo',
			);
		foreach ($absolute_paths as $path)
			$this->assertTrue( path_is_absolute($path), "path_is_absolute('$path') should return true" );
	}

	function test_path_is_not_absolute() {
		if ( !is_callable('path_is_absolute') )
			$this->markTestSkipped();

		$relative_paths = array(
			'',
			'.',
			'..',
			'../foo',
			'../',
			'../foo.bar',
			'foo/bar',
			'foo',
			'FOO',
			'..\\WINDOWS',
			);
		foreach ($relative_paths as $path)
			$this->assertFalse( path_is_absolute($path), "path_is_absolute('$path') should return false" );
	}


	function test_wp_unique_filename() {
		/* this test requires:
		   - that you have dir + file 'data/images/test-image.png',
		   - and that this dir is writeable
		   - there is an image 'test-image.png' that will be used to test unique filenames

		   NB: there is a hardcoded dependency that the testing file is '.png'; however,
		       this limitation is arbitary, so change it if you like.
		*/
		$testdir = DIR_TESTDATA . '/images/';
		$testimg = 'test-image.png';
		$this->assertTrue( file_exists($testdir) );
		$this->assertTrue( is_writable($testdir) );
		$this->assertTrue( file_exists($testdir . $testimg) );

		$cases = array(
			// null case
			'null' . $testimg,

			// edge cases: '.png', 'abc.', 'abc', 'abc0', 'abc1', 'abc0.png', 'abc1.png' (num @ end)
			'.png',
			'abc',
			'abc.',
			'abc0',
			'abc1',
			'abc0.png',
			'abc1.png',

			// replacing # with _
			str_replace('-', '#', $testimg), // test#image.png
			str_replace('-', '##', $testimg), // test##image.png
			str_replace(array('-', 'e'), '#', $testimg), // t#st#imag#.png
			str_replace(array('-', 'e'), '##', $testimg), // t##st##imag##.png

			// replacing \ or ' with nothing
			str_replace('-', '\\', $testimg), // test\image.png
			str_replace('-', '\\\\', $testimg), // test\\image.png
			str_replace(array('-', 'e'), '\\', $testimg), // t\st\imag\.png
			str_replace(array('-', 'e'), '\\\\', $testimg), // t\\st\\imag\\.png
			str_replace('-', "'", $testimg), // test'image.png
			str_replace('-', "'", $testimg), // test''image.png
			str_replace(array('-', 'e'), "'", $testimg), // t'st'imag'.png
			str_replace(array('-', 'e'), "''", $testimg), // t''st''imag''.png
			str_replace('-', "\'", $testimg), // test\'image.png
			str_replace('-', "\'\'", $testimg), // test\'\'image.png
			str_replace(array('-', 'e'), "\'", $testimg), // t\'st\'imag\'.png
			str_replace(array('-', 'e'), "\'\'", $testimg), // t\'\'st\'\'imag\'\'.png

			'test' . str_replace('e', 'é', $testimg), // testtést-imagé.png

			'12%af34567890~!@#$..%^&*()|_+qwerty  fgh`jkl zx<>?:"{}[]="\'/?.png', // kitchen sink
			$testdir.'test-image-with-path.png',
		);

		// what we expect the replacements will do
		$expected = array(
				'null' . $testimg,

				'png',
				'abc',
				'abc',
				'abc0',
				'abc1',
				'abc0.png',
				'abc1.png',

				'testimage.png',
				'testimage.png',
				'tstimag.png',
				'tstimag.png',

				'testimage.png',
				'testimage.png',
				'tstimag.png',
				'tstimag.png',
				'testimage.png',
				'testimage.png',
				'tstimag.png',
				'tstimag.png',
				'testimage.png',
				'testimage.png',
				'tstimag.png',
				'tstimag.png',

				'testtést-imagé.png',

				'12%af34567890@..%^_+qwerty-fghjkl-zx.png',
				str_replace( array( '\\', '/', ':' ), '', $testdir ).'test-image-with-path.png',
			);

		foreach ($cases as $key => $case) {
			// make sure expected file doesn't exist already
			// happens when tests fail and the unlinking doesn't happen
			if( $expected[$key] !== $testimg && file_exists($testdir . $expected[$key]) )
				unlink($testdir . $expected[$key]);

			// -- TEST 1: the replacement is as expected
			$this->assertEquals( $expected[$key], wp_unique_filename($testdir, $case, NULL), $case );
			// -- end TEST 1

			// -- TEST 2: the renaming will produce a unique name
			// create the expected file
			copy($testdir . $testimg, $testdir . $expected[$key]);
			// test that wp_unique_filename actually returns a unique filename
			$this->assertFileNotExists( $testdir . wp_unique_filename($testdir, $case, NULL) );
			// -- end TEST 2

			// cleanup
			if( $expected[$key] !== $testimg &&  file_exists($testdir . $expected[$key]) )
				unlink($testdir . $expected[$key]);
		}
	}

	/**
	 * @ticket 9930
	 */
	function test_is_serialized() {
		$cases = array(
			serialize(null),
			serialize(true),
			serialize(false),
			serialize(-25),
			serialize(25),
			serialize(1.1),
			serialize(2.1E+200),
			serialize('this string will be serialized'),
			serialize("a\nb"),
			serialize(array()),
			serialize(array(1,1,2,3,5,8,13)),
			serialize( (object)array('test' => true, '3', 4) )
		);
		foreach ( $cases as $case )
			$this->assertTrue( is_serialized($case), "Serialized data: $case" );

		$not_serialized = array(
			'a string',
			'garbage:a:0:garbage;',
			'b:4;',
			's:4:test;'
		);
		foreach ( $not_serialized as $case )
			$this->assertFalse( is_serialized($case), "Test data: $case" );
	}

}

/**
 * Test wp_filter_object_list(), wp_list_filter(), wp_list_pluck().
 *
 * @group functions.php
 */
class TestListFilter extends WP_UnitTestCase {
	var $object_list = array();
	var $array_list = array();

	function setUp() {
		$this->array_list['foo'] = array( 'name' => 'foo', 'field1' => true, 'field2' => true, 'field3' => true, 'field4' => array( 'red' ) );
		$this->array_list['bar'] = array( 'name' => 'bar', 'field1' => true, 'field2' => true, 'field3' => false, 'field4' => array( 'green' ) );
		$this->array_list['baz'] = array( 'name' => 'baz', 'field1' => true, 'field2' => false, 'field3' => false, 'field4' => array( 'blue' ) );
		foreach ( $this->array_list as $key => $value ) {
			$this->object_list[ $key ] = (object) $value;
		}
	}

	function test_filter_object_list_and() {
		$list = wp_filter_object_list( $this->object_list, array( 'field1' => true, 'field2' => true ), 'AND' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertArrayHasKey( 'foo', $list );
		$this->assertArrayHasKey( 'bar', $list );
	}

	function test_filter_object_list_or() {
		$list = wp_filter_object_list( $this->object_list, array( 'field1' => true, 'field2' => true ), 'OR' );
		$this->assertEquals( 3, count( $list ) );
		$this->assertArrayHasKey( 'foo', $list );
		$this->assertArrayHasKey( 'bar', $list );
		$this->assertArrayHasKey( 'baz', $list );
	}

	function test_filter_object_list_not() {
		$list = wp_filter_object_list( $this->object_list, array( 'field2' => true, 'field3' => true ), 'NOT' );
		$this->assertEquals( 1, count( $list ) );
		$this->assertArrayHasKey( 'baz', $list );
	}

	function test_filter_object_list_and_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field1' => true, 'field2' => true ), 'AND', 'name' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertEquals( array( 'foo' => 'foo', 'bar' => 'bar' ) , $list );
	}

	function test_filter_object_list_or_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field2' => true, 'field3' => true ), 'OR', 'name' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertEquals( array( 'foo' => 'foo', 'bar' => 'bar' ) , $list );
	}

	function test_filter_object_list_not_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field2' => true, 'field3' => true ), 'NOT', 'name' );
		$this->assertEquals( 1, count( $list ) );
		$this->assertEquals( array( 'baz' => 'baz' ) , $list );
	}

	function test_wp_list_pluck() {
		$list = wp_list_pluck( $this->object_list, 'name' );
		$this->assertEquals( array( 'foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz' ) , $list );

		$list = wp_list_pluck( $this->array_list, 'name' );
		$this->assertEquals( array( 'foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz' ) , $list );
	}

	function test_filter_object_list_nested_array_and() {
		$list = wp_filter_object_list( $this->object_list, array( 'field4' => array( 'blue' ) ), 'AND' );
		$this->assertEquals( 1, count( $list ) );
		$this->assertArrayHasKey( 'baz', $list );
	}

	function test_filter_object_list_nested_array_not() {
		$list = wp_filter_object_list( $this->object_list, array( 'field4' => array( 'red' ) ), 'NOT' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertArrayHasKey( 'bar', $list );
		$this->assertArrayHasKey( 'baz', $list );
	}

	function test_filter_object_list_nested_array_or() {
		$list = wp_filter_object_list( $this->object_list, array( 'field3' => true, 'field4' => array( 'blue' ) ), 'OR' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertArrayHasKey( 'foo', $list );
		$this->assertArrayHasKey( 'baz', $list );
	}

	function test_filter_object_list_nested_array_or_singular() {
		$list = wp_filter_object_list( $this->object_list, array( 'field4' => array( 'blue' ) ), 'OR' );
		$this->assertEquals( 1, count( $list ) );
		$this->assertArrayHasKey( 'baz', $list );
	}


	function test_filter_object_list_nested_array_and_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field4' => array( 'blue' ) ), 'AND', 'name' );
		$this->assertEquals( 1, count( $list ) );
		$this->assertEquals( array( 'baz' => 'baz' ) , $list );
	}

	function test_filter_object_list_nested_array_not_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field4' => array( 'green' ) ), 'NOT', 'name' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertEquals( array( 'foo' => 'foo', 'baz' => 'baz' ), $list );
	}

	function test_filter_object_list_nested_array_or_field() {
		$list = wp_filter_object_list( $this->object_list, array( 'field3' => true, 'field4' => array( 'blue' ) ), 'OR', 'name' );
		$this->assertEquals( 2, count( $list ) );
		$this->assertEquals( array( 'foo' => 'foo', 'baz' => 'baz' ), $list );
	}
}

/**
 * @group http
 */
class TestHTTPFunctions extends WP_UnitTestCase {
	function test_head_request() {
		// this url give a direct 200 response
		$url = 'http://asdftestblog1.files.wordpress.com/2007/09/2007-06-30-dsc_4700-1.jpg';
		$response = wp_remote_head( $url );
		$headers = wp_remote_retrieve_headers( $response );

		$this->assertTrue( is_array( $headers ) );
		$this->assertEquals( 'image/jpeg', $headers['content-type'] );
		$this->assertEquals( '40148', $headers['content-length'] );
		$this->assertEquals( '200', wp_remote_retrieve_response_code( $response ) );
	}

	function test_head_redirect() {
		// this url will 301 redirect
		$url = 'http://asdftestblog1.wordpress.com/files/2007/09/2007-06-30-dsc_4700-1.jpg';
		$response = wp_remote_head( $url );
		$this->assertEquals( '301', wp_remote_retrieve_response_code( $response ) );
	}

	function test_head_404() {
		$url = 'http://asdftestblog1.files.wordpress.com/2007/09/awefasdfawef.jpg';
		$response = wp_remote_head( $url );

		$this->assertTrue( is_array($response) );
		$this->assertEquals( '404', wp_remote_retrieve_response_code( $response ) );
	}

	function test_get_request() {
		$url = 'http://asdftestblog1.files.wordpress.com/2007/09/2007-06-30-dsc_4700-1.jpg';
		$file = tempnam('/tmp', 'testfile');

		$headers = wp_get_http($url, $file);

		// should return the same headers as a head request
		$this->assertTrue( is_array($headers) );
		$this->assertEquals( 'image/jpeg', $headers['content-type'] );
		$this->assertEquals( '40148', $headers['content-length'] );
		$this->assertEquals( '200', $headers['response'] );

		// make sure the file is ok
		$this->assertEquals( 40148, filesize($file) );
		$this->assertEquals( 'b0371a0fc575fcf77f62cd298571f53b', md5_file($file) );
	}

	function test_get_redirect() {
		// this will redirect to asdftestblog1.files.wordpress.com
		$url = 'http://asdftestblog1.wordpress.com/files/2007/09/2007-06-30-dsc_4700-1.jpg';
		$file = tempnam('/tmp', 'testfile');

		$headers = wp_get_http($url, $file);

		// should return the same headers as a head request
		$this->assertTrue( is_array($headers) );
		$this->assertEquals( 'image/jpeg', $headers['content-type'] );
		$this->assertEquals( '40148', $headers['content-length'] );
		$this->assertEquals( '200', $headers['response'] );

		// make sure the file is ok
		$this->assertEquals( 40148, filesize($file) );
		$this->assertEquals( 'b0371a0fc575fcf77f62cd298571f53b', md5_file($file) );
	}

	function test_get_redirect_limit_exceeded() {
		// this will redirect to asdftestblog1.files.wordpress.com
		$url = 'http://asdftestblog1.wordpress.com/files/2007/09/2007-06-30-dsc_4700-1.jpg';
		$file = tempnam('/tmp', 'testfile');
		// pretend we've already redirected 5 times
		$headers = wp_get_http( $url, $file, 6 );
		$this->assertFalse( $headers );
	}
}

/**
 * @group themes
 * @group plugins
 */
class Test_WP_File_Headers extends WP_UnitTestCase {
	function test_get_file_data() {
		$theme_headers = array(
			'Name' => 'Theme Name',
			'ThemeURI' => 'Theme URI',
			'Description' => 'Description',
			'Version' => 'Version',
			'Author' => 'Author',
			'AuthorURI' => 'Author URI',
		);

		$actual = get_file_data( DIR_TESTDATA . '/themedir1/default/style.css', $theme_headers );

		$expected = array(
			'Name' => 'WordPress Default',
			'ThemeURI' => 'http://wordpress.org/',
			'Description' => 'The default WordPress theme based on the famous <a href="http://binarybonsai.com/kubrick/">Kubrick</a>.',
			'Version' => '1.6',
			'Author' => 'Michael Heilemann',
			'AuthorURI' => 'http://binarybonsai.com/',
		);

		foreach ( $actual as $header => $value )
			$this->assertEquals( $expected[ $header ], $value, $header );
	}
		
	function test_get_file_data_cr_line_endings() {
		$headers = array( 'SomeHeader' => 'Some Header', 'Description' => 'Description', 'Author' => 'Author' );
		$actual = get_file_data( DIR_TESTDATA . '/formatting/cr-line-endings-file-header.php', $headers );
		$expected = array(
			'SomeHeader' => 'Some header value!',
			'Description' => 'This file is using CR line endings for a testcase.',
			'Author' => 'A Very Old Mac',
		);

		foreach ( $actual as $header => $value )
			$this->assertEquals( $expected[ $header ], $value, $header );
	}
}
