<?php get_header();?>
<div id="content">
<div id="content-main">
<div <?php post_class(); ?>>
<?php
	global $wp_query;
	$curauth = $wp_query->get_queried_object();
?>
<h2><?php _e('About:','mistylook'); ?> <?php echo $curauth->nickname; ?></h2>
<dl>
<dt><?php _e('Full Name','mistylook'); ?></dt>
<dd><?php echo $curauth->first_name. ' ' . $curauth->last_name ;?></dd>
<dt><?php _e('Website','mistylook'); ?></dt>
<dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
<dt><?php _e('Details','mistylook'); ?></dt>
<dd><?php echo $curauth->description; ?></dd>
</dl>

			<h2><?php printf(__('Posts by %s:','mistylook'), $curauth->nickname); ?></h2>
			<ul class="authorposts">
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<h4>
				<em><?php the_time(get_option("date_format")); ?></em>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>
				</h4>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.','mistylook'); ?></p>

			<?php endif; ?>
			<!-- End Loop -->			
		</ul>
		<p align="center"><?php posts_nav_link(' - ', __('&laquo; Newer Posts','mistylook'), __('Older Posts &raquo;','mistylook')); ?></p>
	</div>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
