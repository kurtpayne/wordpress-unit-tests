<?php
define('DOING_AJAX', true);
@header('Content-Type: text/html; charset=' . get_option('blog_charset'));

class P2Ajax {
	function dispatch() {
		$action = isset( $_REQUEST['action'] )? $_REQUEST['action'] : '';
		do_action( "p2_ajax", $action );
		if ( is_callable( array('P2Ajax', $action ) ) )
			call_user_func( array('P2Ajax', $action ) );
		else
			die('-1');
		exit;
	}
	
	function get_post() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}
		$post_id = $_GET['post_ID'];
		$post_id = substr( $post_id, strpos( $post_id, '-' ) + 1 );
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			die('<p>'.__('Error: not allowed to edit post.', 'p2').'</p>');
		}
		$post = get_post( $post_id );
		echo $post->post_content ;
	}
	
	function tag_search() {
		global $wpdb;
		$term = $_GET['q'];
		if ( false !== strpos( $term, ',' ) ) {
			$term = explode( ',', $term );
			$term = $term[count( $term ) - 1];
		}
		$term = trim( $term );
		if ( strlen( $term ) < 2 )
			die(); // require 2 chars for matching
		$results = $wpdb->get_col( "SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'post_tag' AND t.name LIKE ('%". like_escape( $wpdb->escape( $term ) ) . "%')" );
		echo join( $results, "\n" );
	}

	function logged_in_out() {
			check_ajax_referer( 'ajaxnonce', '_loggedin' );
			echo is_user_logged_in()? 'logged_in' : 'not_logged_in';
	}
	
	function get_comment() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}
		$comment_id = attribute_escape($_GET['comment_ID']);
		$comment_id = substr( $comment_id, strpos( $comment_id, '-' ) + 1);
		$comment = get_comment($comment_id);
		echo $comment->comment_content;
	}

	function save_post() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}

		$post_id = $_POST['post_ID'];
		$post_id = substr( $post_id, strpos( $post_id, '-' ) + 1 );

		if ( !current_user_can( 'edit_post', $post_id )) {
			die('<p>'.__('Error: not allowed to edit post.', 'p2').'</p>');
		}

		$new_post_content	= $_POST['content'];

		// preserve custom "big" titles
		$post = get_post( $post_id );
		
		if ( !$post ) die('-1');

		$clean_title = str_replace( '&hellip;', '', $post->post_title );

		if( strpos($post->post_content, $clean_title ) !== 0 ) {
			$post_title = $post->post_title;
		} else {
			$post_title = prologue_title_from_content( $new_post_content );
		}

		$post = wp_update_post( array(
			'post_title'	=> $post_title,
			'post_content'	=> $new_post_content,
			'post_modified'	=> current_time('mysql'),
			'post_modified_gmt'	=> current_time('mysql', 1),
			'ID' => $post_id
		));
		
		$post = get_post( $post );

		echo apply_filters( 'the_content', $post->post_content );
	}

	function save_comment() {
		check_ajax_referer( 'ajaxnonce', '_inline_edit' );
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}

		$comment_id	= $_POST['comment_ID'];
		$comment_id = substr( $comment_id, strpos( $comment_id, '-' ) + 1);
		$comment = get_comment( $comment_id );

		if ( !current_user_can( 'edit_post', $comment->comment_post_ID ) ) {
			die('<p>'.__('Error: not allowed to edit this comment.', 'p2').'</p>');
		}

		$comment_content = $_POST['comment_content'];

		$comment = wp_update_comment( array(
			'comment_content'	=> $comment_content,
			'comment_ID' => $comment_id
		));

		$comment = get_comment( $comment_id );
		echo apply_filters( 'comment_text', $comment->comment_content );
	}
	
	function new_post() {
		global $user_ID; 
		
		if( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['action'] ) || $_POST['action'] != 'new_post' ) {
		    die('-1');
		}
		if ( !is_user_logged_in() ) {
			die('<p>'.__('Error: not logged in.', 'p2').'</p>');
		}
		if( ! ( current_user_can( 'publish_posts' ) || 
		        (get_option( 'p2_allow_users_publish' ) && $user_ID )) ) {
		        	
			die('<p>'.__('Error: not allowed to post.', 'p2').'</p>');
		}
		check_ajax_referer( 'ajaxnonce', '_ajax_post' );
		$user = wp_get_current_user();
		$user_id		= $user->ID;
		$post_content	= $_POST['posttext'];
		$tags			= trim( $_POST['tags'] );
		if ( $tags == __('Tag it', 'p2') || $tags == 'Tag it' ) $tags = '';

		if ( empty( $_POST['post_title'] ) )
	    	$post_title = prologue_title_from_content( $post_content );
		else
			$post_title = $_POST['post_title'];
			
		require_once ( ABSPATH . '/wp-admin/includes/taxonomy.php' );
		require_once ( ABSPATH . WPINC . '/category.php' );
		
		$accepted_post_cats = apply_filters( 'p2_accepted_post_cats', array( 'post', 'quote', 'status', 'link' ) );
		$post_cat = ( in_array( $_POST['post_cat'], $accepted_post_cats ) ) ? $_POST['post_cat'] : 'post';
		
		if ( !category_exists( $post_cat ) )
			wp_insert_category( array( 'cat_name' => $post_cat ) );
		
		$post_cat = get_category_by_slug( $post_cat );
		
		/* Add the quote citation to the content if it exists */
		if ( !empty( $_POST['post_citation'] ) && 'quote' == $post_cat->slug ) {
			$post_content = '<p>' . $post_content . '</p><cite>' . $_POST['post_citation'] . '</cite>';
		}
		
		$post_id = wp_insert_post( array(
			'post_author'	=> $user_id,
			'post_title'	=> $post_title,
			'post_content'	=> $post_content,
			'post_type'		=> $post_type,
			'post_category' => array( $post_cat->cat_ID ),
			'tags_input'	=> $tags,
			'post_status'	=> 'publish'
		) );
		echo $post_id ? $post_id : '0';
	}

	function get_latest_posts() {
		$load_time = $_GET['load_time'];
		$frontpage = $_GET['frontpage'];
		$num_posts = 10; // max amount of posts to load
		$number_of_new_posts = 0;
		
		query_posts('showposts=' . $num_posts . '&post_status=publish');
		ob_start();
		while (have_posts()) : the_post();
		    $current_user_id = get_the_author_meta( 'ID' );
			if ( get_gmt_from_date( get_the_time( 'Y-m-d H:i:s' ) ) <=  $load_time ) continue;
			$number_of_new_posts++;
			$post_request_ajax = true;
			require dirname(__FILE__) . '/../entry.php';
	    endwhile;
	   	$posts_html = ob_get_clean();

	    if ( $number_of_new_posts != 0 ) {
			nocache_headers();
	    	echo json_encode( array(
				'numberofnewposts' => $number_of_new_posts,
				'html' => $posts_html,
				'lastposttime' => gmdate('Y-m-d H:i:s')
			) );
		} else {
			header("HTTP/1.1 304 Not Modified");
	    }
	}
	
	function new_comment() {
		if( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['action'] ) || $_POST['action'] != 'new_comment' )
		    die();
						
		check_ajax_referer( 'ajaxnonce', '_ajax_post' );

		$comment_content = isset( $_POST['comment'] ) ? trim( $_POST['comment'] ) : null;
		$comment_post_ID = isset( $_POST['comment_post_ID'] )? trim( $_POST['comment_post_ID'] ) : null;
		
		$user = wp_get_current_user();
		
		if ( is_user_logged_in() ) {
			if ( empty( $user->display_name ) )
				$user->display_name = $user->user_login;
			$comment_author       = $user->display_name;
			$comment_author_email = $user->user_email;
			$comment_author_url   = $user->user_url;
			$user_ID 			  = $user->ID;
		} else {
			if ( get_option('comment_registration') ) {
			    die('<p>'.__('Error: you must be logged in to post a comment.', 'p2').'</p>');
			}
			$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
			$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
			$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
		}

		$comment_type = '';

		if ( get_option( 'require_name_email' ) && !$user->ID )
			if ( strlen( $comment_author_email ) < 6 || '' == $comment_author ) {
				die('<p>'.__('Error: please fill the required fields (name, email).', 'p2').'</p>');
			} elseif ( !is_email( $comment_author_email ) ) {
			    die('<p>'.__('Error: please enter a valid email address.', 'p2').'</p>');
			}

		if ( '' == $comment_content )
		    die('<p>'.__('Error: Please type a comment.', 'p2').'</p>');

		$comment_parent = isset( $_POST['comment_parent'] ) ? absint( $_POST['comment_parent'] ) : 0;

		$commentdata = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );

		$comment_id = wp_new_comment( $commentdata );
		$comment = get_comment( $comment_id );
		if ( !$user->ID ) {
			setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_url_' . COOKIEHASH, clean_url($comment->comment_author_url), time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		}
		if ($comment) echo $comment_id;
		else echo __("Error: Unknown error occured. Comment not posted.", 'p2');
	}
	
	function get_latest_comments() {
		global $wpdb, $comments, $comment, $max_depth, $depth, $user_login, $user_ID, $user_identity;

		$number = 10; //max amount of comments to load
		$load_time = $_GET['load_time'];
		$lc_widget = $_GET['lcwidget'];
		$visible_posts =  isset($_GET['vp'])? (array)$_GET['vp'] : array();

		if ( get_option('thread_comments') )
			$max_depth = get_option('thread_comments_depth');
		else
			$max_depth = -1;

		// Since we currently cater the same HTML to all widgets,
		// the instances without avatars will have to remove the avatar in javascript
		$avatar_size = 32;
		
		//get new comments
		if ($user_ID) {
			$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE (comment_approved = '1' OR ( user_id = %d AND comment_approved = '0' ))  AND comment_date_gmt > %s ORDER BY comment_date_gmt DESC LIMIT $number", $user_ID, $load_time));
		} else if ( empty($comment_author) ) {
			$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' AND comment_date_gmt > %s ORDER BY comment_date_gmt DESC LIMIT $number", $load_time));
		} else {
			$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE (comment_approved = '1' OR ( comment_author = %s AND comment_author_email = %s AND comment_approved = '0' ) ) AND comment_date_gmt > %s ORDER BY comment_date_gmt DESC LIMIT $number", $comment_author, $comment_author_email, $load_time));
		}
		$number_of_new_comments = count($comments);

	    $prepare_comments = array();
		if ($number_of_new_comments > 0) {
			foreach ($comments as $comment) {
				// Setup comment html if post is visible
				$comment_html = '';
				if ( in_array( $comment->comment_post_ID, $visible_posts ) )
					$comment_html = p2_comments($comment, array('max_depth' => $max_depth, 'before' => ' | '), $depth, false);

				// Setup widget html if widget is visible
				$comment_widget_html = '';
				if ( $lc_widget )
					$comment_widget_html = P2_Recent_Comments::single_comment_html( $comment, $avatar_size );

				$prepare_comments[] = array( "id" => $comment->comment_ID, "postID" => $comment->comment_post_ID, "commentParent" =>  $comment->comment_parent,
					"html" => $comment_html, "widgetHtml" => $comment_widget_html );
			}
			$json_data = array("numberofnewcomments" => $number_of_new_comments, "comments" => $prepare_comments, "lastcommenttime" => gmdate('Y-m-d H:i:s') );

			echo json_encode( $json_data );
		} else { // No new comments
	        header("HTTP/1.1 304 Not Modified");
		}
	}
}