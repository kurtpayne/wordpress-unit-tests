<?php get_header();?>

<div id="content">
<h1><?php _e('Error 404'); ?></h1>
  <h2 class="entrytitle"><?php _e('The page you requested is no longer here!'); ?> </h2>
  <p><?php printf(__('Visit the <a href="%s">Home Page</a>'), get_option('siteurl')); ?></p>
  <p><?php _e('In order to improve our service, can you inform us that someone else has an incorrect link to our site?'); ?></p>
  <p><a href="/contact"><?php _e('Report broken link'); ?></a> </p>
  <p>&nbsp;</p>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
