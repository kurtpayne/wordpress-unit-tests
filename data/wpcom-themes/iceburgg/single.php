<?php 

get_header();

?>

<div id="maincontent">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div <?php post_class(); ?>>
    <h2><a href="<?php the_permalink() ?>" rel="bookmark">
      <?php the_title(); ?>
      </a></h2>
    <div style="clear: both"></div>
    <div class="pb"><b class="postbitmed"> <b class="postbitmed1"><b></b></b> <b class="postbitmed2"><b></b></b> <b class="postbitmed3"></b> <b class="postbitmed4"></b> <b class="postbitmed5"></b> </b>
      <div class="postbitmed_content">
        <p><img src="<?php bloginfo('template_directory'); ?>/imgs/calen.gif" alt="Posted On" />
          <?php the_time(get_option('date_format')) ?>
        </p>
	<p><?php _e('Filed under'); ?> <?php the_category(', ') ?>
        <?php the_tags( '<br />' . __( 'Tags' ) . ': ', ', ', ''); ?>
        <?php edit_post_link(__('Edit'), '<br />', ''); ?></p>
        <p><img src="<?php bloginfo('template_directory'); ?>/imgs/comments.gif" alt="Comments Dropped" /> <a href="<?php comments_link(); ?>">
          <?php comments_number('leave a response','one response','% responses'); ?>
          </a></p>
      </div>
      <b class="postbitmed"> <b class="postbitmed5"></b> <b class="postbitmed4"></b> <b class="postbitmed3"></b> <b class="postbitmed2"><b></b></b> <b class="postbitmed1"><b></b></b> </b></div>
    <div class="words">
	<?php the_content(__('(Read More)')); ?>
	<?php wp_link_pages(); ?>
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
