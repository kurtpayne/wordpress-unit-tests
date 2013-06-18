<?php
/*
Filename: 		search.php
Date: 			06-06-25
Copyright: 		2006, Glued Ideas
Author: 		Christopher Frazier (cfrazier@gluedideas.com)
Description: 	Multi-Author Template for WordPress (Subtle)
Requires:
*/

load_theme_textdomain('gluedideas_subtle');

if (isset($_GET['author_name'])) {
	$objAuthor = get_userdatabylogin(get_the_author_login());
} else {
	$objAuthor = get_userdata(intval($author));
}

$aOptions = get_option('gi_subtle_theme');

?>
<?php get_header(); ?>
<!-- Content Start -->

			<div id="loop_articles">
			
<?php if (is_author()) : ?>
				<h2><?php _e('Author Archives for', 'gluedideas_subtle') ?> <?php echo($objAuthor->display_name); ?></h2>
<?php elseif (is_search()) : ?>
				<h2><?php _e('Search Results for', 'gluedideas_subtle') ?> "<?php echo wp_specialchars($s); ?>"</h2>
<?php else : ?>
				<h2><?php _e('Site Archives', 'gluedideas_subtle') ?> <?php single_cat_title(''); ?></h2>
<?php endif; ?>

<?php if (have_posts()) : ?>

				<div class="navigation">
					<ul class="links">
						<li class="next"><?php next_posts_link(__('Next Page &raquo;', 'gluedideas_subtle')) ?></li>
						<li class="previous"><?php previous_posts_link(__('&laquo; Previous Page', 'gluedideas_subtle')) ?>&nbsp;</li>
					</ul>
				</div>


<?php while (have_posts()) : the_post(); ?>

				<div id="post_<?php the_ID(); ?>" <?php post_class('summary'); ?>>
					<h3 class="title"><a href="<?php the_permalink() ?>"><span><?php the_title(); ?></span></a></h3>
					<ul class="metalinks">
						<li class="icon author"><?php _e("Posted by", 'gluedideas_subtle'); ?> <?php the_author_posts_link(); ?></li>
						<li class="icon date"><?php the_time(get_option('date_format')) ?></li>
					</ul>
					<br class="clear" />
					<div class="content">
						<?php the_excerpt(); ?>
					<?php if ($aOptions['show_feedflare'] && $aOptions['feedburner'] != '') : ?>
						<ul class="links"><script src="http://feeds.feedburner.com/~s/<?php echo(str_replace('http://feeds.feedburner.com/', '', $aOptions['feedburner'])) ?>?i=<?php the_permalink() ?>" type="text/javascript" charset="utf-8"></script></ul>
					<?php endif; ?>
					</div>
				</div>


<?php endwhile; ?>

				<div class="navigation">
					<ul class="links">
						<li class="next"><?php next_posts_link(__('Next Page &raquo;', 'gluedideas_subtle')) ?></li>
						<li class="previous"><?php previous_posts_link(__('&laquo; Previous Entries', 'gluedideas_subtle')) ?>&nbsp;</li>
					</ul>
				</div>


<?php else : ?>

				<p><?php _e("No posts were found.  Try searching again.", 'gluedideas_subtle'); ?></p>
				
<?php endif; ?>
			</div>
			

<?php if (is_author()) : ?>
			<div id="author" class="prominent reduced"><div class="inner">
				<h2><?php echo($objAuthor->display_name); ?></h2>
				<p><?php echo($objAuthor->description); ?></p>
				<ul>
					<?php if ($objAuthor->user_url != 'http://') : ?><li class="icon author"><a href="<?php echo($objAuthor->user_url); ?>"><?php _e("Visit Author's Website", 'gluedideas_subtle'); ?></a></li><?php endif; ?>
					<li class="icon feed"><a href="<?php get_author_rss_link(true, $objAuthor->ID, $objAuthor->user_login); ?>"><?php _e("Author's Feed", 'gluedideas_subtle'); ?></a></li>
				</ul>
			</div></div>
<?php else : ?>
			<div id="search" class="prominent reduced"><div class="inner">
				<h2><?php _e("Find It Quickly", 'gluedideas_subtle'); ?></h2>
				<p><?php _e("Find what you're looking for quickly by using our keyword search.  Can't find it?  Try our links below.", 'gluedideas_subtle'); ?></p>
				<form action="<?php bloginfo('home'); ?>/" name="form_search" id="form_search" method="get">
					<label for="input_form_search" id="label_form_search"><?php _e("Find this", 'gluedideas_subtle'); ?></label> <input type="text" id="input_form_search" class="input" name="s" />
				</form>
			</div></div>
<?php endif; ?>

			
			<div id="archive_links" class="reduced">
				<div id="widgets_archives_a" class="widget_set archive_group odd">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Archives_1') ) : ?>
					<div id="authors">
						<h2><?php _e("Authors", 'gluedideas_subtle'); ?></h2>
						<p><?php _e("Select an author for posts and author information.", 'gluedideas_subtle'); ?></p>
						<ul class="icon entry">
							<?php wp_list_authors('show_fullname=1&exclude_admin=0'); ?>
						</ul>
					</div>
	
					<div id="dates">
						<h2><?php _e("Monthly Archives", 'gluedideas_subtle'); ?></h2>
						<p><?php _e("Find posts by the month they were written", 'gluedideas_subtle'); ?></p>
						<ul class="icon date">
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
					</div>
<?php endif; ?>
				</div>

				<div id="widgets_archives_b" class="widget_set archive_group even">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Archives_2') ) : ?>
					<div id="categories">
						<h2><?php _e("Categories", 'gluedideas_subtle'); ?></h2>
						<p><?php _e('Find posts using the "tags" provided below.', 'gluedideas_subtle'); ?></p>
						<ul class="icon category">
							<?php wp_list_cats('hierarchical=0'); ?>
						</ul>
					</div>
<?php endif; ?>
				</div>

			</div>
			
			
<!-- Content End -->
<?php get_footer(); ?>