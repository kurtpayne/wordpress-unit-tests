<?php get_header();?>
<div id="content">
<div id="content-main">
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="posttitle">
				<h2><?php _e('Ooops...Where did you get such a link ?','mistylook'); ?></h2>
					<p class="post-info"><?php _e('Server cannot locate what you are looking for!','mistylook'); ?></p>
				</div>
				
				<div class="entry">
			<p><?php _e('The Server tried all of its options before returning this page to you.','mistylook'); ?></p>
			<p><img src="<?php bloginfo('stylesheet_directory') ;?>/img/404.gif" alt="404" class="left" /><?php _e('You are looking for something that is not here now.','mistylook'); ?><br/>
			<?php _e('You can always try doing a <strong>search</strong> or browsing through the <strong>Archives</strong>.<br/>Don&#8217;t loose your hope just yet.','mistylook'); ?><br style="clear:both" /></p>
				</div>
		
				<p class="postmetadata"><?php _e('Posted as Not Found','mistylook'); ?></p>
				
			</div>	
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
