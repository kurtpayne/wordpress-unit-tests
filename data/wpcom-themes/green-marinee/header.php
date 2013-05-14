<?php load_theme_textdomain('greenmarinee');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>
</head>

<body>
<div id="container">
<div id="skip">
	<p><a href="#content" title="Skip to site content"><?php _e('Skip to content','greenmarinee'); ?></a></p>
	<p><a href="#search" title="Skip to search" accesskey="s"><?php _e('Skip to search - Accesskey = s','greenmarinee'); ?></a></p>
</div>
<hr />
	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<!-- Tag line description is off by default. Please see readme.txt or CSS(h1,tagline) for more info
		<div class="tagline"><?php // remove bloginfo('description'); ?></div> 
	-->
	<div id="content_bg">
	<!-- Needed for dropshadows -->
	<div class="container_left">
	<div class="container_right">
	<div class="topline">
	<!-- Start float clearing -->
	<div class="clearfix">
<!-- end header -->