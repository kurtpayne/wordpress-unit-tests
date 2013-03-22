<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

	<meta name="generator" content="WordPress.com" /> <!-- leave this for stats -->

	<style type="text/css" media="screen">
		@import url( <?php bloginfo ('stylesheet_url' ); ?>  );
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
<div id="header">
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<h3 class="description"><?php bloginfo('description'); ?></h3>
</div>


<div id="content">
<?php if (have_posts()) : while ( have_posts()) : the_post(); ?>

	
<div <?php post_class(); ?>>
<h2 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
	
<div class="storycontent">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
</div>
<div class="meta"><?php comments_popup_link(__('Leave a Comment'), __('Comments (1)'), __('Comments (%)')); ?></div>
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/printer.gif" width="102" height="27" class="pmark" alt=" " />

<?php comments_template (); ?> 
</div>

<?php endwhile; ?>

<?php else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>



<div id="menu">

<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
<li id="calendar">
	<?php get_calendar(); ?>
</li> 
<li id="search">
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
<input type="text" name="s" id="s" size="8" /> <input type="submit" name="submit" value="<?php _e('Search'); ?>" id="sub" />
</form>
</li>




<li id="categories"><?php _e('Categories:'); ?>
	<ul>
	<?php wp_list_cats(); ?>
	</ul>
</li>
 


<li id="archives"><?php _e('Archives:'); ?>
 	<ul>
	 <?php wp_get_archives('type=monthly'); ?>
 	</ul>
</li>


<?php wp_list_bookmarks(); ?>
 

<?php endif; ?>
</ul>

</div>

<div id="footer">
<p class="credit">

<cite><a href="http://wordpress.com/" rel="generator">Get a free blog at WordPress.com</a></cite>
| <a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a>
| <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a>
| Theme: <a href="http://www.pikemurdy.com/quentin" rel="designer"><em>Quentin</em></a>.
</p>


</div></div>

<?php do_action('wp_footer'); ?>

</body>
</html>
