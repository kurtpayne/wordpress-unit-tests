<?php get_header();?>
<div id="content">
<div id="content-main">
<?php is_tag(); ?>
<?php if (have_posts()) : ?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if (is_category()) { ?>
        <h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category','mistylook'), single_cat_title('', false)); ?></h2>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
        <h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;','mistylook'), single_tag_title('', false) ); ?></h2>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
        <h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page','mistylook'), get_the_time(__('F jS, Y'))); ?></h2>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
        <h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page','mistylook'), get_the_time(__('F, Y'))); ?></h2>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
        <h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page','mistylook'), get_the_time(__('Y'))); ?></h2>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
        <h2 class="pagetitle"><?php _e('Author Archive','mistylook'); ?></h2>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <h2 class="pagetitle"><?php _e('Blog Archives','mistylook'); ?></h2>
      <?php } ?>
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
					<p class="post-info"><?php printf(__('Posted in %s on %s','mistylook'), get_the_category_list(', ').get_the_tag_list(', '.__('tagged','mistylook').' ', ', '), get_the_time(get_option("date_format"))); ?> | <?php edit_post_link(__('Edit','mistylook'), '', ' | '); ?>  <?php comments_popup_link(__('Leave a Comment &#187;','mistylook'), __('1 Comment &#187;','mistylook'), __('% Comments &#187;','mistylook')); ?></p>
				</div>
				
				<div class="entry">
					<?php the_excerpt(); ?>
					<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mistylook'), the_title_attribute('echo=0')); ?>"><?php _e('Read Full Post &raquo;','mistylook'); ?></a></p>
				</div>
				<?php comments_template(); ?>
			</div>
	
		<?php endwhile; ?>

		<p align="center"><?php posts_nav_link(' - ', __('&laquo; Newer Posts','mistylook'), __('Older Posts &raquo;','mistylook')) ?></p>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','mistylook'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.','mistylook'); ?></p>
	<?php endif; ?>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
