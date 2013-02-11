<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>		
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	wp_enqueue_script( 'comment-reply' );
	wp_head(); 
	?>	
</head>
<body>
<div id="rap">
	<div id="header"><h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1></div>
	<div id="main">
		<div id="content">
			<?php if ($posts) : foreach ($posts as $post) : the_post(); ?>			
				<div <?php post_class(); ?>>
	<h2 class="post-title">
		<em><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></em>
		<?php the_time('l, M j Y'); ?>&nbsp;</h2>
	<p class="post-info">
		<span class="pcat"><?php the_category(' and ') ?></span>
		<?php the_tags( '<span class="pcat">', ', ', '</span>'); ?>
		<span class="pauthor"><?php the_author() ?></span>
		<span class="ptime"><?php the_time();?></span><?php edit_post_link(); ?>
	</p>
	<div class="post-content">
		<?php the_content(); ?>
		<div class="post-footer">&nbsp;</div>
	</div>
	<p class="post-info"><a href="<?php trackback_url(display); ?> ">Trackback URI</a></a>
	<?php comments_template(); ?>
</div>
			<?php endforeach; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
	</div></div>
	<div id="sidebar">
		<?php get_sidebar(); ?>	
	</div>

<p id="footer">
<a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a>
</p>

</p>
</div>
<?php do_action('wp_footer'); ?>
</body>
</html>
