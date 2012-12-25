<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	
	<!-- Basic Meta Data -->
	<meta name="copyright" content="Vigilance Theme Design: Copyright 2008 - 2009 Jestro LLC" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<!--Stylesheets-->
	<link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" rel="stylesheet" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/ie.css" />
	<![endif]-->
	<!--[if lte IE 6]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/ie6.css" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="screen" href="/wp-content/themes/pub/vigilance/functions/style-options.php" />
	<?php 	if (rtl== get_bloginfo( text_direction )) : ?> 
	<!--[if lt IE 8]>
	<style type="text/css" media="screen">
	#nav ul li a{ display:inline-block;	}
	div#title {margin-bottom: -4px !important;}
	</style>
	<![endif]-->
	<?php endif;?>
	<!--WordPress-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--WP Hook-->
  	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body>
<div id="wrapper">
	<div id="header" class="clear">
		<?php if (is_home()) echo('<h1 id="title">'); else echo('<div id="title">');?><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a><?php if (is_home()) echo('</h1>'); else echo('</div>');?>
		<div id="description">
			<h2><?php bloginfo('description'); ?></h2>
		</div><!--end description-->
		<div id="nav">
			<ul>
				<li class="page_item <?php if (is_front_page()) echo('current_page_item');?>"><a href="<?php bloginfo('url'); ?>"><?php _e('Home', 'vigilance'); ?></a></li>
        <?php $exclude_pages = get_option('V_pages_to_exclude'); ?>
        <?php wp_list_pages('depth=1&title_li=&exclude=' . $exclude_pages); ?>
			</ul>
		</div><!--end nav-->
	</div><!--end header-->
	<div id="content" class="pad">
    <?php if (is_home()) include ('header-alertbox.php'); ?>
