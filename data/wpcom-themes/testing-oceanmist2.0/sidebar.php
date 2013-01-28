	<div id="subCol">
		<ul>
      <li>
			  <h2>Browse</h2>
          <div class="pad">
						<select name="archivemenu" onchange="document.location.href=this.options[this.selectedIndex].value;">
          		<option value="">Monthly Archives</option>
							<?php get_archives('monthly','','option','','',''); ?>
        		</select>
						<div class="or"><span>or</span></div>
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>
          </div>
      </li>
			<li>
			  <h2>Image Advertisements</h2>
			  <ul>
			    <li><a href="#"><img src="yourdomain.com/img/ad01.gif" alt="Advert for: describe the service offered" /></a></li>
			    <li><a href="#"><img src="yourdomain.com/img/ad02.gif" alt="Advert for: describe the service offered" /></a></li>
			  </ul>
			</li>
			
			
			<!-- Adverts are disabled per default. Uncomment & insert ad code if you want to use them.
			
			
			// TEXT ADS
			
			<li>
			  <h2>Text Links Advertisements</h2>
			  <ul>
			    <li><a href="#">Advert title</a></li>
			    <li><a href="#">Advert title</a></li>
			  </ul>
			</li>
			
			
			// IMAGE ADS (maximum width 154px)
			
			<li>
			  <h2>Image Advertisements</h2>
			  <ul>
			    <li><a href="#"><img src="yourdomain.com/img/ad01.gif" alt="Advert for: describe the service offered" /></a></li>
			    <li><a href="#"><img src="yourdomain.com/img/ad02.gif" alt="Advert for: describe the service offered" /></a></li>
			  </ul>
			</li>
			
			
			-->
			
			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->
			
			
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			
			<li id="wp-calendar"><h2>Calendar</h2><?php get_calendar(true); ?></li>
			<li id="tagCloud"><h2>Tag Cloud</h2><div class="pad"><?php wp_tag_cloud('smallest=8&largest=18&number=30'); ?></div></li>


			<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

			<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>

				<li><h2>Meta</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>

			<?php endif; ?>
		</ul>
	</div>

