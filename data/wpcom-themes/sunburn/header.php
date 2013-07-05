<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<style type="text/css"> @import url("<?php bloginfo('stylesheet_url'); ?>"); </style>
	<!--[if gte IE 6]> 	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" /> <![endif]-->
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>
</head>
<body>

	<div id="bg_maker">
	
		<div id="wrapper">

			<div id="header_sun"></div>
			
			<div id="header_text">
				<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a><br />
				<span class="description"><?php bloginfo('description'); ?></span></h1>
			</div>		
