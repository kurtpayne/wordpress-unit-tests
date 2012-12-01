<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" />
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); ?>
</head>
<body>
<div id="page">


<div id="header">
	<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('title'); ?></a></h1>
	<div class="description"><?php bloginfo('description'); ?></div>
</div>

<div class="hr">&nbsp;</div> <!-- because IE sucks at styling HRs -->

<div id="headerimg" class="clearfix">
	<div id="header-overlay"> </div>
	<div id="header-image"><img alt="" src="<?php header_image() ?>" /></div>
</div>

<div class="hr">&nbsp;</div>

<div id="wrapper" class="clearfix">
