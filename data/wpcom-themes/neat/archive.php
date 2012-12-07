<?php get_header(); ?>
<?php is_tag(); ?>

	<div id="content">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category'), single_cat_title('', false)); ?></h2>

	<?php /* If this is a tag archive */ } elseif (is_tag()) { ?>
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;'), single_tag_title('', false) ); ?></h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page'), get_the_time(__('F jS, Y'))); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page'), get_the_time(__('F, Y'))); ?></h2>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page'), get_the_time(__('Y'))); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
	  <h2 class="pagetitle"><?php _e('Search Results'); ?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive'); ?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives'); ?></h2>

		<?php } ?>


		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer Entries')); ?></div>
			<div class="alignright"><?php next_posts_link(__('Older Entries &raquo;')) ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?>>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/<?php echo 'rtl' == get_bloginfo( 'text_direction' ) ? 'h1-rtl.gif' : 'h1.gif'; ?>" class="lefth2img" alt="h1" /><h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option('date_format')) ?></small>
				
				<div class="entry">
					<?php the_content(_('Read the rest of this entry ?')); ?>
				</div>
		
				<p class="postmetadata"><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> <strong>|</strong> <?php the_tags( __('Tagged').' ', ', ', ' <strong>|</strong> '); ?><?php edit_post_link(__('Edit'),'','<strong>|</strong>'); ?>  <?php comments_popup_link(__('Leave a Comment &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p> 

			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer Entries')); ?></div>
			<div class="alignright"><?php next_posts_link(__('Older Entries &raquo;')) ?></div>
		</div>
	
	<?php else : ?>

	<h2 class="center"><?php _e('Not Found.'); ?></h2>
		&nbsp;<?php _e('Search something maybe?'); ?> <?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
