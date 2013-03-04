  <?php get_header(); ?>
  
    <div id="content">
    
      <div id="left">
            
        <?php if (have_posts()) : ?>
        
          <?php while (have_posts()) : the_post(); ?>
              
              <div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
            
                <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                
                <?php the_content(__('Read more &raquo;','andreas04')); ?>
                
                <p class="meta">

                <span class="date"><?php $arc_year = get_the_time('Y'); $arc_month = get_the_time('m'); $arc_day = get_the_time('d'); ?><a href="<?php echo get_day_link("$arc_year", "$arc_month", "$arc_day"); ?>"><?php the_time(get_option("date_format")); ?></a> <!-- at <?php the_time()  ?> --></span>                                    

								<span class="postedby">
                  <?php _e('Posted by','andreas04'); ?>                
               	  <?php the_author_posts_link(); ?> | 
                  <?php the_category(', '); ?> |
				  <?php the_tags( '', ', ', ''); ?> |
                  <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments Yet','andreas04'), __('1 Comment','andreas04'), __('% Comments','andreas04')); ?></a>
                  <?php edit_post_link(__('Edit','andreas04'),'<span class="editlink"> | ','</span>'); ?>
								</span>                  

             	</p>
              
             </div>
                
              <?php comments_template(); ?>
              
          
          <?php endwhile; ?>
      
        
        <?php else : ?>
      
        <?php endif; ?>

		<div class="bottomnavigation">

			<p><?php next_posts_link(__('&laquo; Previous Entries','andreas04')) ?> &nbsp;&nbsp;&nbsp; <?php previous_posts_link(__('Next Entries &raquo;','andreas04')) ?></p>

		</div>

      </div>

      <?php get_sidebar(); ?>

      <?php get_footer(); ?>
