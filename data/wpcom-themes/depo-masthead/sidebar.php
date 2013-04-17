		</div>
	</div>
	<div id="sidebar">
		<div class="sleeve">
		<ul class="group">
			<li id="left_sidebar">
			<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left') ) { ?>
			
			<?php depo_about_widget(); ?>
			
			<?php } else { ?>
				
			<?php } ?>
			</ul>
			</li>
			
			<li id="middle_sidebar">
			<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Middle') ) { ?>
			
			<?php depo_archives_widget(); ?>
			
			<?php } else { ?>

			<?php } ?>
			</ul>
			</li>
			
			<li id="right_sidebar">
			<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right') ) { ?>

			<?php search_widget(); ?>
			<?php rss_widget(); ?>

			<?php } else { ?>

			<?php } ?>
			<?php wp_meta(); ?>
			</ul>
			</li>

		</ul>
		<div class="closer"></div>
		</div>
	</div>
</div>
