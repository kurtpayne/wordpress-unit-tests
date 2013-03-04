<?php

if(is_home()) {
	$homeTagStart = '<h1 id="blog-title">';
	$homeTagEnd = '</h1>';
} else {
	$homeTagStart = '<span id="blog-title">';
	$homeTagEnd = '</span>';
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php echo get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
	<meta name="robots" content="all" />
	<meta name="description" content="<?php echo get_bloginfo('description'); ?>" />
	
	<link rel="pingback" href="<?php echo get_settings('home'); ?>/xmlrpc.php" />
	<link rel="stylesheet" href="<?php echo get_bloginfo('stylesheet_url'); ?>?2" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/print.css" type="text/css" media="print" />
	<?php if(get_option('tarski_style')) { ?><link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/styles/<?php echo get_option('tarski_style'); ?>" type="text/css" media="screen,projection" /><?php } ?>

<?php if (is_single()) { ?>
	<link rel="alternate" type="application/rss+xml" title="Comments feed" href="<?php the_permalink() ?>feed/" />
<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> feed" href="<?php echo get_bloginfo('rss2_url'); ?>" />

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); 
?>
</head>

<body class="center <?php if (is_page() || is_single() || is_404()) { echo " single"; } ?>"><div id="wrapper">

<div id="header">

	<div id="header-image">
		<?if (is_home()) { ?><img alt="Header image" src="<?php header_image() ?>" /><? } else { ?><a title="Return to front page" href="<?php echo get_settings('home'); ?>"><img alt="Header image" src="<?php header_image() ?>" /></a><?php } ?>
	</div>

	<div id="title">
		<? if (is_home()) { echo $homeTagStart; bloginfo('name'); echo $homeTagEnd; } else { ?><a title="Return to front page" href="<?php echo get_settings('home'); ?>"><?php echo $homeTagStart; bloginfo('name'); echo $homeTagEnd; ?></a><? } ?>
		<?php if (get_bloginfo('description') != '') { ?><p id="tagline"><?php echo get_bloginfo('description'); ?></p><?php } ?>
	</div>
	
	<div id="navigation">
		<ul id="nav-1">
			<li><a title="Return to front page" href="<?php echo get_settings('home'); ?>">Home</a></li>
			<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
		</ul>

		<ul id="nav-2">
			<li><a class="feed" title="Subscribe to the <?php bloginfo('name'); ?> feed" href="<?php echo get_bloginfo_rss('rss2_url'); ?>">Subscribe to feed</a></li>
		</ul>
	</div>

</div>

<div id="content">
