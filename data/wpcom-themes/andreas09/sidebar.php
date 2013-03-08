<div id="leftside">

	<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('main-sidebar') ) : ?>
	</ul>
</div>
<?php return; endif; ?>
		<li id="categories"><h2><?php _e('Categories','andreas09'); ?></h2>

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

</div>

