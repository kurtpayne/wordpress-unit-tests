<?php get_header() ?>

<div class="sleeve_main">
	
	<div id="main">
		
		<?php if ( have_posts() ) : ?>
			
			<?php while ( have_posts() ) : the_post() ?>
			
				<div class="controls">
					<a href="#" id="togglecomments"><?php _e( 'Hide threads', 'p2' ); ?></a>
					&nbsp;|&nbsp;
					<a href="#directions" id="directions-keyboard"><?php  _e( 'Keyboard Shortcuts', 'p2' ); ?></a>
				</div>
		
				<ul id="postlist">
		    		<?php p2_load_entry() // loads entry.php ?>
				</ul>
			
			<?php endwhile; ?>
			
		<?php else : ?>
			
			<ul id="postlist">
				<li class="no-posts">
			    	<h3><?php _e( 'No posts yet!', 'p2' ) ?></h3>
				</li>
			</ul>
			
		<?php endif; ?>

		<div class="navigation">
			<p><?php previous_post_link( '%link', __( '&larr;&nbsp;Older&nbsp;Posts', 'p2' ) ) ?> | <?php next_post_link( '%link', __( 'Newer&nbsp;Posts&nbsp;&rarr;', 'p2' ) ) ?></p>
		</div>
		
	</div> <!-- main -->

</div> <!-- sleeve -->

<?php get_footer() ?>