<?php load_theme_textdomain('almost-spring');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('url'); ?>/wp-content/themes/livesearch.css );
	</style>
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/themes/livesearch.js"></script>

	<?php 
	wp_get_archives('type=monthly&format=link'); 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>
</head>

<body>

<div id="wrapper">

<div id="header">
<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
</div>

<div id="content">