<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php if ( is_single() ) { ?> Blog Archive &laquo; <?php } ?><?php bloginfo('name'); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_enqueue_script('jquery'); ?>
<?php wp_head(); ?>

<!--[if IE]>
<style type="text/css"> 
	body { font-size:12px; } 
</style>
<![endif]-->
<script type="text/javascript" charset="utf-8">
	/* <![CDATA[ */
	jQuery(document).ready(function($){
		$('#sidebar > ul > li').css('display', 'none');
		$('#sidebar > ul > *:lt(3)').css('display', 'block');
	});
	/* ]]> */
</script>
</head>
<body<?php image_orientation(); ?>>

<div id="page">

<div id="header">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
		
		<ul id="menu">
			<li><a href="<?php bloginfo('url'); ?>/<?php echo mysql2date('Y', get_lastpostdate('blog')); ?>/">archive</a></li>

			<?php wp_list_pages('title_li=' ); ?>

		</ul>
</div>

<div id="content">
	<div class="sleeve">
