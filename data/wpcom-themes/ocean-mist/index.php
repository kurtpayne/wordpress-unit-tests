<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
			
			<div class="postwrapper wideposts" id="post-<?php the_ID(); ?>">
			
			  <div class="title">
				<small><?php printf(__('Posted by: %s'), '<strong>'.get_the_author().'</strong>'); ?> | <?php the_time(get_option('date_format')) ?> <?php edit_post_link(__('(edit)')); ?></small>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			  </div>
			  <div <?php post_class(); ?>>
			    <div class="entry">
			      <?php the_content(__('Read More...')); ?>
		        </div>
			    <div class="postinfo">
			      <p class="com"><?php comments_popup_link(__('Leave a Comment'), __('1 Comment'), __('% Comments')); ?></p>
				  <p><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> <?php the_tags(' | '.__('Tags: '), ', '); ?></p>
			    </div>
			</div>
			
			  </div>
		
	
		<?php endwhile; ?>
		<p align="center"><?php posts_nav_link(' - ',__('&#171; Newer Posts'), __('Older Posts &#187;')) ?></p>
	<?php else : ?>

		<div class="title">
		<h2><?php _e('Not Found'); ?></h2>
		</div>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
	
	<div class="title">
		<h2><?php _e('Categories'); ?></h2>
	</div>
	<div <?php post_class(); ?>>
		<div class="sleeve">
	  <ul class="catlist">
        <?php wp_list_categories('title_li='); ?>	
	  </ul>
	</div>
	</div>
  </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
