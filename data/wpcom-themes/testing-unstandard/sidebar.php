<div class="search">
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>
<?php /* if this is a single post */ if ( is_single() ) { ?>
<br /><br />
<h3>Explore Recent</h3>
<ul class="sidebar-nextprev fix">
  <li class="previous"><?php previous_post_link('%link') ?></li>
  <li class="next"><?php next_post_link('%link') ?></li>
</ul>
<?php } ?>
<?php /* show on home page, index, results */ if ( is_home() || is_page() || is_category() || is_search() ) { ?>
<br /><br />
<h3>Most Recent</h3>
<ul class="sidebar-ul">
  <?php /* will display 10 most recent posts */ wp_get_archives('type=postbypost&limit=10'); ?>
</ul>
<?php } ?>
<br /><br />
<h3>Monthly Archives</h3>
<ul class="sidebar-ul">
  <?php wp_get_archives('type=monthly'); ?>
</ul>
<br /><br />
<h3>Meta</h3>
<ul class="sidebar-ul">
  <?php wp_register(); ?>
	<li><?php wp_loginout(); ?></li>
	<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
	<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
	<?php wp_meta(); ?>
</ul>