</div>
</div>

<div id="feed_bar">
 	<p>Liked it here?<br />
	<span class="small">Why not try sites on the blogroll...</span></p>
</div>

<div id="footer">
	<div id="footer_wrapper">
		<div class="content_padding">
			 <div class="footer_links">
				   <ul class="blogroll_list">
						<?php wp_list_bookmarks(array(
							'title_before' => '<h4>', 
							'title_after' => '</h4>', 
							'before' => '<li>',
							'after' => '</li>',
							'show_images'=>true)
							); ?>
				   </ul>
			</div>
			<div class="footer_meta">
				<p>Get a free blog at <a href="http://wordpress.com">WordPress.com</a> &bull; Theme <a href="http://fadtastic.net/theme/">Fadtastic</a> by Andrew Faulkner.</p>
			</div>
			
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>

