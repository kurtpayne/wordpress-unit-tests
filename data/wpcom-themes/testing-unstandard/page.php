<?php get_header(); ?>
<div class="home fix">
  <div class="left">
    <div class="recent-leads fix">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  			<div class="post single fix" id="post-<?php the_ID(); ?>">
  			  <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></h2>
  			  <div class="meta">
  			    <?php edit_post_link(' (edit this)', '', ''); ?>
  			  </div>
  			  <div class="entry">
  					<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
  				</div>
  			</div>
  		<?php endwhile; else : ?>
  		<?php endif; ?>
  	</div>
  </div>
  <div class="right">
    <?php include (TEMPLATEPATH . '/sidebar.php'); ?>
  </div>
</div>
<?php include (TEMPLATEPATH . '/show_categories.php'); ?>
<?php get_footer(); ?>