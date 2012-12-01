<?php
/*
Filename: 		single.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$temp_post = $post;

load_theme_textdomain('gluedideas_subtle');

?>
<?php get_header(); ?>
<!-- Content Start -->

			<div id="loop_single">
			
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post_<?php the_ID(); ?>" <?php post_class(); ?>>

					<h3 class="title"><a href="<?php the_permalink() ?>"><span><?php the_title(); ?></span></a></h3>
					<ul class="metalinks">
						<li class="icon author"><?php _e("Posted by", 'gluedideas_subtle'); ?> <?php the_author_posts_link(); ?></li>
						<li class="icon date"><?php the_time(get_option('date_format')) ?></li>
					</ul>
					<br class="clear" />
					<div class="content">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div>

				</div>

			</div>


			<div id="post_meta" class="prominent reduced"><div class="inner">
				<h2><?php _e("Information and Links", 'gluedideas_subtle'); ?></h2>
				<p><?php _e("Join the fray by commenting, tracking what others have to say, or linking to it from your blog.", 'gluedideas_subtle'); ?></p>
	
				<dl class="metadata odd">
					<dt class=""><?php _e("Information", 'gluedideas_subtle'); ?></dt>
					<dd class="icon date"><a href="<?php echo(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>"><?php the_time('F jS, Y') ?></a></dd>
					<dd class="icon comment"><a href="#comments"><?php comments_number(__('Leave a Response', 'gluedideas_subtle'),__('One Response', 'gluedideas_subtle'),'% ' . __('Responses', 'gluedideas_subtle')); ?></a></dd>
				</dl>
	
				<dl class="metadata even">
					<dt><?php _e("Feeds and Links", 'gluedideas_subtle'); ?></dt>
					<dd class="icon feed"><?php comments_rss_link(__('Comment Feed', 'gluedideas_subtle')); ?></dd>
					<dd class="icon entry"><a href="<?php get_author_link(true, get_the_author_ID(), get_the_author_login()); ?>"><?php _e("From This Author", 'gluedideas_subtle'); ?></a></dd>
					<dd class="icon delicious"><a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(get_the_title()); ?>">Del.icio.us</a></dd>
					<dd class="icon digg"><a href="http://www.digg.com/submit" target="_new">Digg</a></dd>
					<dd class="icon technorati"><a href="http://technorati.com/cosmos/search.html?url=<?php urlencode(the_permalink()) ?>">Technorati</a></dd>
				</dl>
	
				<dl class="metadata odd">
					<dt><?php _e("Categories", 'gluedideas_subtle'); ?></dt>
					<dd class="icon category"><?php the_category('</dd><dd class="icon category">') ?></dd>
				</dl>
				
				<br class="clear" />
	
				<dl class="other">
					<dt><?php _e("Other Posts", 'gluedideas_subtle'); ?></dt>
					<dd class="icon jump"><?php next_post_link('%link') ?></dd>
					<dd class="icon jump"><?php previous_post_link('%link') ?></dd>
				</dl>
	
			</div></div>

			<div id="widgets" class="widgets_single">
	
				<div id="widgets_single_a" class="widget_set reduced"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Posts_/_Pages_1') ) { echo (''); } ?></div>
				<div id="widgets_single_b" class="widget_set reduced"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Posts_/_Pages_2') ) { echo (''); } ?></div>
			</div>
					
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Advert_3') ) { if (function_exists(displaySubtleAds)) { displaySubtleAds(3); } } ?>

<br class="clear" />

<?php 
	$post = $temp_post;
	update_post_caches($post_id);
	comments_template(); 
?>

<?php endwhile; else: ?>
	
<p><?php _e("Sorry, no posts matched your criteria.", 'gluedideas_subtle'); ?></p>
	
<?php endif; ?>


<!-- Content End -->
<?php get_footer(); ?>
