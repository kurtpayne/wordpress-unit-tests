<div id="sidebar-right" class="sidebar">

<ul class="menu">

<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar('right-sidebar')) { } else { ?>

<li>
<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<input type="submit" id="searchsubmit" value="<?php _e('Search'); ?>" />
</div>
</form>
</li>

<?php wp_list_bookmarks( array( 'title_before' => '<h3>', 'title_after' => '</h3>' ) ); ?>


<li>
<h3>Archives</h3>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>

<li>
<h3>Misc</h3>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://wordpress.org/">WordPress.org</a></li>
<li><a href="http://wordpress.com/">WordPress.com</a></li>
<?php wp_meta(); ?>
</ul>
</li>

<?php } ?>
</ul>
</div>
