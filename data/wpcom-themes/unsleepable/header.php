<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
 	<meta name="description" content="<?php bloginfo('description'); ?>" />
 
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" />
	<![endif]-->
	<!--[if IE 6]>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie6.css" type="text/css" media="screen" />
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<?php if (is_single() or is_page()) { ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php } ?>
	
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>

</head>

<body>

<div id="page">

	<div id="header">
		<div class="top">
			<div id="title">
				<a href="<?php echo get_settings('home'); ?>" title="Back to the front page"><?php bloginfo('name'); ?></a>
			</div>
		
			<ul id="menu">
				<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
			</ul>
                
		</div>
	</div>

	<hr />
