<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	
	<?php // Meta information. ?>

	<?php // CSS Link ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />

	<?php // RSS, Pinging, and Atom ?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>

</head>

<body>
<div id="header">
	<?php // This is the top box ?>
	<a href="<?php bloginfo('home'); ?>" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>
</div>
<div id="text">
	<div id="main">
