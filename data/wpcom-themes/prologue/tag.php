<?php 
get_header( ); 
$tag_obj = $wp_query->get_queried_object();
?>

<div id="main">
	<h2>Latest Updates: <?php single_tag_title( ); ?> <a class="rss" href="<?php echo get_tag_feed_link( $tag_obj->term_id ); ?>">RSS</a></h2>
	<ul>

<?php
if( have_posts( ) ) {

	$previous_user_id = 0;
	while( have_posts( ) ) {
		the_post( );
?>

<li>

<?php
		// Don't show the avatar if the previous post was by the same user
		$current_user_id = get_the_author_ID( );
		if( $previous_user_id !== $current_user_id ) {
			echo prologue_get_avatar( $current_user_id, get_the_author_email( ), 48 );
		}
		$previous_user_id = $current_user_id;
?>

	<h4>
		<?php the_author_posts_link( ); ?>
		<span class="meta">
			<?php the_time( "h:i:s a" ); ?> on <?php the_time( "F j, Y" ); ?> |
			<?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ); ?> |
			<a href="<?php the_permalink( ); ?>">#</a> |
			<?php edit_post_link( __( 'e' ) ); ?>
			<br />
			<?php the_tags( ); ?>
		</span>
	</h4>
	<div class="postcontent">
		<?php the_content( __( '(More ...)' ) ); ?>
	</div> <!-- // postcontent -->
	<div class="bottom_of_entry">&nbsp;</div>
</li>

<?php
	} // while have_posts
} // if have_posts
?>

	</ul>
	<div class="navigation"><p><?php posts_nav_link(' | ','&larr;&nbsp;Newer&nbsp;Posts','Older&nbsp;Posts&nbsp;&rarr;'); ?></p></div>
</div> <!-- // main -->

<?php
get_footer( );
