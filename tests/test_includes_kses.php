<?php
/**
 * Some simple test cases for KSES post content filtering
 *
 * @group formatting
 * @group kses
 */
class Test_wp_filter_post_kses extends WP_UnitTestCase {

	/**
	 * @ticket 20210
	 */
	function test_wp_filter_post_kses_address() {
		global $allowedposttags;

		$attributes = array(
			'class' => 'classname',
			'id' => 'id',
			'style' => 'color: red;',
			'title' => 'title',
		);
		
		foreach ( $attributes as $name => $value ) {
			$string = "<address $name='$value'>1 WordPress Avenue, The Internet.</address>";
			$this->assertEquals( $string, wp_kses( $string, $allowedposttags ) );
		}
	}

	/**
	 * @ticket 20210
	 */
	function test_wp_filter_post_kses_a() {
		global $allowedposttags;

		$attributes = array(
			'class' => 'classname',
			'id' => 'id',
			'style' => 'color: red;',
			'title' => 'title',
			'href' => 'http://example.com',
			'rel' => 'related',
			'rev' => 'revision',
			'name' => 'name',
			'target' => '_blank',
		);
		
		foreach ( $attributes as $name => $value ) {
			$string = "<a $name='$value'>I link this</a>";
			$this->assertEquals( $string, wp_kses( $string, $allowedposttags ) );
		}
	}

	/**
	 * @ticket 20210
	 */
	function test_wp_filter_post_kses_abbr() {
		global $allowedposttags;

		$attributes = array(
			'class' => 'classname',
			'id' => 'id',
			'style' => 'color: red;',
			'title' => 'title',
		);

		foreach ( $attributes as $name => $value ) {
			$string = "<abbr $name='$value'>WP</abbr>";
			$this->assertEquals( $string, wp_kses( $string, $allowedposttags ) );
		}
	}

	function test_feed_links() {
		global $allowedposttags;

		$content = <<<EOF
<a href="feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:javascript:feed:alert(1)">CLICK ME</a>
<a href="feed:feed:javascript:alert(1)">CLICK ME</a>
<a href="javascript:feed:alert(1)">CLICK ME</a>
<a href="javascript:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:feed:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:feed:feed:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:feed:feed:feed:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:javascript:feed:javascript:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:javascript:feed:javascript:feed:javascript:feed:javascript:feed:javascript:alert(1)">CLICK ME</a>
<a href="feed:feed:feed:http:alert(1)">CLICK ME</a>
EOF;

		$expected = <<<EOF
<a href="feed:alert(1)">CLICK ME</a>
<a href="feed:feed:alert(1)">CLICK ME</a>
<a href="feed:feed:alert(1)">CLICK ME</a>
<a href="feed:alert(1)">CLICK ME</a>
<a href="feed:alert(1)">CLICK ME</a>
<a href="">CLICK ME</a>
<a href="">CLICK ME</a>
<a href="">CLICK ME</a>
<a href="">CLICK ME</a>
<a href="">CLICK ME</a>
<a href="">CLICK ME</a>
EOF;

	$this->assertEquals( $expected, wp_kses( $content, $allowedposttags ) );
	}
}
