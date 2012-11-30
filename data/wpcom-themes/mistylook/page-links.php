<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>
<div id="content">
	<div id="content-main">
			<div <?php post_class(); ?>>
		<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<ul>
						<?php wp_list_bookmarks();?>
					</ul>
				</div>
			</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
