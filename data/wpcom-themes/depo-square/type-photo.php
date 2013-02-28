			<div <?php post_class(depo_post_category()) ?> id="post-<?php the_ID(); ?>">
				<?php before_post(); ?>
				<p class="category"><?php depo_post_category_html(); ?></p>
				<div class="entry">
					<?php the_content(__('Read More &raquo;', 'depo-squared')); ?>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'depo-squared'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2> <p class="meta"><?php the_tags(__('Tagged:', 'depo-squared') . ' ', ', ', ''); ?> on <?php the_time(get_option('date_format')) ?> <?php _e('by'); ?> <?php the_author() ?> <?php edit_post_link(__('Edit', 'depo-squared'), '', ''); ?></p>
					<p class="comment-status"><?php comments_popup_link(__('Leave a Comment ', 'depo-squared'), __('1 Comment', 'depo-squared'), __('% Comments', 'depo-squared')); ?></p>
				</div>
				<?php after_post(); ?>
			</div>
			<?php comments_template(); ?>
