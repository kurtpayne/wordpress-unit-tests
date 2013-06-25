<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_enqueue_script('jquery'); ?>
	<?php wp_enqueue_script('functions-js',get_bloginfo('template_url').'/js/functions.js'); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body>
<div id="wrapper">
	
	<div id="masthead" class="fix">
		<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="blogLead">
			<?php if ( blavatar_exists( blavatar_current_domain() ) ): ?>
				<img src="<?php echo clean_url( blavatar_url( blavatar_current_domain(), 'img', 48, false, 'invalidate-cache') ); ?>" alt=""/>
			<?php else: ?>
				<img src="<?php bloginfo('template_directory'); ?>/images/avatar.png?<?php echo time() ?>" alt="Icon" />
			<?php endif; ?>
			<p id="authorIntro"><?php bloginfo('description'); ?></p>
		</div>
	</div>
	
	<?php include (TEMPLATEPATH . '/navigation.strip.php'); ?>