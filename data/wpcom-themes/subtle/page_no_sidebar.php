<?php
/*
Filename: 		page.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
Template Name:  Page, No Sidebar
*/

$aOptions = get_option('gi_subtle_theme');

?>
<?php get_header(); ?>
<!-- Content Start -->

			<div id="loop">

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
						
<!-- Content End -->
<?php get_footer(); ?>