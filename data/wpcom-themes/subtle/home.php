<?php
/*
Filename: 		home.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$aOptions = get_option('gi_subtle_theme');

load_theme_textdomain('gluedideas_subtle');

?>
<?php get_header(); ?>
<!-- Content Start -->

			<div id="loop_articles">

<?php 

if ($aOptions['lead_cats'] != '') { query_posts('category_name=' . $aOptions['lead_cats']); }

if (have_posts()) : 

	$iLeadIndex = 0;

	while (have_posts()) : the_post(); 

		$iLeadIndex++;
		$sPostClass = '';
		$bShowContent = true;

		if ($iLeadIndex <= $aOptions['lead_count']) {
			$sPostClass .= ' lead';
			$bShowContent = true;
		} else {
			$sPostClass .= ' summary';
			$bShowContent = false;
		}

		if ($iLeadIndex == $aOptions['lead_count'] + 1) {
			echo ('<h2>' . __('Previous Articles') . '</h2>');
		}

?>
	
				<div id="post_<?php the_ID(); ?>" <?php post_class($sPostClass); ?>>
					<h3 class="title"><a href="<?php the_permalink() ?>"><span><?php the_title(); ?></span></a></h3>
					<ul class="metalinks">
						<li class="icon author"><?php _e("Posted by", 'gluedideas_subtle'); ?> <?php the_author_posts_link(); ?></li>
						<li class="icon date"><?php the_time(get_option('date_format')) ?></li>
					</ul>
					<?php if ($aOptions['show_metalinks']) : ?>
					<ul class="metalinks">
						<li class="icon comment"><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('Leave a Response', 'gluedideas_subtle'),__('One Response', 'gluedideas_subtle'),'% ' . __('Responses', 'gluedideas_subtle')); ?></a></li>
						<li class="icon delicious"><a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(get_the_title()); ?>">Del.icio.us</a></li>
						<li class="icon digg"><a href="http://www.digg.com/submit" target="_new">Digg</a></li>
						<li class="icon technorati"><a href="http://technorati.com/cosmos/search.html?url=<?php the_permalink() ?>">Technorati</a></li>
					</ul>
					<?php endif; ?>
					<br class="clear" />
					<?php if ($bShowContent) : ?>
					<div class="content">
						<?php the_content(''); ?>
						<ul class="links">
							<li class="icon jump"><?php if (strpos(get_the_content('^&^&'), '^&^&') > 0) : ?><a href="<?php the_permalink() ?>#more-<?php the_ID(); ?>">Continue reading</a><?php endif; if ('open' == $post->comment_status) : ?><?php if (strpos(get_the_content('^&^&'), '^&^&') > 0) { echo(" or "); } ?><a href="<?php the_permalink() ?>#comments"><?php _e("Leave a comment...", 'gluedideas_subtle'); ?></a><?php elseif (get_comments_number() > 0) : ?><?php if (strpos(get_the_content('^&^&'), '^&^&') > 0) { _e(" or ", 'gluedideas_subtle'); } ?><a href="<?php the_permalink() ?>#comments"><?php _e("Read comments...", 'gluedideas_subtle'); ?></a><?php endif; ?></li>
						<?php if ($aOptions['show_feedflare'] && $aOptions['feedburner'] != '') : ?>
							<script src="http://feeds.feedburner.com/~s/<?php echo(str_replace('http://feeds.feedburner.com/', '', $aOptions['feedburner'])) ?>?i=<?php the_permalink() ?>" type="text/javascript" charset="utf-8"></script>
						<?php endif; ?>
						</ul>
					</div>
					<?php endif; ?>
				</div>

<?php 

	endwhile; 

else : 
	
?>

				<h2><?php _e("Oops - There's Nothing Here", 'gluedideas_subtle'); ?></h2>
				<p><?php _e("It looks like the blog owner hasn't written anything yet!", 'gluedideas_subtle'); ?></p>

<?php 

endif; 

?>

			</div>
			
<?php if ($aOptions['description'] != '') : ?>
			<div id="information" class="prominent reduced"><div class="inner">
				<?php echo($aOptions['description']); ?>
			</div></div>

<?php endif; ?>

			<div id="widgets" class="widgets_home">
				<div id="widgets_home_a" class="widget_set reduced"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_1') ) { get_sidebar(); } ?></div>
				<div id="widgets_home_b" class="widget_set reduced"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_2') ) { echo(' '); } ?></div>
			</div>


			
<!-- Content End -->
<?php get_footer(); ?>
