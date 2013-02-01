<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<?php wp_head() ?>
</head>
<body <?php p2_body_class() ?>>

<div id="header">
	
	<div class="sleeve">
		<h1><a href="<?php bloginfo( 'url' ); ?>/"><?php bloginfo( 'name' ); ?></a></h1>
			<?php if ( get_bloginfo('description') ) : ?>
				<small><?php bloginfo( 'description' ); ?></small>
			<?php endif; ?>
	</div>
	
</div>

<div id="wrapper">
	<?php get_sidebar() ?>