<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
function widget_om_tags() {
?>
<li id="tagCloud"><h2>Tag Cloud</h2><div class="pad"><?php wp_tag_cloud('smallest=8&largest=18&number=20'); ?></div></li>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('tag_cloud'), 'widget_om_tags');
function om_footer() {
  echo "Ocean Mist 2.0 theme is available from <a href=\"http://www.tenbytwenty.com/\" title=\"Quality, free wordpress themes, fonts and icons\">TenByTwenty.com</a> | Designed by <a href=\"http://www.edmerritt.com/\" rel=\"designer\" title=\"Creative Web Designer\">Ed Merritt</a> <span style=\"position: absolute; text-indent: -9999px;\">4X.WP.OM.20.EM</span>";
}




/* colour schemes */

function body_sub_theme() {
	echo get_option('sub_theme');
}

add_action('admin_menu', 'sub_theme_page');

function sub_theme_page() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'sub_theme' ) {
		if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
			check_admin_referer('sub-theme-header');
			update_option('sub_theme', $_REQUEST['sub-theme']);
			//wp_redirect("themes.php?page=sub_theme&saved=true");
			//die;
		}
		add_action('admin_head', 'sub_theme_page_head');
	}
	add_theme_page(__('Customize Header'), __('Choose a colour scheme'), 'edit_themes', 'sub_theme', 'sub_theme_body');
}

function sub_theme_page_head() {
?>
<style type='text/css'>
ul.sub_themes {list-style-type: none;}
ul.sub_themes li {float:left; margin:5px; border: 1px solid #eee;}
ul.sub_themes li input {border: 1px solid #ccc; padding: 4px; width: 250px; height: 163px;}
ul.sub_themes li input:hover {border: 2px solid #3366FF; padding: 3px;}
</style>
<?php
}

function sub_theme_body() {
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
?>
<?php
	$sub_themes = array(
	array('','Default','images/cs1.gif'),
	array('cs2','Forest','images/cs2.gif'),
	array('cs3','Neutral','images/cs3.gif'),
	array('cs4','Warm','images/cs4.gif'),
	array('cs5','Night','images/cs5.gif'),
	);
?>
<div class='wrap'>
<h2>Colour Schemes</h2>
<p>select a colour scheme for your blog:</p>
	<form method="post" action="">
		<input type="hidden" name="action" value="save"/>
		<?php wp_nonce_field('sub-theme-header'); ?>
		<ul class="sub_themes">
		<?php foreach ($sub_themes as $theme) { ?>
			<li>
				<input type="image" src="<?php echo bloginfo('template_directory'); ?>/<?php echo $theme[2]; ?>" name="sub-theme" value="<?php echo $theme[0]; ?>"/>
				<p><?php echo $theme[1]; ?>
				<?php echo get_option('sub_theme')==$theme[0] ? '(selected)' : '' ?></p>
			</li>
		<?php } ?>
		</ul>
	</form>
</div>

<?php } ?>