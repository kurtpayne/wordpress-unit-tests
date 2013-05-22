<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php bloginfo('name') ?> RSS 2.0 Feed" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php bloginfo('name') ?> Comments RSS 2.0 Feed" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<link rel="start" href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>" />
<?php sandbox_stylesheets() ?>
<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>

</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper">

	<div id="header">
		<h1 id="blog-title"><a href="<?php echo get_settings('home') ?>/" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a></h1>
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div><!--  #header -->
	
	<?php sandbox_skipnav() ?>

	<?php sandbox_globalnav() ?>
