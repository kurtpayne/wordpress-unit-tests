<?php get_header(); ?>

<!-- content ................................. -->
<div id="content" class="archive">

<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2>Posts filed under '<?php echo single_cat_title(); ?>'</h2>

	<?php } elseif (is_tag()) { ?>
	<h2><?php _e('Posts Tagged '); single_tag_title(); ?></h2>
		

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2>Archive for <?php echo date_i18n(__('F jS, Y', 'connections'), get_the_time('U')); ?></h2>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2>Archive for <?php echo date_i18n(__('F, Y', 'connections'), get_the_time('U')); ?></h2>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time('Y'); ?></h2>

	<?php /* If this is a search */ } elseif (is_search()) { ?>
	<h2>Search Results</h2>

	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2>Author Archive</h2>

	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>

<?php } ?>

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

		<?php ($post->post_excerpt != "")? the_excerpt() : BX_shift_down_headlines(the_content()); ?>

		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink() ?>" class="more">Continue Reading</a><?php } ?>
   		<?php comments_popup_link('Add comment', '1 comment', '% comments', 'commentlink', ''); ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<!--<em class="author"><?php the_author(); ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
   		</p>

	</div>


<?php endwhile; ?>

	<p><!-- this is ugly -->
	<span class="next"><?php previous_posts_link('Next Posts') ?></span>
	<span class="previous"><?php next_posts_link('Previous Posts') ?></span>
	</p>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
