<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '0060ff'
);

$content_width = 500;

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header_1.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 770);
define('HEADER_IMAGE_HEIGHT', 140);
define( 'NO_HEADER_TEXT', true );

function cutline_admin_header_style() {
?>
<style type="text/css">
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

if ( function_exists('register_sidebar') )
    register_sidebar();

add_custom_image_header('', 'cutline_admin_header_style');

function cutline_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, 48 ); ?>
			<p class="comment_meta">
				<strong><?php comment_author_link() ?> </strong>
				<span class="comment_time">// <a href="#comment-<?php comment_ID() ?>" title="<?php echo attribute_escape(__('Permalink to this comment','cutline')); ?>"><?php comment_date() ?> <?php _e('at'); ?> <?php comment_time() ?></a> <?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?>  <?php edit_comment_link(__('edit','cutline'),'(',')'); ?></span> 			</p> 			<div class="entry">
				<?php comment_text() ?> 
				<?php if ($comment->comment_approved == '0') : ?>
				<p><strong><?php _e('Your comment is awaiting moderation.','cutline'); ?></strong></p>
				<?php endif; ?>
			</div>
		</li>
<?php }
?>
