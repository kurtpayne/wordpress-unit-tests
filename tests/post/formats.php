<?php

/**
 * @group post
 */
class Tests_Post_Formats extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
	}

	function test_set_get_post_format_for_post() {
		$post_id = $this->factory->post->create();

		$format = get_post_format( $post_id );
		$this->assertFalse( $format );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );

		$format = get_post_format( $post_id );
		$this->assertEquals( 'aside', $format );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		$result = set_post_format( $post_id, '' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );
	}

	/**
	 * @ticket 22473
	 */
	function test_set_get_post_format_for_page() {
		$post_id = $this->factory->post->create( array( 'post_type' => 'page' ) );

		$format = get_post_format( $post_id );
		$this->assertFalse( $format );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );
		// The format can be set but not retrieved until it is registered.
		$format = get_post_format( $post_id );
		$this->assertFalse( $format );
		// Register format support for the page post type.
		add_post_type_support( 'page', 'post-formats' );
		// The previous set can now be retrieved.
		$format = get_post_format( $post_id );
		$this->assertEquals( 'aside', $format );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		$result = set_post_format( $post_id, '' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );

		remove_post_type_support( 'page', 'post-formats' );
	}

	function test_has_format() {
		$post_id = $this->factory->post->create();

		$this->assertFalse( has_post_format( 'standard', $post_id ) );
		$this->assertFalse( has_post_format( '', $post_id ) );

		$result = set_post_format( $post_id, 'aside' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 1, count( $result ) );
		$this->assertTrue( has_post_format( 'aside', $post_id ) );

		$result = set_post_format( $post_id, 'standard' );
		$this->assertNotInstanceOf( 'WP_Error', $result );
		$this->assertInternalType( 'array', $result );
		$this->assertEquals( 0, count( $result ) );
		// Standard is a special case. It shows as false when set.
		$this->assertFalse( has_post_format( 'standard', $post_id ) );

		// Dummy format type
		$this->assertFalse( has_post_format( 'dummy', $post_id ) );

		// Dummy post id
		$this->assertFalse( has_post_format( 'aside', 12345 ) );
	}

	/**
	 * @ticket 23625
	 */
	function test_get_content_chat() {
		$data =<<<DATA
Scott: Hey.
Nacin: Go away.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey.'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
Nacin: Go away.

Nacin is mean to me.
DATA;

		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
I have a question.
Nacin: Go away.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey. I have a question.'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);

		$data =<<<DATA
Scott: Hey.
I have a question: what is your favorite color?
Nacin: Go away.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey. I have a question: what is your favorite color?'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
I have a question: will you read this http://www.justinbieber.com ?
Nacin: Go away.

Nacin hates Justin Bieber.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey. I have a question: will you read this <a href="http://www.justinbieber.com" rel="nofollow">http://www.justinbieber.com</a> ?'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
I have a question: what is your favorite color?
Nacin: Go away.

Nacin hates color.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey. I have a question: what is your favorite color?'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
Nacin: Go away.

Helen: Hey.
Nacin: Go away.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey.'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)

			),
			array(
				array(
					'time' => '',
					'author' => 'Helen',
					'message' => 'Hey.'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA

Scott: Hey.
Nacin: Go away.

Helen: Hey.
Nacin: Go away.

Nacin appears busy today.
DATA;

		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
I have a question: what is your favorite color?
Nacin: Go away.

Helen: Hey.
I have a question: what is your favorite pizza topping?
Nacin: Go away.
DATA;

		$stanzas = get_content_chat( $data );
		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Scott',
					'message' => 'Hey. I have a question: what is your favorite color?'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Helen',
					'message' =>  'Hey. I have a question: what is your favorite pizza topping?'
				),
				array(
					'time' => '',
					'author' => 'Nacin',
					'message' => 'Go away.'
				)
			)
		);
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
Scott: Hey.
I have a question: what is your favorite color?
Nacin: Go away.

Helen: Hey.
I have a question: what is your favorite pizza topping?
Nacin: Go away.

Nacin hates color and pizza.
DATA;

		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
[3/7/13 11:19:33 AM] Helen Hou-Sandi: I like Apples.
[3/7/13 11:29:31 AM] Scott Taylor: word
DATA;

		$expected = array(
			array(
				array(
					'time' => '[3/7/13 11:19:33 AM]',
 					'author' => 'Helen Hou-Sandi',
					'message' => 'I like Apples.'
				),
				array(
					'time' => '[3/7/13 11:29:31 AM]',
					'author' => 'Scott Taylor',
					'message' => 'word'
				),
			)
		);

		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );

		$data =<<<DATA
