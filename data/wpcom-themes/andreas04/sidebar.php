

<div id="right">
<?php query_posts('pagename=about'); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="sidebar-about">
<h2><?php the_title(); ?> <?php edit_post_link(__('Edit','andreas04'), '<small>(', ')</small>'); ?></h2>
<?php the_content(); ?>
</div>
<?php endwhile; ?>
<?php endif; ?>

<div class="subcontainer">
  <ul class="rightsub">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
   <li>
    <h2><?php _e('Recent','andreas04'); ?></h2>
    <ul>
      <?php get_archives('postbypost','12','custom','<li>','</li>'); ?>
    </ul>
   </li>
   <li>
    <h2><?php _e('Links','andreas04'); ?></h2>
    <ul>
      <?php get_links('-1', '<li>', '</li>', '', FALSE, 'id', FALSE, FALSE, -1, FALSE, TRUE); ?>
    </ul>
   </li>
<?php endif; ?>
  </ul>
    
  <ul class="rightsub2">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
   <li>
    <h2><?php _e('Archives','andreas04'); ?></h2>
    <ul>
      <?php get_archives('monthly', '12', 'html', '', '', TRUE); ?>
    </ul>
   </li>
   <li>
    <h2><?php _e('Categories','andreas04'); ?></h2>
    <ul class="sellLi">
      <?php wp_list_cats(''); ?>
    </ul>
   </li>
   <li>
    <h2>RSS</h2>
      <a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries RSS','andreas04'); ?></a><br />
      <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments RSS','andreas04'); ?></a>
   </li>
<?php endif; ?>
  </ul>
</div>
</div>
