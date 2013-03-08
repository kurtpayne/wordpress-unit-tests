<?php get_header(); ?>
<?php is_tag(); ?>

	<?php if (have_posts()) : ?>
	
		<?php while (have_posts()) : the_post(); ?>
<div <?php post_class(); ?>>
<div class="heading">{<?php the_time(get_option('date_format')) ?>} &nbsp;  <span id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','girl'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></span></div>

<div class="entry">
<?php the_content(__('Read the rest of this entry &raquo;','girl')); ?>
<?php wp_link_pages(); ?>
</div>

<div class="footer"><?php the_author() ?> @  <?php the_time(); ?>  [<?php _e('filed under','girl'); ?> <?php the_category(', ') ?> <?php if (is_callable('the_tags')) the_tags(__('tagged ','girl'), ', '); ?> <?php edit_post_link(__('Edit?','girl'),' (',')'); ?> 
<?php comments_popup_link(__('Leave a Comment &#187;','girl'),__('1 Comment &#187;','girl'),__('% Comments &#187;','girl')); ?> </div>
</div>

<br />
<br />

			<?php comments_template(); ?>

		<?php endwhile; ?>
		
		
		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries','girl')) ?></div>
			<div class="alignright"><?php posts_nav_link('',__('Next Entries &raquo;','girl'),'') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','girl'); ?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.","girl"); ?></p>
		
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