[3/5/13 2:30:09 PM] Scott Taylor: https://github.com/johndyer/mediaelement
[3/5/13 2:30:15 PM] Scott Taylor: MIT
[3/5/13 2:31:13 PM] Andrew Nacin: https://github.com/johndyer/mediaelement/issues?labels=Wordpress
DATA;

		$expected = array(
			array(
				array(
					'time' => '[3/5/13 2:30:09 PM]',
 					'author' => 'Scott Taylor',
					'message' => '<a href="https://github.com/johndyer/mediaelement" rel="nofollow">https://github.com/johndyer/mediaelement</a>'
				),
				array(
					'time' => '[3/5/13 2:30:15 PM]',
					'author' => 'Scott Taylor',
					'message' => 'MIT'
				),
				array(
					'time' => '[3/5/13 2:31:13 PM]',
					'author' => 'Andrew Nacin',
					'message' => '<a href="https://github.com/johndyer/mediaelement/issues?labels=Wordpress" rel="nofollow">https://github.com/johndyer/mediaelement/issues?labels=Wordpress</a>'
				),
			)
		);

		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );

		$data = <<<DATA
Nigel Tufnel: The numbers all go to eleven. Look, right across the board, eleven, eleven, eleven and…

Marti DiBergi: Oh, I see. And most amps go up to ten?

Nigel Tufnel: Exactly.

Marti DiBergi: Does that mean it’s louder? Is it any louder?

Nigel Tufnel: Well, it’s one louder, isn’t it? It’s not ten. You see, most blokes, you know, will be playing at ten. You’re on ten here, all the way up, all the way up, all the way up, you’re on ten on your guitar. Where can you go from there? Where?

Marti DiBergi: I don’t know.

Nigel Tufnel: Nowhere. Exactly. What we do is, if we need that extra push over the cliff, you know what we do?

Marti DiBergi: Put it up to eleven.

Nigel Tufnel: Eleven. Exactly. One louder.

Marti DiBergi: Why don’t you just make ten louder and make ten be the top number and make that a little louder?

Nigel Tufnel: These go to eleven.
DATA;

		$expected = array(
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'The numbers all go to eleven. Look, right across the board, eleven, eleven, eleven and…'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Marti DiBergi',
					'message' => 'Oh, I see. And most amps go up to ten?'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'Exactly.'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Marti DiBergi',
					'message' => 'Does that mean it’s louder? Is it any louder?'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'Well, it’s one louder, isn’t it? It’s not ten. You see, most blokes, you know, will be playing at ten. You’re on ten here, all the way up, all the way up, all the way up, you’re on ten on your guitar. Where can you go from there? Where?'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Marti DiBergi',
					'message' => 'I don’t know.'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'Nowhere. Exactly. What we do is, if we need that extra push over the cliff, you know what we do?'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Marti DiBergi',
					'message' => 'Put it up to eleven.'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'Eleven. Exactly. One louder.'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Marti DiBergi',
					'message' => 'Why don’t you just make ten louder and make ten be the top number and make that a little louder?'
				)
			),
			array(
				array(
					'time' => '',
					'author' => 'Nigel Tufnel',
					'message' => 'These go to eleven.'
				)
			),
		);
		$stanzas = get_content_chat( $data );
		$this->assertEquals( $stanzas, $expected );
	}

	/**
	 * @ticket 23570
	 */
	function test_get_content_url() {
		$link = 'http://nytimes.com';
		$commentary = 'This is my favorite link';
		$link_with_commentary =<<<DATA
$link

$commentary
DATA;

		$link_post_id = $this->factory->post->create( array( 'post_content' => $link ) );
		$content_link = get_content_url( get_post_field( 'post_content', $link_post_id ) );
		$this->assertEquals( $content_link, $link );

		$link_with_post_id = $this->factory->post->create( array( 'post_content' => $link_with_commentary ) );
		$content_link = get_content_url( get_post_field( 'post_content', $link_with_post_id ) );
		$this->assertEquals( $content_link, $link );

		update_post_meta( $link_post_id, '_format_url', $link );
		$content_link = get_content_url( get_post_field( 'post_content', $link_post_id ) );
		$this->assertEquals( $content_link, $link );

		update_post_meta( $link_with_post_id, '_format_url', $link );
		$content_link = get_content_url( get_post_field( 'post_content', $link_with_post_id ) );
		$this->assertEquals( $content_link, $link );

		$empty_post_id = $this->factory->post->create( array( 'post_content' => '' ) );
		update_post_meta( $empty_post_id, '_format_url', $link );
		$content_link = get_content_url( get_post_field( 'post_content', $empty_post_id ) );
		$this->assertEquals( $content_link, '' );

		$comm_post_id = $this->factory->post->create( array( 'post_content' => $commentary ) );
		update_post_meta( $comm_post_id, '_format_url', $link );
		$content_link = get_content_url( get_post_field( 'post_content', $comm_post_id ) );
		$this->assertEquals( $content_link, '' );
	}
}