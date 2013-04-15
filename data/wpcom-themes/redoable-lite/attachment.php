<?php get_header(); ?>

<div class="content">
	
	<div id="primary">
		<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
		<div id="current-content">
		<?php } ?>
			<div id="primarycontent" class="hfeed">

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>

	<?php 
		// This also populates the iconsize for the next line
		$attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); 

		// This lets us style narrow icons specially
		if( get_bloginfo('version') < 2.1 ) {
			$_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment';
		} else {
			$_post = &get_postdata($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment';
		} ?>
		
		
	
				<div id="post-<?php the_ID(); ?>" class="<?php redo_post_class(); ?>">
					<div class="entry-head">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title='<?php printf( __('Permanent Link to "%s"','redo_domain'), wp_specialchars(get_the_title(),1) ); ?>'><?php the_title(); ?></a></h3>

						<small class="entry-meta">
							<span class="chronodata">
							<?php /* Date & Author */

								printf(__('Published %1$s %2$s','redo_domain'),
									sprintf(__('by %s','redo_domain'), '<a href="' . get_author_link(0, $authordata->ID, $authordata->user_nicename) .'">' . get_the_author() . '</a>'),
								(function_exists('time_since') ?
									sprintf(__('%s ago','redo_domain'),
									time_since(abs(strtotime($post->post_date_gmt . " GMT")), time())
								):
								get_the_time(get_option('date_format'))
								)
								);
							?>
							</span>
						</small>
					</div> <!-- .entry-head -->

					<div class="entry-content">
						<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>
						<?php the_content(); ?>
						<?php if( get_bloginfo('version') < 2.1 ) { ?>
							<?php link_pages('<p><strong>'.__('Pages:','redo_domain').'</strong> ', '</p>','number'); ?>
						<?php } else { ?>
							<?php wp_link_pages('before=<p><strong>'.__('Pages:','redo_domain').'</strong>&after=</p>&next_or_number=number')?>
						<?php } ?>
					</div> <!-- .entry-content -->
				</div> <!-- #post-ID -->

				<?php comments_template(); ?>	

	<?php } } else { ?>

				<h2><?php _e('Sorry, no attachments matched your criteria.','redo_domain'); ?></h2>

	<?php } ?>
			</div> <!-- #primarycontent -->
		
		<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
		</div> <!-- #current-content -->
		
		<div id="dynamic-content"></div>
		<?php } ?>

	</div> <!-- #primary -->

	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>

</div> <!-- .content -->

<?php get_footer(); ?>
