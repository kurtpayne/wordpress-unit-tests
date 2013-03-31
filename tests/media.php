<?php

/**
 * @group media
 * @group shortcode
 */
class Tests_Media extends WP_UnitTestCase {

  function setUp() {
    parent::setUp();
    $this->caption = 'A simple caption.';
    $this->html_content = <<<CAP
A <strong class='classy'>bolded</strong> <em>caption</em> with a <a href="#">link</a>.
CAP;
    $this->img_content = <<<CAP
<img src="pic.jpg" id='anId' alt="pic"/>
CAP;
  }

  function test_img_caption_shortcode_added() {
    global $shortcode_tags;
    $this->assertEquals( 'img_caption_shortcode', $shortcode_tags['caption'] );
    $this->assertEquals( 'img_caption_shortcode', $shortcode_tags['wp_caption'] );
  }

  function test_img_caption_shortcode_with_empty_params() {
    $result = img_caption_shortcode( array() );
    $this->assertNull( $result );
  }

  function test_img_caption_shortcode_with_bad_attr() {
    $result = img_caption_shortcode( array(), 'content' );
    $this->assertEquals( 'content', 'content' );
  }

  function test_img_caption_shortcode_with_old_format() {
    $result = img_caption_shortcode(
      array( 'width' => 20, 'caption' => $this->caption )
    );
    $this->assertEquals( 2, preg_match_all( '/wp-caption/', $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( '/alignnone/', $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "/{$this->caption}/", $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "/width: 30/", $result, $_r ) );
  }

  function test_img_caption_shortcode_with_old_format_id_and_align() {
    $result = img_caption_shortcode(
      array(
        'width' => 20,
        'caption' => $this->caption,
        'id' => '"myId',
        'align' => '&myAlignment'
      )
    );
    $this->assertEquals( 1, preg_match_all( '/wp-caption &amp;myAlignment/', $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( '/id="&quot;myId"/', $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "/{$this->caption}/", $result, $_r ) );
  }

  function test_new_img_caption_shortcode_with_html_caption() {
    $result = img_caption_shortcode(
      array( 'width' => 20, 'caption' => $this->html_content )
    );
    $our_preg = preg_quote( $this->html_content );

    $this->assertEquals( 1, preg_match_all( "~{$our_preg}~", $result, $_r ) );
  }

  function test_new_img_caption_shortcode_new_format() {
    $result = img_caption_shortcode(
      array( 'width' => 20 ),
      $this->img_content . $this->html_content
    );
    $img_preg = preg_quote( $this->img_content );
    $content_preg = preg_quote( $this->html_content );

    $this->assertEquals( 1, preg_match_all( "~{$img_preg}.*wp-caption-text~", $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "~wp-caption-text.*{$content_preg}~", $result, $_r ) );
  }

  function test_new_img_caption_shortcode_new_format_and_linked_image() {
    $linked_image = "<a href='#'>{$this->img_content}</a>";
    $result = img_caption_shortcode(
      array( 'width' => 20 ),
      $linked_image . $this->html_content
    );
    $img_preg = preg_quote( $linked_image );
    $content_preg = preg_quote( $this->html_content );

    $this->assertEquals( 1, preg_match_all( "~{$img_preg}.*wp-caption-text~", $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "~wp-caption-text.*{$content_preg}~", $result, $_r ) );
  }

  function test_new_img_caption_shortcode_new_format_and_linked_image_with_newline() {
    $linked_image = "<a href='#'>{$this->img_content}</a>";
    $result = img_caption_shortcode(
      array( 'width' => 20 ),
      $linked_image . "\n\n" . $this->html_content
    );
    $img_preg = preg_quote( $linked_image );
    $content_preg = preg_quote( $this->html_content );

    $this->assertEquals( 1, preg_match_all( "~{$img_preg}.*wp-caption-text~", $result, $_r ) );
    $this->assertEquals( 1, preg_match_all( "~wp-caption-text.*{$content_preg}~", $result, $_r ) );
  }

	function test_add_remove_oembed_provider() {
		wp_oembed_add_provider( 'http://foo.bar/*', 'http://foo.bar/oembed' );
		$this->assertTrue( wp_oembed_remove_provider( 'http://foo.bar/*' ) );
		$this->assertFalse( wp_oembed_remove_provider( 'http://foo.bar/*' ) );
	}

	function test_wp_prepare_attachment_for_js() {
		// Attachment without media
		$id = wp_insert_attachment(array(
			'post_status' => 'publish',
			'post_title' => 'Prepare',
			'post_content_filtered' => 'Prepare',
			'post_type' => 'post'
		));
		$post = get_post( $id );

		$prepped = wp_prepare_attachment_for_js( $post );
		$this->assertInternalType( 'array', $prepped );
		$this->assertEquals( 0, $prepped['uploadedTo'] );
		$this->assertEquals( '', $prepped['mime'] );
		$this->assertEquals( '', $prepped['type'] );
		$this->assertEquals( '', $prepped['subtype'] );
		$this->assertEquals( '', $prepped['url'] );
		$this->assertEquals( site_url( 'wp-includes/images/crystal/default.png' ), $prepped['icon'] );

		// Fake a mime
		$post->post_mime_type = 'image/jpeg';
		$prepped = wp_prepare_attachment_for_js( $post );
		$this->assertEquals( 'image/jpeg', $prepped['mime'] );
		$this->assertEquals( 'image', $prepped['type'] );
		$this->assertEquals( 'jpeg', $prepped['subtype'] );

		// Fake a mime without a slash. See #WP22532
		$post->post_mime_type = 'image';
		$prepped = wp_prepare_attachment_for_js( $post );
		$this->assertEquals( 'image', $prepped['mime'] );
		$this->assertEquals( 'image', $prepped['type'] );
		$this->assertEquals( '', $prepped['subtype'] );
	}

	/**
	 * @ticket 19067
	 */
	function test_wp_convert_bytes_to_hr() {
		$kb = 1024;
		$mb = $kb * 1024;
		$gb = $mb * 1024;
		$tb = $gb * 1024;

		// test if boundaries are correct
		$this->assertEquals( '1TB', wp_convert_bytes_to_hr( $tb ) );
		$this->assertEquals( '1GB', wp_convert_bytes_to_hr( $gb ) );
		$this->assertEquals( '1MB', wp_convert_bytes_to_hr( $mb ) );
		$this->assertEquals( '1kB', wp_convert_bytes_to_hr( $kb ) );

		// now some values around
		$this->assertTrue( abs( 1.50000095367 - (float) wp_convert_bytes_to_hr( $tb + $tb / 2 + $mb ) ) < 0.0001 );
		$this->assertTrue( abs( 1023.99902248 - (float) wp_convert_bytes_to_hr( $tb - $mb - $kb ) ) < 0.0001 );
		$this->assertTrue( abs( 1.5009765625 - (float) wp_convert_bytes_to_hr( $gb + $gb / 2 + $mb ) ) < 0.0001 );
		$this->assertTrue( abs( 1022.99902344 - (float) wp_convert_bytes_to_hr( $gb - $mb - $kb ) ) < 0.0001 );

		// edge
		$this->assertEquals( '-1B', wp_convert_bytes_to_hr( -1 ) );
		$this->assertEquals( '0B', wp_convert_bytes_to_hr( 0 ) );
	}
}
