<?php
if ( function_exists('register_sidebar') ) {
	$a = get_bloginfo('template_directory');

	register_sidebar(array(
        'before_widget' => '<!-- //start sideitem //--><br /><div class="sideitem"><div class="sideitemtop"><img src="'.$a.'/img/stl.gif" alt="" width="15" height="15" class="corner" style="display: none" /></div>',
        'after_widget' => '<div class="sideitembottom"><img src="'.$a.'/img/sbl.gif" alt="" width="15" height="15" class="corner" style="display: none" /></div></div><!-- //end sideitem //-->',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}

function widget_rounded_links() {
	$a = get_bloginfo('template_directory');
 ?>
	<!-- //start sideitem //--><br /><div class="sideitem"><div class="sideitemtop"><img src="<?php echo $a; ?>/img/stl.gif" alt="" width="15" height="15" class="corner" style="display: none" /></div>
    	<?php 
	wp_list_bookmarks(array(
	'title_before' => '<h2>', 
	'title_after' => '</h2>', 
   	));
	?>
	<div class="sideitembottom"><img src="<?php echo $a; ?>/img/sbl.gif" alt="" width="15" height="15" class="corner" style="display: none" /></div></div><!-- //end sideitem //-->
<?php }

unregister_widget('WP_Widget_Links');
wp_register_sidebar_widget('links', __('Links', 'widgets'), 'widget_rounded_links');
