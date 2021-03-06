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
	$this->img_name = 'image.jpg';
	$this->img_url = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . $this->img_name;
	$this->img_html = '<img src="' . $this->img_url . '"/>';
	$this->img_dimensions = array( 'width' => 100, 'height' => 100 );
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
		$hr = wp_convert_bytes_to_hr( $tb + $tb / 2 + $mb );
		$this->assertTrue( abs( 1.50000095367 - (float) str_replace( ',', '.', $hr ) ) < 0.0001 );

		$hr = wp_convert_bytes_to_hr( $tb - $mb - $kb );
		$this->assertTrue( abs( 1023.99902248 - (float) str_replace( ',', '.', $hr ) ) < 0.0001 );

		$hr = wp_convert_bytes_to_hr( $gb + $gb / 2 + $mb );
		$this->assertTrue( abs( 1.5009765625 - (float) str_replace( ',', '.', $hr ) ) < 0.0001 );

		$hr = wp_convert_bytes_to_hr( $gb - $mb - $kb );
		$this->assertTrue( abs( 1022.99902344 - (float) str_replace( ',', '.', $hr ) ) < 0.0001 );

		// edge
		$this->assertEquals( '-1B', wp_convert_bytes_to_hr( -1 ) );
		$this->assertEquals( '0B', wp_convert_bytes_to_hr( 0 ) );
	}

	/**
	 * @ticket 22960
	 */
	function test_get_attached_images() {
		$post_id = $this->factory->post->create();
		$attachment_id = $this->factory->attachment->create_object( $this->img_name, $post_id, array(
			'post_mime_type' => 'image/jpeg',
			'post_type' => 'attachment'
		) );

		$images = get_attached_media( 'image', $post_id );
		$this->assertEquals( $images, array( $attachment_id => get_post( $attachment_id ) ) );
	}

	/**
	 * @ticket 22960
	 */
	function test_get_attached_image_srcs() {
		$post_id = $this->factory->post->create();
		$this->factory->attachment->create_object( $this->img_name, $post_id, array(
			'post_mime_type' => 'image/jpeg',
			'post_type' => 'attachment'
		) );

		$images = get_attached_image_srcs( $post_id );
		$this->assertEquals( $images, array( $this->img_url ) );
	}

	/**
	 * @ticket 22960
	 */
	function test_content_images() {
		$src1 = $this->img_url;
		$html1 = $this->img_html;
		$src2 = str_replace( '.jpg', '2.jpg', $this->img_url );
		$html2 = str_replace( $src1, $src2, $this->img_html );
		$src3 = str_replace( '.jpg', '3.jpg', $this->img_url );
		$html3 = str_replace( $src1, $src3, $this->img_html );

		$blob =<<<BLOB
This is a sentence that will all of a sudden contain {$html1} and then {$html2} and why not {$html3}
BLOB;

		$images = get_content_images( $blob );
		$this->assertEquals( $images, array( $html1, $html2, $html3 ) );

		$images = get_content_images( $blob, false );
		$this->assertEquals( $images, array( $src1, $src2, $src3 ) );

		$images = get_content_images( $blob, true );
		$this->assertEquals( $images, array( $html1, $html2, $html3 ) );

		$images = get_content_images( $blob, false );
		$this->assertEquals( $images, array( $src1, $src2, $src3 ) );

		$images = get_content_images( $blob, true, 1 );
		$this->assertEquals( $images, array( $html1 ) );

		$images = get_content_images( $blob, false, 1 );
		$this->assertEquals( $images, array( $src1 ) );
	}

	/**
	 * @ticket 22960
	 */
	function test_content_image() {
		$blob =<<<BLOB
This is a sentence that will all of a sudden contain {$this->img_html}
BLOB;

		$image = get_content_image( $blob );
		$this->assertEquals( $image, $this->img_html );

		$image = get_content_image( $blob, false );
		$this->assertEquals( $image, $this->img_url );

		$linked_html = '<a href="http://woo.com">' . $this->img_html . '</a>';
		$blob = "This is a sentence that will all of a sudden contain $linked_html";
		$image = get_content_image( $blob );
		$this->assertEquals( $image, $linked_html );

		$captioned_html = '[caption width="300"]<a href="http://woo.com">' . $this->img_html . '</a> A Caption[/caption]';
		$blob = "This is a sentence that will all of a sudden contain $captioned_html";
		$result = '<div class="wp-caption alignnone" style="width: 310px"><a href="http://woo.com"><img src="http://example.org/wp-content/uploads/image.jpg"/></a><p class="wp-caption-text">A Caption</p></div>';
		$image = get_content_image( $blob );
		$this->assertEquals( $image, $result );
	}

	/**
	 * @ticket 22960
	 */
	function test_content_galleries() {
		$ids1 = array();
		$ids1_srcs = array();
		foreach ( range( 1, 3 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids1[] = $attachment_id;
			$ids1_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids2 = array();
		$ids2_srcs = array();
		foreach ( range( 4, 6 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids2[] = $attachment_id;
			$ids2_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids1_joined = join( ',', $ids1 );
		$ids2_joined = join( ',', $ids2 );

		$blob =<<<BLOB
[gallery ids="$ids1_joined"]

[gallery ids="$ids2_joined"]
BLOB;

		$post_id = $this->factory->post->create( array( 'post_content' => $blob ) );
		$galleries = get_content_galleries( get_post_field( 'post_content', $post_id ), false );
		$expected = array(
			array( 'ids' => $ids1_joined, 'src' => $ids1_srcs ),
			array( 'ids' => $ids2_joined, 'src' => $ids2_srcs )
		);
		$this->assertEquals( $galleries, $expected );
	}

	/**
	 * @ticket 22960
	 */
	function test_post_galleries_images() {
		$ids1 = array();
		$ids1_srcs = array();
		foreach ( range( 1, 3 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids1[] = $attachment_id;
			$ids1_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids2 = array();
		$ids2_srcs = array();
		foreach ( range( 4, 6 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids2[] = $attachment_id;
			$ids2_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids1_joined = join( ',', $ids1 );
		$ids2_joined = join( ',', $ids2 );

		$blob =<<<BLOB
[gallery ids="$ids1_joined"]

[gallery ids="$ids2_joined"]
BLOB;
		$post_id = $this->factory->post->create( array( 'post_content' => $blob ) );
		$srcs = get_post_galleries_images( $post_id );
		$this->assertEquals( $srcs, array( $ids1_srcs, $ids2_srcs ) );
	}

	/**
	 * @ticket 22960
	 */
	function test_post_gallery_images() {
		$ids1 = array();
		$ids1_srcs = array();
		foreach ( range( 1, 3 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids1[] = $attachment_id;
			$ids1_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids2 = array();
		$ids2_srcs = array();
		foreach ( range( 4, 6 ) as $i ) {
			$attachment_id = $this->factory->attachment->create_object( "image$i.jpg", 0, array(
				'post_mime_type' => 'image/jpeg',
				'post_type' => 'attachment'
			) );
			wp_update_attachment_metadata( $attachment_id, $this->img_dimensions );
			$ids2[] = $attachment_id;
			$ids2_srcs[] = 'http://' . WP_TESTS_DOMAIN . '/wp-content/uploads/' . "image$i.jpg";
		}

		$ids1_joined = join( ',', $ids1 );
		$ids2_joined = join( ',', $ids2 );

		$blob =<<<BLOB
[gallery ids="$ids1_joined"]

[gallery ids="$ids2_joined"]
BLOB;
		$post_id = $this->factory->post->create( array( 'post_content' => $blob ) );
		$srcs = get_post_gallery_images( $post_id );
		$this->assertEquals( $srcs, $ids1_srcs );
	}

	function test_get_embedded_media() {
		$obj =<<<OBJ
<object src="this" data="that">
	<param name="value"/>
</object>
OBJ;
		$embed =<<<EMBED
<embed src="something.mp4"/>
EMBED;
		$iframe =<<<IFRAME
<iframe src="youtube.com" width="7000" />
IFRAME;
		$audio =<<<AUDIO
<audio preload="none">
	<source />
</audio>
AUDIO;
		$video =<<<VIDEO
<video preload="none">
	<source />
</video>
VIDEO;

		$content =<<<CONTENT
This is a comment
$obj

This is a comment
$embed

This is a comment
$iframe

This is a comment
$audio

This is a comment
$video

This is a comment
CONTENT;

		$audios = array_values( compact( 'audio', 'obj', 'embed', 'iframe' ) );
		$videos = array_values( compact( 'video', 'obj', 'embed', 'iframe' ) );

		$matches = get_embedded_media( 'audio', $content );
		$this->assertEquals( $matches, $audios );
		$matches = get_embedded_media( 'video', $content );
		$this->assertEquals( $matches, $videos );
	}
}
