<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
<?php is_tag(); ?>
		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle"><?php _e('Archive for the','whiteasmilk'); ?> '<?php echo single_cat_title(); ?>'<?php _e(' Category','whiteasmilk'); ?></h2>

 <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
        <h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','whiteasmilk'); ?> <?php the_time(__('F jS, Y','whiteasmilk')); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','whiteasmilk'); ?> <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for','whiteasmilk'); ?> <?php the_time('Y'); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results','whiteasmilk'); ?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive','whiteasmilk'); ?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives','whiteasmilk'); ?></h2>

		<?php } ?>


		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries','whiteasmilk')) ?></div>
			<div class="alignright"><?php posts_nav_link('',__('Next Entries &raquo;','whiteasmilk'),'') ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','whiteasmilk'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time(get_option('date_format')) ?></small>
				
				<div class="entry">
					<?php the_content(__('Read the rest of this entry &raquo;','whiteasmilk')); ?>
				</div>
		
				<p class="postmetadata"><?php _e('Posted in','whiteasmilk'); ?> <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link(__('Edit','whiteasmilk'),'','<strong>|</strong>'); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','whiteasmilk'),__('1 Comment &#187;','whiteasmilk'),__('% Comments &#187;','whiteasmilk')); ?><br /> <?php the_tags('Tags: ', ', ', '<br />'); ?></p> 

			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries','whiteasmilk')) ?></div>
			<div class="alignright"><?php posts_nav_link('',__('Next Entries &raquo;','whiteasmilk'),'') ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','whiteasmilk'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
