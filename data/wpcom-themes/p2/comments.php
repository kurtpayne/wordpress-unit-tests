<?php
if ( get_comments_number() > 0 ) {
	echo "<ul class='commentlist inlinecomments'>\n";
	
	wp_list_comments( array(
		'callback' => 'p2_comments'
	) );
	
	echo "</ul>\n";
}