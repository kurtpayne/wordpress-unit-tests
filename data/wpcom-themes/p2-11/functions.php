<?php
define( 'P2_INC_PATH',  get_template_directory() . '/inc' );
define( 'P2_INC_URL', get_bloginfo('template_directory' ).'/inc' );
define( 'P2_JS_PATH',  get_template_directory() . '/js' );
define( 'P2_JS_URL', get_bloginfo('template_directory' ).'/js' );

if( !class_exists('Services_JSON') ) require_once( P2_INC_PATH . '/JSON.php' );
require_once( P2_INC_PATH . '/compat.php' );
require_once( P2_INC_PATH . '/p2.php' );
require_once( P2_INC_PATH . '/js.php' );
require_once( P2_INC_PATH . '/options-page.php' );
require_once( P2_INC_PATH . '/template-tags.php' );
require_once( P2_INC_PATH . '/widgets/recent-tags.php' );
require_once( P2_INC_PATH . '/widgets/recent-comments.php' );

$content_width = '632';

if( function_exists('register_sidebar') )
	register_sidebar();

// Content Filters
function p2_get_at_name_map() {
	global $wpdb;
	static $name_map = array();
	if ( $name_map ) // since $names is static, the stuff below will only get run once per page load.
 		return $name_map;
	$users = get_users_of_blog();
	// get display names (can take out if you only want to handle nicenames)
	foreach ( $users as $user ) {
 		$name_map["@$user->user_login"]['id'] = $user->ID;
		$users_to_array[] = $user->ID;
	}
	// get nicenames (can take out if you only want to handle display names)
	$user_ids = join( ',', array_map( 'intval', $users_to_array ) );

	foreach ( $wpdb->get_results( "SELECT ID, display_name, user_nicename from $wpdb->users WHERE ID IN($user_ids)" ) as $user ) {
 		$name_map["@$user->display_name"]['id'] = $user->ID;
		$name_map["@$user->user_nicename"]['id'] = $user->ID;
	}

	foreach( $name_map as $name => $values)
 		$name_map[$name]['replacement'] = '<a href="' . clean_url( '/mentions/'. get_usermeta($values['id'], 'user_login') ) . '">' . wp_specialchars( $name ) . '</a>';

	// remove any empty name just in case
	unset( $name_map['@'] );
	return $name_map;
}

add_action( 'init', 'mention_taxonomy', 0 ); // initialize the taxonomy

function mention_taxonomy() {
	register_taxonomy( 'mentions', 'post', array( 'hierarchical' => false, 'label' => 'Mentions', 'query_var' => true, 'rewrite' => true ) );
}

function p2_at_names( $content ) {
	global $post, $comment;
	$name_map = p2_get_at_name_map(); // get users user_login and display_name map
	$content_original = $content; // save content before @names are found
	foreach($name_map as $name => $values) { //loop and...
		$content = str_ireplace( $name, $values['replacement'], $content ); // Change case to that in $name_map
		$content = strtr( $content, $name, $name ); // Replaces keys with values longest to shortest, without re-replacing pieces it's already done
		if( $content != $content_original ) // if the content has changed, an @name has been found.
 			$users_to_add[] = get_usermeta( $name_map[$name]['id'], 'user_login' ); // add that user to an array.
		$content_original = $content;
	}
	if( is_array($users_to_add) ) $cache_data = implode($users_to_add); // if we've got an array, make it a comma delimited string
	if( isset($cache_data) && $cache_data != wp_cache_get( 'mentions', $post->ID) ) {
		wp_set_object_terms( $post->ID, $users_to_add, 'mentions', true ); // tag the post.
		wp_cache_set( 'mentions', $cache_data, $post->ID);
	}
	return $content;
}

if( !is_admin() ) add_filter( 'the_content', 'p2_at_names' ); // hook into content
if( !is_admin() ) add_filter( 'comment_text', 'p2_at_names' ); // hook into comment text

function p2_at_name_highlight( $c ) {
	global $wp_query;
	if($wp_query->query_vars['taxonomy'] != 'mentions') return $c;
	$mention_name = $wp_query->query_vars['term'];
	$name_map = p2_get_at_name_map();
	$names[] = get_usermeta( $name_map["@$mention_name"]['id'], 'display_name' );
	$names[] = get_usermeta( $name_map["@$mention_name"]['id'], 'user_login' );
	foreach( $names as $key => $name ) {
			$at_name = "@$name";
			$c = str_replace($at_name, "<span class='mention-highlight'>$at_name</span>", $c);
	}
	return $c;
}

