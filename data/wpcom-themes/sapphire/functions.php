<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => 'cc6600'
);

$content_width = 450;

function sapphire_widgets_init() {
	register_sidebars(1, array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	));
	function wp_widget_pages_control() {
		$options = $newoptions = get_option('widget_pages');
		if ( $_POST['pages-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['pages-title']));

			$sortby = stripslashes( $_POST['pages-sortby'] );

			if ( in_array( $sortby, array( 'post_title', 'menu_order', 'ID' ) ) ) {
				$newoptions['sortby'] = $sortby;
			} else {
				$newoptions['sortby'] = 'menu_order';
			}

			$newoptions['exclude'] = strip_tags( stripslashes( $_POST['pages-exclude'] ) );
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_pages', $options);
		}
		$title = attribute_escape($options['title']);
		$exclude = attribute_escape( $options['exclude'] );
	?>
			<p><label for="pages-title"><?php _e('Title:'); ?> <input class="widefat" id="pages-title" name="pages-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p>
				<label for="pages-sortby"><?php _e( 'Sort by:' ); ?>
					<select name="pages-sortby" id="pages-sortby" class="widefat">
						<option value="post_title"<?php selected( $options['sortby'], 'post_title' ); ?>><?php _e('Page title'); ?></option>
						<option value="menu_order"<?php selected( $options['sortby'], 'menu_order' ); ?>><?php _e('Page order'); ?></option>
						<option value="ID"<?php selected( $options['sortby'], 'ID' ); ?>><?php _e( 'Page ID' ); ?></option>
					</select>
				</label>
			</p>
			<p>
				<label for="pages-exclude"><?php _e( 'Exclude:' ); ?> <input type="text" value="<?php echo $exclude; ?>" name="pages-exclude" id="pages-exclude" class="widefat" /></label>
				<br />
				<small><?php _e( 'Page IDs, separated by commas.' ); ?></small>
			</p>
			<input type="hidden" id="pages-submit" name="pages-submit" value="1" />
	<?php
	}
	function widget_sapphire_pages($args) {
		extract( $args );
		$options = get_option( 'widget_pages' );

		$title = empty( $options['title'] ) ? __( 'Pages' ) : apply_filters('widget_title', $options['title']);
		$sortby = empty( $options['sortby'] ) ? 'menu_order' : $options['sortby'];
		$exclude = empty( $options['exclude'] ) ? '' : $options['exclude'];

		if ( $sortby == 'menu_order' ) {
			$sortby = 'menu_order, post_title';
		}

		$out = wp_list_pages( array('title_li' => '', 'echo' => 0, 'sort_column' => $sortby, 'exclude' => $exclude) );

		echo $before_widget;
		echo $before_title . $title . $after_title;
	?>
		<ul>
			<li class="page_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>
			<?php echo $out; ?>
		</ul>
	<?php
		echo $after_widget;
	}

	unregister_widget('WP_Widget_Pages');
	wp_register_sidebar_widget('pages', __('Pages (Sapphire)'), 'widget_sapphire_pages', null, 'pages');
	wp_register_widget_control('pages', __('Pages (Sapphire)'), 'wp_widget_pages_control' );

}
add_action('widgets_init', 'sapphire_widgets_init');

define('HEADER_TEXTCOLOR', 'FFFFFF');
define('HEADER_IMAGE', '%s/images/sapphirehead.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 740);
define('HEADER_IMAGE_HEIGHT', 180);

function header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat center;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header .description {
	display: none;
}
<?php } else { ?>
#header h1 a, .description {
	color:#<?php header_textcolor() ?>;
}
<?php } ?>
</style>
<?php
}

function sapphire_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image() ?>) no-repeat;
	background-repeat: no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
	font-family: Verdana, Arial, Sans-Serif;
}
#headimg h1{
font-size: 32px;
font-weight: bold;
padding-top: 60px;
text-align: center;
margin: 0;
}
#headimg h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor() ?>;
font-size: 15px;
text-align: center;
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

add_custom_image_header('header_style', 'sapphire_admin_header_style');

?>
