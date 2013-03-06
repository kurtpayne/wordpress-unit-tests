<!-- Alternate right sidebar template for 2 column page -->
<!-- Edit this sidebar as you want -->
<div id="rightside">
	<ul>
		<li><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
	</ul>
	<ul class="box">
		<li><h2><?php _e('Categories','andreas09'); ?></h2>
			<ul>
				<?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=1'); ?>
			</ul>
		</li>
			<li><h2><?php _e('Archives','andreas09'); ?></h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>
	</ul>
	<ul>
		<li><h2><?php _e('Subscribe','andreas09'); ?></h2>
			<ul>
				<li class="feed"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)','andreas09'); ?></a></li>
				<li class="feed"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)','andreas09'); ?></a></li>
			</ul></li>
	</ul>
</div>
