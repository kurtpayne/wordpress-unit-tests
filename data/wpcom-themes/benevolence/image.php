<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">

<?php
if (have_posts()) {
	while(have_posts()) {
		the_post();
?>
<br />
<div <?php post_class(); ?>>
	<a class="title" href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?>
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
	<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>

	<div class="navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
	
    <div class="sep"></div>

<?php comments_template(); // Get wp-comments.php template ?>
</div>
<?php } // closes printing entries with excluded cats ?>

<?php } else { ?>
<?php _e('Sorry, no posts matched your criteria.','benevolence'); ?>
<?php } ?>

 <div class="right"><?php posts_nav_link('','',__('previous &raquo;','benevolence')) ?></div>
 <div class="left"><?php posts_nav_link('',__('&laquo; newer ','benevolence'),'') ?></div>

<br /><br />

</div>

<?php get_footer(); ?>
