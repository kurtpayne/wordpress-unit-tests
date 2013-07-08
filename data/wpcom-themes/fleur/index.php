<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>		
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
	?>
</head>
<body>
<div id="rap">
	<div id="header"><h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1></div>
	<div id="main">
		<div id="content">
			<?php if ($posts) : foreach ($posts as $post) : the_post(); ?>			
				<?php require('post.php'); ?>
			<?php endforeach; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		<p align="center"><?php posts_nav_link() ?></p>		
	</div></div>
<div id="sidebar">
<?php get_sidebar(); ?>	
</div>

<p id="footer">
Theme: Fleur De Lys by <a href="http://www.simpleinside.com/" rel="designer">Sadish Balasubramanian</a>. <a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
</p>
</p>
</div>
<?php wp_footer(); ?>


</body>
</html>
