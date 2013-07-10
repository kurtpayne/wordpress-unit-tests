<!-- begin sidebar -->
	<div id="dooncha_sidebar">
	<?php if ( !dynamic_sidebar('sidebar') ) { ?>
		<!-- something about author, you can enter the description under user option -->
		<p class="side_title"><?php _e('About author'); ?></p>
		<p id="author_talk"><?php mytheme_about() ?></p>
	
		<!--search form-->
		<p class="side_title"><?php _e('Search'); ?></p>
	
		<form action="<?php bloginfo('home'); ?>/" id="searchform" method="get">
			<p><input value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
			<input type="submit" value="search" id="searchbutton" name="searchbutton" /></p>
		</form>
		<hr class="sidebar_line" />
		
		<!--main navigation-->
		<p class="side_title"><?php _e('Navigation'); ?></p>
			<ul class="nonnavigational">
			<li><a href="<?php bloginfo('url'); ?>" title="home">Home</a></li>
                        <?php wp_list_pages('title_li='); ?> 
		        </ul>
			
		<!--categories-->
		<p class="side_title"><?php _e('Categories:'); ?></p>
			<ul class="nonnavigational">
			<?php wp_list_cats('sort_column=name&hide_empty=0'); ?>
			</ul>
			
		<!--links-->
		<p class="side_title"><?php _e('Links:'); ?></p>
			<ul class="nonnavigational">
			<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
			</ul>
			
		<!--archives-->
		<p class="side_title"><?php _e('Archives:'); ?></p>
			<ul class="nonnavigational">
			<?php wp_get_archives('type=monthly'); ?>
			</ul>
			
		<!--meta-->
		<p class="side_title"><?php _e('Feeds'); ?></p>
			<ul class="nonnavigational">
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			</ul>								
	<?php } ?>			
	</div><!--close dooncha sidebar-->

