<?php 
get_header( ); 
?>

<div id="userpage">
<div id="main">

<?php
if( have_posts( ) ) {
	$first_post = true;

	while( have_posts( ) ) {
		the_post( );

		$author_feed_url = '';
		if( function_exists( 'get_author_feed_link' ) ) {
			$author_feed_url = get_author_feed_link( get_the_author_ID( ) );
		}
		else {
			$author_feed_url = get_author_rss_link( false, get_the_author_ID( ), get_the_author_nickname( ) );
		}
?>

<?php if( $first_post === true ) { ?>
	<h2>
		<?php echo prologue_get_avatar( get_the_author_id( ), get_the_author_email( ), 48 ); ?>
		Updates from <?php the_author_posts_link( ); ?>
		<a class="rss" href="<?php echo $author_feed_url; ?>">RSS</a>
	</h2>
<?php } // first_post ?>

	<ul>
		<li>
			<h4>
				<?php the_time( "h:i:s a" ); ?> on <?php the_time( "F j, Y" ); ?>
				|
				<span class="meta">
					<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ); ?>
					| <a href="<?php echo get_permalink( ); ?>">#</a> | 
					<?php edit_post_link( __( 'e' ) ); ?>
					<br />
					<?php the_tags( __( 'Tags: ' ), ', ', ' ' ); ?>
					<br />
				</span>
			</h4>
			<?php the_content( __( '(More ...)' ) ); ?>
			<p class="meta">
			</p>
			<div class="bottom_of_entry">&nbsp;</div>
		</li>
	</ul>

<?php
		$first_post = false;

	} // while have_posts

	echo '<div class="navigation"><p>' . posts_nav_link() . '</p></div>';

} // if have_posts
?>


</div> <!-- // main -->
</div> <!-- // postpage -->

<?php
get_footer( );
