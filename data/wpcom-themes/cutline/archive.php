<?php get_header(); ?>
		
	<div id="content_box">

		<div id="content" class="posts">
	
		<?php if (have_posts()) : ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h2 class="archive_head"><?php printf(__('Entries categorized as &#8216;%s&#8217;','cutline'), single_cat_title('', false)); ?></h2>

			<?php } elseif (is_tag()) { ?>
			<h2 class="archive_head"><?php printf(__('Entries tagged as &#8216;%s&#8217;','cutline'), single_tag_title('', false)); ?></h2>
		
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="archive_head"><?php printf(__('Entries from %s','cutline'), get_the_time('F Y')); ?></h2>
			
			<?php /* If this is a search */ } elseif (is_search()) { ?>
			<h2 class="archive_head"><?php _e('Search Results','cutline'); ?></h2>

			<?php } ?>

			<?php while (have_posts()) : the_post(); ?>
			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','cutline'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(get_option('date_format')) ?><!-- by <?php the_author() ?> --> &middot; <?php comments_popup_link(__('Leave a Comment','cutline'), __('1 Comment','cutline'), __('% Comments','cutline')); ?></h4>
			<div class="entry">
				<?php the_content() ?>
			</div>
			<p class="tagged"><strong><?php _e('Categories:','cutline'); ?></strong> <?php the_category(' &middot; ') ?> <?php the_tags( '<br /><strong>' . __( 'Tagged:','cutline' ) . '</strong> ', ', ', ''); ?></p>

			</div>
			
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>

		<?php else : ?>
		
			<h2 class="page_header"><?php _e('Welp, we couldn\'t find that... try again?','cutline'); ?></h2>
			<div class="entry">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
			
		</div>
	
		<?php get_sidebar(); ?>
		
	</div>
		
<?php get_footer(); ?>