add_filter( 'the_content', 'p2_at_name_highlight' );
add_filter( 'comment_text', 'p2_at_name_highlight' );

// Widgets
function prologue_flush_tag_cache() {
	wp_cache_delete( 'prologue_theme_tag_list' );
}
add_action( 'save_post', 'prologue_flush_tag_cache' );

function prologue_get_avatar( $user_id, $email, $size ) {
	if ( $user_id )
		return get_avatar( $user_id, $size );
	else
		return get_avatar( $email, $size );
}

function prologue_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
	<?php echo get_avatar( $comment, 32 ); ?>
	<h4>
		<?php comment_author_link(); ?>
		<span class="meta"><?php comment_time(); ?> <?php _e('on', 'p2'); ?> <?php comment_date(); ?> <span class="actions"><a href="#comment-<?php comment_ID( ); ?>"><?php _e('Permalink', 'p2'); ?></a><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?><?php edit_comment_link( __( 'Edit' , 'p2'), ' | ',''); ?></span><br /></span>
	</h4>
	<div class="commentcontent<?php if (current_user_can('edit_post', $comment->comment_post_ID)) echo(' comment-edit') ?>"  id="commentcontent-<?php comment_ID( ); ?>">
			<?php comment_text( ); ?>
	<?php if ( $comment->comment_approved == '0' ) : ?>
	<p><em><?php _e('Your comment is awaiting moderation.', 'p2') ?></em></p>
	<?php endif; ?>
	</div>
<?php
}

function p2_title($before = '<h2>', $after = '</h2>', $returner = false) {
	if( is_page() ) return;
	if (is_single() && p2_the_title( '','', true ) == false ) {?>
		<h2 class="transparent_title"><?php echo the_title(); ?></h2><?php
		return true;
	} else {
		p2_the_title($before, $after, $returner);
	}
}

function p2_the_title($before = '<h2>', $after = '</h2>', $returner = false) {
	global $post, $looping;

	$temp = $post;
	$t = apply_filters('the_title', $temp->post_title);
	$title = $temp->post_title;
	$content = $temp->post_content;
	$pos = 0;

	if ( (int)get_option('prologue_show_titles') != 1 or $title == 'Post Title' ) return false;

	$content = trim($content);
	$title = trim($title);
	$title = preg_replace('/\.\.\.$/','',$title);
	$title = str_replace("\n", ' ', $title );
	$title = str_replace('  ',' ', $title);
	$content = str_replace("\n", ' ', strip_tags($content) );
	$content = str_replace('  ',' ', $content);
	$content = trim($content);
	$title = trim($title);

	if( strpos($title, 'http') !== false )  {
		$split = @str_split( $content, strpos($content, 'http'));
		$content = $split[0];
		$split2 = @str_split( $title, strpos($title, 'http'));
		$title = $split2[0];
	}
	$pos = strpos( $content, $title );

	if( ( false === $pos or $pos > 0) && $title != '' ) {
		$outputs = ( is_single() ) ? $before.$t.$after : $before.'<a href="'.$temp->guid.'">'.$t.'&nbsp;</a>'.$after;
		if($returner == true) {
			return $outputs;
		} else {
			echo $outputs;
		}
	}
}

function prologue_loop() {
	global $looping;
	$looping = ($looping === 1 ) ? 0 : 1;
}
add_action('loop_start', 'prologue_loop');
add_action('loop_end', 'prologue_loop');


function p2_comments( $comment, $args, $echocomment = true ) {
	$GLOBALS['comment'] = $comment;

	$depth = prologue_get_comment_depth( get_comment_ID() );
	$comment_text =  apply_filters( 'comment_text', $comment->comment_content );
	$comment_class = comment_class( $class = '', $comment_id = null, $post_id = null, $echo = false );
	$comment_time = get_comment_time();
	$comment_date = get_comment_date();
	$id = get_comment_ID();
	$avatar = get_avatar( $comment, 32 );
	$author_link = get_comment_author_link();
	$reply_link = prologue_get_comment_reply_link(
        array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ', 'reply_text' => __('Reply', 'p2') ),
        $comment->comment_ID, $comment->comment_post_ID );
	$can_edit = current_user_can( 'edit_post', $comment->comment_post_ID );
	$edit_comment_url = get_edit_comment_link( $comment->comment_ID );
	$edit_link = $can_edit? " | <a class='comment-edit-link' href='$edit_comment_url' title='".attribute_escape(__('Edit comment', 'p2'))."'>".__('Edit', 'p2')."</a>" : '';
	$content_class = $can_edit? 'commentcontent comment-edit' : 'commentcontent';
	$awaiting_message = $comment->comment_approved == '0'? '<p><em>'.__('Your comment is awaiting moderation.', 'p2').'</em></p>' : '';
	$permalink = clean_url( get_comment_link() );
	$permalink_text = __('Permalink', 'p2');
	$date_time = p2_date_time_with_microformat('comment');
	$html = <<<HTML
<li $comment_class id="comment-$id">
    $avatar
    <h4>
        $author_link
        <span class="meta">
            $date_time
            <span class="actions"><a href="$permalink">$permalink_text</a> $reply_link $edit_link</span>
        </span>
    </h4>
    <div class="$content_class" id="commentcontent-$id">
        $comment_text
    </div>
HTML;
	if(!is_single() && get_comment_type() != 'comment')
		return false;

	if ($echocomment)
		echo $html;
	else
		return $html;
}

