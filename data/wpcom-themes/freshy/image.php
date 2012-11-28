<?php ob_start(); ?>

<?php get_header(); ?>

	<div id="content">
	
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				
				<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>

				<div class="entry">
					<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'auto' ); ?></a></p>
					<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?></div>
					<div class="image-description"><?php if ( !empty($post->post_content) ) the_content(); ?></div>
				</div>
			</div>
			<div class="navigation">
				<div class="alignleft"><?php previous_image_link() ?></div>
				<div class="alignright"><?php next_image_link() ?></div>
			</div>
			<br/>
			<h3><?php _e('Actions',TEMPLATE_DOMAIN); ?></h3>
			<ul class="postmetadata">
		<?php if ('open' == $post-> comment_status) : ?>
			<li class="with_icon"><img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') ?>/images/icons/feed-icon-16x16.gif" alt="rss" />&nbsp;<?php comments_rss_link(__('Comments RSS',TEMPLATE_DOMAIN)); ?></li>
		<?php endif; ?>
		<?php if ('open' == $post->ping_status) : ?>
			<li class="with_icon"><img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') ?>/images/icons/trackback-icon-16x16.gif" alt="trackback" />&nbsp;<a href="<?php trackback_url(true); ?> " rel="trackback" title="make a trackback"><?php _e('Trackback',TEMPLATE_DOMAIN); ?></a></li>
		<?php endif; ?>
		<?php if ($user_ID) : ?>
			<li class="with_icon"><img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') ?>/images/icons/edit-icon-16x16.gif" alt="edit" />&nbsp;<?php edit_post_link(__('Edit',TEMPLATE_DOMAIN),'',''); ?></li>
		<?php endif; ?>
			</ul>
				
			<?php comments_template(); ?>
						
		<?php endwhile; ?>
	
	<!-- nothing found -->
	<?php else : ?>

		<h2><?php _e('Not Found',TEMPLATE_DOMAIN); ?></h2>
		<p><?php _e('Sorry, but you are looking for something that isn\'t here.',TEMPLATE_DOMAIN); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
		
	</div>
	
	<hr style="display:none"/>
	
	<!-- sidebar -->
	<?php get_sidebar(); ?>

	<br style="clear:both" /><!-- without this little <br /> NS6 and IE5PC do not stretch the frame div down to encopass the content DIVs -->
</div>
				
<!-- footer -->
<?php get_footer(); ?>

<? ob_end_flush();?>
