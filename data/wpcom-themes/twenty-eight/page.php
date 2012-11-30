<?php get_header(); ?>
<div class="content">
	<div class="primary">
		<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
			<div class="item">
				<div class="pagetitle">
					<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php the_title(); ?>'><?php the_title(); ?></a></h2>
					<?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="Edit Link" />', '<span class="editlink">', '</span>'); ?>
				</div>
				<div class="itemtext">
					<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?><?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				</div>
			</div>
		<?php } ?>
		<?php } else { $notfound = '1'; ?>
		<h2>Not Found</h2>
		<div class="item">
			<div class="itemtext">
				<p>Oh no! You're looking for something which just isn't here.</p>
			</div>
		</div>
		<?php } ?>
		<?php comments_template(); ?>
	</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