function tags_with_count( $format = 'list', $before = '', $sep = '', $after = '' ) {
	global $post;
	$posttags = get_the_tags($post->ID, 'post_tag');

	if ( !$posttags )
		return;

	foreach ( $posttags as $tag ) {
		if ( $tag->count > 1 && !is_tag($tag->slug) ) {
			$tag_link = '<a href="' . get_term_link($tag, 'post_tag') . '" rel="tag">' . $tag->name . ' (' . number_format_i18n( $tag->count ) . ')</a>';
		} else {
			$tag_link = $tag->name;
		}

		if ( $format == 'list' )
			$tag_link = '<li>' . $tag_link . '</li>';

		$tag_links[] = $tag_link;
	}

	echo $before . join( $sep, $tag_links ) . $after;
}

function latest_post_permalink() {
	global $wpdb;
	$sql = "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1";
	$last_post_id = $wpdb->get_var($sql);
	$permalink = get_permalink($last_post_id);
	return $permalink;
}

function prologue_title_from_content( $content ) {

    static $strlen =  null;
    if ( !$strlen ) {
        $strlen = function_exists('mb_strlen')? 'mb_strlen' : 'strlen';
    }
    $max_len = 40;
    $title = $strlen( $content ) > $max_len? wp_html_excerpt( $content, $max_len ) . '...' : $content;
    $title = trim( strip_tags( $title ) );
    $title = str_replace("\n", " ", $title);

	//Try to detect image or video only posts, and set post title accordingly
	if ( !$title ) {
		if ( preg_match("/<object|<embed/", $content ) )
			$title = __('Video Post', 'p2');
		elseif ( preg_match( "/<img/", $content ) )
			$title = __('Image Post', 'p2');
	}
    return $title;
}
if ( is_admin() && ( false === get_option('prologue_show_titles') ) ) {
	add_option('prologue_show_titles', 1);
}

function p2_fix_empty_titles( $post_ID, $post ) {
	if( is_object($post) && $post->post_title == '' ) {
		$post->post_title = prologue_title_from_content( $post->post_content );
		$post->post_modified = current_time('mysql');
		$post->post_modified_gmt = current_time('mysql', 1);
		return wp_update_post( $post );
	}
}
add_action( 'save_post', 'p2_fix_empty_titles', 10, 2 );

function p2_init_at_names() {
	global $init_var_names, $name;

	// @names
	$init_var_names = array( 'comment_author', 'comment_author_email', 'comment_author_url' );
	foreach($init_var_names as $name)
		if (!isset($$name)) $$name = '';
}
add_action( 'template_redirect' , 'p2_init_at_names' );

function p2_add_head_content() {
	if ( is_home() ) {
		include ABSPATH . '/wp-admin/includes/media.php';
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		$media_upload_js = '/wp-admin/js/media-upload.js';
		wp_enqueue_script('media-upload', get_bloginfo('wpurl') . $media_upload_js, array( 'thickbox' ), filemtime( ABSPATH . $media_upload_js) );
	}
}
add_action( 'wp_head', 'p2_add_head_content' );

