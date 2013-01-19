  <?php get_header(); ?>
  
    <div id="content">
    
      <div id="left">
            
        <?php if (have_posts()) : ?>
        
          <?php while (have_posts()) : the_post(); ?>
              
              <div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
            
                <h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

		<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
		<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
		<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

		<div class="navigation">
			<div class="alignleft"><?php previous_image_link() ?></div>
			<div class="alignright"><?php next_image_link() ?></div>
		</div>
                <p class="meta">
			<span class="postedby"><a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments Yet','andreas04'), __('1 Comment','andreas04'), __('% Comments','andreas04')); ?></a></span>
			<?php edit_post_link(__('Edit','andreas04'),'<span class="editlink"> | ','</span>'); ?>
		</p>                  
              </div>
                
              <?php comments_template(); ?>						
          <?php endwhile; ?>
      
        <?php else : ?>
      
        <?php endif; ?>
  
      </div>

      <?php get_sidebar(); ?>

      <?php get_footer(); ?>
