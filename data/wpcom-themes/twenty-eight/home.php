<?php get_header(); ?>
<div class="content">
	<div class="primary">
		<?php while (have_posts()) { the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('item entry'); ?>>
			<div class="itemhead">
				<h3><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php strip_tags(the_title()); ?>'><?php the_title(); ?></a></h3>
				<?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="Edit Link" />','<span class="editlink">','</span>'); ?>
				<p class="metadata"><?php the_time(get_option('date_format')) ?> in <?php { the_category(', '); }?><?php if ( (is_home()) && !(is_page()) && !(is_single()) && !(is_search()) && !(is_archive()) && !(is_author()) && !(is_category()) && !(is_paged()) OR is_search() ) { ?>&nbsp;with&nbsp;<?php comments_popup_link('Leave a <span>Comment</span>', '1&nbsp;<span>Comment</span>', '%&nbsp;<span>Comments</span>', 'commentslink', '<span class="commentslink">Closed</span>'); ?><?php } ?><?php the_tags('<br />Tags: ', ', ', '<br />'); ?></p>
			</div>

			<div class="itemtext">
				<?php if (is_archive() or is_search()) { 
					the_excerpt();
				} else {
					the_content("Continue Reading &raquo;");
				} ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>

		</div>
		<?php } ?>
		<p align="center"><?php posts_nav_link() ?></p>	
	</div> <!-- close primary -->
	<?php get_sidebar(); ?>
</div> <!-- close content -->
	<?php get_footer(); ?>
