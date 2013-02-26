<?php get_header(); ?>
<div class="home fix">
  <div class="left">
    <?php $top_query = new WP_Query('showposts=1'); ?>
    <?php while($top_query->have_posts()) : $top_query->the_post(); $first_post = $post->ID; ?>
    	<div class="post" id="post-<?php the_ID(); ?>">
    	  <div class="main-post-bg">
    	    <p class="post-comments"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></p>
    	    <?php $image = get_post_meta($post->ID, 'lead_image', true); ?>
    	    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img width="593" src="<?php echo $image; ?>" alt="" /></a>
    	    <div class="title-insert">
    		    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
    		  </div>
    		</div>
      </div>
    <?php endwhile; ?>
    <div class="recent-leads fix">
      <?php query_posts('showposts=9'); ?>
  		<?php while(have_posts()) : the_post(); if(!($first_post == $post->ID)) : ?>
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
  		<?php endif; endwhile; ?>
  	</div>
  </div>
  <div class="right">
    <?php include (TEMPLATEPATH . '/sidebar.php'); ?>
  </div>
</div>
<?php include (TEMPLATEPATH . '/show_categories.php'); ?>
<?php get_footer(); ?>