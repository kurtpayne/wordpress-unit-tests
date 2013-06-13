<?php get_header(); ?>

<?php is_tag(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class('post'); ?>>
<div class="postop">
<img src="<?php bloginfo('template_directory'); ?>/img/tl.gif" alt="" width="15" height="15" class="corner" style="display: none" />
</div>

<h3><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h3>
<div class="meta"><?php edit_post_link(__('Edit This')); ?></div>

<div class="storycontent">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="image-navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
</div><!-- end STORYCONTENT -->
<div class='reset'>&nbsp;</div>
<div class="feedback">
<?php comments_popup_link(__('Leave a Comment'), __('Comments (1)'), __('Comments (%)')); ?>
</div><br /><!-- end FEEDBACK -->

<div class="postbottom">
<img src="<?php bloginfo('template_directory'); ?>/img/bl.gif" alt="" width="15" height="15" class="corner" style="display: none" />
</div>

</div><!-- end POST -->

<div id="comments-post">
<?php comments_template(); ?>
</div><!-- end COMMENTS-POST -->

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
