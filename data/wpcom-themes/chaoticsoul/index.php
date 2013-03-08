<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<?php while(have_posts()) : the_post() ?>	
		
			<div class="post lastfive" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				&bull;<?php the_time(get_option("date_format")); ?>  &bull; <?php comments_popup_link(__('Leave a Comment', 'chaoticsoul'), __('1 Comment', 'chaoticsoul'), __('% Comments', 'chaoticsoul')); ?> <?php edit_post_link(__('Edit', 'chaoticsoul'), '(', ')'); ?>

				<div class="entry">
					<?php the_content("<span class=\"continue\">" . __('Continue reading', 'chaoticsoul') . " '" . the_title('', '', false) . "'</span>"); ?>

					<p class="postmetadata"><?php printf(__('Posted in %s', 'chaoticsoul'), get_the_category_list(', ')); ?>
						<?php the_tags('<br />' .  __( 'Tags' ) . ': ', ', ', '');  ?>
					</p>
				</div>
			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'chaoticsoul'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'chaoticsoul'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	<div class="navigation">
	<?php $_SERVER['REQUEST_URI']  = preg_replace("/(.*?).php(.*?)&(.*?)&(.*?)&_=/","$2$3",$_SERVER['REQUEST_URI']); ?>
		<div class="left"><?php next_posts_link('<span>&laquo;</span> '.__('Previous Entries', 'chaoticsoul').''); ?></div>
		<div class="right"><?php previous_posts_link(''.__('Next Entries', 'chaoticsoul').' <span>&raquo;</span>'); ?></div>
		<div class="clear"></div>
	</div>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
