<?php // This template is used when no article was found. ?>
<?php get_header(); ?>

<h1><?php _e("Nothing was Found"); ?></h1>

<p><?php _e("I'm sorry to report that no article was found under that address. Perhaps you would like to try searching now?"); ?></p>

<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" length="20" />
<input type="submit" id="searchsubmit" name="Submit" value="<?php echo attribute_escape(__("Search")); ?>" />
</form>

<?php get_footer(); ?>
