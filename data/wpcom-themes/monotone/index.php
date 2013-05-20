<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php 
		$wp_query->is_single = 1;
	 	if(is_home()) $wp_query->is_single = 0; ?>
		
		<?php if(is_sticky()) { $sticky++; } else { $regular++; ?>
	<div class="image">
		<div class="nav prev"><?php next_post_link('%link','&lsaquo;') ?></div>
		<?php the_image(); ?>
		<div class="nav next"><?php if(is_home()) $wp_query->is_single = 1; previous_post_link('%link','&rsaquo;'); if(is_home()) $wp_query->is_single = 0; ?></div>
	</div>
	<?php partial('post'); ?>
	<?php } ?>
<?php endwhile; else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>

<?php $wp_query->is_single = 1; ?>

<div class="navigation">
	<div class="prev"><?php next_post_link('%link', '&lsaquo' ) ?></div>
	<div class="next"><?php previous_post_link('%link','&rsaquo;') ?></div>
</div>

<?php get_footer(); ?>
