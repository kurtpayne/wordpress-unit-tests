<?php get_header(); ?>

	<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="postwrapper wideposts" id="post-<?php the_ID(); ?>">
			<div class="title">
				<small><?php printf(__('Posted by: %s'), '<strong>'.get_the_author().'</strong>'); ?> | <?php the_time(get_option('date_format')) ?> <?php edit_post_link(__('(edit)')); ?></small>
				<h2><?php the_title(); ?></h2>
			</div>
			<div <?php post_class(); ?>>
				<div class="entry">
			      		<?php the_content(''); ?>
					<?php wp_link_pages('<p class="pages">'.__('Pages:').' ', '</p>', '', '', '', ''); ?>
		        	</div>
			    	<div class="postinfo">
					<p><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?><?php the_tags(' | '.__('Tags:').' ', ', '); ?></p>
			  	</div>
			</div>
			<div class="navigation">
				<div class="alignleft"><?php previous_post_link(__('&laquo; %link')) ?></div>
				<div class="alignright"><?php next_post_link(__('%link &raquo;')) ?></div>
			</div>
			<br style="clear:both" />
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<div class="title">
		<h2><?php _e('Not Found'); ?></h2>
		</div>
		<div <?php post_class(); ?>>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>
<?php endif; ?>
	
	<div class="title">
		<h2><?php _e('Categories'); ?></h2>
	</div>
	<div <?php post_class(); ?>>
	  <ul class="catlist">
        <?php wp_list_categories('title_li='); ?>	
	  </ul>
	</div>
	
  </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
