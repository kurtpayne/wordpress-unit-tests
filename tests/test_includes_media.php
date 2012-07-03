<?php

class TestIncludesMedia extends WP_UnitTestCase {

  function setUp() {
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

}
