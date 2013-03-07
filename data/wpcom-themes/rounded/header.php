<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>

<!--[if lt IE 7.]>
<script defer type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/pngfix.js"></script>
<![endif]-->

</head>

<body>
<div id="rap">

<div id="masthead">
		<div id="pagetab">
			<div class="ltab">&nbsp;</div>
			<ul>
			<?php wp_list_pages('title_li=&depth=1'); ?>
			</ul>
			<div class="rtab">&nbsp;</div>
		</div><!-- end PAGETAB -->
		<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
							
				<h2><?php bloginfo('description'); ?></h2>
				
</div><!-- end MASTHEAD -->

<div id="main">

<div id="content">
<!-- end header -->
