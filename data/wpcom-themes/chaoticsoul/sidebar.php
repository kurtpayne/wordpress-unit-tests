	<div id="sidebar">
	
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
	
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		
		<?php if (is_single()) { ?>
			
			<h3><?php _e('About This Post','chaoticsoul'); ?></h3>
			<p class="postmetadata alt">
				<small>
				<?php
						printf(__('This entry was posted on %s at %s and is filed under %s.', 'chaoticsoul'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format')), get_the_category_list(', ')); 
						printf(__('You can follow any responses to this entry through the %s feed.', 'chaoticsoul'), '<a href="'.get_post_comments_feed_link().'">RSS 2.0</a>');
						if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open
							printf(__('You can <a href="#respond">leave a response</a>, or <a href="%s" rel="trackback">trackback</a> from your own site.', 'chaoticsoul'), get_trackback_url(true));
						} elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open
							printf(__('Responses are currently closed, but you can <a href="%s" rel="trackback">trackback</a> from your own site.', 'chaoticsoul'), get_trackback_url(true));

						} elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not
							_e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'chaoticsoul');

						} elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open
							_e('Both comments and pings are currently closed.', 'chaoticsoul');

						}
						edit_post_link(__('Edit this entry.', 'chaoticsoul'),'','');
					?>
				</small>
			</p>
			
			<h3><?php _e('Navigate', 'chaoticsoul'); ?></h3>
			
			<ul class="navigation">
				<?php previous_post_link('<li>'.__('Previous:', 'chaoticsoul').'&nbsp;<strong>%link</strong></li>') ?>
				<?php next_post_link('<li>'.__('Next:', 'chaoticsoul').'&nbsp;<strong>%link</strong></li>') ?>
			</ul>	
		
		<?php } else { ?>
						
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You are currently browsing the archives for the %s category.', 'chaoticsoul'), single_cat_title('', false)); ?></p>

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You are currently browsing the %s weblog archives for the day %s.', 'chaoticsoul'), '<a href="'.get_bloginfo('home').'/">'.get_bloginfo('name').'</a>', get_the_time(get_option('date_format')));?></p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You are currently browsing the %s weblog archives for %s.', 'chaoticsoul'), '<a href="'.get_bloginfo('home').'/">'.get_bloginfo('name').'</a>', get_the_time('F, Y'));?></p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You are currently browsing the %s weblog archives for the year %s.', 'chaoticsoul'), '<a href="'.get_bloginfo('home').'/">'.get_bloginfo('name').'</a>', get_the_time('Y'));?></p>

		 <?php /* If this is a search */ } elseif (is_search()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You have searched the %s weblog archives for %s. If you are unable to find anything in these search results, you can try one of these links.', 'chaoticsoul'), '<a href="'.get_bloginfo('home').'/">'.get_bloginfo('name').'</a>', '<strong>'.wp_specialchars($s).'</strong>');?></p>

			<?php /* Paged archive */ } elseif (is_paged()) { ?>
			<h3><?php _e('About This Page'); ?></h3>
			<p><?php printf(__('You are currently browsing the %s weblog archives.', 'chaoticsoul'), '<a href="'.get_bloginfo('home').'/">'.get_bloginfo('name').'</a>');?></p>

			<?php } ?>

			<h3><?php _e('Pages', 'chaoticsoul'); ?></h3>
				<ul>
				<?php wp_list_pages('title_li='); ?>
				</ul>

			<h3><?php _e('Archives', 'chaoticsoul'); ?></h3>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>

			<h3><?php _e('Categories', 'chaoticsoul'); ?></h3>
				<ul>
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
				</ul>
						
		<?php } ?>
	
	<?php endif; ?>
	
	</div>
