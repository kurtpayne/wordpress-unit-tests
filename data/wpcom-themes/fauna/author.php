<?php get_header(); ?>

	<div id="body">

		<div id="main" class="entry">
			<div class="box">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php if ($about_text != true) { /* This shows the "about text" only once */ ?>
			
				<h2><?php _e('About') ?> <?php the_author_meta('display_name'); ?></h2>
				<? $author_nicename = the_author_meta('user_nicename'); ?>
				<p><?php the_author_meta('user_description'); ?></p>
				<ul>
					<li><?php _e('Full name:') ?> <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></li>
					<li><?php _e('Web site:') ?> <a href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('user_url'); ?></a></li>
					<li><?php _e('Contact via AOL Instant Messenger:') ?> <?php the_author_meta('aim'); ?></li>
					<li><?php _e('Contact via Yahoo Messenger:') ?> <?php the_author_meta('yim'); ?></li>
					<li><?php _e('Contact via Jabber / Google Talk:') ?> <?php the_author_meta('jabber'); ?></li>
				</ul>
				
				<h2><?php _e('Entries Authored by') ?> <?php the_author_meta('display_name'); ?></h2>

				<p><?php _e('You can follow entries authored by') ?> <?php the_author_meta('user_nicename'); ?> <?php _e('via an') ?> <a href="<? echo get_author_rss_link(0, $author, $author_nicename); ?>" title="<?php _e('RSS 2.0') ?>"><?php _e('author-only XML feed') ?></a>.</p>
				<p><?php the_author_meta('user_nicename'); ?> <?php _e('has authored') ?> <?php the_author_posts(); ?> <?php _e('on this weblog') ?>:</p>
				
				<ul><?php } $about_text = true; ?>
					<li><a href="<?php the_permalink() ?>" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; ?>
				</ul>
					
				<hr />
			
			</div>

			<?php $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'"); ?>
			<?php if ($numposts > $posts_per_page) { ?>
			<?php include("nav.php"); ?>
			<?php } ?>
			
			<?php else : ?>
			<div class="box">
				<h2>Not Found</h2>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			</div>
			<?php endif; ?>
			
			<hr />
		</div>

		<?php get_sidebar(); ?>

	</div>
				
	<?php get_footer(); ?>
