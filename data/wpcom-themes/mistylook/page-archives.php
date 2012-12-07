<?php
/*
Template Name: Archives
*/
?>
<?php get_header();?>
<div id="content">
<div id="content-main">
<div <?php post_class(); ?>>
				<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<p class="post-info"><?php edit_post_link(); ?></p>
				<div class="entry">
				<h2><?php _e('by Categories','mistylook'); ?></h2>
					<ul>
						<?php wp_list_cats('optioncount=1');    ?>
					</ul>						
					<h2><?php _e('by Month','mistylook'); ?></h2>
					<ul><?php wp_get_archives('type=monthly'); ?></ul>
					<h2><?php _e('Last 50 Posts','mistylook'); ?></h2>
					<ul>
					<?php $posts = query_posts('showposts=50');?>			
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li><h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h4></li>
					<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.','mistylook'); ?></p>
					<?php endif; ?>		
					</ul>					
				</div>
			</div>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
