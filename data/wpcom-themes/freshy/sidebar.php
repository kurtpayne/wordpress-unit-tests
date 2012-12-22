<?php global $freshy_options; ?>
	
	<div id="sidebar">
		<div>
		<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
		<?php if(function_exists('yy_menu')) : ?>
			<h2><?php _e('Navigation',TEMPLATE_DOMAIN); ?></h2>
			<ul>
			<?php yy_menu('sort_column=menu_order&title_li=', 'hide_empty=0&sort_column=name&optioncount=1&title_li=&hierarchical=1&feed=RSS&feed_image='.get_bloginfo('stylesheet_directory').'/images/icons/feed-icon-10x10.gif'); ?>
			</ul>
	
		<?php elseif (function_exists('freshy_menu')):
			freshy_menu($freshy_options['args_pages'],$freshy_options['args_cats']);
		endif; ?>
				
			<h2><?php _e('Search',TEMPLATE_DOMAIN); ?></h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>

			<h2><?php _e('Links',TEMPLATE_DOMAIN); ?></h2>
			<ul>
			<?php wp_list_bookmarks(); ?>
			</ul>
		<?php endif; ?>
		</div>
	</div>
