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
		<em><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a></em> &raquo; <?php the_title(); ?>
	</h2>
	<p class="post-info">
		<?php edit_post_link(); ?>
	</p>
	<div class="post-content">
		<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
		<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
		<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

		<div class="navigation">
			<div class="alignleft"><?php previous_image_link() ?></div>
			<div class="alignright"><?php next_image_link() ?></div>
		</div>

		<div class="post-footer">&nbsp;</div>
	</div>
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
