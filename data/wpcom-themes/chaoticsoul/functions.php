<?php
function chaoticsoul_comment($comment, $args, $depth) { 
$GLOBALS['comment'] = $comment;	
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<?php comment_text() ?>
			<p class="commentmetadata">
				<?php echo get_avatar( $comment, 32 ); ?>
				<small>
				<cite><?php comment_author_link() ?></cite> <?php _e('said this on', 'chaoticsoul'); ?>
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'chaoticsoul'); ?></em>
				<?php endif; ?>
				<a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date(get_option('date_format')) ?> <?php _e('at', 'chaoticsoul');?> <?php comment_time(get_option('time_format')) ?></a><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ')) ?> <?php edit_comment_link(__('edit', 'chaoticsoul'),'(',')'); ?>
				</small>
			</p>
		</li>
<?php }

$themecolors = array(
	'bg' => '161410',
	'text' => '999999',
	'link' => 'd8d7d3',
	'border' => '161410'
	);

$content_width = 497;

// Widgets FTW!
function widget_chaoticsoul_links() {
	wp_list_bookmarks(array(
		'title_before' => '<h3>', 
		'title_after' => '</h3>', 
	));
}

function widget_chaoticsoul_search() {
?>
	<form method="get" id="searchform" action="/">
	<div><input type="text" value="<?php _e('Search', 'chaoticsoul'); ?>" onblur="this.value=(this.value=='') ? '<?php _e('Search', 'chaoticsoul'); ?>' : this.value;" onfocus="this.value=(this.value=='<?php _e('Search', 'chaoticsoul'); ?>') ? '' : this.value;" name="s" id="s" />
	</div>
	</form>
<?php
}

function chaoticsoul_widget_init() {
	register_sidebar(array(
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	wp_register_sidebar_widget('links', __('Links', 'widgets'), 'widget_chaoticsoul_links');
	wp_register_sidebar_widget('search', __('Search', 'widgets'), 'widget_chaoticsoul_search');
}
add_action('widgets_init', 'chaoticsoul_widget_init');

// Custom Header FTW!

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/chaostheory.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 760);
define('HEADER_IMAGE_HEIGHT', 151);
define('NO_HEADER_TEXT', true );

function chaoticsoul_admin_header_style() {
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

<?php }

add_custom_image_header('', 'chaoticsoul_admin_header_style');

?>
