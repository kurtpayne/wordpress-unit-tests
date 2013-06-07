<?php

$content_width = 500;

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '265E15',
	'border' => 'ffffff',
	'url' => '265E15'
);

register_sidebar(array(
	'before_widget' => '<li class="sidebox">',
	'after_widget' => '</li>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

function mistylook_widgets_init() {
	unregister_widget('WP_Widget_Links');
	wp_register_sidebar_widget('links', __('Links'), 'mistylook_ShowLinks');
}
add_action('widgets_init', 'mistylook_widgets_init');

function mistylook_ShowLinks() {
	wp_list_bookmarks(array(
		'class' => 'linkcat widget sidebox'
	));
}

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/img/misty.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 760);
define('HEADER_IMAGE_HEIGHT', 190);
define( 'NO_HEADER_TEXT', true );

function mistylook_admin_header_style() {
?>
<style type="text/css">
#headimg {
	background: url(<?php header_image() ?>) no-repeat;
}
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
function mistylook_header_style() {
?>
<style type="text/css">
#headerimage {
	background: url(<?php header_image() ?>) no-repeat;
}
</style>
<?php
}
if ( function_exists('add_custom_image_header') ) {
	add_custom_image_header('mistylook_header_style', 'mistylook_admin_header_style');
}


function mistylook_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID( ); ?>">
		<div id="div-comment-<?php comment_ID( ); ?>">
		<div class="cmtinfo"><em><?php edit_comment_link(__('edit this','mistylook'),'',''); ?> <?php _e('on','mistylook'); ?> <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date() ?> <?php _e('at','mistylook'); ?> <?php comment_time() ?></a><?php echo comment_reply_link(array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?></em> <?php echo get_avatar( $comment, 48 ); ?> <cite><?php comment_author_link() ?></cite></div>
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.','mistylook'); ?></em><br />
			<?php endif; ?>			
			<?php comment_text() ?>
			<br style="clear: both" />	
		</div>
<?php
}

function mistylook_get_author_posts_link() {
	global $authordata;
	return sprintf(
		'<a href="%1$s" title="%2$s">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		sprintf( __( 'Posts by %s' ), attribute_escape( get_the_author() ) ),
		get_the_author()
	);
}
