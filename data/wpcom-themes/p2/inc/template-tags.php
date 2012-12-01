<?php
function p2_body_class() {
	if( is_taxonomy( 'mentions' ) ) return body_class( 'mentions' );
	return body_class();
}
function p2_user_can_post() {
	global $user_ID;
	
	if ( current_user_can( 'publish_posts' ) || ( get_option( 'p2_allow_users_publish' ) && $user_ID ) )
		return true;
	
	return false;
}

function p2_show_comment_form() {
	global $post, $form_visible;

	$show = ( !isset( $form_visible ) || !$form_visible ) && 'open' == $post->comment_status;
	
	if ( $show )
		$form_visible = true;
	
	return $show;
}

function p2_is_ajax_request() {
	global $post_request_ajax;
	
	return $post_request_ajax;
}

function p2_posting_type() {
	echo p2_get_posting_type();
}
function p2_get_posting_type() {
	return $_GET['p'];
}

function p2_media_upload_form() { 
	require( ABSPATH . '/wp-admin/includes/template.php' );
	media_upload_form();
?>
<?php
}
	
function p2_user_display_name() {
	echo p2_get_user_display_name();
}
	function p2_get_user_display_name() {
		global $current_user;

		return apply_filters( 'p2_get_user_display_name', isset( $current_user->first_name ) && $current_user->first_name ? $current_user->first_name : $current_user->display_name );
	}

function p2_user_avatar( $args = '' ) {
	echo p2_get_user_avatar( $args );
}
	function p2_get_user_avatar( $args = '' ) {
		global $current_user;
		
		$defaults = array(
			'user_id' => false,
			'email' => $current_user->user_email,
			'size' => 48
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
		
		if ( !$user_id )
			$avatar = get_avatar( $email, $size );
		else
			$avatar = get_avatar( $user_id, $size );
		
	 	return apply_filters( 'p2_get_user_avatar', $avatar, $r );
	}

function p2_discussion_links() {
	echo p2_get_discussion_links();
}
	function p2_get_discussion_links() {
		global $post; 
		
		$comments = get_comments( array( 'post_id' => $post->ID ) );

		foreach ( $comments as $comment )
			$unique_commentors[$comment->comment_author_email] = $comment;
			
		$total_unique_commentors = count( $unique_commentors );

		$counter = 1;
		foreach ($unique_commentors as $comment) {
			if ( $counter > 3 )
				break;
			
			if ( 1 != $counter && $total_unique_commentors == $counter )
				$content .= ', and ';
			else if ( 1 != $counter )
				$content .= ', ';
	
			$content .= get_avatar( $comment, 16 ) . ' ';
			
			if ( $comment->user_id )
				$content .= '<a href="' . site_url( 'author/' . esc_attr( $comment->comment_author ) ) . '">' . esc_attr( $comment->comment_author ) . '</a>';
			else {
				if ( $comment->comment_author_url )
					$content .= '<a href="' . esc_attr( $comment->comment_author_url ) . '">' . esc_attr( $comment->comment_author ) . '</a>';					
				else
					$content .= esc_attr( $comment->comment_author );						
			}

			$counter++;
		}
		
		if ( $total_unique_commentors > 3 )
			if ( ( $total_unique_commentors - 3 ) != 1 )
				$content .= sprintf( __( ' and %s others are discussing.', 'p2' ), ( $total_unique_commentors - 3 ) );
			else
				$content .= __( ' and one other person are discussing.', 'p2' );
		else {
			if ( $total_unique_commentors == 1 )
				$content .= __( ' is discussing.', 'p2' );
			else
				$content .= __( ' are discussing.', 'p2' );
		}

		return $content;
	}

function p2_quote_content() {
	echo p2_get_quote_content();
}
	function p2_get_quote_content() {
		return apply_filters( 'p2_get_quote_content', get_the_content( __( '(More ...)' , 'p2' ) ) );
	}
	add_filter( 'p2_get_quote_content', 'p2_quote_filter_kses', 1 );
	add_filter( 'p2_get_quote_content', 'wptexturize' );
	add_filter( 'p2_get_quote_content', 'convert_smilies' );
	add_filter( 'p2_get_quote_content', 'convert_chars' );
	add_filter( 'p2_get_quote_content', 'prepend_attachment' );
	
	function p2_quote_filter_kses( $content ) {
		global $allowedtags;
	
		$quote_allowedtags = $allowedtags;
		$quote_allowedtags['cite'] = array();
		$quote_allowedtags['p'] = array();

		return wp_kses( $content, $quote_allowedtags );
	}

function p2_the_category() {
	echo p2_get_the_category();
}
	function p2_get_the_category() {
		$categories = get_the_category();
		return apply_filters( 'p2_get_the_category', $categories[0]->slug );
	}

function p2_user_prompt() {
	echo p2_get_user_prompt();
}
	function p2_get_user_prompt() {
		$prompt = get_option('p2_prompt_text'); 
		
		return apply_filters( 'p2_get_user_prompt', sprintf ( __( 'Hi, %s. %s', 'p2' ), wp_specialchars( p2_get_user_display_name() ), ( $prompt != '' ) ? stripslashes( $prompt ) : __( 'Whatcha up to?', 'p2' ) ) );
	}

function p2_page_number() {
	echo p2_get_page_number();
}
	function p2_get_page_number() {
		global $paged;
		return apply_filters( 'p2_get_page_number', $paged );
	}
	
function p2_media_buttons() {
	echo P2::media_buttons();
}

function p2_get_hide_sidebar() {
	return ( '' != get_option( 'p2_hide_sidebar' ) ) ? true : false;
}

function p2_author_id() {
	echo p2_get_author_id();
}
	function p2_get_author_id() {
		global $authordata;
		return apply_filters( 'p2_get_author_id', $authordata->ID );
	}

function p2_author_name() {
	echo p2_get_author_name();
}
	function p2_get_author_name() {
		global $authordata;

		return apply_filters( 'p2_get_author_name', $authordata->user_nicename );
	}

function p2_mention_name() {
	echo p2_get_mention_name();
}
	
	function p2_get_mention_name() {
		global $wp_query;
		$mention_name = $wp_query->query_vars['term'];
		$name_map = p2_get_at_name_map();
		$name = get_usermeta( $name_map["@$mention_name"]['id'], 'display_name' );
		return $name;
	}

function p2_author_feed_link() {
	echo p2_get_author_feed_link();
}
	function p2_get_author_feed_link() {
		global $author;
		return apply_filters( 'p2_get_author_feed_link', get_author_feed_link( $author->ID ) );
	}

function p2_user_identity() {
	echo p2_get_user_identity();
}
	function p2_get_user_identity() {
		global $user_identity;
		return $user_identity;
	}

function p2_load_entry() {
	global $withcomments;
	
	$withcomments = true;
	
	if ( file_exists( STYLESHEETPATH . '/entry.php' ) )
		require STYLESHEETPATH . '/entry.php';
	else if ( file_exists( TEMPLATEPATH . '/entry.php' ) )
		require TEMPLATEPATH . '/entry.php';
}

function p2_date_time_with_microformat( $type = 'post' ) {
	$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
	return '<abbr title="'.$d('Y-m-d\TH:i:s\Z', true).'">'.sprintf( __('%1$s <em>on</em> %2$s', 'p2'),  $d(get_option('time_format')), $d( get_option('date_format') ) ).'</abbr>';
}


?>