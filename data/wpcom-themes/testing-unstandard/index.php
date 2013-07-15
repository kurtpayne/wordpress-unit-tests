<?php get_header(); ?>
<div class="home fix">
  <div class="left">
    <div class="recent-leads fix">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  			<div class="post" id="post-<?php the_ID(); ?>">
  			  <div class="secondary-post-bg left">
  			    <p class="post-comments"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></p>
  			    <?php $image = get_post_meta($post->ID, 'secondary_image', true); ?>
      	    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php echo $image; ?>" alt="" /></a>
  			    <div class="title-insert">
  				    <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></h3>
  				  </div>
  				</div>
  			</div>
  		  <?php endwhile; ?>
  		  <div class="entry navigation fix">
  		    <br class="clear" />
    			<p align="left"><?php next_posts_link('next'); ?> <?php previous_posts_link('previous'); ?></p>
    		</div>
  		  <?php else : ?>
  		  <div class="post single">
    			<h2>No matching results</h2>
    			<div class="entry">
    				<p>You seem to have found a mis-linked page or search query with no associated or related results.</p>
    			</div>
    		</div>
  		<?php endif; ?>
  	</div>
  </div>
  <div class="right">
    <?php include (TEMPLATEPATH . '/sidebar.php'); ?>
  </div>
</div>
<?php include (TEMPLATEPATH . '/show_categories.php'); ?>
<?php get_footer(); ?>