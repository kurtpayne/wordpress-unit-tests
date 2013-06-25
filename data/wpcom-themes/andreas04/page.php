<?php get_header(); ?>
  
    <div id="content">
    
      <div id="left">
            
        <?php if (have_posts()) : ?>
        
          <?php while (have_posts()) : the_post(); ?>
              
              <div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
            
                <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                
                <?php the_content(''); ?>
		<?php wp_link_pages(); ?>
              </div>
              
          <?php comments_template(); ?>
          <?php endwhile; ?>
      
        
        <?php else : ?>
      
        <?php endif; ?>
  
      </div>

      <?php get_sidebar(); ?>

      <?php get_footer(); ?>

    </div>
  
  </div>
</body>
</html>
