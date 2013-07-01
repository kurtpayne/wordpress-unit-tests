	<div id="sidebar">
      <?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
		
	  <div class="title">
        <h2>Browse</h2>
      </div>
      <div class="post">
        <select name="archivemenu" onchange="document.location.href=this.options[this.selectedIndex].value;">
		<option value=""><?php _e('Monthly Archives'); ?></option>
          <?php get_archives('monthly','','option','','',''); ?>
        </select>		
        <?php include (TEMPLATEPATH . '/searchform.php'); ?>
	  </div>
	  <div class="title">
        <h2>Links</h2>
      </div>
	  <div class="post">
	    <ul>
          <?php get_linksbyname('', '<li>', '</li>', '', TRUE, 'name', FALSE); ?>
		</ul>
      </div>
	  <div class="title">
        <h2>Subscribe</h2>
      </div>
	  <div class="post">
	    <ul>
		<li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)'); ?></a></li>
		<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)'); ?></a></li>
		</ul>
      </div>
<?php endif; ?>
</div>
