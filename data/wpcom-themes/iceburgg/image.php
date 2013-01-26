<?php 

get_header();

?>

<div id="maincontent">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div <?php post_class(); ?>>
    <h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
    <div style="clear: both"></div>
    <div class="pb"><b class="postbitmed"> <b class="postbitmed1"><b></b></b> <b class="postbitmed2"><b></b></b> <b class="postbitmed3"></b> <b class="postbitmed4"></b> <b class="postbitmed5"></b> </b>
      <div class="postbitmed_content">
	<p><?php edit_post_link(__('Edit'), '<br />', ''); ?></p>
        <p><img src="<?php bloginfo('template_directory'); ?>/imgs/comments.gif" alt="Comments Dropped" /> <a href="<?php comments_link(); ?>">
          <?php comments_number('leave a response','one response','% responses'); ?>
          </a></p>
      </div>
      <b class="postbitmed"> <b class="postbitmed5"></b> <b class="postbitmed4"></b> <b class="postbitmed3"></b> <b class="postbitmed2"><b></b></b> <b class="postbitmed1"><b></b></b> </b></div>
    <div class="words">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
    </div>
    <div style="clear: both"></div>
    <?php endwhile; else: ?>
    <p>
      <?php _e('Sorry, no posts matched your criteria.'); ?>
    </p>
    <?php endif; ?>
    <?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
    <div style="clear: both"></div>
    <div id="cprespace"></div>
    <div style="clear: both"></div>
    <?php comments_template(); ?>
    <div style="clear: both"></div>
  </div>
  <div style="clear: both"></div>
</div>
<?php get_footer(); ?>
