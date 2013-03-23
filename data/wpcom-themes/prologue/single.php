<?php 
get_header( ); 

if( have_posts( ) ) {
	$first_post = true;

	while( have_posts( ) ) {
		the_post( );

		$email_md5		= md5( get_the_author_email( ) );
		$default_img	= urlencode( 'http://use.perl.org/images/pix.gif' );
?>

<div id="postpage">
<div id="main">
	<h2>
		<?php echo prologue_get_avatar( get_the_author_ID( ), get_the_author_email( ), 48 ); ?>
		<?php the_author_posts_link( ); ?>
	</h2>
	<ul>
		<li>
			<h4>
				<?php the_time( "h:i:s a" ); ?> on <?php the_time( "F j, Y" ); ?>
				| <a href="<?php echo get_permalink( ); ?>">#</a> | 
				<?php edit_post_link( __( 'e' ) ); ?>
				<span class="meta">
					<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ); ?>
					<br />
					<?php the_tags( __( 'Tags: ' ), ', ', ' ' ); ?>
				</span>
			</h4>
			<?php the_content( __( '(More ...)' ) ); ?>
			<div class="bottom_of_entry">&nbsp;</div>
		</li>
	</ul>

<?php
		comments_template( );

	} // while have_posts
} // if have_posts
?>

</div> <!-- // main -->
</div> <!-- // postpage -->

<?php
get_footer( );
