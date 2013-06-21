<?php get_header() ?>

<div id="content">

<?php if (have_posts()) : ?>
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'springloaded'), single_cat_title('', false)); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'springloaded'), single_tag_title('', false) ); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page', 'springloaded'), get_the_time(__('F jS, Y', 'springloaded'))); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page', 'springloaded'), get_the_time(__('F, Y', 'springloaded'))); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page', 'springloaded'), get_the_time(__('Y', 'springloaded'))); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive', 'springloaded'); ?></h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives', 'springloaded'); ?></h2>
 	  <?php } ?>

	<?php while (have_posts()) : the_post(); ?>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<p class="post-date" title="<?php printf(__('%1$s at %2$s'), get_the_time(get_option('date_format')), get_the_time(get_option('time_format'))); ?>">
				<span class="date-day"><?php the_time('j') ?></span>
				<span class="date-month"><?php the_time('M') ?></span>
			</p>
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), attribute_escape(get_the_title())); ?>"><?php the_title(); ?></a></h3>
			<p class="metadata">
			<?php printf(__('Posted by %1$s in %2$s.'), get_the_author(), get_the_category_list(', ')); ?>
			<?php the_tags(__('Tagged: ', 'sandbox'), ", ", "."); ?>
			<span class="feedback"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></span><?php edit_post_link('Edit', ' | ', ''); ?></p>
			<div class="entry">
				<?php the_excerpt(); ?>
				<p><a href="<?php the_permalink(); ?>"><span class="more-link"><?php _e('Continue reading &raquo;', 'springloaded') ?></span></p>
			</div>
		</div>

	<?php endwhile; ?>
	
		<div class="prev-next">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;')); ?></div>
		</div>

<?php else : ?>
	<div <?php post_class(); ?>>
		<h2 class="center"><?php _e('Not Found'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	</div>

<?php endif; ?>

</div><!-- /content -->

</div><!-- /main -->

<?php get_sidebar() ?>

<?php get_footer() ?>
