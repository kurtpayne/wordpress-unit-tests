	<div id="sidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			
			<?php /* If this is a category archive */ if (is_category()) { ?>
			<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>
			
			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p>You are currently browsing the <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> weblog archives
			for the day <?php the_time('l, F jS, Y'); ?>.</p>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p>You are currently browsing the <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> weblog archives
			for <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p>You are currently browsing the <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> weblog archives
			for the year <?php the_time('Y'); ?>.</p>
			
		 <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p>You have searched the <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> weblog archives
			for <strong>'<?php echo wp_specialchars($s); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p>You are currently browsing the <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> weblog archives.</p>

			<?php } ?>
		
		<ul>
			<li class="page_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>
			<?php wp_list_pages('title_li='); ?>
		</ul>
		
		<h2>Subscribe</h2>
			<p><?php bloginfo('name'); ?> syndicates its <a href="<?php bloginfo('rss2_url'); ?>">weblog posts</a>
		and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments</a> using a technology called 
		RSS (Real Simple Syndication). You can use a service like <a href="http://bloglines.com/">Bloglines</a> to get
		notified when there are new posts to this weblog.</p>

		<h2><?php _e('Archives'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
		

		<h2><?php _e('Categories'); ?></h2>
				<ul>
				<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
				</ul>
		

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>				
				<ul>
				<?php wp_list_bookmarks(); ?>
				</ul>
				
		<h2><?php _e('Meta'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.com/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress.com</a></li>
					<?php wp_meta(); ?>
				</ul>
		
			<?php } ?>
<?php endif; ?>
	</div>

