<?php
/*
Filename: 		page.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

$aOptions = get_option('gi_subtle_theme');

?>
<?php get_header(); ?>
<!-- Content Start -->

			<div id="loop_page">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<div id="post_<?php the_ID(); ?>" class="post lead">
					<h3 class="title"><a href="<?php the_permalink() ?>"><span><?php the_title(); ?></span></a></h3>
					<!-- <div class="timestamp author">Posted by Christopher Frazier on March 25, 2006</div> -->
					<div class="content">
						<?php the_content(); ?>
						<?php link_pages('<h4>Pages:</h4><p>', '</p>', 'number'); ?>
					</div>
				</div>

<?php endwhile; endif; ?>
				
			</div>
			
			<div id="widgets" class="page">
				<div id="widgets_page" class="widget_set reduced">

<?php 

	if ($aOptions['show_subpages']) :

		global $id;
		$aSubPages = get_page_children($id, '');
		if (count($aSubPages) > 0) :

?>
					<div id="child_pages">
						<h3>More Pages</h3>
						<ul class="icon jump">
							<?php foreach ($aSubPages as $page) { echo('<li><a href="' . $page->guid . '">' . $page->post_title . '</a></li>'); } ?>
						</ul>
					</div>

<?php endif; ?>

<?php endif; ?>
				
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Posts_/_Pages_3') ) { echo(' '); } ?>
  
				</div>
			</div>
			
<!-- Content End -->
<?php get_footer(); ?>