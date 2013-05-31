<?php get_header(); ?>
	<?php if (have_posts()) : ?>
 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'depo-square'), single_cat_title('', false)); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'depo-square'), single_tag_title('', false) ); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page', 'depo-square'), get_the_time(__('F jS, Y', 'depo-square'))); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page', 'depo-square'), get_the_time(__('F, Y', 'depo-square'))); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page', 'depo-square'), get_the_time(__('Y', 'depo-square'))); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive', 'depo-square'); ?></h2>
 	  <?php /* If this is a paged archive */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results', 'depo-square'); ?></h2>
 	  <?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<?php 
			if( depo_post_category() == 'type-photo') { 
				include 'type-photo.php'; 
			} elseif( depo_post_category() == 'type-quote') {
				include 'type-quote.php';
			} else { ?>
			<div <?php post_class(depo_post_category()) ?> id="post-<?php the_ID(); ?>">
				<?php before_post(); ?>
				<p class="category"><?php depo_post_category_html(); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'depo-square'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				
				
				<p class="meta"><?php edit_post_link(__('Edit', 'depo-square'), '', ''); ?></p>

				<div class="entry">
					<?php if(is_attachment() ) : ?>
						<p class="attachment aligncenter"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></p>
                <div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link() ?></div>
					<div class="alignright"><?php next_image_link() ?></div>
				</div>
				<?php else: ?>
					<?php the_content(__('Read More &raquo;', 'depo-square')); ?>
					<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php endif; ?>
				</div>

				<div class="endbuttski">

				<p class="comment-status"><?php comments_popup_link(__('Leave a Comment ', 'depo-square'), __('1 Comment', 'depo-square'), __('% Comments', 'depo-square')); ?></p>
				</div>
				<?php comments_template(); ?>
				<?php after_post(); ?>
			</div>
			<?php }?>
		<?php endwhile; ?>
			
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'depo-square')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'depo-square')) ?></div>
		</div>
		<?php if( !is_home() && !is_front_page() ): ?><div class="navigation_to_home"><a href="<?php bloginfo('wpurl'); ?>"><?php _e('&laquo Back to Home'); ?></div><?php endif; ?>

	<?php else : ?>
		<div class="post">
		<h2 class="center"><?php _e('Not Found', 'depo-square'); ?></h2>
		<div class="entry">
		<br />
		<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'depo-square'); ?></p>
		</div>
		</div>
	<?php endif; ?>
	
<?php get_footer(); ?>
