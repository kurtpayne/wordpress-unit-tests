<div id="secondary">

<?php if (function_exists('dynamic_sidebar')) { echo "<div class=\"widgets\">\n"; } ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar') ) :  // widgets! ?>

<?php
	echo '<ul>';
	wp_list_bookmarks(array('title_before' => '<h3>', 'title_after' => '</h3>'));
	echo '</ul>';
	wp_meta();
?>

<?php endif; // end widgets if ?>

<?php if (function_exists('dynamic_sidebar')) { echo "</div>\n"; } ?>

<?php
	// Reset the post data incase part of the sidebar code messed it up
	$wp_the_query->current_post--;
	setup_postdata($wp_query->next_post());
?>
</div>
