<?php get_header(); ?>

	<div id="content" class="sanda">

		<?php if (have_posts()) : ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			
			<?php /* If this is a category archive */ if (is_category()) { ?>				
				<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
	
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
			
			<?php /* If this is a search */ } elseif (is_search()) { ?>
				<h2 class="pagetitle">Search Results for '<?php echo $s; ?>'</h2>
			
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
				<h2 class="pagetitle">Author Archive</h2>
	
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2 class="pagetitle">Blog Archives</h2>
	
			<?php } ?>
	
	
				<?php while (have_posts()) : the_post(); ?>
				
					<div <?php post_class(); ?>>
				
						<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a><br />
						<?php the_time(get_option('date_format')) ?></h3>
		
						<div class="entry">
							<?php the_excerpt() ?>
						</div>
				
						<p class="postmetadata">Posted in <?php the_category(', ') ?> | <?php the_tags( __( 'Tagged' ) . ': ', ', ', ' | '); ?> <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Leave a Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p> 
		
					</div>
			
				<?php endwhile; ?>
	
	
			<?php 
			
				// This young snippet fixes the problem of a grey navigation bar
				// when there is nothing to fill it, a bit pointless having it sitting
				// there all empty and unfufilled
				
				$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
				$perpage = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'posts_per_page'");
	
				if ($numposts > $perpage) {
				
			?>
					
					<div class="navigation">
						<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
						<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
					</div>
					
			<?php }	?>
	
		<?php else : ?>

			<h2>No Data Found</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>

		<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
