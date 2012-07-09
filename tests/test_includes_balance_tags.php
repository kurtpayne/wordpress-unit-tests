<?php

/**
 * @group formatting
 */
class TestBalanceTags extends WP_UnitTestCase {

	// These are single/self-closing tags that WP has traditionally recognized.
	var $basic_single_tags = array( 'br', 'hr', 'img', 'input' );

	// This is a complete(?) listing of valid single/self-closing tags.
	var $single_tags = array(
		'area', 'base', 'basefont', 'br', 'col', 'command',
		'embed', 'frame', 'hr', 'img', 'input', 'isindex',
		'link', 'meta', 'param', 'source' );

	// Tags that can be directly nested within themselves, i.e. <div><div>Test</div></div>
	var $nestable_tags = array( 'blockquote', 'div', 'q', 'span' );
	// Use this instead if/when #20401 gets fixed
	//var $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

	// These are single tags WP has traditionally properly handled
	// This test can be removed if #1597 is fixed and the next test passes, as
	//   it supercedes this test.
	function test_selfcloses_unclosed_basic_known_single_tags() {
		foreach ( $this->basic_single_tags as $tag ) {
			$this->assertEquals( "<$tag />", balanceTags( "<$tag>", true ) );
		}
	}
 
	/**
	 * If a recognized valid single tag appears unclosed, it should get self-closed
	 *
	 * @ticket 1597
	 */
	function test_selfcloses_unclosed_known_single_tags() {

		foreach ( $this->single_tags as $tag ) {
			$this->assertEquals( "<$tag />", balanceTags( "<$tag>", true ) );
		}
	}

	// These are single tags WP has traditionally properly handled
	// This test can be removed if #1597 is fixed and the next test passes, as
	//   it supercedes this test.
	function test_selfcloses_basic_known_single_tags_having_closing_tag() {
		foreach ( $this->basic_single_tags as $tag ) {
			$this->assertEquals( "<$tag />", balanceTags( "<$tag></$tag>", true ) );
		}
	}

	/**
	 * If a recognized valid single tag is given a closing tag, the closing tag
	 *   should get removed and tag should be self-closed.
	 *
	 * @ticket 1597
	 */
	function test_selfcloses_known_single_tags_having_closing_tag() {

		foreach ( $this->single_tags as $tag ) {
			$this->assertEquals( "<$tag />", balanceTags( "<$tag></$tag>", true ) );
		}
	}

	/**
	 * @ticket 1597
	 */
	function test_closes_unknown_single_tags_with_closing_tag() {

		$inputs = array(
			'<strong/>',
			'<em />',
			'<p class="main1"/>',
			'<p class="main2" />',
		);
		$expected = array(
			'<strong></strong>',
			'<em></em>',
			'<p class="main1"></p>',
			'<p class="main2"></p>',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_closes_unclosed_single_tags_having_attributes() {
		$inputs = array(
			'<img src="/images/example.png">',
			'<input type="text" name="example">'
		);
		$expected = array(
			'<img src="/images/example.png"/>',
			'<input type="text" name="example"/>'
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_allows_validly_closed_single_tags() {
		$inputs = array(
			'<br />',
			'<hr />',
			'<img src="/images/example.png" />',
			'<input type="text" name="example" />'
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $inputs[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_balances_nestable_tags() {
		$inputs = array(
			'<q>Test<q>Test</q>',
			'<div><div>Test',
			'<div>Test</div></div>',
		);
		$expected = array(
			'<q>Test<q>Test</q></q>',
			'<div><div>Test</div></div>',
			'<div>Test</div>',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_allows_adjacent_nestable_tags() {
		$inputs = array(
			'<blockquote><blockquote>Example quote</blockquote></blockquote>',
			'<div class="container"><div>This is allowed></div></div>',
			'<span><span><span>Example in spans</span></span></span>',
			'<blockquote>Main quote<blockquote>Example quote</blockquote> more text</blockquote>',
			'<q><q class="inner-q">Inline quote</q></q>',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $inputs[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	/**
	 * @ticket 20401
	 */
	function test_allows_immediately_nested_object_tags() {

		$object = '<object id="obj1"><param name="param1"/><object id="obj2"><param name="param2"/></object></object>';
		$this->assertEquals( $object, balanceTags( $object, true ) );
	}

	function test_balances_nested_non_nestable_tags() {
		$inputs = array(
			'<b><b>This is bold</b></b>',
			'<b>Some text here <b>This is bold</b></b>',
		);
		$expected = array(
			'<b></b><b>This is bold</b>',
			'<b>Some text here </b><b>This is bold</b>',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_fixes_improper_closing_tag_sequence() {
		$inputs = array(
			'<p>Here is a <strong class="part">bold <em>and emphasis</p></em></strong>',
			'<ul><li>Aaa</li><li>Bbb</ul></li>',
		);
		$expected = array(
			'<p>Here is a <strong class="part">bold <em>and emphasis</em></strong></p>',
			'<ul><li>Aaa</li><li>Bbb</li></ul>',
		);

		foreach ($inputs as $key => $input) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_adds_missing_closing_tags() {
		$inputs = array(
			'<b><i>Test</b>',
			'<p>Test',
			'<p>Test test</em> test</p>',
			'</p>Test',
			'<p>Here is a <strong class="part">Test</p>',
		);
		$expected = array(
			'<b><i>Test</i></b>',
			'<p>Test</p>',
			'<p>Test test test</p>',
			'Test',
			'<p>Here is a <strong class="part">Test</strong></p>',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

	function test_removes_extraneous_closing_tags() {
		$inputs = array(
			'<b>Test</b></b>',
			'<div>Test</div></div><div>Test',
			'<p>Test test</em> test</p>',
			'</p>Test',
		);
		$expected = array(
			'<b>Test</b>',
			'<div>Test</div><div>Test</div>',
			'<p>Test test test</p>',
			'Test',
		);

		foreach ( $inputs as $key => $input ) {
			$this->assertEquals( $expected[$key], balanceTags( $inputs[$key], true ) );
		}
	}

}
