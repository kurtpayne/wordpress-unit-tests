<?php

abstract class WP_Formatting_UnitTestCase extends WP_UnitTestCase {
    function file_test($name, $callback) {
        $input = $this->get_testdata($name . ".input.txt");
        $output = $this->get_testdata($name . ".output.txt");
        for ($i=0; $i<count($input); ++$i) {
            $in = call_user_func($callback, $input[$i]);
            $this->assertEquals($output[$i], $in);
        }
    }

	/*
	Get test data from files, one test per line.
	Comments start with "###".
	*/
	function get_testdata($name) {
		$data = file( DIR_TESTDATA.'/jacob/'.$name );
		$odata = array();
		foreach ($data as $datum) {
		    // comment
		    $commentpos = strpos($datum, "###");
		    if ($commentpos !== false) {
		        $datum = trim(substr($datum, 0, $commentpos));
		        if (!$datum)
		            continue;
		    }
		    $odata[] = $datum;
		}
		return $odata;
	}
}

/**
 * @group formatting
 */
class Test_Seems_UTF8 extends WP_Formatting_UnitTestCase {
	/*
	 * `seems_utf8` returns true for utf-8 strings, false otherwise.
	 */
    function test_returns_true_for_utf8_strings() {
        // from http://www.i18nguy.com/unicode-example.html
        $utf8 = $this->get_testdata('utf-8.txt');
        $this->assertTrue(count($utf8) > 3);
        foreach ($utf8 as $string) {
            $this->assertTrue(seems_utf8($string));
        }
    }
    function test_returns_false_for_non_utf8_strings() {
    	$this->markTestIncomplete( 'This test does not have any assertions.' );

        $big5 = $this->get_testdata('test_big5.txt');
        $big5 = $big5[0];
        $strings = array(
            "abc",
            "123",
            $big5
        );
    }
}

/**
 * @group formatting
 */
class Test_UTF8_URI_Encode extends WP_Formatting_UnitTestCase {
    /*
    Non-ASCII UTF-8 characters should be percent encoded. Spaces etc.
    are dealt with elsewhere.
    */
    function test_percent_encodes_non_reserved_characters() {
        $utf8urls = $this->get_testdata('utf-8.txt');
        $urlencoded = $this->get_testdata('utf-8-urlencoded.txt');
        for ($i=0; $i<count($utf8urls); ++$i) {
            $this->assertEquals($urlencoded[$i], utf8_uri_encode($utf8urls[$i]));
        }
    }
    function test_output_is_not_longer_than_optional_length_argument() {
        $utf8urls = $this->get_testdata('utf-8.txt');
        foreach ($utf8urls as $url) {
            $maxlen = rand(5, 200);
            $this->assertTrue(strlen(utf8_uri_encode($url, $maxlen)) <= $maxlen);
        }
        
    }
    
}

/**
 * @group formatting
 */
class Test_WP_ISO_Descrambler extends WP_Formatting_UnitTestCase {
	/*
	 * Decodes text in RFC2047 "Q"-encoding, e.g.
	 * =?iso-8859-1?q?this=20is=20some=20text?=
	*/
    function test_decodes_iso_8859_1_rfc2047_q_encoding() {
        $this->assertEquals("this is some text", wp_iso_descrambler("=?iso-8859-1?q?this=20is=20some=20text?="));
    }
}

/**
 * @group formatting
 */
class Test_Ent2NCR extends WP_Formatting_UnitTestCase {
    function test_converts_named_entities_to_numeric_character_references() {
        $data = $this->get_testdata("entities.txt");
        foreach ($data as $datum) {
            $parts = explode("|", $datum);
            $name = "&" . trim($parts[0]) . ";";
            $ncr = trim($parts[1]);
            $this->assertEquals("&#".$ncr.";", ent2ncr($name), $name);
        }
    }
}
