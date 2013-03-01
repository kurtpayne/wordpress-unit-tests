<?php

$wp_andreas09_ImageColour = get_settings('wp_andreas09_ImageColour');

if (!$wp_andreas09_ImageColour) {

$wp_andreas09_ImageColour = 'blue';

update_option('wp_andreas09_ImageColour', $wp_andreas09_ImageColour);

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	<meta name="author" content="Ainslie Johnson / Original design by Andreas Viklund - http://andreasviklund.com" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?5" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/<?php echo "" . get_settings( 'wp_andreas09_ImageColour' ) . ".css"; ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>

</head>

<body>

<div id="container">
	<div id="sitename">
		<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2><?php bloginfo('description'); ?></h2>
	</div>

	<div id="mainmenu">
		<ul class="level1">
			<li <?php if ( is_front_page() ) echo 'class="current_page_item"'; ?>><a href="/"><?php _e('Home','andreas09'); ?></a></li>
		<?php
					wp_list_pages('depth=1&title_li=' );
		//    if(function_exists("wp_andreas09_nav")) {
		//      wp_andreas09_nav("sort_column=name&list_tag=0&show_all_parents=1&show_root=1");
		//    }
		?>
		</ul>
	</div>

<div id="wrap">
