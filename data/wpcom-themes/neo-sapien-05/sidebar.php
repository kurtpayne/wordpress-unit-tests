<!-- SIDEBAR -->

<div id="sidebar">
<ul>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1)) : ?>
<li><h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<ul>
<li><?php bloginfo('description'); ?></li>
<?php wp_list_pages('depth=1&title_li=<h2>' . __('Pages') . '</h2>' ); ?>
</ul>
</li>
<li><h2><?php _e('Syndicate'); ?></h2>
<ul>
<li><a href="<?php echo bloginfo('rss2_url'); ?>"><?php _e('Entries'); ?></a></li>
<li><a href="<?php echo bloginfo('comments_rss2_url'); ?>"><?php _e('Comments'); ?></a></li>
</ul>
</li>
<li><h2><?php _e('Meta'); ?></h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check?uri=referer"><?php _e('Valid xhtml'); ?></a></li>
<?php wp_meta(); ?>
</ul>
</li>
</ul>
</li>
<?php endif; ?>
</ul>
</div>

<!-- END SIDEBAR -->