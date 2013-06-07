<?php header("HTTP/1.1 404 Not Found"); ?>
<?php get_header(); ?>

<!-- BEGIN 404.PHP -->
<div id="content">
<h2>Hi there! You seem to be lost...</h2>
<p>The address you tried going to doesn't exist on our blog. Don't worry. It's possible that the page you're looking for has been moved to a different address or you may have mis-typed the address.</p>
<p>For now, you may want to go to our <a href="<?php echo get_settings('home'); ?>/">home page</a> or search for what you're looking for:</p>
<?php include(TEMPLATEPATH . "/searchform.php"); ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
