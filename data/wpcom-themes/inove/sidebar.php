<?php
	$options = get_option('inove_options');
?>

<!-- sidebar START -->
<div id="sidebar">

<!-- sidebar north START -->
<div id="northsidebar" class="sidebar">

	<!-- feeds -->
	<div class="widget widget_feeds">
		<div class="content">
			<div id="subscribe">
				<a rel="external nofollow" id="feedrss" title="<?php _e('Subscribe to this blog...', 'inove'); ?>" href="<?php bloginfo('rss2_url'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> feed', 'inove'); ?></a>
				<?php if($options['feed_readers']) : ?>
					<ul id="feed_readers">
						<li id="google_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('Google', 'inove'); ?>" href="http://fusion.google.com/add?feedurl=<?php bloginfo('rss2_url'); ?>"><span><?php _e('Google', 'inove'); ?></span></a></li>
						<li id="youdao_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('Youdao', 'inove'); ?>" href="http://reader.youdao.com/#url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('Youdao', 'inove'); ?></span></a></li>
						<li id="xianguo_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('Xian Guo', 'inove'); ?>" href="http://www.xianguo.com/subscribe.php?url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('Xian Guo', 'inove'); ?></span></a></li>
						<li id="zhuaxia_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('Zhua Xia', 'inove'); ?>" href="http://www.zhuaxia.com/add_channel.php?url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('Zhua Xia', 'inove'); ?></span></a></li>
						<li id="yahoo_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('My Yahoo!', 'inove'); ?>"	href="http://add.my.yahoo.com/rss?url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('My Yahoo!', 'inove'); ?></span></a></li>
						<li id="newsgator_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('newsgator', 'inove'); ?>"	href="http://www.newsgator.com/ngs/subscriber/subfext.aspx?url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('newsgator', 'inove'); ?></span></a></li>
						<li id="bloglines_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('Bloglines', 'inove'); ?>"	href="http://www.bloglines.com/sub/<?php bloginfo('rss2_url'); ?>"><span><?php _e('Bloglines', 'inove'); ?></span></a></li>
						<li id="inezha_reader"><a rel="external nofollow" class="reader" title="<?php _e('Subscribe with ', 'inove'); _e('iNezha', 'inove'); ?>"	href="http://inezha.com/add?url=<?php bloginfo('rss2_url'); ?>"><span><?php _e('iNezha', 'inove'); ?></span></a></li>
					</ul>
				<?php endif; ?>
			</div>
			<div class="fixed"></div>
		</div>
	</div>

	<!-- showcase -->
	<?php if( $options['showcase_content'] && (
		($options['showcase_registered'] && $user_ID) || 
		($options['showcase_commentator'] && !$user_ID && isset($_COOKIE['comment_author_'.COOKIEHASH])) || 
		($options['showcase_visitor'] && !$user_ID && !isset($_COOKIE['comment_author_'.COOKIEHASH]))
	) ) : ?>
		<div class="widget">
			<?php if($options['showcase_caption']) : ?>
				<h3><?php if($options['showcase_title']){echo($options['showcase_title']);}else{_e('Showcase', 'inove');} ?></h3>
			<?php endif; ?>
			<div class="content">
				<?php echo($options['showcase_content']); ?>
			</div>
		</div>
	<?php endif; ?>

<?php if ( !function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar') ) : ?>
	
	<!-- posts -->
	<?php
		if (is_single()) {
			$posts_widget_title = __('Recent Posts', 'inove');
		} else {
			$posts_widget_title = __('Random Posts', 'inove');
		}
	?>

	<div class="widget">
		<h3><?php echo $posts_widget_title; ?></h3>
		<ul>
			<?php
				if (is_single()) {
					$posts = get_posts('numberposts=10&orderby=post_date');
				} else {
					$posts = get_posts('numberposts=5&orderby=rand');
				}
				foreach($posts as $post) {
					setup_postdata($post);
					echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
				}
				$post = $posts[0];
			?>
		</ul>
	</div>

	<!-- tag cloud -->
	<?php if (!is_single()) : ?>
		<div id="tag_cloud" class="widget">
			<h3><?php _e('Tag Cloud', 'inove'); ?></h3>
			<?php wp_tag_cloud('smallest=8&largest=16'); ?>
		</div>
	<?php endif; ?>



		<!-- categories -->
		<div class="widget widget_categories">
			<h3><?php _e('Categories', 'inove'); ?></h3>
			<ul>
				<?php wp_list_cats('sort_column=name&optioncount=0&depth=1'); ?>
			</ul>
		</div>


		<!-- blogroll -->
		<div class="widget widget_links">
			<h3><?php _e('Blogroll', 'inove'); ?></h3>
			<ul>
				<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
			</ul>
		</div>


	<!-- archives -->
	<div class="widget">
		<h3><?php _e('Archives', 'inove'); ?></h3>
		<?php if(function_exists('wp_easyarchives_widget')) : ?>
			<?php wp_easyarchives_widget("limit=6"); ?>
		<?php else : ?>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		<?php endif; ?>
	</div>

	<!-- meta -->
	<div class="widget">
		<h3><?php _e('Meta', 'inove'); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
		</ul>
	</div>
<?php endif; ?>
	</div>
</div>
<!-- sidebar END -->
