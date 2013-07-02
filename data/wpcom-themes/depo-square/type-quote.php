			<div <?php post_class(depo_post_category()) ?> id="post-<?php the_ID(); ?>">
				<?php before_post(); ?>
				<p class="category"><?php depo_post_category_html(); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'depo-squared'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>

				<div class="entry">
					<?php the_content(__('Read More &raquo;', 'depo-squared')); ?>
				</div>
				<p class="meta"><?php _e('Posted'); ?> <a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')) ?></a> <?php _e('by'); ?> <?php the_author() ?> <?php edit_post_link(__('Edit', 'depo-squared'), '', ''); ?></p>

				<div class="endbuttski">

				<p class="comment-status"><?php comments_popup_link(__('Leave a Comment ', 'depo-squared'), __('1 Comment', 'depo-squared'), __('% Comments', 'depo-squared')); ?></p>
				</div>
				<?php comments_template(); ?>
				<?php after_post(); ?>
			</div>
