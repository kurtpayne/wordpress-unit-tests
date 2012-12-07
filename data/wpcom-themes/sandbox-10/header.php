<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">

	<div id="header">
		<h1 id="blog-title"><a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo('name') ?></a></h1>
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div><!--  #header -->

	<div id="access">
		<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'sandbox'); ?>"><?php _e('Skip to content', 'sandbox'); ?></a></div>
		<?php sandbox_globalnav() ?>
	</div><!-- #access -->
