<?php
/**
 *	@package WordPress
 *	@subpackage Grid_Focus
 */
?>
<div class="secondaryColumn">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Primary - Post') ) : else : ?>
		<div class="widgetContainer widget_pages">
			<h3 class="widgetTitle"><?php _e('Pages'); ?></h3>
			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
		<div class="widgetContainer widget_pages">
			<h3><?php _e('Archives', 'kubrick'); ?></h3>	
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</div>
	<?php endif; ?>
</div>