function prologue_new_post_noajax() {
	if( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['action'] ) || $_POST['action'] != 'post' )
	    return;

	if ( !is_user_logged_in() )
		auth_redirect();

	if( !current_user_can( 'publish_posts' ) ) {
		wp_redirect( get_bloginfo( 'url' ) . '/' );
		exit;
	}

	check_admin_referer( 'new-post' );

	$user_id		= $current_user->user_id;
	$post_content	= $_POST['posttext'];
	$tags			= $_POST['tags'];

	$post_title = prologue_title_from_content( $post_content );

	$post_id = wp_insert_post( array(
		'post_author'	=> $user_id,
		'post_title'	=> $post_title,
		'post_content'	=> $post_content,
		'tags_input'	=> $tags,
		'post_status'	=> 'publish'
	) );

	wp_redirect( get_bloginfo( 'url' ) . '/' );

	exit;
}
add_filter( 'template_redirect', 'prologue_new_post_noajax' );

//Search related Functions

function search_comments_distinct( $distinct ) {
	global $wp_query;
	if (!empty($wp_query->query_vars['s']))
		return 'DISTINCT';
}
add_filter('posts_distinct', 'search_comments_distinct');

function search_comments_where( $where ) {
	global $wp_query, $wpdb;
	if (!empty($wp_query->query_vars['s'])) {
			$or = " OR ( comment_post_ID = ".$wpdb->posts . ".ID  AND comment_approved =  '1' AND comment_content LIKE '%" . like_escape( $wpdb->escape($wp_query->query_vars['s'] ) ) . "%') ";
  			$where = preg_replace( "/\bor\b/i", $or." OR", $where, 1 );
	}
	return $where;
}
add_filter('posts_where', 'search_comments_where');

function search_comments_join( $join ) {
	global $wp_query, $wpdb, $request;
	if (!empty($wp_query->query_vars['s']))
		$join .= " LEFT JOIN $wpdb->comments ON ( comment_post_ID = ID  AND comment_approved =  '1')";
	return $join;
}
add_filter('posts_join', 'search_comments_join');

function get_search_query_terms() {
	$search = get_query_var('s');
	$search_terms = get_query_var('search_terms');
	if ( !empty($search_terms) ) {
		return $search_terms;
	} else if ( !empty($search) ) {
		return array($search);
	}
	return array();
}

function hilite( $text ) {
	$query_terms = array_filter( array_map('trim', get_search_query_terms() ) );
	foreach ( $query_terms as $term ) {
	    $term = preg_quote( $term, '/' );
		if ( !preg_match( '/<.+>/', $text ) ) {
			$text = preg_replace( '/(\b'.$term.'\b)/i','<span class="hilite">$1</span>', $text );
		} else {
			$text = preg_replace( '/(?<=>)([^<]+)?(\b'.$term.'\b)/i','$1<span class="hilite">$2</span>', $text );
		}
	}
	return $text;
}

function hilite_tags( $tags ) {
	$query_terms = array_filter( array_map('trim', get_search_query_terms() ) );
	// tags are kept escaped in the db
	$query_terms = array_map( 'wp_specialchars', $query_terms );
	foreach( array_filter((array)$tags) as $tag )
	    if ( in_array( trim($tag->name), $query_terms ) )
	        $tag->name ="<span class='hilite'>". $tag->name . "</span>";
	return $tags;
}

// Highlight text and comments:
add_filter('the_content', 'hilite');
add_filter('get_the_tags', 'hilite_tags');
add_filter('the_excerpt', 'hilite');
add_filter('comment_text', 'hilite');

function iphone_css() {
if ( strstr( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) or isset($_GET['iphone']) && $_GET['iphone'] ) { ?>
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<style type="text/css">
/* <![CDATA[ */
/* iPhone CSS */
<?php $iphonecss = dirname( __FILE__ ) . '/style-iphone.css'; if( is_file( $iphonecss ) ) require $iphonecss; ?>
/* ]]> */
</style>
<?php } }
add_action('wp_head', 'iphone_css');

/*
	Modified to replace query string with blog url in output string
*/
function prologue_get_comment_reply_link( $args = array(), $comment = null, $post = null ) {
	global $user_ID;

	$defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply', 'p2'),
		'login_text' => __('Log in to Reply', 'p2'), 'depth' => 0, 'before' => '', 'after' => '');

	$args = wp_parse_args($args, $defaults);
	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	$post = get_post($post);

	if ( 'open' != $post->comment_status )
		return false;

	$link = '';

	$reply_text = wp_specialchars( $reply_text );

	if ( get_option('comment_registration') && !$user_ID )
		$link = '<a rel="nofollow" href="' . site_url('wp-login.php?redirect_to=' . urlencode( get_permalink() ) ) . '">' . wp_specialchars( $login_text ) . '</a>';
	else
		$link = "<a rel='nofollow' class='comment-reply-link' href='". get_permalink($post). "#" . urlencode( $respond_id ) . "' onclick='return addComment.moveForm(\"" . js_escape( "$add_below-$comment->comment_ID" ) . "\", \"$comment->comment_ID\", \"" . js_escape( $respond_id ) . "\", \"$post->ID\")'>$reply_text</a>";
	return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

