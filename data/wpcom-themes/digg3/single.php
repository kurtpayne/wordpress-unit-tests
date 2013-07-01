<?php get_header(); ?>

	<div class="wrapper"><!-- This wrapper class appears only on Page and Single Post pages. -->
	<div class="narrowcolumnwrapper"><div class="narrowcolumn">

		<div class="content">

			<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

				<div class="postinfo">
<?php printf(__('Posted on %s by %s'), '<span class="postdate">'.get_the_time(get_option('date_format')).'</span>', get_the_author()); ?>	
<?php edit_post_link(__('Edit', 'digg3'), ' &#124; ', ''); ?>
				</div>

				<div class="entry">

					<?php the_content(); ?>
					<?php link_pages('<p><strong>' . __('Pages', 'digg3') . ':</strong> ', '</p>', 'number'); ?>

					<p class="postinfo">
				<?php _e('Filed under&#58;', 'digg3'); ?> <?php the_category(', ') ?> <?php the_tags( '&#124; ' . __( 'Tagged:' , 'digg3') . ' ', ', ', ''); ?>
					</p>

				</div>
			</div>

<?php endwhile; ?>

<?php include (TEMPLATEPATH . '/browse.php'); ?>

<?php else : ?>

			<div <?php post_class(); ?>>

				<h2><?php _e('Not Found', 'digg3'); ?></h2>

				<div class="entry">
<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'digg3'); ?></p>
				</div>

			</div>

<?php endif; ?>

		</div><!-- End content -->

	</div></div><!-- End narrowcolumnwrapper and narrowcolumn classes -->

	<?php comments_template(); ?>

	</div><!-- End wrapper class -->

<?php get_footer(); ?>
