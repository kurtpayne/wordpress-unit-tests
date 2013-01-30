<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
get_header();
?>
<div id="filler" class="fix">
	<div id="mainColumn">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="postMeta">
				<p class="container">
					<span class="date"><?php the_date(); ?> &bull; <?php the_time(); ?></span>
					<span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span>
				</p>
			</div>
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></h2>
			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				<?php wp_link_pages(); ?>
				<p><?php _e('Filed under: '); the_category(', '); echo ' '; the_tags(', ',', ',''); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
		<?php else : ?>
		<div class="post">
			<div class="postMeta">
				<p class="container">
					<span class="date">No Matches</span>
				</p>
			</div>
			<h2>No matching results</h2>
			<div class="entry">
				<p>You seem to have found a mis-linked page or search query with no matching results. Please trying your search again. If you feel that you should be staring at something a little more concrete, feel free to email the author of this site or browse the archives.</p>
			</div>
		</div>
		<?php endif; ?>
		<div id="paginateIndex" class="fix">
			<p><span class="left"><?php previous_posts_link('&laquo; Previous') ?></span> <span class="right"><?php next_posts_link('Next &raquo;') ?></span></p>
		</div>
	</div>
	<?php include (TEMPLATEPATH . '/second.column.index.php'); ?>
	<?php include (TEMPLATEPATH . '/third.column.shared.php'); ?>
</div>
<?php get_footer(); ?>