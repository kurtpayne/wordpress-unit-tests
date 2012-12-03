
<?php get_header(); ?>

		<?php get_sidebar(); ?>

	<div id="content" class="narrowcolumn" style="margin:0px; ">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_post('&laquo; %','','yes') ?></div>
			<div class="alignright"><?php next_post(' % &raquo;','','yes') ?></div>
		</div>

		<div <?php post_class(); ?>>
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','whiteasmilk'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<small><?php the_time(get_option('date_format')) ?> <!-- by <?php the_author() ?> --></small>
	
			<div class="entry">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;','whiteasmilk').'</p>'); ?>
	
				<?php link_pages(__('<p><strong>Pages:</strong> ','whiteasmilk'), '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php _e('This entry was posted on','whiteasmilk'); ?>
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?> 
						<?php the_time(get_option('date_format')) ?> <?php _e('at','whiteasmilk'); ?> <?php the_time() ?>
						<?php _e('and is filed under','whiteasmilk'); ?> <?php the_category(', ') ?>.
						 
						<?php  edit_post_link(__('Edit this entry.','whiteasmilk'),'',''); ?>

						<br />
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.','whiteasmilk'); ?></p>
	
<?php endif; ?>

	</div>

<?php get_footer(); ?>