function prologue_comment_depth_loop( $comment_id, $depth )  {
	$comment = get_comment( $comment_id );
	if ( $comment->comment_parent != 0 ) {
		return prologue_comment_depth_loop( $comment->comment_parent, $depth + 1 );
	}
	return $depth;
}

function prologue_get_comment_depth( $comment_id ) {
	return prologue_comment_depth_loop( $comment_id, 1 );
}

function prologue_comment_depth( $comment_id ) {
	echo prologue_get_comment_depth( $comment_id );
}

function prologue_poweredby_link() {
    return apply_filters( 'prologue_poweredby_link',
        sprintf( __('<strong>%1$s</strong> is proudly powered by %2$s.', 'p2'),
        get_bloginfo('name'), '<a href="http://wordpress.org/" rel="generator">WordPress</a>' ) );
}

if ( defined('IS_WPCOM') && IS_WPCOM ) {
    add_filter( 'prologue_poweredby_link', returner('<a href="http://wordpress.com/">'.__('Blog at WordPress.com', 'p2').'.</a>') );
}

/* Custom Header Code */
define('HEADER_TEXTCOLOR', '3478E3');
define('HEADER_IMAGE', ''); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 980);
define('HEADER_IMAGE_HEIGHT', 120);

function p2_admin_header_style() {
?>
	<style type="text/css">
	#headimg{
		background: url(<?php header_image() ?>) repeat;
		height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
		width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
		padding:0 0 0 18px;
	}

	#headimg h1{
		padding-top:40px;
		margin: 0;
		font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: 200;
	}
	#headimg h1 a {
		color:#<?php header_textcolor() ?>;
		text-decoration: none;
		border-bottom: none;
		font-size: 1.4em;
		margin: -0.4em 0 0 0;
	}
	#headimg #desc{
		color:#<?php header_textcolor() ?>;
		font-size:1.1em;
		margin-top:1em;
		font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: 200;
	}

	<?php if ( 'blank' == get_header_textcolor() ) { ?>
	#headimg h1, #headimg #desc {
		display: none;
	}
	#headimg h1 a, #headimg #desc {
		color:#<?php echo HEADER_TEXTCOLOR ?>;
	}
	<?php } ?>

	</style>
<?php
}

function p2_header_style() {
?>
	<style type="text/css">
		<?php if ( '' != get_header_image() ) : ?>
		#header {
			background: url(<?php header_image() ?>) repeat;
		}
		#header .sleeve {
			margin-right: 0;
			background-color: transparent;
			box-shadow: none !important;
			-webkit-box-shadow: none !important;
			-moz-box-shadow: none !important;
		}
		#header {
			box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2) !important;
			-webkit-box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2) !important;
			-moz-box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2) !important;
		}
		<?php endif; ?>
		<?php if ( 'blank' == get_header_textcolor() ) { ?>
		#header h1, #header small {
			display: none;
		}
		<?php } else { ?>
		#header h1 a, #header small {
			color: #<?php header_textcolor() ?>;
		}
		<?php } ?>
	</style>
<?php
}
add_custom_image_header( 'p2_header_style', 'p2_admin_header_style' );

function p2_background_color() {
	$background_color = get_option( 'p2_background_color' );

	if ( '' != $background_color ) :
	?>
	<style type="text/css">
		body {
			background-color: <?php echo attribute_escape( $background_color ) ?>;
		}
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_background_color' );

function p2_background_image() {
	$p2_background_image = get_option( 'p2_background_image' );

	if ( 'none' == $p2_background_image || '' == $p2_background_image )
		return false;

?>
	<style type="text/css">
		body {
			background-image: url( <?php echo get_template_directory_uri() . '/i/backgrounds/pattern-' . $p2_background_image . '.png' ?> );
		}
	</style>
<?php
}
add_action( 'wp_head', 'p2_background_image' );

function p2_hidden_sidebar_css() {
	$hide_sidebar = get_option( 'p2_hide_sidebar' );

	if ( '' != $hide_sidebar ) :
	?>
	<style type="text/css">
		.sleeve_main { margin-right: 0; }
		#wrapper { background: transparent; }
		#header, #footer, #wrapper { width: 760px; }
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_hidden_sidebar_css' );

