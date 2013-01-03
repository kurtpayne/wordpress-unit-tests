<div id="sidebar-left" class="sidebar">

<ul class="menu">

<?php /* WordPress Widget Support */ if (function_exists('dynamic_sidebar') and dynamic_sidebar('left-sidebar')) { } else { ?>
<li>
<h3>Pages</h3>
<ul>
<li><a href="<?php echo get_option('home'); ?>/"><?php _e('Home'); ?></a></li>
<?php wp_list_pages( 'title_li=&depth=1' ); ?>
</ul>
</li>

<?php wp_list_categories('optioncount=1&hierarchical=0&title_li=<h3>'.__('Categories').'</h3>'); ?>

<?php } ?>
</ul>

</div>
