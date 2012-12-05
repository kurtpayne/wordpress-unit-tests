<?php
$content_width = 462;
add_filter( 'the_content', 'make_clickable' );

function get_recent_post_ids( $return_as_string = true ) {
	global $wpdb;

	$recent_ids =  (array) $wpdb->get_results( "
		SELECT MAX(ID) AS post_id
		FROM {$wpdb->posts}
		WHERE post_type = 'post'
		  AND post_status = 'publish'      
		GROUP BY post_author
		ORDER BY post_date_gmt DESC
	", ARRAY_A );

	if( $return_as_string === true ) {
		$ids_string = '';
		foreach( $recent_ids as $post_id ) {
			$ids_string .= "{$post_id['post_id']}, ";
		}

		// Remove trailing comma
		$ids_string = substr( $ids_string, 0, -2 );

		return $ids_string;
	}

	$ids = array( );
	foreach( $recent_ids as $post_id ) {
		$ids[] = $post_id['post_id'];
	}

	return $ids;
}

function prologue_recent_projects_widget( $args ) {
	extract( $args );
	$options = get_option( 'prologue_recent_projects' );

	$title = empty( $options['title'] ) ? __( 'Recent Tags' ) : $options['title'];
	$num_to_show = empty( $options['num_to_show'] ) ? 35 : $options['num_to_show'];

	$num_to_show = (int) $num_to_show;

	$before = $before_widget;
	$before .= $before_title . $title . $after_title;

	$after = $after_widget;

	echo prologue_recent_projects( $num_to_show, $before, $after );
}

function prologue_recent_projects( $num_to_show = 35, $before = '', $after = '' ) {
	$cache = wp_cache_get( 'prologue_theme_tag_list', '' );
	if( !empty( $cache[$num_to_show] ) ) {
		$recent_tags = $cache[$num_to_show];
	}
	else {
		$all_tags = (array) get_tags( array( 'get' => 'all' ) );

		$recent_tags = array( );
		foreach( $all_tags as $tag ) {
			if( $tag->count < 1 )
				continue;

			$tag_posts = get_objects_in_term( $tag->term_id, 'post_tag' );
			$recent_post_id = max( $tag_posts );
			$recent_tags[$tag->term_id] = $recent_post_id;
		}

		arsort( $recent_tags );

		$num_tags = count( $recent_tags );
		if( $num_tags > $num_to_show ) {
			$reduce_by = (int) $num_tags - $num_to_show;

			for( $i = 0; $i < $reduce_by; $i++ ) {
				array_pop( $recent_tags );
			}
		}

		wp_cache_set( 'prologue_theme_tag_list', array( $num_to_show => $recent_tags ) );
	}

	echo $before;
	echo "<ul>\n";

	foreach( $recent_tags as $term_id => $post_id ) {
		$tag = get_term( $term_id, 'post_tag' );
		$tag_link = get_tag_link( $tag->term_id );
?>

<li>
<a class="rss" href="<?php echo get_tag_feed_link( $tag->term_id ); ?>">RSS</a>&nbsp;<a href="<?php echo $tag_link; ?>"><?php echo $tag->name; ?></a>&nbsp;(&nbsp;<?php echo $tag->count; ?>&nbsp;)
</li>

<?php
    } // foreach get_tags
?>

	</ul>

<p><a class="allrss" href="<?php bloginfo( 'rss2_url' ); ?>">All Updates RSS</a></p>

<?php
	echo $after;
}

function prologue_flush_tag_cache( ) {
	wp_cache_delete( 'prologue_theme_tag_list' );
}
add_action( 'save_post', 'prologue_flush_tag_cache' );

function prologue_recent_projects_control( ) {
	$options = $newoptions = get_option( 'prologue_recent_projects' );

	if( $_POST['prologue_submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['prologue_title'] ) );
		$newoptions['num_to_show'] = strip_tags( stripslashes( $_POST['prologue_num_to_show'] ) );
	}

	if( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'prologue_recent_projects', $options );
	}

	$title = attribute_escape( $options['title'] );
	$num_to_show = $options['num_to_show'];
?>

<input type="hidden" name="prologue_submit" id="prologue_submit" value="1" />

<p><label for="prologue_title"><?php _e('Title:') ?> 
<input type="text" class="widefat" id="prologue_title" name="prologue_title" value="<?php echo $title ?>" />
</label></p>

<p><label for="prologue_num_to_show"><?php _e('Num of tags to show:') ?> 
<input type="text" class="widefat" id="prologue_num_to_show" name="prologue_num_to_show" value="<?php echo $num_to_show ?>" />
</label></p>

<?php
}
wp_register_sidebar_widget( 'prologue_recent_projects_widget', __( 'Recent Projects' ), 'prologue_recent_projects_widget' );
wp_register_widget_control( 'prologue_recent_projects_widget', __( 'Recent Projects' ), 'prologue_recent_projects_control' );

function load_javascript( ) {
//	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_print_scripts', load_javascript );

if( function_exists('register_sidebar') )
	register_sidebar();


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/there-is-no-image.jpg'); 
define('HEADER_IMAGE_WIDTH', 726);
define('HEADER_IMAGE_HEIGHT', 150);
define('NO_HEADER_TEXT', true);

function prologue_admin_header_style( ) {
?>
<style type="text/css">
#headimg h1, #desc {
	display: none;
}
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
</style>
<?php
}
add_custom_image_header( '', 'prologue_admin_header_style' );


function prologue_get_avatar( $wpcom_user_id, $email, $size, $rating = '', $default = 'http://s.wordpress.com/i/mu.gif' ) {
	if( !empty( $wpcom_user_id ) && $wpcom_user_id !== false && function_exists( 'get_avatar' ) ) {
		return get_avatar( $wpcom_user_id, $size );
	}
	elseif( !empty( $email ) && $email !== false ) {
		$default = urlencode( $default );

		$out = 'http://www.gravatar.com/avatar.php?gravatar_id=';
		$out .= md5( $email );
		$out .= "&amp;size={$size}";
		$out .= "&amp;default={$default}";

		if( !empty( $rating ) ) {
			$out .= "&amp;rating={$rating}";
		}

		return "<img alt='' src='{$out}' class='avatar avatar-{$size}' height='{$size}' width='{$size}' />";
	}
	else {
		return "<img alt='' src='{$default}' />";
	}
}

function prologue_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<?php echo prologue_get_avatar( $comment->user_id, $comment->comment_author_email, 32 ); ?>
	<h4>
		<?php comment_author_link( ); ?>
		<span class="meta"><?php comment_time( ); ?> on <?php comment_date( ); ?> | <a href="#comment-<?php comment_ID( ); ?>">#</a><?php echo comment_reply_link(array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?><?php edit_comment_link( __( 'e' ), ' | ',''); ?></span>
	</h4>
	<?php comment_text( ); ?>
	</div>

<?php	
}

function prologue_comment_noreply($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
	<?php echo prologue_get_avatar( $comment->user_id, $comment->comment_author_email, 32 ); ?>
	<h4>
		<?php comment_author_link( ); ?>
		<span class="meta"><?php comment_time( ); ?> on <?php comment_date( ); ?> | <a href="#comment-<?php comment_ID( ); ?>">#</a> <?php edit_comment_link( __( 'e' ), '&nbsp;|&nbsp;',''); ?></span>
	</h4>
	<?php comment_text( ); ?>

<?php	
}
