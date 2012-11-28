<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '006699'
);

$content_width = 426;

if ( function_exists('register_sidebar') )
    register_sidebar();

define('HEADER_TEXTCOLOR', 'ffffff');

define('HEADER_IMAGE_WIDTH', 527);
define('HEADER_IMAGE_HEIGHT', 273);

if (get_theme_mod('dd_colour_scheme') == "Green")
	define('HEADER_IMAGE', '%s/images/header_green.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme') == "Pink")
	define('HEADER_IMAGE', '%s/images/header_pink.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme', 'Blue') == "Blue")
	define('HEADER_IMAGE', '%s/images/header_blue.jpg'); // %s is theme dir uri

if (get_theme_mod('dd_colour_scheme') == "Grey")
	define('HEADER_IMAGE', '%s/images/matt-bus-grey.jpg'); // %s is theme dir uri

function daydream_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1 {
padding: 160px 20px 0 20px;
margin: 0;
font-size: 44px;
font-weight: normal;
}

#headimg h1 a {
	color:#<?php header_textcolor() ?>;
	border: none;
	font-family: Georgia, "Lucida Sans Unicode", lucida, Verdana, sans-serif;
	font-weight: normal;
	letter-spacing: 1px;
	text-decoration: none;
}
#headimg #desc {
font-family: Georgia, "Lucida Sans Unicode", lucida, Verdana, sans-serif;
margin: 0 35px 0 35px;
color: #<?php header_textcolor() ?>;
font-size: 17px;
}

#headimg h1, #desc {
	text-align: left;
}

<?php if (get_theme_mod('dd_title') == "centre") { ?>

#headimg h1, #desc { text-align: center; }

<?php } else if (get_theme_mod('dd_title') == "right") { ?>

#headimg h1, #desc { text-align: right; }

<?php } ?>

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headerimg h1, #headerimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>

</style>
<?php
}

add_custom_image_header('', 'daydream_admin_header_style');

function dd_add_admin() {
		
		if ( 'save' == $_POST['dd_action'] ) {

			// Update Options
			$dd_colour_scheme = preg_replace( '|[^a-z]|i', '', $_POST['dd_colour_scheme'] );
			$dd_title = preg_replace( '|[^a-z]|i', '', $_POST['dd_title'] );
			set_theme_mod('dd_colour_scheme', $dd_colour_scheme );
			set_theme_mod('dd_title', $dd_title );

			// Go back to the options
			header("Location: themes.php?page=dd-options&saved=true");
			die;
		}

	add_submenu_page('themes.php', __('Day Dream Options'), __('Day Dream Options'), 5, 'dd-options', 'dd_admin');
}

function dd_admin() {

	if ( $_GET['saved'] ) echo '<div id="message" class="updated fade"><p>Day Dream options saved. <a href="'. get_bloginfo('url') .'">View Site &raquo;</a></strong></p></div>';
	
?>

<div class="wrap">
<h2><?php _e('Theme Options'); ?></h2>

	<form id='dd_options' method="post">
			<h3><?php _e('Title'); ?></h3>
			
				<p>
					<input type="radio" name="dd_title" value="left" <?php if (get_theme_mod('dd_title') == "left") { echo "checked='checked'"; } ?> /> Left Align (default)<br />
					<input type="radio" name="dd_title" value="centre" <?php if (get_theme_mod('dd_title') == "centre") { echo "checked='checked'"; } ?> /> Centre<br />
					<input type="radio" name="dd_title" value="right" <?php if (get_option('dd_title') == "right") { echo "checked='checked'"; } ?> /> Right Align<br />
</p>

		<h3>Colour Schemes</h3>
		
			<p>
				<label><input type="radio" name="dd_colour_scheme" value="Blue" <?php if (get_theme_mod('dd_colour_scheme', 'Blue') == "Blue") { echo "checked='checked'"; } ?> /> Blue <img src="<?php bloginfo('template_directory'); ?>/images/option_blue.jpg" alt="Blue" /></label>

				<label><input type="radio" name="dd_colour_scheme" value="Green" <?php if (get_theme_mod('dd_colour_scheme') == "Green") { echo "checked='checked'"; } ?> /> Green <img src="<?php bloginfo('template_directory'); ?>/images/option_green.jpg" alt="Green" /></label>
				</p>

				<p>
				<label><input type="radio" name="dd_colour_scheme" value="Pink" <?php if (get_theme_mod('dd_colour_scheme') == "Pink") { echo "checked='checked'"; } ?> /> Pink <img src="<?php bloginfo('template_directory'); ?>/images/option_pink.jpg" alt="Pink" /></label>
				
				<label><input type="radio" name="dd_colour_scheme" value="Grey" <?php if (get_theme_mod('dd_colour_scheme') == "Grey") { echo "checked='checked'"; } ?> /> Grey <img src="<?php bloginfo('template_directory'); ?>/images/option_grey.jpg" alt="Grey" /></label>
				</p>
		<input type="hidden" name="dd_action" value="save" />
	<p class="submit" style="clear: both"><input name="save" id="save" type="submit" value="Save Options &raquo;" /></p>
	</form>

</div>
<?php
}

function dd_admin_header() { ?>
<style media="screen" type="text/css">
form#dd_options label { 
	width: 140px;
	display: block;
	float: left;
}
</style>
<?php }

add_action('admin_head', 'dd_admin_header');
add_action('admin_menu', 'dd_add_admin');

	/*
	Plugin Name: Nice Categories
	Plugin URI: http://txfx.net/2004/07/22/wordpress-conversational-categories/
	Description: Displays the categories conversationally, like: Category1, Category2 and Category3
	Version: 1.5.1
	Author: Mark Jaquith
	Author URI: http://txfx.net/
	*/
	
	function the_nice_category($normal_separator = ', ', $penultimate_separator = ' and ') {
		$categories = get_the_category();
	   
		  if (empty($categories)) {
			_e('Uncategorized');
			return;
		}
	
		$thelist = '';
			$i = 1;
			$n = count($categories);
			foreach ($categories as $category) {
				$category->cat_name = $category->cat_name;
					if (1 < $i && $i != $n) $thelist .= $normal_separator;
					if (1 < $i && $i == $n) $thelist .= $penultimate_separator;
				$thelist .= '<a href="' . get_category_link($category->cat_ID) . '" title="' . sprintf(__("View all posts in %s"), $category->cat_name) . '">'.$category->cat_name.'</a>';
						 ++$i;
			}
		echo apply_filters('the_category', $thelist, $normal_separator);
	} 

?>
