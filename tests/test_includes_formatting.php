<?php

/**
 * @group formatting
 */
class TestMakeClickable extends WP_UnitTestCase {
	function test_mailto_xss() {
		$in = 'testzzz@"STYLE="behavior:url(\'#default#time2\')"onBegin="alert(\'refresh-XSS\')"';
		$this->assertEquals($in, make_clickable($in));
	}

	function test_valid_mailto() {
		$valid_emails = array(
			'foo@example.com',
			'foo.bar@example.com',
			'Foo.Bar@a.b.c.d.example.com',
			'0@example.com',
			'foo@example-example.com',
			);
		foreach ($valid_emails as $email) {
			$this->assertEquals('<a href="mailto:'.$email.'">'.$email.'</a>', make_clickable($email));
		}
	}

	function test_invalid_mailto() {
		$invalid_emails = array(
			'foo',
			'foo@',
			'foo@@example.com',
			'@example.com',
			'foo @example.com',
			'foo@example',
			);
		foreach ($invalid_emails as $email) {
			$this->assertEquals($email, make_clickable($email));
		}
	}

	// tests that make_clickable will not link trailing periods, commas and
	// (semi-)colons in URLs with protocol (i.e. http://wordpress.org)
	function test_strip_trailing_with_protocol() {
		$urls_before = array(
			'http://wordpress.org/hello.html',
			'There was a spoon named http://wordpress.org. Alice!',
			'There was a spoon named http://wordpress.org, said Alice.',
			'There was a spoon named http://wordpress.org; said Alice.',
			'There was a spoon named http://wordpress.org: said Alice.',
			'There was a spoon named (http://wordpress.org) said Alice.'
			);
		$urls_expected = array(
			'<a href="http://wordpress.org/hello.html" rel="nofollow">http://wordpress.org/hello.html</a>',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>. Alice!',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>, said Alice.',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>; said Alice.',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>: said Alice.',
			'There was a spoon named (<a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>) said Alice.'
			);

		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// tests that make_clickable will not link trailing periods, commas and
	// (semi-)colons in URLs with protocol (i.e. http://wordpress.org)
	function test_strip_trailing_with_protocol_nothing_afterwards() {
		$urls_before = array(
			'http://wordpress.org/hello.html',
			'There was a spoon named http://wordpress.org.',
			'There was a spoon named http://wordpress.org,',
			'There was a spoon named http://wordpress.org;',
			'There was a spoon named http://wordpress.org:',
			'There was a spoon named (http://wordpress.org)',
			'There was a spoon named (http://wordpress.org)x',
			);
		$urls_expected = array(
			'<a href="http://wordpress.org/hello.html" rel="nofollow">http://wordpress.org/hello.html</a>',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>.',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>,',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>;',
			'There was a spoon named <a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>:',
			'There was a spoon named (<a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>)',
			'There was a spoon named (<a href="http://wordpress.org" rel="nofollow">http://wordpress.org</a>)x',
			);

		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// tests that make_clickable will not link trailing periods, commas and
	// (semi-)colons in URLs without protocol (i.e. www.wordpress.org)
	function test_strip_trailing_without_protocol() {
		$urls_before = array(
			'www.wordpress.org',
			'There was a spoon named www.wordpress.org. Alice!',
			'There was a spoon named www.wordpress.org, said Alice.',
			'There was a spoon named www.wordpress.org; said Alice.',
			'There was a spoon named www.wordpress.org: said Alice.',
			'There was a spoon named www.wordpress.org) said Alice.'
			);
		$urls_expected = array(
			'<a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>. Alice!',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>, said Alice.',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>; said Alice.',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>: said Alice.',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>) said Alice.'
			);

		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// tests that make_clickable will not link trailing periods, commas and
	// (semi-)colons in URLs without protocol (i.e. www.wordpress.org)
	function test_strip_trailing_without_protocol_nothing_afterwards() {
		$urls_before = array(
			'www.wordpress.org',
			'There was a spoon named www.wordpress.org.',
			'There was a spoon named www.wordpress.org,',
			'There was a spoon named www.wordpress.org;',
			'There was a spoon named www.wordpress.org:',
			'There was a spoon named www.wordpress.org)'
			);
		$urls_expected = array(
			'<a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>.',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>,',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>;',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>:',
			'There was a spoon named <a href="http://www.wordpress.org" rel="nofollow">http://www.wordpress.org</a>)'
			);

		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// #4570
	function test_iri() {
		$urls_before = array(
			'http://www.詹姆斯.com/',
			'http://bg.wikipedia.org/Баба',
			'http://example.com/?a=баба&b=дядо',
		);
		$urls_expected = array(
			'<a href="http://www.詹姆斯.com/" rel="nofollow">http://www.詹姆斯.com/</a>',
			'<a href="http://bg.wikipedia.org/Баба" rel="nofollow">http://bg.wikipedia.org/Баба</a>',
			'<a href="http://example.com/?a=баба&#038;b=дядо" rel="nofollow">http://example.com/?a=баба&#038;b=дядо</a>',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// #10990
	function test_brackets_in_urls() {
		$urls_before = array(
			'http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)',
			'(http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software))',
			'blah http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software) blah',
			'blah (http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)) blah',
			'blah blah blah http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software) blah blah',
			'blah blah blah http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)) blah blah',
			'blah blah (http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)) blah blah',
			'blah blah http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software).) blah blah',
			'blah blah http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software).)moreurl blah blah',
			'In his famous speech “You and Your research” (here:
			http://www.cs.virginia.edu/~robins/YouAndYourResearch.html)
			Richard Hamming wrote about people getting more done with their doors closed, but', 
		);
		$urls_expected = array(
			'<a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>',
			'(<a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>)',
			'blah <a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a> blah',
			'blah (<a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>) blah',
			'blah blah blah <a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a> blah blah',
			'blah blah blah <a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>) blah blah',
			'blah blah (<a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>) blah blah',
			'blah blah <a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>.) blah blah',
			'blah blah <a href="http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)" rel="nofollow">http://en.wikipedia.org/wiki/PC_Tools_(Central_Point_Software)</a>.)moreurl blah blah',
			'In his famous speech “You and Your research” (here:
			<a href="http://www.cs.virginia.edu/~robins/YouAndYourResearch.html" rel="nofollow">http://www.cs.virginia.edu/~robins/YouAndYourResearch.html</a>)
			Richard Hamming wrote about people getting more done with their doors closed, but', 
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// Based on a real comments which were incorrectly linked. #11211
	function test_real_world_examples() {
		$urls_before = array(
			'Example: WordPress, test (some text), I love example.com (http://example.org), it is brilliant',
			'Example: WordPress, test (some text), I love example.com (http://example.com), it is brilliant',
			'Some text followed by a bracketed link with a trailing elipsis (http://example.com)...',
			'In his famous speech “You and Your research” (here: http://www.cs.virginia.edu/~robins/YouAndYourResearch.html) Richard Hamming wrote about people getting more done with their doors closed...',
		);
		$urls_expected = array(
			'Example: WordPress, test (some text), I love example.com (<a href="http://example.org" rel="nofollow">http://example.org</a>), it is brilliant',
			'Example: WordPress, test (some text), I love example.com (<a href="http://example.com" rel="nofollow">http://example.com</a>), it is brilliant',
			'Some text followed by a bracketed link with a trailing elipsis (<a href="http://example.com" rel="nofollow">http://example.com</a>)...',
			'In his famous speech “You and Your research” (here: <a href="http://www.cs.virginia.edu/~robins/YouAndYourResearch.html" rel="nofollow">http://www.cs.virginia.edu/~robins/YouAndYourResearch.html</a>) Richard Hamming wrote about people getting more done with their doors closed...',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	// #14993
	function test_twitter_hash_bang() {
		$urls_before = array(
			'http://twitter.com/#!/wordpress/status/25907440233',
			'This is a really good tweet http://twitter.com/#!/wordpress/status/25907440233 !',
			'This is a really good tweet http://twitter.com/#!/wordpress/status/25907440233!',
		);
		$urls_expected = array(
			'<a href="http://twitter.com/#!/wordpress/status/25907440233" rel="nofollow">http://twitter.com/#!/wordpress/status/25907440233</a>',
			'This is a really good tweet <a href="http://twitter.com/#!/wordpress/status/25907440233" rel="nofollow">http://twitter.com/#!/wordpress/status/25907440233</a> !',
			'This is a really good tweet <a href="http://twitter.com/#!/wordpress/status/25907440233" rel="nofollow">http://twitter.com/#!/wordpress/status/25907440233</a>!',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	function test_wrapped_in_angles() {
		$before = array(
			'URL wrapped in angle brackets <http://example.com/>',
			'URL wrapped in angle brackets with padding < http://example.com/ >',
			'mailto wrapped in angle brackets <foo@example.com>',
		);
		$expected = array(
			'URL wrapped in angle brackets <<a href="http://example.com/" rel="nofollow">http://example.com/</a>>',
			'URL wrapped in angle brackets with padding < <a href="http://example.com/" rel="nofollow">http://example.com/</a> >',
			'mailto wrapped in angle brackets <foo@example.com>',
		);
		foreach ($before as $key => $url) {
			$this->assertEquals($expected[$key], make_clickable($url));
		}
	}

	function test_preceded_by_punctuation() {
		$before = array(
			'Comma then URL,http://example.com/',
			'Period then URL.http://example.com/',
			'Semi-colon then URL;http://example.com/',
			'Colon then URL:http://example.com/',
			'Exclamation mark then URL!http://example.com/',
			'Question mark then URL?http://example.com/',
		);
		$expected = array(
			'Comma then URL,<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
			'Period then URL.<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
			'Semi-colon then URL;<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
			'Colon then URL:<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
			'Exclamation mark then URL!<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
			'Question mark then URL?<a href="http://example.com/" rel="nofollow">http://example.com/</a>',
		);
		foreach ($before as $key => $url) {
			$this->assertEquals($expected[$key], make_clickable($url));
		}
	}

	function test_dont_break_attributes() {
		$urls_before = array(
			"<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>",
			"(<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"http://trunk.domain/testing#something (<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"http://trunk.domain/testing#something
			(<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"<span style='text-align:center; display: block;'><object width='425' height='350'><param name='movie' value='http://www.youtube.com/v/nd_BdvG43rE&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1' /> <param name='allowfullscreen' value='true' /> <param name='wmode' value='opaque' /> <embed src='http://www.youtube.com/v/nd_BdvG43rE&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1' type='application/x-shockwave-flash' allowfullscreen='true' width='425' height='350' wmode='opaque'></embed> </object></span>",
			'<a href="http://example.com/example.gif" title="Image from http://example.com">Look at this image!</a>',
		);
		$urls_expected = array(
			"<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>",
			"(<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"<a href=\"http://trunk.domain/testing#something\" rel=\"nofollow\">http://trunk.domain/testing#something</a> (<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"<a href=\"http://trunk.domain/testing#something\" rel=\"nofollow\">http://trunk.domain/testing#something</a>
			(<img src='http://trunk.domain/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley'>)",
			"<span style='text-align:center; display: block;'><object width='425' height='350'><param name='movie' value='http://www.youtube.com/v/nd_BdvG43rE&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1' /> <param name='allowfullscreen' value='true' /> <param name='wmode' value='opaque' /> <embed src='http://www.youtube.com/v/nd_BdvG43rE&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1' type='application/x-shockwave-flash' allowfullscreen='true' width='425' height='350' wmode='opaque'></embed> </object></span>",
			'<a href="http://example.com/example.gif" title="Image from http://example.com">Look at this image!</a>',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals($urls_expected[$key], make_clickable($url));
		}
	}

	/**
	 * @ticket 16892
	 */
	function test_click_inside_html() {
		$urls_before = array(
			'<span>http://example.com</span>',
			'<p>http://example.com/</p>',
		);
		$urls_expected = array(
			'<span><a href="http://example.com" rel="nofollow">http://example.com</a></span>',
			'<p><a href="http://example.com/" rel="nofollow">http://example.com/</a></p>',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals( $urls_expected[$key], make_clickable( $url ) );
		}
	}

	function test_no_links_within_links() {
		$in = array(
			'Some text with a link <a href="http://example.com">http://example.com</a>',
			//'<a href="http://wordpress.org">This is already a link www.wordpress.org</a>', // fails in 3.3.1 too
		);
		foreach ( $in as $text ) {
			$this->assertEquals( $text, make_clickable( $text ) );
		}
	}

	/**
	 * ticket 16892
	 */
	function test_no_segfault() {
		if ( version_compare( $GLOBALS['wp_version'], '3.1.1', '<' ) )
			$this->markTestSkipped();

		$in = str_repeat( 'http://example.com/2011/03/18/post-title/', 256 );
		$out = make_clickable( $in );
		if ( version_compare( $GLOBALS['wp_version'], '3.4-alpha', '>=' ) )
			$this->assertEquals( $in, $out );
	}

	/**
	 * @ticket 16859
	 */
	function test_square_brackets() {
		$urls_before = array(
			'http://example.com/?foo[bar]=baz',
			'http://example.com/?baz=bar&foo[bar]=baz',
		);
		$urls_expected = array(
			'<a href="http://example.com/?foo%5Bbar%5D=baz" rel="nofollow">http://example.com/?foo%5Bbar%5D=baz</a>',
			'<a href="http://example.com/?baz=bar&#038;foo%5Bbar%5D=baz" rel="nofollow">http://example.com/?baz=bar&#038;foo%5Bbar%5D=baz</a>',
		);
		foreach ($urls_before as $key => $url) {
			$this->assertEquals( $urls_expected[$key], make_clickable( $url ) );
		}
	}
}

/**
 * @group formatting
 */
class TestJSEscape extends WP_UnitTestCase {
	function test_js_escape_simple() {
		$out = esc_js('foo bar baz();');
		$this->assertEquals('foo bar baz();', $out);
	}

	function test_js_escape_quotes() {
		$out = esc_js('foo "bar" \'baz\'');
		// does it make any sense to change " into &quot;?  Why not \"?
		$this->assertEquals("foo &quot;bar&quot; \'baz\'", $out);
	}

	function test_js_escape_backslash() {
		$bs = '\\';
		$out = esc_js('foo '.$bs.'t bar '.$bs.$bs.' baz');
		// \t becomes t - bug?
		$this->assertEquals('foo t bar '.$bs.$bs.' baz', $out);
	}

	function test_js_escape_amp() {
		$out = esc_js('foo & bar &baz; &apos;');
		$this->assertEquals("foo &amp; bar &amp;baz; &apos;", $out);
	}

	function test_js_escape_quote_entity() {
		$out = esc_js('foo &#x27; bar &#39; baz &#x26;');
		$this->assertEquals("foo \\' bar \\' baz &amp;", $out);
	}

	function test_js_no_carriage_return() {
		$out = esc_js("foo\rbar\nbaz\r");
		// \r is stripped
		$this->assertequals("foobar\\nbaz", $out);
	}

	function test_js_escape_rn() {
		$out = esc_js("foo\r\nbar\nbaz\r\n");
		// \r is stripped
		$this->assertequals("foo\\nbar\\nbaz\\n", $out);
	}
}

/**
 * @group formatting
 */
class TestHtmlExcerpt extends WP_UnitTestCase {
	function test_simple() {
		$this->assertEquals("Baba", wp_html_excerpt("Baba told me not to come", 4));
	}
	function test_html() {
		$this->assertEquals("Baba", wp_html_excerpt("<a href='http://baba.net/'>Baba</a> told me not to come", 4));
	}
	function test_entities() {
		$this->assertEquals("Baba ", wp_html_excerpt("Baba &amp; Dyado", 8));
		$this->assertEquals("Baba ", wp_html_excerpt("Baba &#038; Dyado", 8));
		$this->assertEquals("Baba &amp; D", wp_html_excerpt("Baba &amp; Dyado", 12));
		$this->assertEquals("Baba &amp; Dyado", wp_html_excerpt("Baba &amp; Dyado", 100));
	}
}

/* // @todo These tests need to be rewritten for sanitize_sql_orderby
class TestSanitizeOrderby extends WP_UnitTestCase {
	function test_empty() {
		$cols = array('a' => 'a');
		$this->assertEquals( '', sanitize_sql_orderby('', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('  ', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby("\t", $cols) );
		$this->assertEquals( '', sanitize_sql_orderby(null, $cols) );
		$this->assertEquals( '', sanitize_sql_orderby(0, $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('+', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('-', $cols) );
	}

	function test_unknown_column() {
		$cols = array('name' => 'post_name', 'date' => 'post_date');
		$this->assertEquals( '', sanitize_sql_orderby('unknown_column', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('+unknown_column', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('-unknown_column', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('-unknown1,+unknown2,unknown3', $cols) );
		$this->assertEquals( 'post_name ASC', sanitize_sql_orderby('name,unknown_column', $cols) );
		$this->assertEquals( '', sanitize_sql_orderby('!@#$%^&*()_=~`\'",./', $cols) );
	}

	function test_valid() {
		$cols = array('name' => 'post_name', 'date' => 'post_date', 'random' => 'rand()');
		$this->assertEquals( 'post_name ASC', sanitize_sql_orderby('name', $cols) );
		$this->assertEquals( 'post_name ASC', sanitize_sql_orderby('+name', $cols) );
		$this->assertEquals( 'post_name DESC', sanitize_sql_orderby('-name', $cols) );
		$this->assertEquals( 'post_date ASC, post_name ASC', sanitize_sql_orderby('date,name', $cols) );
		$this->assertEquals( 'post_date ASC, post_name ASC', sanitize_sql_orderby(' date , name ', $cols) );
		$this->assertEquals( 'post_name DESC, post_date ASC', sanitize_sql_orderby('-name,date', $cols) );
		$this->assertEquals( 'post_name ASC, post_date ASC', sanitize_sql_orderby('name ,+ date', $cols) );
		$this->assertEquals( 'rand() ASC', sanitize_sql_orderby('random', $cols) );
	}
}
*/

/**
 * @group formatting
 */
class TestWPTexturize extends WP_UnitTestCase {
	function test_dashes() {
		$this->assertEquals('Hey &#8212; boo?', wptexturize('Hey -- boo?'));
		$this->assertEquals('<a href="http://xx--xx">Hey &#8212; boo?</a>', wptexturize('<a href="http://xx--xx">Hey -- boo?</a>'));
	}

	function test_disable() {
		$this->assertEquals('<pre>---</pre>', wptexturize('<pre>---</pre>'));
		$this->assertEquals('[a]a&#8211;b[code]---[/code]a&#8211;b[/a]', wptexturize('[a]a--b[code]---[/code]a--b[/a]'));
		$this->assertEquals('<pre><code></code>--</pre>', wptexturize('<pre><code></code>--</pre>'));

		$this->assertEquals('<code>---</code>', wptexturize('<code>---</code>'));

		$this->assertEquals('<code>href="baba"</code> &#8220;baba&#8221;', wptexturize('<code>href="baba"</code> "baba"'));

		$enabled_tags_inside_code = '<code>curl -s <a href="http://x/">baba</a> | grep sfive | cut -d "\"" -f 10 &gt; topmp3.txt</code>';
		$this->assertEquals($enabled_tags_inside_code, wptexturize($enabled_tags_inside_code));

		$double_nest = '<pre>"baba"<code>"baba"<pre></pre></code>"baba"</pre>';
		$this->assertEquals($double_nest, wptexturize($double_nest));

		$invalid_nest = '<pre></code>"baba"</pre>';
		$this->assertEquals($invalid_nest, wptexturize($invalid_nest));

	}

	//WP Ticket #1418
	function test_bracketed_quotes_1418() {
		$this->assertEquals('(&#8220;test&#8221;)', wptexturize('("test")'));
		$this->assertEquals('(&#8216;test&#8217;)', wptexturize("('test')"));
		$this->assertEquals('(&#8217;twas)', wptexturize("('twas)"));
	}

	//WP Ticket #3810
	function test_bracketed_quotes_3810() {
		$this->assertEquals('A dog (&#8220;Hubertus&#8221;) was sent out.', wptexturize('A dog ("Hubertus") was sent out.'));
	}

	//WP Ticket #4539
	function test_basic_quotes() {
		$this->assertEquals('test&#8217;s', wptexturize('test\'s'));
		$this->assertEquals('test&#8217;s', wptexturize('test\'s'));

		$this->assertEquals('&#8216;quoted&#8217;', wptexturize('\'quoted\''));
		$this->assertEquals('&#8220;quoted&#8221;', wptexturize('"quoted"'));

		$this->assertEquals('space before &#8216;quoted&#8217; space after', wptexturize('space before \'quoted\' space after'));
		$this->assertEquals('space before &#8220;quoted&#8221; space after', wptexturize('space before "quoted" space after'));

		$this->assertEquals('(&#8216;quoted&#8217;)', wptexturize('(\'quoted\')'));
		$this->assertEquals('{&#8220;quoted&#8221;}', wptexturize('{"quoted"}'));

		$this->assertEquals('&#8216;qu(ot)ed&#8217;', wptexturize('\'qu(ot)ed\''));
		$this->assertEquals('&#8220;qu{ot}ed&#8221;', wptexturize('"qu{ot}ed"'));

		$this->assertEquals(' &#8216;test&#8217;s quoted&#8217; ', wptexturize(' \'test\'s quoted\' '));
		$this->assertEquals(' &#8220;test&#8217;s quoted&#8221; ', wptexturize(' "test\'s quoted" '));
	}

	/**
	 * @ticket 4539
	 * @ticket 15241
	 */
	function test_full_sentences_with_unmatched_single_quotes() {
		$this->assertEquals(
			'That means every moment you&#8217;re working on something without it being in the public it&#8217;s actually dying.',
			wptexturize("That means every moment you're working on something without it being in the public it's actually dying.")
		);
	}

	/**
	 * @ticket 4539
	 */
	function test_quotes() {
		$this->assertEquals('&#8220;Quoted String&#8221;', wptexturize('"Quoted String"'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;', wptexturize('Here is "<a href="http://example.com">a test with a link</a>"'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link and a period</a>&#8221;.', wptexturize('Here is "<a href="http://example.com">a test with a link and a period</a>".'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221; and a space.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>" and a space.'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a> and some text quoted&#8221;', wptexturize('Here is "<a href="http://example.com">a test with a link</a> and some text quoted"'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;, and a comma.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>", and a comma.'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;; and a semi-colon.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>"; and a semi-colon.'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;- and a dash.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>"- and a dash.'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;&#8230; and ellipses.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>"... and ellipses.'));
		$this->assertEquals('Here is &#8220;a test <a href="http://example.com">with a link</a>&#8221;.', wptexturize('Here is "a test <a href="http://example.com">with a link</a>".'));
		$this->assertEquals('Here is &#8220;<a href="http://example.com">a test with a link</a>&#8221;and a work stuck to the end.', wptexturize('Here is "<a href="http://example.com">a test with a link</a>"and a work stuck to the end.'));
		$this->assertEquals('A test with a finishing number, &#8220;like 23&#8221;.', wptexturize('A test with a finishing number, "like 23".'));
		$this->assertEquals('A test with a number, &#8220;like 62&#8221;, is nice to have.', wptexturize('A test with a number, "like 62", is nice to have.'));
	}

	/**
	 * @ticket 4539
	 */
	function test_quotes_before_s() {
		$this->assertEquals('test&#8217;s', wptexturize("test's"));
		$this->assertEquals('&#8216;test&#8217;s', wptexturize("'test's"));
		$this->assertEquals('&#8216;test&#8217;s&#8217;', wptexturize("'test's'"));
		$this->assertEquals('&#8216;string&#8217;', wptexturize("'string'"));
		$this->assertEquals('&#8216;string&#8217;s&#8217;', wptexturize("'string's'"));
	}

	/**
	 * @ticket 4539
	 */
	function test_quotes_before_numbers() {
		$this->assertEquals('Class of &#8217;99', wptexturize("Class of '99"));
		$this->assertEquals('Class of &#8217;99&#8217;s', wptexturize("Class of '99's"));
		$this->assertEquals('&#8216;Class of &#8217;99&#8217;', wptexturize("'Class of '99'"));
		$this->assertEquals('&#8216;Class of &#8217;99&#8217;s&#8217;', wptexturize("'Class of '99's'"));
		$this->assertEquals('&#8216;Class of &#8217;99&#8217;s&#8217;', wptexturize("'Class of '99&#8217;s'"));
		$this->assertEquals('&#8220;Class of 99&#8221;', wptexturize("\"Class of 99\""));
		$this->assertEquals('&#8220;Class of &#8217;99&#8221;', wptexturize("\"Class of '99\""));
	}

	function test_quotes_after_numbers() {
		$this->assertEquals('Class of &#8217;99', wptexturize("Class of '99"));
	}

	/**
	 * @ticket 4539
	 * @ticket 15241
	 */
	function test_other_html() {
		$this->assertEquals('&#8216;<strong>', wptexturize("'<strong>"));
		$this->assertEquals('&#8216;<strong>Quoted Text</strong>&#8217;,', wptexturize("'<strong>Quoted Text</strong>',"));
		$this->assertEquals('&#8220;<strong>Quoted Text</strong>&#8221;,', wptexturize('"<strong>Quoted Text</strong>",'));
	}

	function test_x() {
		$this->assertEquals('14&#215;24', wptexturize("14x24"));
	}

	function test_minutes_seconds() {
		$this->assertEquals('9&#8242;', wptexturize('9\''));
		$this->assertEquals('9&#8243;', wptexturize("9\""));

		$this->assertEquals('a 9&#8242; b', wptexturize('a 9\' b'));
		$this->assertEquals('a 9&#8243; b', wptexturize("a 9\" b"));

		$this->assertEquals('&#8220;a 9&#8242; b&#8221;', wptexturize('"a 9\' b"'));
		$this->assertEquals('&#8216;a 9&#8243; b&#8217;', wptexturize("'a 9\" b'"));
	}

	/**
	 * @ticket 8775
	 */
	function test_wptexturize_quotes_around_numbers() {
		$this->assertEquals('&#8220;12345&#8221;', wptexturize('"12345"'));
		$this->assertEquals('&#8216;12345&#8217;', wptexturize('\'12345\''));
		$this->assertEquals('&#8220;a 9&#8242; plus a &#8216;9&#8217;, maybe a 9&#8242; &#8216;9&#8217; &#8221;', wptexturize('"a 9\' plus a \'9\', maybe a 9\' \'9\' "'));
		$this->assertEquals('<p>&#8216;99<br />&#8216;123&#8217;<br />&#8217;tis<br />&#8216;s&#8217;</p>', wptexturize('<p>\'99<br />\'123\'<br />\'tis<br />\'s\'</p>'));
	}

	/**
	 * @ticket 8912
	 */
	function test_wptexturize_html_comments() {
		$this->assertEquals('<!--[if !IE]>--><!--<![endif]-->', wptexturize('<!--[if !IE]>--><!--<![endif]-->'));
		$this->assertEquals('<!--[if !IE]>"a 9\' plus a \'9\', maybe a 9\' \'9\' "<![endif]-->', wptexturize('<!--[if !IE]>"a 9\' plus a \'9\', maybe a 9\' \'9\' "<![endif]-->'));
		$this->assertEquals('<ul><li>Hello.</li><!--<li>Goodbye.</li>--></ul>', wptexturize('<ul><li>Hello.</li><!--<li>Goodbye.</li>--></ul>'));
	}

	/**
	 * @ticket 4539
	 * @ticket 15241
	 */
	function test_entity_quote_cuddling() {
		$this->assertEquals('&nbsp;&#8220;Testing&#8221;', wptexturize('&nbsp;"Testing"'));
		$this->assertEquals('&#38;&#8220;Testing&#8221;', wptexturize('&#38;"Testing"'));
	}
}

/**
 * @group formatting
 */
class TestEscUrl extends WP_UnitTestCase {
	function test_spaces() {
		$this->assertEquals('http://example.com/MrWordPress', esc_url('http://example.com/Mr WordPress'));
		$this->assertEquals('http://example.com/Mr%20WordPress', esc_url('http://example.com/Mr%20WordPress'));
	}

	function test_bad_characters() {
		$this->assertEquals('http://example.com/watchthelinefeedgo', esc_url('http://example.com/watchthelinefeed%0Ago'));
		$this->assertEquals('http://example.com/watchthelinefeedgo', esc_url('http://example.com/watchthelinefeed%0ago'));
		$this->assertEquals('http://example.com/watchthecarriagereturngo', esc_url('http://example.com/watchthecarriagereturn%0Dgo'));
		$this->assertEquals('http://example.com/watchthecarriagereturngo', esc_url('http://example.com/watchthecarriagereturn%0dgo'));
		//Nesting Checks
		$this->assertEquals('http://example.com/watchthecarriagereturngo', esc_url('http://example.com/watchthecarriagereturn%0%0ddgo'));
		$this->assertEquals('http://example.com/watchthecarriagereturngo', esc_url('http://example.com/watchthecarriagereturn%0%0DDgo'));
		$this->assertEquals('http://example.com/', esc_url('http://example.com/%0%0%0DAD'));
		$this->assertEquals('http://example.com/', esc_url('http://example.com/%0%0%0ADA'));
		$this->assertEquals('http://example.com/', esc_url('http://example.com/%0%0%0DAd'));
		$this->assertEquals('http://example.com/', esc_url('http://example.com/%0%0%0ADa'));
	}

	function test_relative() {
		$this->assertEquals('/example.php', esc_url('/example.php'));
		$this->assertEquals('example.php', esc_url('example.php'));
		$this->assertEquals('#fragment', esc_url('#fragment'));
		$this->assertEquals('?foo=bar', esc_url('?foo=bar'));
	}

	function test_protocol() {
		$this->assertEquals('http://example.com', esc_url('http://example.com'));
		$this->assertEquals('', esc_url('nasty://example.com/'));
	}

	function test_display_extras() {
		$this->assertEquals('http://example.com/&#039;quoted&#039;', esc_url('http://example.com/\'quoted\''));
		$this->assertEquals('http://example.com/\'quoted\'', esc_url('http://example.com/\'quoted\'',null,'notdisplay'));
	}

	function test_non_ascii() {
		$this->assertEquals( 'http://example.org/баба', esc_url( 'http://example.org/баба' ) );
		$this->assertEquals( 'http://баба.org/баба', esc_url( 'http://баба.org/баба' ) );
		$this->assertEquals( 'http://müller.com/', esc_url( 'http://müller.com/' ) );
	}

	function test_feed() {
		$this->assertEquals( '', esc_url( 'feed:javascript:alert(1)' ) );
		$this->assertEquals( '', esc_url( 'feed:javascript:feed:alert(1)' ) );
		$this->assertEquals( '', esc_url( 'feed:feed:javascript:alert(1)' ) );
		$this->assertEquals( 'feed:feed:alert(1)', esc_url( 'feed:feed:alert(1)' ) );
		$this->assertEquals( 'feed:http://wordpress.org/feed/', esc_url( 'feed:http://wordpress.org/feed/' ) );
	}

	/**
	 * @ticket 16859
	 */
	function test_square_brackets() {
		$this->assertEquals( 'http://example.com/?foo%5Bbar%5D=baz', esc_url( 'http://example.com/?foo[bar]=baz' ) );
		$this->assertEquals( 'http://example.com/?baz=bar&#038;foo%5Bbar%5D=baz', esc_url( 'http://example.com/?baz=bar&foo[bar]=baz' ) );
		//IPv6 addresses in urls - RFC2732
		$this->assertEquals( 'http://[::FFFF::127.0.0.1]', esc_url( 'http://[::FFFF::127.0.0.1]' ) );
		$this->assertEquals( 'http://[::127.0.0.1]', esc_url( 'http://[::127.0.0.1]' ) );
		$this->assertEquals( 'http://[::DEAD:BEEF:DEAD:BEEF:DEAD:BEEF:DEAD:BEEF]', esc_url( 'http://[::DEAD:BEEF:DEAD:BEEF:DEAD:BEEF:DEAD:BEEF]' ) );
	}
}

/**
 * @group formatting
 */
class TestAutop extends WP_UnitTestCase {
	//From ticket http://core.trac.wordpress.org/ticket/11008
	function test_first_post() {
		$expected = '<p>Welcome to WordPress!  This post contains important information.  After you read it, you can make it private to hide it from visitors but still have the information handy for future reference.</p>
<p>First things first:</p>
<ul>
<li><a href="%1$s" title="Subscribe to the WordPress mailing list for Release Notifications">Subscribe to the WordPress mailing list for release notifications</a></li>
</ul>
<p>As a subscriber, you will receive an email every time an update is available (and only then).  This will make it easier to keep your site up to date, and secure from evildoers.<br />
When a new version is released, <a href="%2$s" title="If you are already logged in, this will take you directly to the Dashboard">log in to the Dashboard</a> and follow the instructions.<br />
Upgrading is a couple of clicks!</p>
<p>Then you can start enjoying the WordPress experience:</p>
<ul>
<li>Edit your personal information at <a href="%3$s" title="Edit settings like your password, your display name and your contact information">Users &#8250; Your Profile</a></li>
<li>Start publishing at <a href="%4$s" title="Create a new post">Posts &#8250; Add New</a> and at <a href="%5$s" title="Create a new page">Pages &#8250; Add New</a></li>
<li>Browse and install plugins at <a href="%6$s" title="Browse and install plugins at the official WordPress repository directly from your Dashboard">Plugins &#8250; Add New</a></li>
<li>Browse and install themes at <a href="%7$s" title="Browse and install themes at the official WordPress repository directly from your Dashboard">Appearance &#8250; Add New Themes</a></li>
<li>Modify and prettify your website&#8217;s links at <a href="%8$s" title="For example, select a link structure like: http://example.com/1999/12/post-name">Settings &#8250; Permalinks</a></li>
<li>Import content from another system or WordPress site at <a href="%9$s" title="WordPress comes with importers for the most common publishing systems">Tools &#8250; Import</a></li>
<li>Find answers to your questions at the <a href="%10$s" title="The official WordPress documentation, maintained by the WordPress community">WordPress Codex</a></li>
</ul>
<p>To keep this post for reference, <a href="%11$s" title="Click to edit the content and settings of this post">click to edit it</a>, go to the Publish box and change its Visibility from Public to Private.</p>
<p>Thank you for selecting WordPress.  We wish you happy publishing!</p>
<p>PS.  Not yet subscribed for update notifications?  <a href="%1$s" title="Subscribe to the WordPress mailing list for Release Notifications">Do it now!</a></p>
';
		$test_data = '
Welcome to WordPress!  This post contains important information.  After you read it, you can make it private to hide it from visitors but still have the information handy for future reference.

First things first:
<ul>
<li><a href="%1$s" title="Subscribe to the WordPress mailing list for Release Notifications">Subscribe to the WordPress mailing list for release notifications</a></li>
</ul>
As a subscriber, you will receive an email every time an update is available (and only then).  This will make it easier to keep your site up to date, and secure from evildoers.
When a new version is released, <a href="%2$s" title="If you are already logged in, this will take you directly to the Dashboard">log in to the Dashboard</a> and follow the instructions.
Upgrading is a couple of clicks!

Then you can start enjoying the WordPress experience:
<ul>
<li>Edit your personal information at <a href="%3$s" title="Edit settings like your password, your display name and your contact information">Users &#8250; Your Profile</a></li>
<li>Start publishing at <a href="%4$s" title="Create a new post">Posts &#8250; Add New</a> and at <a href="%5$s" title="Create a new page">Pages &#8250; Add New</a></li>
<li>Browse and install plugins at <a href="%6$s" title="Browse and install plugins at the official WordPress repository directly from your Dashboard">Plugins &#8250; Add New</a></li>
<li>Browse and install themes at <a href="%7$s" title="Browse and install themes at the official WordPress repository directly from your Dashboard">Appearance &#8250; Add New Themes</a></li>
<li>Modify and prettify your website&#8217;s links at <a href="%8$s" title="For example, select a link structure like: http://example.com/1999/12/post-name">Settings &#8250; Permalinks</a></li>
<li>Import content from another system or WordPress site at <a href="%9$s" title="WordPress comes with importers for the most common publishing systems">Tools &#8250; Import</a></li>
<li>Find answers to your questions at the <a href="%10$s" title="The official WordPress documentation, maintained by the WordPress community">WordPress Codex</a></li>
</ul>
To keep this post for reference, <a href="%11$s" title="Click to edit the content and settings of this post">click to edit it</a>, go to the Publish box and change its Visibility from Public to Private.

Thank you for selecting WordPress.  We wish you happy publishing!

PS.  Not yet subscribed for update notifications?  <a href="%1$s" title="Subscribe to the WordPress mailing list for Release Notifications">Do it now!</a>
';

		// On windows environments, the EOL-style is \r\n
		$expected = str_replace( "\r\n", "\n", $expected);

		$this->assertEquals($expected, wpautop($test_data));
	}

	/**
	 * wpautop() Should not alter the contents of "<pre>" elements
	 *
	 * @ticket 19855
	 */	
	public function test_skip_pre_elements() {
		$code = file_get_contents( DIR_TESTDATA . '/formatting/sizzle.js' );
		$code = str_replace( "\r", '', $code );
		$code = htmlentities( $code );
		
		// Not wrapped in <p> tags
		$str = "<pre>$code</pre>";
		$this->assertEquals( $str, trim( wpautop( $str ) ) );

		// Text before/after is wrapped in <p> tags
		$str = "Look at this code\n\n<pre>$code</pre>\n\nIsn't that cool?";
		
		// Expected text after wpautop
		$expected = '<p>Look at this code</p>' . "\n<pre>" . $code . "</pre>\n" . '<p>Isn\'t that cool?</p>';
		$this->assertEquals( $expected, trim( wpautop( $str ) ) );

		// Make sure HTML breaks are maintained if manually inserted
		$str = "Look at this code\n\n<pre>Line1<br />Line2<br>Line3<br/>Line4\nActual Line 2\nActual Line 3</pre>\n\nCool, huh?";
		$expected = "<p>Look at this code</p>\n<pre>Line1<br />Line2<br>Line3<br/>Line4\nActual Line 2\nActual Line 3</pre>\n<p>Cool, huh?</p>";
		$this->assertEquals( $expected, trim( wpautop( $str ) ) );
	}
	
	/**
	 * wpautop() Should not add <br/> to "<input>" elements
	 *
	 * @ticket 16456
	 */	
	public function test_skip_input_elements() {
		$str = 'Username: <input type="text" id="username" name="username" /><br />Password: <input type="password" id="password1" name="password1" />';
		$this->assertEquals( "<p>$str</p>", trim( wpautop( $str ) ) );
	}
}

/**
 * @group formatting
 */
class TestLikeEscape extends WP_UnitTestCase {
	/**
	 * @ticket 10041
	 */
	function test_like_escape() {

		$inputs = array(
			'howdy%', //Single Percent
			'howdy_', //Single Underscore
			'howdy\\', //Single slash
			'howdy\\howdy%howdy_', //The works
		);
		$expected = array(
			"howdy\\%",
			'howdy\\_',
			'howdy\\\\',
			'howdy\\\\howdy\\%howdy\\_'
		);

		foreach ($inputs as $key => $input) {
			$this->assertEquals($expected[$key], like_escape($input));
		}
	}
}

/**
 * @group formatting
 */
class TestSanitizeTextField extends WP_UnitTestCase {
	// #11528
	function test_sanitize_text_field() {
		$inputs = array(
			'оРангутанг', //Ensure UTF8 text is safe the Р is D0 A0 and A0 is the non-breaking space.
			'САПР', //Ensure UTF8 text is safe the Р is D0 A0 and A0 is the non-breaking space.
			'one is < two',
			'tags <span>are</span> <em>not allowed</em> here',
			' we should trim leading and trailing whitespace ',
			'we  also  trim  extra  internal  whitespace',
			'tabs 	get removed too',
			'newlines are not welcome
			here',
			'We also %AB remove %ab octets',
			'We don\'t need to wory about %A
			B removing %a
			b octets even when %a	B they are obscured by whitespace',
			'%AB%BC%DE', //Just octets
			'Invalid octects remain %II',
			'Nested octects %%%ABABAB %A%A%ABBB',
		);
		$expected = array(
			'оРангутанг',
			'САПР',
			'one is &lt; two',
			'tags are not allowed here',
			'we should trim leading and trailing whitespace',
			'we also trim extra internal whitespace',
			'tabs get removed too',
			'newlines are not welcome here',
			'We also remove octets',
			'We don\'t need to wory about %A B removing %a b octets even when %a B they are obscured by whitespace',
			'', //Emtpy as we strip all the octets out
			'Invalid octects remain %II',
			'Nested octects',
		);

		foreach ($inputs as $key => $input) {
			$this->assertEquals($expected[$key], sanitize_text_field($input));
		}
	}
}

/**
 * @group formatting
 */
class TestSanitizeMimeType extends WP_UnitTestCase {
	// 17855
	function test_sanitize_valid_mime_type() {
		$inputs = array(
			'application/atom+xml',
			'application/EDI-X12',
			'application/EDIFACT',
			'application/json',
			'application/javascript',
			'application/octet-stream',
			'application/ogg',
			'application/pdf',
			'application/postscript',
			'application/soap+xml',
			'application/x-woff',
			'application/xhtml+xml',
			'application/xml-dtd',
			'application/xop+xml',
			'application/zip',
			'application/x-gzip',
			'audio/basic',
			'image/jpeg',
			'text/css',
			'text/html',
			'text/plain',
			'video/mpeg',
		);

		foreach ( $inputs as $input ) {
			$this->assertEquals($input, sanitize_mime_type($input));
		}
	}
}

/**
 * @group formatting
 */
class TestSanitizeFileName extends WP_UnitTestCase {
	function test_munges_extensions() {
		# r17990
		$file_name = sanitize_file_name( 'test.phtml.txt' );
		$this->assertEquals( 'test.phtml_.txt', $file_name );
	}

	function test_removes_special_chars() {
		$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
		$string = 'test';
		foreach ( $special_chars as $char )
			$string .= $char;
		$string .= 'test';
		$this->assertEquals( 'testtest', sanitize_file_name( $string ) );
	}

	function test_replaces_any_number_of_hyphens_with_one_hyphen() {
		$this->assertEquals("a-t-t", sanitize_file_name("a----t----t"));
	}

	function test_trims_trailing_hyphens() {
		$this->assertEquals("a-t-t", sanitize_file_name("a----t----t----"));
	}

	function test_replaces_any_amount_of_whitespace_with_one_hyphen() {
		$this->assertEquals("a-t", sanitize_file_name("a          t"));
		$this->assertEquals("a-t", sanitize_file_name("a    \n\n\nt"));
	}
}

/**
 * @group formatting
 */
class TestWPSpecialchars extends WP_UnitTestCase {
	function test_wp_specialchars_basics() {
		$html =  "&amp;&lt;hello world&gt;";
		$this->assertEquals( $html, _wp_specialchars( $html ) );

		$double = "&amp;amp;&amp;lt;hello world&amp;gt;";
		$this->assertEquals( $double, _wp_specialchars( $html, ENT_NOQUOTES, false, true ) );
	}

	function test_allowed_entity_names() {
		global $allowedentitynames;

		// Allowed entities should be unchanged
		foreach ( $allowedentitynames as $ent ) {
			$ent = '&' . $ent . ';';
			$this->assertEquals( $ent, _wp_specialchars( $ent ) );
		}
	}

	function test_not_allowed_entity_names() {
		$ents = array( 'iacut', 'aposs', 'pos', 'apo', 'apo?', 'apo.*', '.*apo.*', 'apos ', ' apos', ' apos ' );

		foreach ( $ents as $ent ) {
			$escaped = '&amp;' . $ent . ';';
			$ent = '&' . $ent . ';';
			$this->assertEquals( $escaped, _wp_specialchars( $ent ) );
		}
	}

	function test_optionally_escapes_quotes() {
		$source = "\"'hello!'\"";
		$this->assertEquals( '"&#039;hello!&#039;"', _wp_specialchars($source, 'single') );
		$this->assertEquals( "&quot;'hello!'&quot;", _wp_specialchars($source, 'double') );
		$this->assertEquals( '&quot;&#039;hello!&#039;&quot;', _wp_specialchars($source, true) );
		$this->assertEquals( $source, _wp_specialchars($source) );
	}
}

/**
 * @group formatting
 */
class TestEscAttr extends WP_UnitTestCase {
	function test_esc_attr_quotes() {
		$attr = '"double quotes"';
		$this->assertEquals( '&quot;double quotes&quot;', esc_attr( $attr ) );

		$attr = "'single quotes'";
		$this->assertEquals( '&#039;single quotes&#039;', esc_attr( $attr ) );

		$attr = "'mixed' " . '"quotes"';
		$this->assertEquals( '&#039;mixed&#039; &quot;quotes&quot;', esc_attr( $attr ) );

		// Handles double encoding?
		$attr = '"double quotes"';
		$this->assertEquals( '&quot;double quotes&quot;', esc_attr( esc_attr( $attr ) ) );

		$attr = "'single quotes'";
		$this->assertEquals( '&#039;single quotes&#039;', esc_attr( esc_attr( $attr ) ) );

		$attr = "'mixed' " . '"quotes"';
		$this->assertEquals( '&#039;mixed&#039; &quot;quotes&quot;', esc_attr( esc_attr( $attr ) ) );
	}

	function test_esc_attr_amp() {
		$out = esc_attr( 'foo & bar &baz; &apos;' );
		$this->assertEquals( "foo &amp; bar &amp;baz; &apos;", $out );
	}
}

/**
 * @group formatting
 */
class TestEscHtml extends WP_UnitTestCase {
	function test_esc_html_basics() {
		// Simple string
		$html = "The quick brown fox.";
		$this->assertEquals( $html, esc_html( $html ) );

		// URL with &
		$html = "http://localhost/trunk/wp-login.php?action=logout&_wpnonce=cd57d75985";
		$escaped = "http://localhost/trunk/wp-login.php?action=logout&amp;_wpnonce=cd57d75985";
		$this->assertEquals( $escaped, esc_html( $html ) );

		// SQL query
		$html = "SELECT meta_key, meta_value FROM wp_trunk_sitemeta WHERE meta_key IN ('site_name', 'siteurl', 'active_sitewide_plugins', '_site_transient_timeout_theme_roots', '_site_transient_theme_roots', 'site_admins', 'can_compress_scripts', 'global_terms_enabled') AND site_id = 1";
		$escaped = "SELECT meta_key, meta_value FROM wp_trunk_sitemeta WHERE meta_key IN (&#039;site_name&#039;, &#039;siteurl&#039;, &#039;active_sitewide_plugins&#039;, &#039;_site_transient_timeout_theme_roots&#039;, &#039;_site_transient_theme_roots&#039;, &#039;site_admins&#039;, &#039;can_compress_scripts&#039;, &#039;global_terms_enabled&#039;) AND site_id = 1";
		$this->assertEquals( $escaped, esc_html( $html ) );
	}

	function test_escapes_ampersands() {
		$source = "penn & teller & at&t";
		$res = "penn &amp; teller &amp; at&amp;t";
		$this->assertEquals( $res, esc_html($source) );
	}

	function test_escapes_greater_and_less_than() {
		$source = "this > that < that <randomhtml />";
		$res = "this &gt; that &lt; that &lt;randomhtml /&gt;";
		$this->assertEquals( $res, esc_html($source) );
	}

	function test_ignores_existing_entities() {
		$source = '&#038; &#x00A3; &#x22; &amp;';
		$res = '&amp; &#xA3; &quot; &amp;';
		$this->assertEquals( $res, esc_html($source) );
	}
}

/**
 * @group formatting
 */
class TestSanitizeUser extends WP_UnitTestCase {
	function test_strips_html() {
		$input = "Captain <strong>Awesome</strong>";
		$expected = is_multisite() ? 'captain awesome' : 'Captain Awesome';
		$this->assertEquals($expected, sanitize_user($input));
	}
	/**
	 * @ticket 10823
	 */
	function test_strips_entities() {
		$this->assertEquals("ATT", sanitize_user("AT&amp;T"));
		$this->assertEquals("ATT Test;", sanitize_user("AT&amp;T Test;"));
		$this->assertEquals("AT&T Test;", sanitize_user("AT&T Test;"));
	}
	function test_strips_percent_encoded_octets() {
		$expected = is_multisite() ? 'franois' : 'Franois';
		$this->assertEquals( $expected, sanitize_user( "Fran%c3%a7ois" ) );
	}
	function test_optional_strict_mode_reduces_to_safe_ascii_subset() {
		$this->assertEquals("abc", sanitize_user("()~ab~ˆcˆ!", true));
	}
}

/**
 * @group formatting
 */
class TestIsEmail extends WP_UnitTestCase {
	function test_returns_true_if_given_a_valid_email_address() {
		$data = array(
			"bob@example.com",
			"phil@example.info",
			"ace@204.32.222.14",
			"kevin@many.subdomains.make.a.happy.man.edu"
			);
		foreach ( $data as $datum ) {
			$this->assertEquals( $datum, is_email($datum), $datum );
		}
	}

	function test_returns_false_if_given_an_invalid_email_address() {
		$data = array(
			"khaaaaaaaaaaaaaaan!",
			'http://bob.example.com/',
			"sif i'd give u it, spamer!1",
			"com.exampleNOSPAMbob",
			"bob@your mom"
			);
		foreach ($data as $datum) {
			$this->assertFalse(is_email($datum), $datum);
		}
	}
}

/**
 * @group formatting
 */
class TestSanitizeTitle extends WP_UnitTestCase {
	function test_strips_html() {
		$input = "Captain <strong>Awesome</strong>";
		$expected = "captain-awesome";
		$this->assertEquals($expected, sanitize_title($input));
	}

	function test_titles_sanitized_to_nothing_are_replaced_with_optional_fallback() {
		$input = "<strong></strong>";
		$fallback = "Captain Awesome";
		$this->assertEquals($fallback, sanitize_title($input, $fallback));
	}
}

/**
 * @group formatting
 */
class TestSanitizeTitleWithDashes extends WP_UnitTestCase {
	function test_strips_html() {
		$input = "Captain <strong>Awesome</strong>";
		$expected = "captain-awesome";
		$this->assertEquals($expected, sanitize_title($input));
	}

	function test_strips_unencoded_percent_signs() {
		$this->assertEquals("fran%c3%a7ois", sanitize_title_with_dashes("fran%c3%a7%ois"));
	}

	function test_makes_title_lowercase() {
		$this->assertEquals("abc", sanitize_title_with_dashes("ABC"));
	}

	function test_replaces_any_amount_of_whitespace_with_one_hyphen() {
		$this->assertEquals("a-t", sanitize_title_with_dashes("a          t"));
		$this->assertEquals("a-t", sanitize_title_with_dashes("a    \n\n\nt"));
	}

	function test_replaces_any_number_of_hyphens_with_one_hyphen() {
		$this->assertEquals("a-t-t", sanitize_title_with_dashes("a----t----t"));
	}

	function test_trims_trailing_hyphens() {
		$this->assertEquals("a-t-t", sanitize_title_with_dashes("a----t----t----"));
	}

	function test_handles_non_entity_ampersands() {
		$this->assertEquals("penn-teller-bull", sanitize_title_with_dashes("penn & teller bull"));
	}

	/**
	 * @ticket 10823
	 */
	function test_strips_entities() {
		$this->assertEquals("no-entities-here", sanitize_title_with_dashes("No &nbsp; Entities &ndash; Here &amp;"));
		$this->assertEquals("one-two", sanitize_title_with_dashes("One &amp; Two", '', 'save'));
		$this->assertEquals("one-two", sanitize_title_with_dashes("One &#123; Two;", '', 'save'));
		$this->assertEquals("one-two", sanitize_title_with_dashes("One & Two;", '', 'save'));
		$this->assertEquals("one-two", sanitize_title_with_dashes("One Two™;", '', 'save'));
		$this->assertEquals("one-two", sanitize_title_with_dashes("One &&amp; Two;", '', 'save'));
		$this->assertEquals("onetwo", sanitize_title_with_dashes("One&Two", '', 'save'));
		$this->assertEquals("onetwo-test", sanitize_title_with_dashes("One&Two Test;", '', 'save'));
	}

	function test_replaces_nbsp() {
		$this->assertEquals("dont-break-the-space", sanitize_title_with_dashes("don't break the space", '', 'save'));
	}

	function test_replaces_ndash_mdash() {
		$this->assertEquals("do-the-dash", sanitize_title_with_dashes("Do – the Dash", '', 'save'));
		$this->assertEquals("do-the-dash", sanitize_title_with_dashes("Do the — Dash", '', 'save'));
	}

	function test_replaces_iexcel_iquest() {
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("Just ¡a Slug", '', 'save'));
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("Just a Slug¿", '', 'save'));
	}

	function test_replaces_angle_quotes() {
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("‹Just a Slug›", '', 'save'));
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("«Just a Slug»", '', 'save'));
	}

	function test_replaces_curly_quotes() {
		$this->assertEquals("hey-its-curly-joe", sanitize_title_with_dashes("Hey its “Curly Joe”", '', 'save'));
		$this->assertEquals("hey-its-curly-joe", sanitize_title_with_dashes("Hey its ‘Curly Joe’", '', 'save'));
		$this->assertEquals("hey-its-curly-joe", sanitize_title_with_dashes("Hey its „Curly Joe“", '', 'save'));
		$this->assertEquals("hey-its-curly-joe", sanitize_title_with_dashes("Hey its ‚Curly Joe‛", '', 'save'));
		$this->assertEquals("hey-its-curly-joe", sanitize_title_with_dashes("Hey its „Curly Joe‟", '', 'save'));
	}

	function test_replaces_copy_reg_deg_trade() {
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("Just © a Slug", '', 'save'));
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("® Just a Slug", '', 'save'));
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("Just a ° Slug", '', 'save'));
		$this->assertEquals("just-a-slug", sanitize_title_with_dashes("Just ™ a Slug", '', 'save'));
	}

	/**
	 * @ticket 19820
	 */
	function test_replaces_multiply_sign() {
		$this->assertEquals("6x7-is-42", sanitize_title_with_dashes("6×7 is 42", '', 'save'));
	}

	/**
	 * @ticket 20772
	 */
	function test_replaces_standalone_diacritic() {
		$this->assertEquals("aaaa", sanitize_title_with_dashes("āáǎà", '', 'save'));
	}

}

/**
 * @group formatting
 */
class TestConvertChars extends WP_UnitTestCase {
	function test_replaces_windows1252_entities_with_unicode_ones() {
		$input = "&#130;&#131;&#132;&#133;&#134;&#135;&#136;&#137;&#138;&#139;&#140;&#145;&#146;&#147;&#148;&#149;&#150;&#151;&#152;&#153;&#154;&#155;&#156;&#159;";
		$output = "&#8218;&#402;&#8222;&#8230;&#8224;&#8225;&#710;&#8240;&#352;&#8249;&#338;&#8216;&#8217;&#8220;&#8221;&#8226;&#8211;&#8212;&#732;&#8482;&#353;&#8250;&#339;&#376;";
		$this->assertEquals($output, convert_chars($input));
	}

	/**
	 * @ticket 20503
	 */
	function test_replaces_latin_letter_z_with_caron() {
		$input = "&#142;&#158;";
		$output = "&#381;&#382;";
		$this->assertEquals( $output, convert_chars( $input ) );
	}

	function test_converts_html_br_and_hr_to_the_xhtml_self_closing_variety() {
		$inputs = array(
			"abc <br> lol <br />" => "abc <br /> lol <br />",
			"<br> ho ho <hr>"     => "<br /> ho ho <hr />",
			"<hr><br>"            => "<hr /><br />"
			);
		foreach ($inputs as $input => $expected) {
			$this->assertEquals($expected, convert_chars($input));
		}
	}

	function test_escapes_lone_ampersands() {
		$this->assertEquals("at&#038;t", convert_chars("at&t"));
	}

	function test_removes_category_and_title_metadata_tags() {
		$this->assertEquals("", convert_chars("<title><div class='lol'>abc</div></title><category>a</category>"));
	}
}

/**
 * @group formatting
 */
class TestZeroise extends WP_UnitTestCase {
	function test_pads_with_leading_zeroes() {
		$this->assertEquals("00005", zeroise(5, 5));
	}

	function test_does_nothing_if_input_is_already_longer() {
		$this->assertEquals("5000000", zeroise(5000000, 2));
	}
}

/**
 * @group formatting
 */
class TestBackslashit extends WP_UnitTestCase {
	function test_backslashes_alphas() {
		$this->assertEquals("\\a943\\b\\c", backslashit("a943bc"));
	}

	function test_double_backslashes_leading_numbers() {
		$this->assertEquals("\\\\95", backslashit("95"));
	}
}

/**
 * @group formatting
 */
class TestUntrailingslashit extends WP_UnitTestCase {
	function test_removes_trailing_slashes() {
		$this->assertEquals("a", untrailingslashit("a/"));
		$this->assertEquals("a", untrailingslashit("a////"));
	}
}

/**
 * @group formatting
 */
class TestTrailingslashit extends WP_UnitTestCase {
	function test_adds_trailing_slash() {
		$this->assertEquals("a/", trailingslashit("a"));
	}

	function test_does_not_add_trailing_slash_if_one_exists() {
		$this->assertEquals("a/", trailingslashit("a/"));
	}
}

/**
 * The clean_pre() removes pararaph and line break
 * tags within `<pre>` elements as part of wpautop().
 *
 * @group formatting
 */
class TestCleanPre extends WP_UnitTestCase {
	function test_removes_self_closing_br_with_space() {
		$source = 'a b c\n<br />sldfj<br />';
		$res = 'a b c\nsldfj';

		$this->assertEquals($res, clean_pre($source));
	}

	function test_removes_self_closing_br_without_space() {
		$source = 'a b c\n<br/>sldfj<br/>';
		$res = 'a b c\nsldfj';
		$this->assertEquals($res, clean_pre($source));
	}

	// I don't think this can ever happen in production;
	// <br> is changed to <br /> elsewhere. Left in because
	// that replacement shouldn't happen (what if you want
	// HTML 4 output?).
	function test_removes_html_br() {
		$source = 'a b c\n<br>sldfj<br>';
		$res = 'a b c\nsldfj';
		$this->assertEquals($res, clean_pre($source));
	}

	function test_removes_p() {
		$source = "<p>isn't this exciting!</p><p>oh indeed!</p>";
		$res = "\nisn't this exciting!\noh indeed!";
		$this->assertEquals($res, clean_pre($source));
	}
}

/**
 * @group formatting
 */
class TestSmilies extends WP_UnitTestCase {

	function test_convert_smilies() {
		global $wpsmiliestrans;
		$includes_path = includes_url("images/smilies/");

		// standard smilies, use_smilies: ON
		update_option( 'use_smilies', 1 );

		smilies_init();

		$inputs = array(
						'Lorem ipsum dolor sit amet mauris ;-) Praesent gravida sodales. :lol: Vivamus nec diam in faucibus eu, bibendum varius nec, imperdiet purus est, at augue at lacus malesuada elit dapibus a, :eek: mauris. Cras mauris viverra elit. Nam laoreet viverra. Pellentesque tortor. Nam libero ante, porta urna ut turpis. Nullam wisi magna, :mrgreen: tincidunt nec, sagittis non, fringilla enim. Nam consectetuer nec, ullamcorper pede eu dui odio consequat vel, vehicula tortor quis pede turpis cursus quis, egestas ipsum ultricies ut, eleifend velit. Mauris vestibulum iaculis. Sed in nunc. Vivamus elit porttitor egestas. Mauris purus :?:',
						'<strong>Welcome to the jungle!</strong> We got fun n games! :) We got everything you want 8-) <em>Honey we know the names :)</em>',
						"<strong;)>a little bit of this\na little bit:other: of that :D\n:D a little bit of good\nyeah with a little bit of bad8O",
						'<strong style="here comes the sun :-D">and I say it\'s allright:D:D',
						'<!-- Woo-hoo, I\'m a comment, baby! :x > -->',
						':?:P:?::-x:mrgreen:::', /*
						'the question is, <textarea>Should smilies be converted in textareas :?:</textarea>',
						'the question is, <code>Should smilies be converted in code or pre tags :?:</code>',
						'the question is, <code style="color:#fff">Should smilies be converted in code or pre tags :?:</code>',
						'the question is, <code>Should smilies be converted in invalid code or pre tags :?:</pre>',
						'<Am I greedy?>Yes I am :)> :) The world makes me :mad:' */
						);

		$outputs = array(
						'Lorem ipsum dolor sit amet mauris <img src=\''.$includes_path.'icon_wink.gif\' alt=\';-)\' class=\'wp-smiley\' />  Praesent gravida sodales. <img src=\''.$includes_path.'icon_lol.gif\' alt=\':lol:\' class=\'wp-smiley\' />  Vivamus nec diam in faucibus eu, bibendum varius nec, imperdiet purus est, at augue at lacus malesuada elit dapibus a, <img src=\''.$includes_path.'icon_surprised.gif\' alt=\':eek:\' class=\'wp-smiley\' />  mauris. Cras mauris viverra elit. Nam laoreet viverra. Pellentesque tortor. Nam libero ante, porta urna ut turpis. Nullam wisi magna, <img src=\''.$includes_path.'icon_mrgreen.gif\' alt=\':mrgreen:\' class=\'wp-smiley\' />  tincidunt nec, sagittis non, fringilla enim. Nam consectetuer nec, ullamcorper pede eu dui odio consequat vel, vehicula tortor quis pede turpis cursus quis, egestas ipsum ultricies ut, eleifend velit. Mauris vestibulum iaculis. Sed in nunc. Vivamus elit porttitor egestas. Mauris purus <img src=\''.$includes_path.'icon_question.gif\' alt=\':?:\' class=\'wp-smiley\' /> ',
						'<strong>Welcome to the jungle!</strong> We got fun n games! <img src=\''.$includes_path.'icon_smile.gif\' alt=\':)\' class=\'wp-smiley\' />  We got everything you want <img src=\''.$includes_path.'icon_cool.gif\' alt=\'8-)\' class=\'wp-smiley\' /> <em>Honey we know the names <img src=\''.$includes_path.'icon_smile.gif\' alt=\':)\' class=\'wp-smiley\' /> </em>',
						"<strong;)>a little bit of this\na little bit:other: of that <img src='{$includes_path}icon_biggrin.gif' alt=':D' class='wp-smiley' />  <img src='{$includes_path}icon_biggrin.gif' alt=':D' class='wp-smiley' />  a little bit of good\nyeah with a little bit of bad8O",
						'<strong style="here comes the sun :-D">and I say it\'s allright:D:D',
						'<!-- Woo-hoo, I\'m a comment, baby! :x > -->',
						' <img src=\''.$includes_path.'icon_question.gif\' alt=\':?:\' class=\'wp-smiley\' /> P:?::-x:mrgreen:::', /*
						'the question is, <textarea>Should smilies be converted in textareas :?:</textarea>',
						'the question is, <code>Should smilies be converted in code or pre tags :?:</code>',
						'the question is, <code style="color:#fff">Should smilies be converted in code or pre tags :?:</code>',
						'the question is, <code>Should smilies be converted in invalid code or pre tags :?:</pre>',
						'<Am I greedy?>Yes I am <img src=\''.$includes_path.'icon_smile.gif\' alt=\':)\' class=\'wp-smiley\' /> > <img src=\''.$includes_path.'icon_smile.gif\' alt=\':)\' class=\'wp-smiley\' />  The world makes me <img src=\'http://wp-test.php/wp-includes/images/smilies/icon_mad.gif\' alt=\':mad:\' class=\'wp-smiley\' />' */
						);

		foreach ( $inputs as $k => $input ) {
			$this->assertEquals( $outputs[$k], convert_smilies($input) );
		}

		update_option( 'use_smilies', 0 );

		// standard smilies, use_smilies: OFF

		foreach ( $inputs as $input ) {
			$this->assertEquals( $input, convert_smilies($input) );
		}

		return;

		// custom smilies, use_smilies: ON
		update_option( 'use_smilies', 1 );
		$wpsmiliestrans = array(
		  ':PP' => 'icon_tongue.gif',
		  ':arrow:' => 'icon_arrow.gif',
		  ':monkey:' => 'icon_shock_the_monkey.gif',
		  ':nervou:' => 'icon_nervou.gif'
		);

		smilies_init();

		$inputs = array('Peter Brian Gabriel (born 13 February 1950) is a British singer, musician, and songwriter who rose to fame as the lead vocalist and flautist of the progressive rock group Genesis. :monkey:',
						'Star Wars Jedi Knight:arrow: Jedi Academy is a first and third-person shooter action game set in the Star Wars universe. It was developed by Raven Software and published, distributed and marketed by LucasArts in North America and by Activision in the rest of the world. :nervou:',
						':arrow:monkey:Lorem ipsum dolor sit amet enim. Etiam ullam:PP<br />corper. Suspendisse a pellentesque dui, non felis.<a>:arrow::arrow</a>'
						);

		$outputs = array('Peter Brian Gabriel (born 13 February 1950) is a British singer, musician, and songwriter who rose to fame as the lead vocalist and flautist of the progressive rock group Genesis. <img src=\''.$includes_path.'icon_shock_the_monkey.gif\' alt=\'icon_arrow\' class=\'wp-smiley\' />',
						'Star Wars Jedi Knight<img src=\''.$includes_path.'icon_arrow.gif\' alt=\'icon_arrow\' class=\'wp-smiley\' /> Jedi Academy is a first and third-person shooter action game set in the Star Wars universe. It was developed by Raven Software and published, distributed and marketed by LucasArts in North America and by Activision in the rest of the world. <img src=\''.$includes_path.'icon_nervou.gif\' alt=\'icon_nervou\' class=\'wp-smiley\' />',
						'<img src=\''.$includes_path.'icon_arrow.gif\' alt=\'icon_arrow\' class=\'wp-smiley\' />monkey:Lorem ipsum dolor sit amet enim. Etiam ullam<img src=\''.$includes_path.'icon_tongue.gif\' alt=\'icon_tongue\' class=\'wp-smiley\' /><br />corper. Suspendisse a pellentesque dui, non felis.<a><img src=\''.$includes_path.'icon_arrow.gif\' alt=\'icon_arrow\' class=\'wp-smiley\' />:arrow</a>'
						);

		foreach ( $inputs as $k => $input ) {
			$this->assertEquals( $outputs[$k], convert_smilies($input) );
		}
	}
}

/**
 * @group formatting
 */
class TestWPTrimWords extends WP_UnitTestCase {
	private $long_text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius lacinia vehicula. Etiam sapien risus, ultricies ac posuere eu, convallis sit amet augue. Pellentesque urna massa, lacinia vel iaculis eget, bibendum in mauris. Aenean eleifend pulvinar ligula, a convallis eros gravida non. Suspendisse potenti. Pellentesque et odio tortor. In vulputate pellentesque libero, sed dapibus velit mollis viverra. Pellentesque id urna euismod dolor cursus sagittis.';

	function test_trims_to_55_by_default() {
		$trimmed = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius lacinia vehicula. Etiam sapien risus, ultricies ac posuere eu, convallis sit amet augue. Pellentesque urna massa, lacinia vel iaculis eget, bibendum in mauris. Aenean eleifend pulvinar ligula, a convallis eros gravida non. Suspendisse potenti. Pellentesque et odio tortor. In vulputate pellentesque libero, sed dapibus velit&hellip;';
		$this->assertEquals( $trimmed, wp_trim_words( $this->long_text ) );
	}

	function test_trims_to_10() {
		$trimmed = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius&hellip;';
		$this->assertEquals( $trimmed, wp_trim_words( $this->long_text, 10 ) );
	}

	function test_trims_to_5_and_uses_custom_more() {
		$trimmed = 'Lorem ipsum dolor sit amet,[...] Read on!';
		$this->assertEquals( $trimmed, wp_trim_words( $this->long_text, 5, '[...] Read on!' ) );
	}

	function test_strips_tags_before_trimming() {
		$text = 'This text contains a <a href="http://wordpress.org"> link </a> to WordPress.org!';
		$trimmed = 'This text contains a link&hellip;';
		$this->assertEquals( $trimmed, wp_trim_words( $text, 5 ) );
	}

	// #18726
	function test_strips_script_and_style_content() {
		$trimmed = 'This text contains. It should go.';

		$text = 'This text contains<script>alert(" Javascript");</script>. It should go.';
		$this->assertEquals( $trimmed, wp_trim_words( $text ) );

		$text = 'This text contains<style>#css { width:expression(alert("css")) }</style>. It should go.';
		$this->assertEquals( $trimmed, wp_trim_words( $text ) );		
	}

	function test_doesnt_trim_short_text() {
		$text = 'This is some short text.';
		$this->assertEquals( $text, wp_trim_words( $text ) );
	}
}

/**
 * @group formatting
 */
class TestRemoveAccents extends WP_UnitTestCase {
	public function test_remove_accents_simple() {
		$this->assertEquals( 'abcdefghijkl', remove_accents( 'abcdefghijkl' ) );
	}

	/**
	 * @ticket 9591
	 */
	public function test_remove_accents_latin1_supplement() {
		$input = 'ªºÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ';
		$output = 'aoAAAAAAAECEEEEIIIIDNOOOOOOUUUUYTHsaaaaaaaeceeeeiiiidnoooooouuuuythy';

		$this->assertEquals( $output, remove_accents( $input ), 'remove_accents replaces Latin-1 Supplement' );
	}

	public function test_remove_accents_latin_extended_a() {
		$input = 'ĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĸĹĺĻļĽľĿŀŁłŃńŅņŇňŉŊŋŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſ';
		$output = 'AaAaAaCcCcCcCcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkkLlLlLlLlLlNnNnNnNnNOoOoOoOEoeRrRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzs';

		$this->assertEquals( $output, remove_accents( $input ), 'remove_accents replaces Latin Extended A' );
	}

	public function test_remove_accents_latin_extended_b() {
		$this->assertEquals( 'SsTt', remove_accents( 'ȘșȚț' ), 'remove_accents replaces Latin Extended B' );
	}

	public function test_remove_accents_euro_pound_signs() {
		$this->assertEquals( 'E', remove_accents( '€' ), 'remove_accents replaces euro sign' );
		$this->assertEquals( '', remove_accents( '£' ), 'remove_accents replaces pound sign' );
	}

	public function test_remove_accents_iso8859() {
		// File is Latin1 encoded
		$file = DIR_TESTDATA . DIRECTORY_SEPARATOR . 'formatting' . DIRECTORY_SEPARATOR . 'remove_accents.01.input.txt';
		$input = file_get_contents( $file );
		$input = trim( $input );
		$output = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyyOEoeAEDHTHssaedhth";

		$this->assertEquals( $output, remove_accents( $input ), 'remove_accents from ISO-8859-1 text' );
	}

	/**
	 * @ticket 17738
	 */
	public function test_remove_accents_vowels_diacritic() {
		// Vowels with diacritic
		// unmarked
		$this->assertEquals( 'OoUu', remove_accents( 'ƠơƯư' ) );
		// grave accent
		$this->assertEquals( 'AaAaEeOoOoUuYy', remove_accents( 'ẦầẰằỀềỒồỜờỪừỲỳ' ) );
		// hook
		$this->assertEquals( 'AaAaAaEeEeIiOoOoOoUuUuYy', remove_accents( 'ẢảẨẩẲẳẺẻỂểỈỉỎỏỔổỞởỦủỬửỶỷ' ) );
		// tilde
		$this->assertEquals( 'AaAaEeEeOoOoUuYy', remove_accents( 'ẪẫẴẵẼẽỄễỖỗỠỡỮữỸỹ' ) );
		// acute accent
		$this->assertEquals( 'AaAaEeOoOoUu', remove_accents( 'ẤấẮắẾếỐốỚớỨứ' ) );
		// dot below 
		$this->assertEquals( 'AaAaAaEeEeIiOoOoOoUuUuYy', remove_accents( 'ẠạẬậẶặẸẹỆệỊịỌọỘộỢợỤụỰựỴỵ' ) );
	}

	/**
	 * @ticket 20772
	 */
	public function test_remove_accents_hanyu_pinyin() {
		// Vowels with diacritic (Chinese, Hanyu Pinyin)
		// macron
		$this->assertEquals( 'aeiouuAEIOUU', remove_accents( 'āēīōūǖĀĒĪŌŪǕ' ) );
		// acute accent
		$this->assertEquals( 'aeiouuAEIOUU', remove_accents( 'áéíóúǘÁÉÍÓÚǗ' ) );
		// caron
		$this->assertEquals( 'aeiouuAEIOUU', remove_accents( 'ǎěǐǒǔǚǍĚǏǑǓǙ' ) );
		// grave accent
		$this->assertEquals( 'aeiouuAEIOUU', remove_accents( 'àèìòùǜÀÈÌÒÙǛ' ) );
		// unmarked
		$this->assertEquals( 'aaeiouuAEIOUU', remove_accents( 'aɑeiouüAEIOUÜ' ) );
	}
}

/**
 * @group formatting
 */
class TestStripSlashesDeep extends WP_UnitTestCase {
	/**
	 * @ticket 18026
	 */
	function test_preserves_original_datatype() {

		$this->assertEquals( true, stripslashes_deep( true ) );
		$this->assertEquals( false, stripslashes_deep( false ) );
		$this->assertEquals( 4, stripslashes_deep( 4 ) );
		$this->assertEquals( 'foo', stripslashes_deep( 'foo' ) );
		$arr = array( 'a' => true, 'b' => false, 'c' => 4, 'd' => 'foo' );
		$arr['e'] = $arr; // Add a sub-array
		$this->assertEquals( $arr, stripslashes_deep( $arr ) ); // Keyed array
		$this->assertEquals( array_values( $arr ), stripslashes_deep( array_values( $arr ) ) ); // Non-keyed

		$obj = new stdClass;
		foreach ( $arr as $k => $v )
			$obj->$k = $v;
		$this->assertEquals( $obj, stripslashes_deep( $obj ) );
	}

	function test_strips_slashes() {
		$old = "I can\'t see, isn\'t that it?";
		$new = "I can't see, isn't that it?";
		$this->assertEquals( $new, stripslashes_deep( $old ) );
		$this->assertEquals( $new, stripslashes_deep( "I can\\'t see, isn\\'t that it?" ) );
		$this->assertEquals( array( 'a' => $new ), stripslashes_deep( array( 'a' => $old ) ) ); // Keyed array
		$this->assertEquals( array( $new ), stripslashes_deep( array( $old ) ) ); // Non-keyed

		$obj_old = new stdClass;
		$obj_old->a = $old;
		$obj_new = new stdClass;
		$obj_new->a = $new;
		$this->assertEquals( $obj_new, stripslashes_deep( $obj_old ) );
	}

	function test_permits_escaped_slash() {
		$txt = "I can't see, isn\'t that it?";
		$this->assertEquals( $txt, stripslashes_deep( "I can\'t see, isn\\\'t that it?" ) );
		$this->assertEquals( $txt, stripslashes_deep( "I can\'t see, isn\\\\\'t that it?" ) );
	}
}
